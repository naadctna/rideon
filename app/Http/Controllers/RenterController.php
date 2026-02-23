<?php

namespace App\Http\Controllers;

use App\Models\Motor;
use App\Models\Penyewaan;
use App\Models\Revenue;
use App\Models\Transaksi;
use App\Models\TarifRental;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller as BaseController;

class RenterController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $user = Auth::user();
        
        if ($user->role !== 'penyewa') {
            return redirect()->route('login')->with('error', 'Access denied');
        }

        // Auto-update status penyewaan yang sudah lewat tanggal selesai
        Penyewaan::updateExpiredRentals();

        // Get statistics
        $totalRentals = Penyewaan::where('penyewa_id', $user->id)->count();
        $activeRentals = Penyewaan::where('penyewa_id', $user->id)
                                 ->where('status', 'active')
                                 ->count();
        $completedRentals = Penyewaan::where('penyewa_id', $user->id)
                                    ->where('status', 'completed')
                                    ->count();
        $totalSpent = Transaksi::whereHas('penyewaan', function($query) use ($user) {
            $query->where('penyewa_id', $user->id);
        })->where('status', 'berhasil')->sum('jumlah');

        // Get recent rentals
        $recentRentals = Penyewaan::where('penyewa_id', $user->id)
                                 ->with(['motor.tarifRental', 'transaksi'])
                                 ->orderBy('created_at', 'desc')
                                 ->limit(5)
                                 ->get();

        // Get active rentals with owner contact info
        $activeRentalsList = Penyewaan::where('penyewa_id', $user->id)
                                     ->whereIn('status', ['approved', 'active'])
                                     ->with(['motor.tarifRental', 'motor.pemilik'])
                                     ->orderBy('created_at', 'desc')
                                     ->get();

        // Get all motors for dashboard display (available and rented)
        $availableMotors = Motor::whereIn('status', ['tersedia', 'disewa'])
                                ->with(['tarifRental'])
                                ->orderBy('created_at', 'desc')
                                ->limit(8)
                                ->get();

        // Get unique brands and types for filter
        $merkOptions = Motor::whereIn('status', ['tersedia', 'disewa'])->distinct()->pluck('merk')->sort();
        $tipeOptions = Motor::whereIn('status', ['tersedia', 'disewa'])->distinct()->pluck('tipe_cc')->sort();

        return view('renter.dashboard', compact(
            'totalRentals', 
            'activeRentals', 
            'completedRentals', 
            'totalSpent',
            'recentRentals',
            'activeRentalsList',
            'availableMotors',
            'merkOptions',
            'tipeOptions'
        ));
    }

    public function filterMotors(Request $request)
    {
        $query = Motor::whereIn('status', ['tersedia', 'disewa'])
                     ->with(['tarifRental']);

        // Filter by merk with LIKE search
        if ($request->filled('merk')) {
            $query->where('merk', 'like', '%' . $request->merk . '%');
        }

        // Filter by tipe_cc with exact match
        if ($request->filled('tipe_cc')) {
            $query->where('tipe_cc', $request->tipe_cc);
        }

        $motors = $query->orderBy('created_at', 'desc')->limit(8)->get();

        return view('renter.partials.motor-grid', compact('motors'))->render();
    }

    public function searchMotors(Request $request)
    {
        $query = Motor::whereIn('status', ['tersedia', 'disewa'])
                     ->with(['tarifRental']);

        // Filter by merk
        if ($request->filled('merk')) {
            $query->where('merk', 'like', '%' . $request->merk . '%');
        }

        // Filter by tipe_cc
        if ($request->filled('tipe_cc')) {
            $query->where('tipe_cc', $request->tipe_cc);
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->whereHas('tarifRental', function($q) use ($request) {
                $q->where('tarif_harian', '>=', $request->min_price);
            });
        }

        if ($request->filled('max_price')) {
            $query->whereHas('tarifRental', function($q) use ($request) {
                $q->where('tarif_harian', '<=', $request->max_price);
            });
        }

        $motors = $query->paginate(12);
        $merkOptions = Motor::whereIn('status', ['tersedia', 'disewa'])->distinct()->pluck('merk');

        return view('renter.search-motors', compact('motors', 'merkOptions'));
    }

    public function showMotor($id)
    {
        $motor = Motor::with(['tarifRental', 'pemilik'])->findOrFail($id);
        
        if ($motor->status !== 'tersedia') {
            return redirect()->back()->with('error', 'Motor tidak tersedia untuk disewa');
        }

        return view('renter.show-motor', compact('motor'));
    }

    public function rentMotor(Request $request, $id)
    {
        $motor = Motor::with(['tarifRental', 'pemilik'])->findOrFail($id);
        
        if ($motor->status !== 'tersedia') {
            return redirect()->back()->with('error', 'Motor tidak tersedia');
        }

        $request->validate([
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'tipe_durasi' => 'required|in:harian,mingguan,bulanan',
            'metode_pembayaran' => 'required|in:dana,ovo,gopay,shopeepay,linkaja,qris'
        ]);

        // Calculate rental cost
        $startDate = \Carbon\Carbon::parse($request->tanggal_mulai);
        $endDate = \Carbon\Carbon::parse($request->tanggal_selesai);
        $days = $startDate->diffInDays($endDate) + 1;

        $totalCost = 0;
        $tarif_per_unit = 0;
        
        switch ($request->tipe_durasi) {
            case 'harian':
                $totalCost = $days * $motor->tarifRental->tarif_harian;
                $tarif_per_unit = $motor->tarifRental->tarif_harian;
                break;
            case 'mingguan':
                $weeks = ceil($days / 7);
                $totalCost = $weeks * $motor->tarifRental->tarif_mingguan;
                $tarif_per_unit = $motor->tarifRental->tarif_mingguan;
                break;
            case 'bulanan':
                $months = ceil($days / 30);
                $totalCost = $months * $motor->tarifRental->tarif_bulanan;
                $tarif_per_unit = $motor->tarifRental->tarif_bulanan;
                break;
        }

        // Start database transaction
        \DB::beginTransaction();
        
        try {
            // Create rental record
            $rental = Penyewaan::create([
                'penyewa_id' => \Auth::id(),
                'motor_id' => $motor->id,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'tipe_durasi' => $request->tipe_durasi,
                'harga' => $totalCost,
                'status' => 'active'
            ]);

            // PEMBAYARAN OTOMATIS BERHASIL - Langsung bagi hasil
            // 1. Buat transaksi (otomatis berhasil)
            $transaksi = Transaksi::create([
                'penyewaan_id' => $rental->id,
                'jumlah' => $totalCost,
                'metode_pembayaran' => $request->metode_pembayaran,
                'status' => 'berhasil',
                'tanggal' => now(),
            ]);

            // 2. Bagi hasil: 30% admin, 70% pemilik
            $adminShare = $totalCost * 0.30;
            $ownerShare = $totalCost * 0.70;

            // 3. Cari admin
            $admin = \App\Models\User::where('role', 'admin')->first();
            
            // 4. Buat record revenue untuk admin
            if ($admin) {
                Revenue::create([
                    'transaksi_id' => $transaksi->id,
                    'user_id' => $admin->id,
                    'tipe' => 'admin',
                    'jumlah' => $adminShare,
                    'persentase' => 30.00,
                    'status' => 'received',
                    'keterangan' => 'Bagian admin dari rental #' . $rental->id
                ]);
            }

            // 5. Buat record revenue untuk pemilik
            Revenue::create([
                'transaksi_id' => $transaksi->id,
                'user_id' => $motor->pemilik_id,
                'tipe' => 'pemilik',
                'jumlah' => $ownerShare,
                'persentase' => 70.00,
                'status' => 'received',
                'keterangan' => 'Bagian pemilik dari rental #' . $rental->id
            ]);

            // 6. Update status motor
            $motor->update(['status' => 'disewa']);

            \DB::commit();
            
            // Load relasi transaksi untuk ditampilkan
            $rental->load('transaksi');
            
            return view('renter.booking-confirmation', compact('motor', 'rental'));
            
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses rental: ' . $e->getMessage());
        }
    }

    public function payment($transactionId)
    {
        $transaction = Transaksi::with(['penyewaan.motor', 'penyewaan.penyewa'])
                                ->where('id', $transactionId)
                                ->where('status', 'pending')
                                ->firstOrFail();

        // Make sure user owns this transaction
        if ($transaction->penyewaan->penyewa_id !== Auth::id()) {
            abort(403);
        }

        return view('renter.payment', compact('transaction'));
    }

    public function myRentals()
    {
        $user = Auth::user();
        
        $rentals = Penyewaan::where('penyewa_id', $user->id)
                           ->with(['motor.tarifRental', 'transaksi'])
                           ->orderBy('created_at', 'desc')
                           ->paginate(10);

        return view('renter.my-rentals', compact('rentals'));
    }

    public function getRentalDetails($id)
    {
        $rental = Penyewaan::with(['motor.tarifRental', 'motor.pemilik', 'transaksi', 'penyewa'])
                          ->where('id', $id)
                          ->where('penyewa_id', Auth::id())
                          ->firstOrFail();

        return response()->json([
            'success' => true,
            'rental' => $rental
        ]);
    }

    public function downloadInvoice($id)
    {
        $rental = Penyewaan::with(['motor.tarifRental', 'motor.pemilik', 'transaksi', 'penyewa'])
                          ->where('id', $id)
                          ->where('penyewa_id', Auth::id())
                          ->firstOrFail();

        // Calculate duration
        $startDate = \Carbon\Carbon::parse($rental->tanggal_mulai);
        $endDate = \Carbon\Carbon::parse($rental->tanggal_selesai);
        $duration = $startDate->diffInDays($endDate) + 1;

        $data = [
            'rental' => $rental,
            'duration' => $duration,
            'date' => now()->format('d/m/Y')
        ];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('renter.invoice-pdf', $data);
        $pdf->setPaper('A4', 'portrait');

        $filename = 'invoice_' . str_pad($rental->id, 6, '0', STR_PAD_LEFT) . '_' . date('Ymd') . '.pdf';

        return $pdf->download($filename);
    }
}
