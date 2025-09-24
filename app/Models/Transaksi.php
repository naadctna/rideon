<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'pemesanan_id',
        'jumlah',
        'metode_pembayaran',
        'status',
        'tanggal',
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
        'tanggal' => 'date',
    ];

    // Relationships
    public function penyewaan()
    {
        return $this->belongsTo(Penyewaan::class, 'pemesanan_id');
    }
}
