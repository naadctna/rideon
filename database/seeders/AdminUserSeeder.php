<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@rideon.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'no_tlpn' => '081234567890',
            'email_verified_at' => now(),
        ]);

        // Create additional admin user for testing
        User::create([
            'name' => 'Admin Test',
            'email' => 'admintest@rideon.com', 
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'no_tlpn' => '081234567891',
            'email_verified_at' => now(),
        ]);
    }
}
