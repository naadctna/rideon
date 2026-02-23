<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Penyewaan;
use App\Models\Motor;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UpdateExpiredRentals extends Command
{
    protected $signature = 'rentals:update-expired';
    protected $description = 'Update status penyewaan dan motor yang sudah lewat tanggal selesai';

    public function handle()
    {
        $now = Carbon::now();
        
        // Cari penyewaan yang sudah lewat tanggal selesai tapi statusnya masih active
        $expiredRentals = Penyewaan::where('status', 'active')
            ->where('tanggal_selesai', '<', $now)
            ->with('motor')
            ->get();

        if ($expiredRentals->isEmpty()) {
            $this->info('Tidak ada penyewaan yang expired.');
            return 0;
        }

        $count = 0;
        foreach ($expiredRentals as $rental) {
            DB::beginTransaction();
            try {
                // Update status penyewaan menjadi completed
                $rental->update(['status' => 'completed']);
                
                // Update status motor menjadi tersedia
                if ($rental->motor) {
                    $rental->motor->update(['status' => 'tersedia']);
                }
                
                DB::commit();
                $count++;
                $this->info("Updated rental ID {$rental->id} - Motor {$rental->motor->merk} ({$rental->motor->no_plat})");
                
            } catch (\Exception $e) {
                DB::rollback();
                $this->error("Failed to update rental ID {$rental->id}: {$e->getMessage()}");
            }
        }

        $this->info("Total {$count} penyewaan berhasil diupdate.");
        return 0;
    }
}
