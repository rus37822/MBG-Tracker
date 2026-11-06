<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_matches_the_mbg_brand(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('MBG Tracker')
            ->assertSee('Area Petugas')
            ->assertSee('name="email"', false)
            ->assertSee('name="password"', false)
            ->assertSee('mbg-theme')
            ->assertSee('Belum punya akun? Daftar')
            ->assertSee(route('admin.login'), false)
            ->assertSee('Masuk admin');
    }

    public function test_guest_can_register_and_must_sign_in_afterward(): void
    {
        $this->get(route('register'))
            ->assertOk()
            ->assertSee('name="name"', false)
            ->assertSee('name="email"', false)
            ->assertSee('name="password"', false)
            ->assertSee('name="password_confirmation"', false);

        $this->post(route('register.store'), [
            'name' => 'Petugas Baru',
            'email' => 'petugas-baru@example.com',
            'password' => 'kata-sandi-aman',
            'password_confirmation' => 'kata-sandi-aman',
        ])->assertRedirect(route('login'));

        $user = User::where('email', 'petugas-baru@example.com')->firstOrFail();

        $this->assertSame('Petugas Baru', $user->name);
        $this->assertNotSame('kata-sandi-aman', $user->password);
        $this->assertGuest();

        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Pendaftaran berhasil. Silakan masuk dengan akun Anda.');

        $this->post(route('login.store'), [
            'email' => 'petugas-baru@example.com',
            'password' => 'kata-sandi-aman',
        ])->assertRedirect(route('mbg.index'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_registration_rejects_duplicate_email_and_unconfirmed_password(): void
    {
        User::factory()->create(['email' => 'petugas@example.com']);

        $this->from(route('register'))
            ->post(route('register.store'), [
                'name' => 'Petugas Baru',
                'email' => 'petugas@example.com',
                'password' => 'kata-sandi-aman',
                'password_confirmation' => 'kata-sandi-berbeda',
            ])
            ->assertRedirect(route('register'))
            ->assertSessionHasErrors(['email', 'password']);

        $this->assertDatabaseCount('users', 1);
        $this->assertGuest();
    }

    public function test_guest_is_redirected_to_login_before_accessing_mbg_data(): void
    {
        $this->get(route('mbg.index'))
            ->assertRedirect(route('login'));

        $this->get(route('mbg.daily-menu'))
            ->assertRedirect(route('login'));

        $this->post(route('mbg.store'), [
            'nama' => 'Penerima',
            'kelas' => 'VII-A',
            'jumlah' => 1,
            'waktu_pengambilan' => now()->toDateTimeString(),
        ])->assertRedirect(route('login'));

        $this->assertDatabaseCount('mbg_records', 0);
    }

    public function test_staff_can_sign_in_and_are_redirected_to_the_requested_page(): void
    {
        $staff = User::factory()->create([
            'email' => 'petugas@example.com',
            'password' => 'rahasia-petugas',
        ]);

        $this->get(route('mbg.history'))
            ->assertRedirect(route('login'));

        $this->post(route('login.store'), [
            'email' => $staff->email,
            'password' => 'rahasia-petugas',
            'remember' => '1',
        ])->assertRedirect(route('mbg.history'));

        $this->assertAuthenticatedAs($staff);
        $this->get(route('mbg.history'))->assertOk();
    }

    public function test_invalid_credentials_do_not_sign_in_and_show_an_error(): void
    {
        User::factory()->create([
            'email' => 'petugas@example.com',
            'password' => 'rahasia-petugas',
        ]);

        $this->from(route('login'))
            ->post(route('login.store'), [
                'email' => 'petugas@example.com',
                'password' => 'kata-sandi-salah',
            ])
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_staff_can_log_out_and_session_is_invalidated(): void
    {
        $this->actingAs(User::factory()->create());

        $this->post(route('logout'))
            ->assertRedirect(route('login'));

        $this->assertGuest();
        $this->get(route('mbg.index'))->assertRedirect(route('login'));
    }
}
