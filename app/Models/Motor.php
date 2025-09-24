<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Motor extends Model
{
    use HasFactory;

    protected $fillable = [
        'pemilik_id',
        'merk',
        'tipe_cc',
        'no_plat',
        'status',
        'photo',
        'dokumen_kepemilikan',
    ];

    // Relationships
    public function pemilik()
    {
        return $this->belongsTo(User::class, 'pemilik_id');
    }

    public function tarifRental()
    {
        return $this->hasOne(TarifRental::class);
    }

    public function penyewaan()
    {
        return $this->hasMany(Penyewaan::class);
    }
}
