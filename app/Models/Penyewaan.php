<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penyewaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'penyewa_id',
        'motor_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'tipe_durasi',
        'harga',
        'status',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'harga' => 'decimal:2',
    ];

    // Relationships
    public function penyewa()
    {
        return $this->belongsTo(User::class, 'penyewa_id');
    }

    public function motor()
    {
        return $this->belongsTo(Motor::class);
    }

    public function transaksi()
    {
        return $this->hasOne(Transaksi::class, 'pemesanan_id');
    }

    public function bagiHasil()
    {
        return $this->hasOne(BagiHasil::class, 'pemesanan_id');
    }
}
