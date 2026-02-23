<?php

namespace Database\Seeders;

use App\Models\Motor;
use App\Models\TarifRental;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MotorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first pemilik user
        $pemilik = User::where('role', 'pemilik')->first();
        
        if (!$pemilik) {
            $this->command->error('No pemilik user found. Please run AdminSeeder first.');
            return;
        }

        $motors = [
            [
                'merk' => 'Honda Vario 150',
                'no_plat' => 'B 1234 ABC',
                'tipe_cc' => '150',
                'status' => 'tersedia',
                'tarif_harian' => 75000,
                'tarif_mingguan' => 450000,
                'tarif_bulanan' => 1800000,
            ],
            [
                'merk' => 'Yamaha NMAX',
                'no_plat' => 'B 5678 DEF',
                'tipe_cc' => '150',
                'status' => 'tersedia',
                'tarif_harian' => 80000,
                'tarif_mingguan' => 500000,
                'tarif_bulanan' => 2000000,
            ],
            [
                'merk' => 'Honda Beat',
                'no_plat' => 'B 9012 GHI',
                'tipe_cc' => '125',
                'status' => 'tersedia',
                'tarif_harian' => 50000,
                'tarif_mingguan' => 300000,
                'tarif_bulanan' => 1200000,
            ],
            [
                'merk' => 'Kawasaki Ninja 250',
                'no_plat' => 'B 3456 JKL',
                'tipe_cc' => '150',
                'status' => 'tersedia',
                'tarif_harian' => 120000,
                'tarif_mingguan' => 750000,
                'tarif_bulanan' => 3000000,
            ],
            [
                'merk' => 'Honda PCX',
                'no_plat' => 'B 7890 MNO',
                'tipe_cc' => '150',
                'status' => 'tersedia',
                'tarif_harian' => 85000,
                'tarif_mingguan' => 550000,
                'tarif_bulanan' => 2200000,
            ],
            [
                'merk' => 'Yamaha R15',
                'no_plat' => 'B 2345 PQR',
                'tipe_cc' => '150',
                'status' => 'tersedia',
                'tarif_harian' => 100000,
                'tarif_mingguan' => 650000,
                'tarif_bulanan' => 2600000,
            ],
            // Motor pending untuk testing verifikasi
            [
                'merk' => 'Honda Vario Test',
                'no_plat' => 'B 1111 TST',
                'tipe_cc' => '125',
                'status' => 'pending',
                'tarif_harian' => null,
                'tarif_mingguan' => null,
                'tarif_bulanan' => null,
            ],
            [
                'merk' => 'Yamaha Mio Test',
                'no_plat' => 'B 2222 TST',
                'tipe_cc' => '110',
                'status' => 'pending',
                'tarif_harian' => null,
                'tarif_mingguan' => null,
                'tarif_bulanan' => null,
            ],
            [
                'merk' => 'Honda Scoopy',
                'no_plat' => 'B 6789 STU',
                'tipe_cc' => '125',
                'status' => 'tersedia',
                'tarif_harian' => 45000,
                'tarif_mingguan' => 280000,
                'tarif_bulanan' => 1100000,
            ],
            [
                'merk' => 'Suzuki GSX',
                'no_plat' => 'B 0123 VWX',
                'tipe_cc' => '150',
                'status' => 'tersedia',
                'tarif_harian' => 90000,
                'tarif_mingguan' => 570000,
                'tarif_bulanan' => 2300000,
            ],
        ];

        foreach ($motors as $motorData) {
            // Create motor
            $motor = Motor::create([
                'pemilik_id' => $pemilik->id,
                'merk' => $motorData['merk'],
                'no_plat' => $motorData['no_plat'],
                'tipe_cc' => $motorData['tipe_cc'],
                'status' => $motorData['status'],
            ]);

            // Create tariff only if motor is not pending
            if ($motorData['status'] !== 'pending') {
                TarifRental::create([
                    'motor_id' => $motor->id,
                    'tarif_harian' => $motorData['tarif_harian'],
                    'tarif_mingguan' => $motorData['tarif_mingguan'],
                    'tarif_bulanan' => $motorData['tarif_bulanan'],
                ]);
            }
        }

        $this->command->info('Motor seeder completed successfully!');
    }
}
