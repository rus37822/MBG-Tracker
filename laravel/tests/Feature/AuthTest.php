<?php

namespace Tests\Feature;

use App\Models\DailyMenu;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
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
            ->assertSee('"/login"', false)
            ->assertSee('"/admin/login"', false)
            ->assertSee('"/register"', false)
            ->assertSee('Belum punya akun? Daftar')
            ->assertSee(route('admin.login', absolute: false), false)
            ->assertSee('Masuk admin');
    }

    public function test_login_flow_stays_on_the_current_host_when_app_url_is_different(): void
    {
        config(['app.url' => 'http://127.0.0.1:8000']);
        $staff = User::factory()->create([
            'email' => 'petugas@example.com',
            'password' => 'rahasia-petugas',
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('href="/login"', false)
            ->assertDontSee('href="http://127.0.0.1:8000/login"', false);

        $this->get('/login')
            ->assertOk()
            ->assertSee('action="/login"', false);

        $this->post('/login', [
            'email' => $staff->email,
            'password' => 'rahasia-petugas',
        ])->assertRedirect('/mbg/form');

        $this->assertAuthenticatedAs($staff);
    }

    public function test_guest_registration_requires_admin_approval_before_sign_in(): void
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
        ])->assertRedirect(route('login', absolute: false));

        $user = User::where('email', 'petugas-baru@example.com')->firstOrFail();

        $this->assertSame('Petugas Baru', $user->name);
        $this->assertNotSame('kata-sandi-aman', $user->password);
        $this->assertFalse($user->is_approved);
        $this->assertGuest();

        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Akun Anda menunggu verifikasi admin sebelum dapat digunakan.');

        $this->post(route('login.store'), [
            'email' => 'petugas-baru@example.com',
            'password' => 'kata-sandi-aman',
        ])->assertRedirect(route('login', absolute: false))
            ->assertSessionHasErrors(['email' => 'Akun Anda masih menunggu verifikasi admin.']);

        $this->assertGuest();

        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin)
            ->patch(route('admin.users.approve', $user))
            ->assertRedirect(route('admin.users.index', absolute: false))
            ->assertSessionHas('status');

        $this->assertTrue($user->fresh()->is_approved);

        $this->post(route('logout'))->assertRedirect(route('login', absolute: false));
        $this->post(route('login.store'), [
            'email' => 'petugas-baru@example.com',
            'password' => 'kata-sandi-aman',
        ])->assertRedirect(route('mbg.form', absolute: false));

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
            ->assertRedirect(route('register', absolute: false))
            ->assertSessionHasErrors(['email', 'password']);

        $this->assertDatabaseCount('users', 1);
        $this->assertGuest();
    }

    public function test_guest_is_redirected_to_login_before_accessing_mbg_data(): void
    {
        $this->get(route('mbg.index'))
            ->assertRedirect(route('login', absolute: false));

        $this->get(route('mbg.daily-menu'))
            ->assertRedirect(route('login', absolute: false));

        $this->post(route('mbg.store'), [
            'nama' => 'Penerima',
            'kelas' => 'VII-A',
            'jumlah' => 1,
            'waktu_pengambilan' => now()->toDateTimeString(),
        ])->assertRedirect(route('login', absolute: false));

        $this->assertDatabaseCount('mbg_records', 0);
    }

    public function test_root_is_public_and_links_to_the_staff_login_page(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Menu MBG Hari Ini')
            ->assertSee('href="'.route('login', absolute: false).'"', false)
            ->assertSee('Masuk Petugas');

        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Area Petugas')
            ->assertSee('name="email"', false);
        $this->assertGuest();
    }

    public function test_public_home_shows_only_the_menu_for_today(): void
    {
        $todayMenu = DailyMenu::create([
            'menu_date' => now()->toDateString(),
            'foto' => 'daily-menus/menu-hari-ini.jpg',
        ]);
        DailyMenu::create([
            'menu_date' => now()->subDay()->toDateString(),
            'foto' => 'daily-menus/menu-kemarin.jpg',
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee(Storage::disk('public')->url($todayMenu->foto), false)
            ->assertDontSee('menu-kemarin.jpg');

        $this->assertGuest();
    }

    public function test_staff_cannot_manage_the_public_daily_menu(): void
    {
        $staff = User::factory()->create();

        $this->actingAs($staff)
            ->get(route('mbg.daily-menu'))
            ->assertForbidden();

        $this->post(route('mbg.daily-menu.store'), [])
            ->assertForbidden();
    }

    public function test_staff_can_sign_in_and_are_redirected_to_the_requested_page(): void
    {
        $staff = User::factory()->create([
            'email' => 'petugas@example.com',
            'password' => 'rahasia-petugas',
        ]);

        $this->get(route('mbg.history'))
            ->assertRedirect(route('login', absolute: false));

        $this->post(route('login.store'), [
            'email' => $staff->email,
            'password' => 'rahasia-petugas',
            'remember' => '1',
        ])->assertRedirect(route('mbg.history', absolute: false));

        $this->assertAuthenticatedAs($staff);
        $this->get(route('mbg.history'))->assertOk();
    }

    public function test_staff_can_sign_in_after_visiting_the_root_page(): void
    {
        $staff = User::factory()->create([
            'email' => 'petugas@example.com',
            'password' => 'rahasia-petugas',
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Menu MBG Hari Ini')
            ->assertSee('href="'.route('login', absolute: false).'"', false);
        $this->get(route('login'))->assertOk()->assertSee('Area Petugas');

        $this->post(route('login.store'), [
            'email' => $staff->email,
            'password' => 'rahasia-petugas',
        ])->assertRedirect(route('mbg.form', absolute: false));

        $this->assertAuthenticatedAs($staff);
        $this->get(route('mbg.form'))
            ->assertOk()
            ->assertSee('Catat Pengambilan')
            ->assertSee('/mbg/form', false)
            ->assertDontSee('/admin/users', false);
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
            ->assertRedirect(route('login', absolute: false))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_staff_can_log_out_and_session_is_invalidated(): void
    {
        $this->actingAs(User::factory()->create());

        $this->post(route('logout'))
            ->assertRedirect(route('login', absolute: false));

        $this->assertGuest();
        $this->get(route('mbg.index'))        ->assertRedirect(route('login', absolute: false));
        $this->get('/')->assertOk()->assertSee('Menu MBG Hari Ini');
    }
}
