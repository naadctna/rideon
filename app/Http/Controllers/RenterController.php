<?php

namespace App\Http\Controllers;

use App\Models\Motor;
use App\Models\Penyewaan;
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

        // Get statistics
        $totalRentals = Penyewaan::where('penyewa_id', $user->id)->count();
        $activeRentals = Penyewaan::where('penyewa_id', $user->id)
                                 ->where('status', 'aktif')
                                 ->count();
        $completedRentals = Penyewaan::where('penyewa_id', $user->id)
                                    ->where('status', 'selesai')
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

        // Get active rentals
        $activeRentalsList = Penyewaan::where('penyewa_id', $user->id)
                                     ->where('status', 'aktif')
                                     ->with(['motor.tarifRental'])
                                     ->orderBy('tanggal_mulai', 'desc')
                                     ->get();

        // Get available motors for dashboard display
        $availableMotors = Motor::where('status', 'tersedia')
                                ->with(['tarifRental'])
                                ->orderBy('created_at', 'desc')
                                ->limit(8)
                                ->get();

        // Get unique brands and types for filter
        $merkOptions = Motor::where('status', 'tersedia')->distinct()->pluck('merk')->sort();
        $tipeOptions = Motor::where('status', 'tersedia')->distinct()->pluck('tipe_cc')->sort();

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
        $query = Motor::where('status', 'tersedia')
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
        $query = Motor::where('status', 'tersedia')
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
        $merkOptions = Motor::where('status', 'tersedia')->distinct()->pluck('merk');

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
            'metode_pembayaran' => 'required|in:cash,transfer,ewallet'
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
                'metode_pembayaran' => $request->metode_pembayaran,
                'tarif_per_unit' => $tarif_per_unit,
                'total_biaya' => $totalCost,
                'status' => 'aktif'
            ]);

            // Update motor status to 'disewa'
            $motor->update(['status' => 'disewa']);

            \DB::commit();
            
            return view('renter.booking-confirmation', compact('motor', 'rental'));
            
        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses rental');
        }
    }

    public function storeBooking(Request $request)
    {
        $request->validate([
            'motor_id' => 'required|exists:motors,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'tipe_durasi' => 'required|in:harian,mingguan,bulanan',
            'harga' => 'required|numeric|min:0'
        ]);

        DB::beginTransaction();
        try {
            // Create rental
            $rental = Penyewaan::create([
                'penyewa_id' => Auth::id(),
                'motor_id' => $request->motor_id,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'tipe_durasi' => $request->tipe_durasi,
                'harga' => $request->harga,
                'status' => 'menunggu_pembayaran'
            ]);

            // Create transaction
            $transaction = Transaksi::create([
                'penyewaan_id' => $rental->id,
                'jumlah' => $request->harga,
                'status' => 'pending',
                'metode_pembayaran' => 'transfer'
            ]);

            // Update motor status
            Motor::where('id', $request->motor_id)->update(['status' => 'disewa']);

            DB::commit();

            return redirect()->route('renter.payment', $transaction->id)
                           ->with('success', 'Booking berhasil dibuat. Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat booking');
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
}