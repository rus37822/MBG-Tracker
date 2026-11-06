<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_must_log_in_before_opening_admin_dashboard(): void
    {
        $this->get(route('admin.users.index'))
            ->assertRedirect(route('login'));
    }

    public function test_admin_entry_from_login_redirects_admin_to_account_dashboard_after_sign_in(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();

        $this->get(route('admin.login'))
            ->assertOk()
            ->assertSee('Area Admin')
            ->assertSee('Masuk dengan akun admin')
            ->assertSee(route('admin.login.store'), false);

        $this->post(route('admin.login.store'), [
            'email' => $admin->email,
            'password' => 'password',
        ])->assertRedirect(route('admin.users.index'));

        $this->assertAuthenticatedAs($admin);
        $this->get(route('admin.users.index'))->assertOk();
    }

    public function test_regular_user_cannot_sign_in_through_admin_login(): void
    {
        $user = User::factory()->create();

        $this->from(route('admin.login'))
            ->post(route('admin.login.store'), [
                'email' => $user->email,
                'password' => 'password',
            ])
            ->assertRedirect(route('admin.login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_regular_user_cannot_open_admin_dashboard_or_change_accounts(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.users.index'))
            ->assertForbidden();

        $this->put(route('admin.users.update', $otherUser), [
            'name' => 'Nama Diubah',
            'email' => $otherUser->email,
        ])->assertForbidden();

        $this->delete(route('admin.users.destroy', $otherUser))
            ->assertForbidden();

        $this->assertDatabaseHas('users', [
            'id' => $otherUser->id,
            'name' => $otherUser->name,
        ]);
    }

    public function test_admin_can_view_accounts_and_open_edit_page(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();
        $user = User::factory()->create(['name' => 'Petugas Demo']);

        $this->actingAs($admin)
            ->get(route('admin.users.index'))
            ->assertOk()
            ->assertSee('Kelola akun')
            ->assertSee('Petugas Demo')
            ->assertSee(route('admin.users.edit', $user), false);

        $this->get(route('admin.users.edit', $user))
            ->assertOk()
            ->assertSee('Petugas Demo')
            ->assertSee('name="password_confirmation"', false);

        $this->get(route('mbg.index'))
            ->assertSee(route('admin.users.index'), false);
    }

    public function test_admin_can_update_account_and_optionally_reset_password(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();
        $user = User::factory()->create([
            'email' => 'petugas@example.com',
            'password' => 'password-lama',
        ]);

        $this->actingAs($admin)
            ->put(route('admin.users.update', $user), [
                'name' => 'Petugas Diperbarui',
                'email' => 'petugas-baru@example.com',
                'password' => 'password-baru',
                'password_confirmation' => 'password-baru',
            ])
            ->assertRedirect(route('admin.users.index'))
            ->assertSessionHas('status');

        $user->refresh();
        $this->assertSame('Petugas Diperbarui', $user->name);
        $this->assertSame('petugas-baru@example.com', $user->email);
        $this->assertTrue(password_verify('password-baru', $user->password));
    }

    public function test_admin_can_update_account_without_changing_password_or_admin_role(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();
        $user = User::factory()->create(['password' => 'password-lama']);
        $originalPassword = $user->password;

        $this->actingAs($admin)
            ->put(route('admin.users.update', $user), [
                'name' => 'Nama Baru',
                'email' => 'nama-baru@example.com',
                'password' => '',
                'password_confirmation' => '',
                'is_admin' => true,
            ])
            ->assertRedirect(route('admin.users.index'));

        $user->refresh();
        $this->assertSame('Nama Baru', $user->name);
        $this->assertSame($originalPassword, $user->password);
        $this->assertFalse($user->is_admin);
    }

    public function test_admin_can_delete_another_user_but_not_themselves_or_last_admin(): void
    {
        $admin = User::factory()->create();
        $admin->forceFill(['is_admin' => true])->save();
        $otherAdmin = User::factory()->create();
        $otherAdmin->forceFill(['is_admin' => true])->save();
        $user = User::factory()->create();

        $this->actingAs($admin)
            ->delete(route('admin.users.destroy', $user))
            ->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseMissing('users', ['id' => $user->id]);

        $this->delete(route('admin.users.destroy', $admin))
            ->assertRedirect()
            ->assertSessionHasErrors('account');
        $this->assertDatabaseHas('users', ['id' => $admin->id]);

        $otherAdmin->delete();

        $this->delete(route('admin.users.destroy', $admin))
            ->assertRedirect()
            ->assertSessionHasErrors('account');
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }
}
