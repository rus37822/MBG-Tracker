<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use RuntimeException;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $name = config('admin.name');
        $email = config('admin.email');
        $password = config('admin.password');

        if (
            ! is_string($name) || trim($name) === '' || strlen($name) > 255
            || ! is_string($email) || filter_var($email, FILTER_VALIDATE_EMAIL) === false
            || ! is_string($password) || strlen($password) < 8
        ) {
            throw new RuntimeException(
                'Set ADMIN_NAME, a valid ADMIN_EMAIL, and an ADMIN_PASSWORD of at least 8 characters before seeding.'
            );
        }

        $admin = User::query()->firstOrNew(['email' => $email]);

        if (! $admin->exists) {
            $admin->name = trim($name);
            $admin->password = $password;
        }

        $admin->is_admin = true;
        $admin->is_approved = true;
        $admin->save();
    }
}
