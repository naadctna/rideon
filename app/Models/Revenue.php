<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Revenue extends Model
{
    protected $fillable = [
        'transaksi_id',
        'user_id',
        'tipe',
        'jumlah',
        'persentase',
        'status',
        'keterangan'
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
        'persentase' => 'decimal:2',
    ];

    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function penyewaan(): BelongsTo
    {
        return $this->belongsTo(Penyewaan::class, 'transaksi_id', 'id')
                    ->through('transaksi');
    }
}
