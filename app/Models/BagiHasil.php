<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BagiHasil extends Model
{
    use HasFactory;

    protected $fillable = [
        'pemesanan_id',
        'bagi_hasil_pemilik',
        'bagi_hasil_admin',
        'settled_at',
        'tanggal',
    ];

    protected $casts = [
        'bagi_hasil_pemilik' => 'decimal:2',
        'bagi_hasil_admin' => 'decimal:2',
        'settled_at' => 'datetime',
        'tanggal' => 'date',
    ];

    // Relationships
    public function penyewaan()
    {
        return $this->belongsTo(Penyewaan::class, 'pemesanan_id');
    }
}
