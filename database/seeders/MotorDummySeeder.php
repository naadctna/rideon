<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Motor;

class MotorDummySeeder extends Seeder
{
    public function run(): void
    {
        // Cari atau buat user pemilik
        $pemilik = User::where('role', 'pemilik')->first();
        
        if (!$pemilik) {
            $pemilik = User::create([
                'name' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'password' => bcrypt('password'),
                'role' => 'pemilik',
                'no_tlpn' => '081234567890',
                'address' => 'Jakarta Selatan',
            ]);
        }

        // Motor 1 - Pending
        Motor::create([
            'pemilik_id' => $pemilik->id,
            'merk' => 'Honda Vario 160',
            'tipe_cc' => '150',
            'no_plat' => 'B1234XYZ',
            'status' => 'pending',
        ]);

        // Motor 2 - Pending
        Motor::create([
            'pemilik_id' => $pemilik->id,
            'merk' => 'Yamaha NMAX',
            'tipe_cc' => '150',
            'no_plat' => 'B5678ABC',
            'status' => 'pending',
        ]);

        // Motor 3 - Pending
        Motor::create([
            'pemilik_id' => $pemilik->id,
            'merk' => 'Honda PCX 160',
            'tipe_cc' => '150',
            'no_plat' => 'B9012DEF',
            'status' => 'pending',
        ]);

        // Motor 4 - Pending
        Motor::create([
            'pemilik_id' => $pemilik->id,
            'merk' => 'Yamaha Aerox 155',
            'tipe_cc' => '150',
            'no_plat' => 'B3456GHI',
            'status' => 'pending',
        ]);

        // Motor 5 - Pending (untuk reject testing)
        Motor::create([
            'pemilik_id' => $pemilik->id,
            'merk' => 'Suzuki Nex II',
            'tipe_cc' => '125',
            'no_plat' => 'B7890JKL',
            'status' => 'pending',
        ]);

        echo "✅ 5 motor dummy (status pending) berhasil ditambahkan!\n";
    }
}
