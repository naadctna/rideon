<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TarifRental extends Model
{
    use HasFactory;

    protected $fillable = [
        'motor_id',
        'tarif_harian',
        'tarif_mingguan',
        'tarif_bulanan',
    ];

    protected $casts = [
        'tarif_harian' => 'decimal:2',
        'tarif_mingguan' => 'decimal:2',
        'tarif_bulanan' => 'decimal:2',
    ];

    // Relationships
    public function motor()
    {
        return $this->belongsTo(Motor::class);
    }
}
