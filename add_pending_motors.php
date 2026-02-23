<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Motor;

// Find owner user
$owner = User::where('email', 'owner@rideon.com')->first();

if (!$owner) {
    echo "Owner user not found!\n";
    exit;
}

// Check if pending motors already exist
$existingPending = Motor::where('status', 'pending')->count();

if ($existingPending > 0) {
    echo "Already have {$existingPending} pending motors!\n";
    exit;
}

// Create pending motors
$motors = [
    [
        'merk' => 'Honda Vario',
        'tipe_cc' => '125',
        'no_plat' => 'B1234ABC',
        'photo' => 'default-motor.jpg',
        'dokumen_kepemilikan' => 'default-stnk.jpg',
        'status' => 'pending',
        'pemilik_id' => $owner->id,
    ],
    [
        'merk' => 'Yamaha Mio',
        'tipe_cc' => '125',
        'no_plat' => 'B5678DEF',
        'photo' => 'default-motor.jpg',
        'dokumen_kepemilikan' => 'default-stnk.jpg',
        'status' => 'pending',
        'pemilik_id' => $owner->id,
    ],
    [
        'merk' => 'Honda Beat',
        'tipe_cc' => '125',
        'no_plat' => 'B9999GHI',
        'photo' => 'default-motor.jpg',
        'dokumen_kepemilikan' => 'default-stnk.jpg',
        'status' => 'pending',
        'pemilik_id' => $owner->id,
    ]
];

foreach ($motors as $motorData) {
    Motor::create($motorData);
    echo "Created motor: {$motorData['merk']} {$motorData['tipe_cc']}cc - {$motorData['no_plat']}\n";
}

echo "Successfully added 3 pending motors for testing!\n";