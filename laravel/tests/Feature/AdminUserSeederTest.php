<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminUserSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_seeder_creates_and_restores_the_configured_admin(): void
    {
        config([
            'admin.name' => 'Admin MBG',
            'admin.email' => 'admin@example.com',
            'admin.password' => 'admin-password-123',
        ]);

        $this->seed();

        $admin = User::query()->where('email', 'admin@example.com')->sole();

        $this->assertModelExists($admin);
        $this->assertTrue($admin->is_admin);
        $this->assertTrue($admin->is_approved);
        $this->assertTrue(Hash::check('admin-password-123', $admin->password));

        $admin->forceFill([
            'name' => 'Admin Diperbarui',
            'password' => 'password-yang-diubah',
            'is_admin' => false,
            'is_approved' => false,
        ])->save();
        $storedPassword = $admin->refresh()->password;

        $this->seed();

        $admin->refresh();

        $this->assertSame('Admin Diperbarui', $admin->name);
        $this->assertSame($storedPassword, $admin->password);
        $this->assertTrue($admin->is_admin);
        $this->assertTrue($admin->is_approved);
        $this->assertSame(1, User::query()->count());
    }
}
