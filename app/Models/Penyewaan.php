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
        return $this->hasOne(Transaksi::class, 'penyewaan_id');
    }

    public function bagiHasil()
    {
        return $this->hasOne(Revenue::class, 'penyewaan_id');
    }

    /**
     * Update status penyewaan yang sudah melewati tanggal selesai
     * Dan update status motor menjadi tersedia
     */
    public static function updateExpiredRentals()
    {
        $today = now()->startOfDay();
        
        // Ambil semua penyewaan yang sudah lewat tanggal selesai tapi masih aktif
        $expiredRentals = self::where('status', 'active')
            ->whereDate('tanggal_selesai', '<', $today)
            ->get();
        
        foreach ($expiredRentals as $rental) {
            // Update status penyewaan menjadi completed
            $rental->status = 'completed';
            $rental->save();
            
            // Update status motor menjadi tersedia
            if ($rental->motor) {
                $rental->motor->status = 'tersedia';
                $rental->motor->save();
            }
        }
        
        return $expiredRentals->count();
    }
}
