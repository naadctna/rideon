<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Motor;
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

        // Find the owner for motor relationship
        $owner = User::where('email', 'owner@rideon.com')->first();

        // Create pending motors for testing verification
        Motor::create([
            'merk' => 'Honda Vario',
            'tipe_cc' => '125',
            'no_plat' => 'B1234ABC',
            'photo' => 'default-motor.jpg',
            'dokumen_kepemilikan' => 'default-stnk.jpg',
            'status' => 'pending',
            'pemilik_id' => $owner->id,
        ]);

        Motor::create([
            'merk' => 'Yamaha Mio',
            'tipe_cc' => '125',
            'no_plat' => 'B5678DEF',
            'photo' => 'default-motor.jpg',
            'dokumen_kepemilikan' => 'default-stnk.jpg',
            'status' => 'pending',
            'pemilik_id' => $owner->id,
        ]);

        Motor::create([
            'merk' => 'Honda Beat',
            'tipe_cc' => '125',
            'no_plat' => 'B9999GHI',
            'photo' => 'default-motor.jpg',
            'dokumen_kepemilikan' => 'default-stnk.jpg',
            'status' => 'pending',
            'pemilik_id' => $owner->id,
        ]);
    }
}
