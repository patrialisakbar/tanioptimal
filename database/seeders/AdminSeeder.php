<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Seed the application's database dengan 1 admin dan 1 user
     * 
     * Admin:
     *   Email: admin@tanioptimal.com
     *   Password: admin12345
     *   Role: admin (bisa login ke Filament)
     * 
     * User:
     *   Email: user@tanioptimal.com
     *   Password: user12345
     *   Role: user (TIDAK bisa login ke Filament)
     */
    public function run(): void
    {
        User::query()->delete();

        // Create Admin User
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@tanioptimal.com',
            'password' => bcrypt('admin12345'),
            'role' => 'admin',
        ]);

        // Create Regular User
        User::create([
            'name' => 'User Biasa',
            'email' => 'user@tanioptimal.com',
            'password' => bcrypt('user12345'),
            'role' => 'user',
        ]);
    }
}
