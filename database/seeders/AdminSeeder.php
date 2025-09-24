<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin RideOn',
            'email' => 'admin@rideon.com',
            'password' => Hash::make('password123'),
            'no_tlpn' => '08123456789',
            'role' => 'admin',
        ]);

        // Create sample owner
        User::create([
            'name' => 'John Owner',
            'email' => 'owner@rideon.com',
            'password' => Hash::make('password123'),
            'no_tlpn' => '08123456790',
            'role' => 'pemilik',
        ]);

        // Create sample renter
        User::create([
            'name' => 'Jane Renter',
            'email' => 'renter@rideon.com',
            'password' => Hash::make('password123'),
            'no_tlpn' => '08123456791',
            'role' => 'penyewa',
        ]);
    }
}
