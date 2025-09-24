<?php

namespace App\Http\Controllers;

use App\Models\Motor;
use App\Models\Penyewaan;
use App\Models\Transaksi;
use App\Models\TarifRental;
use App\Models\User;
use App\Models\BagiHasil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Routing\Controller as BaseController;

class AdminController extends BaseController
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function dashboard()
    {
        // Get statistics
        $totalMotors = Motor::count();
        $pendingVerification = Motor::where('status', 'pending')->count();
        $activeRentals = Penyewaan::where('status', 'aktif')->count();
        $totalRevenue = Transaksi::where('status', 'berhasil')->sum('jumlah');
        
        // Get monthly revenue for chart
        $monthlyRevenue = Transaksi::where('status', 'berhasil')
            ->whereYear('created_at', date('Y'))
            ->selectRaw('MONTH(created_at) as month, SUM(jumlah) as total')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Fill missing months with 0
        for ($i = 1; $i <= 12; $i++) {
            if (!isset($monthlyRevenue[$i])) {
                $monthlyRevenue[$i] = 0;
            }
        }
        ksort($monthlyRevenue);

        // Get recent activities
        $recentRentals = Penyewaan::with(['motor', 'penyewa'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get motors pending verification
        $pendingMotors = Motor::where('status', 'pending')
            ->with(['pemilik', 'tarifRental'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get top performing motors
        $topMotors = Motor::withCount(['penyewaan'])
            ->having('penyewaan_count', '>', 0)
            ->orderBy('penyewaan_count', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalMotors',
            'pendingVerification', 
            'activeRentals',
            'totalRevenue',
            'monthlyRevenue',
            'recentRentals',
            'pendingMotors',
            'topMotors'
        ));
    }

    public function motorVerification()
    {
        $motors = Motor::where('status', 'pending')
            ->with(['pemilik', 'tarifRental'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.motor-verification', compact('motors'));
    }

    public function verifyMotor(Request $request, $id)
    {
        $motor = Motor::findOrFail($id);
        
        $request->validate([
            'action' => 'required|in:approve,reject',
            'tarif_harian' => 'required_if:action,approve|numeric|min:0',
            'tarif_mingguan' => 'required_if:action,approve|numeric|min:0',
            'tarif_bulanan' => 'required_if:action,approve|numeric|min:0',
            'rejection_reason' => 'required_if:action,reject|string|max:500'
        ]);

        DB::beginTransaction();
        try {
            if ($request->action === 'approve') {
                // Update motor status
                $motor->update(['status' => 'tersedia']);

                // Create or update tariff
                TarifRental::updateOrCreate(
                    ['motor_id' => $motor->id],
                    [
                        'tarif_harian' => $request->tarif_harian,
                        'tarif_mingguan' => $request->tarif_mingguan,
                        'tarif_bulanan' => $request->tarif_bulanan,
                    ]
                );

                $message = 'Motor berhasil diverifikasi dan tersedia untuk disewa';
            } else {
                // Reject motor
                $motor->update([
                    'status' => 'rejected',
                    'rejection_reason' => $request->rejection_reason
                ]);
                $message = 'Motor ditolak dengan alasan: ' . $request->rejection_reason;
            }

            DB::commit();
            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses verifikasi');
        }
    }

    public function rentalManagement()
    {
        $rentals = Penyewaan::with(['motor', 'penyewa', 'transaksi'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.rental-management', compact('rentals'));
    }

    public function confirmPayment($transactionId)
    {
        $transaction = Transaksi::with(['penyewaan.motor', 'penyewaan.penyewa'])->findOrFail($transactionId);
        
        DB::beginTransaction();
        try {
            // Update transaction status
            $transaction->update(['status' => 'berhasil']);
            
            // Update rental status
            $transaction->penyewaan->update(['status' => 'aktif']);
            
            // Update motor status
            $transaction->penyewaan->motor->update(['status' => 'disewa']);

            DB::commit();
            return redirect()->back()->with('success', 'Pembayaran berhasil dikonfirmasi');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat konfirmasi pembayaran');
        }
    }

    public function confirmReturn($rentalId)
    {
        $rental = Penyewaan::with(['motor', 'transaksi'])->findOrFail($rentalId);
        
        DB::beginTransaction();
        try {
            // Update rental status
            $rental->update(['status' => 'selesai']);
            
            // Update motor status back to available
            $rental->motor->update(['status' => 'tersedia']);

            // Create bagi hasil record
            $adminShare = $rental->harga * 0.3; // 30% untuk admin
            $ownerShare = $rental->harga * 0.7; // 70% untuk pemilik

            BagiHasil::create([
                'pemesanan_id' => $rental->id,
                'bagi_hasil_pemilik' => $ownerShare,
                'bagi_hasil_admin' => $adminShare,
                'settled_at' => now(),
                'tanggal' => now()->toDateString()
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Pengembalian motor berhasil dikonfirmasi');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat konfirmasi pengembalian');
        }
    }

    public function reports()
    {
        // Get rental statistics
        $totalRentals = Penyewaan::count();
        $completedRentals = Penyewaan::where('status', 'selesai')->count();
        $activeRentals = Penyewaan::where('status', 'aktif')->count();
        
        // Get revenue statistics
        $totalRevenue = Transaksi::where('status', 'berhasil')->sum('jumlah');
        $adminRevenue = DB::table('bagi_hasil')->sum('bagi_hasil_admin');
        $ownerRevenue = DB::table('bagi_hasil')->sum('bagi_hasil_pemilik');

        // Get monthly statistics
        $currentYear = date('Y');
        $monthlyStats = [];
        
        for ($month = 1; $month <= 12; $month++) {
            $monthlyStats[] = [
                'month' => $month,
                'month_name' => Carbon::create()->month($month)->format('M'),
                'rentals' => Penyewaan::whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $month)->count(),
                'revenue' => Transaksi::where('status', 'berhasil')
                    ->whereYear('created_at', $currentYear)
                    ->whereMonth('created_at', $month)->sum('jumlah')
            ];
        }

        // Get top performers
        $topMotors = Motor::withCount('penyewaan')
            ->with(['pemilik'])
            ->having('penyewaan_count', '>', 0)
            ->orderBy('penyewaan_count', 'desc')
            ->limit(10)
            ->get();

        return view('admin.reports', compact(
            'totalRentals',
            'completedRentals', 
            'activeRentals',
            'totalRevenue',
            'adminRevenue',
            'ownerRevenue',
            'monthlyStats',
            'topMotors'
        ));
    }
}
