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
        // Auto-update status penyewaan yang sudah lewat tanggal selesai
        Penyewaan::updateExpiredRentals();
        
        // Get statistics
        $totalMotors = Motor::count();
        $pendingVerification = Motor::where('status', 'pending')->count();
        $activeRentals = Penyewaan::where('status', 'active')->count();
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

        // Get motors pending verification (only 2 latest)
        $pendingMotors = Motor::where('status', 'pending')
            ->with(['pemilik', 'tarifRental'])
            ->orderBy('created_at', 'desc')
            ->limit(2)
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

    public function motorVerification(Request $request)
    {
        $status = $request->get('status', 'pending');
        
        $query = Motor::with(['pemilik', 'tarifRental'])
            ->orderBy('created_at', 'desc');
        
        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }
        
        $motors = $query->paginate(10);

        // Stats for summary cards
        $totalMotors = Motor::count();
        $pendingVerification = Motor::where('status', 'pending')->count();
        $verifiedMotors = Motor::where('status', 'tersedia')->count();
        $rejectedMotors = Motor::where('status', 'rejected')->count();

        return view('admin.motor-verification', compact(
            'motors',
            'totalMotors',
            'pendingVerification',
            'verifiedMotors',
            'rejectedMotors',
            'status'
        ));
    }

    public function motorVerificationDetail($id)
    {
        $motor = Motor::with(['pemilik', 'tarifRental', 'penyewaan'])
            ->findOrFail($id);

        // Get rental history for this motor
        $rentalHistory = Penyewaan::where('motor_id', $id)
            ->with(['penyewa', 'transaksi'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate statistics
        $totalRentals = $rentalHistory->count();
        $activeRentals = $rentalHistory->where('status', 'active')->count();
        $completedRentals = $rentalHistory->where('status', 'selesai')->count();
        
        // Calculate total revenue from this motor
        $totalRevenue = Transaksi::whereIn('penyewaan_id', $rentalHistory->pluck('id'))
            ->where('status', 'berhasil')
            ->sum('jumlah');

        return view('admin.motor-verification-detail', compact(
            'motor',
            'rentalHistory',
            'totalRentals',
            'activeRentals',
            'completedRentals',
            'totalRevenue'
        ));
    }

    public function verifyMotor(Request $request, $id)
    {
        try {
            \Log::info('Verify Motor Request', [
                'id' => $id,
                'action' => $request->action,
                'all_data' => $request->all()
            ]);

            $motor = Motor::findOrFail($id);
            
            $request->validate([
                'action' => 'required|in:approve,reject',
                'tarif_harian' => 'required_if:action,approve|numeric|min:0',
                'tarif_mingguan' => 'required_if:action,approve|numeric|min:0',
                'tarif_bulanan' => 'required_if:action,approve|numeric|min:0',
                'rejection_reason' => 'required_if:action,reject|string|max:500'
            ]);

            DB::beginTransaction();
            
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
                \Log::info('Motor approved', ['motor_id' => $id]);
            } else {
                // Reject motor
                $motor->update([
                    'status' => 'rejected',
                    'rejection_reason' => $request->rejection_reason
                ]);
                $message = 'Motor ditolak dengan alasan: ' . $request->rejection_reason;
                \Log::info('Motor rejected', ['motor_id' => $id, 'reason' => $request->rejection_reason]);
            }

            DB::commit();
            return redirect()->back()->with('success', $message);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation Error in verifyMotor', [
                'errors' => $e->errors(),
                'input' => $request->all()
            ]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error in verifyMotor', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function rentalManagement(Request $request)
    {
        // Auto-update status penyewaan yang sudah lewat tanggal selesai
        Penyewaan::updateExpiredRentals();
        
        $status = $request->get('status');
        $search = $request->get('search');
        $sortBy = $request->get('sortBy', 'newest');
        
        $query = Penyewaan::with(['motor', 'penyewa', 'transaksi']);
        
        // Filter by status
        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }
        
        // Search
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->whereHas('motor', function($mq) use ($search) {
                    $mq->where('merk', 'like', "%{$search}%")
                      ->orWhere('no_plat', 'like', "%{$search}%");
                })
                ->orWhereHas('penyewa', function($pq) use ($search) {
                    $pq->where('name', 'like', "%{$search}%");
                });
            });
        }
        
        // Sort
        switch($sortBy) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'price_high':
                $query->orderBy('harga', 'desc');
                break;
            case 'price_low':
                $query->orderBy('harga', 'asc');
                break;
            default: // newest
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        $rentals = $query->paginate(15);

        // Get stats for the cards
        $pendingPayment = Penyewaan::whereHas('transaksi', function($query) {
            $query->where('status', 'pending');
        })->count();
        
        $activeRentals = Penyewaan::where('status', 'active')->count();
        
        $completedRentals = Penyewaan::where('status', 'completed')->count();
        
        $cancelledRentals = Penyewaan::where('status', 'cancelled')->count();

        return view('admin.rental-management', compact(
            'rentals', 
            'pendingPayment', 
            'activeRentals', 
            'completedRentals', 
            'cancelledRentals',
            'status',
            'search',
            'sortBy'
        ));
    }

    public function confirmPayment($transactionId)
    {
        $transaction = Transaksi::with(['penyewaan.motor', 'penyewaan.penyewa'])->findOrFail($transactionId);
        
        DB::beginTransaction();
        try {
            // Update transaction status
            $transaction->update(['status' => 'berhasil']);
            
            // Update rental status
            $transaction->penyewaan->update(['status' => 'active']);
            
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
            $rental->update(['status' => 'completed']);
            
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

    public function reports(Request $request)
    {
        // Get filter parameters
        $month = $request->input('month', date('Y-m'));
        $status = $request->input('status', 'all');
        
        // Parse month and year
        $date = Carbon::parse($month . '-01');
        $year = $date->year;
        $monthNum = $date->month;
        
        // Build query for rentals
        $query = Penyewaan::with(['motor', 'penyewa', 'transaksi'])
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $monthNum);
        
        // Filter by status if not "all"
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        // Get rentals
        $rentals = $query->orderBy('created_at', 'desc')->get();
        
        // Calculate summary
        $totalRentals = $rentals->count();
        $completedRentals = $rentals->whereIn('status', ['selesai', 'completed'])->count();
        $activeRentals = $rentals->whereIn('status', ['aktif', 'active'])->count();
        $totalRevenue = $rentals->sum('harga');
        $adminRevenue = $totalRevenue * 0.30;
        $ownerRevenue = $totalRevenue * 0.70;
        
        // Get total motors
        $totalMotors = Motor::count();
        
        // Get available months (last 12 months)
        $availableMonths = [];
        for ($i = 0; $i < 12; $i++) {
            $monthDate = Carbon::now()->subMonths($i);
            $availableMonths[] = [
                'value' => $monthDate->format('Y-m'),
                'label' => $monthDate->format('F Y')
            ];
        }
        
        return view('admin.reports', compact(
            'rentals',
            'totalRentals',
            'completedRentals',
            'activeRentals',
            'totalRevenue',
            'adminRevenue',
            'ownerRevenue',
            'totalMotors',
            'month',
            'status',
            'availableMonths'
        ));
    }

    public function revenueSummary()
    {
        $revenues = Revenue::with(['transaksi.penyewaan.motor', 'user'])
                          ->orderBy('created_at', 'desc')
                          ->paginate(20);

        $adminRevenue = Revenue::where('tipe', 'admin')->sum('jumlah');
        $ownerRevenue = Revenue::where('tipe', 'pemilik')->sum('jumlah');
        $totalRevenue = $adminRevenue + $ownerRevenue;

        return view('admin.revenue-summary', compact(
            'revenues',
            'adminRevenue',
            'ownerRevenue',
            'totalRevenue'
        ));
    }

    public function getPaymentProof($id)
    {
        $rental = Penyewaan::findOrFail($id);
        
        if (!$rental->bukti_pembayaran) {
            return response()->json(['error' => 'Bukti pembayaran tidak tersedia'], 404);
        }
        
        return response()->json([
            'bukti_pembayaran' => asset('storage/' . $rental->bukti_pembayaran),
            'rental_id' => $rental->id
        ]);
    }

    public function getRentalDetails($id)
    {
        $rental = Penyewaan::with(['motor', 'penyewa', 'transaksi'])->findOrFail($id);
        
        $duration = \Carbon\Carbon::parse($rental->tanggal_mulai)->diffInDays($rental->tanggal_selesai) + 1;
        
        return response()->json([
            'rental' => [
                'id' => $rental->id,
                'status' => $rental->status,
                'tipe_durasi' => $rental->tipe_durasi,
                'tanggal_mulai' => \Carbon\Carbon::parse($rental->tanggal_mulai)->format('d/m/Y'),
                'tanggal_selesai' => \Carbon\Carbon::parse($rental->tanggal_selesai)->format('d/m/Y'),
                'durasi' => $duration . ' hari',
                'harga' => 'Rp ' . number_format($rental->harga, 0, ',', '.'),
                'created_at' => $rental->created_at->format('d/m/Y H:i'),
                'motor' => [
                    'merk' => $rental->motor->merk,
                    'tipe_cc' => $rental->motor->tipe_cc,
                    'no_plat' => $rental->motor->no_plat,
                    'foto' => $rental->motor->photo,
                ],
                'penyewa' => [
                    'name' => $rental->penyewa->name,
                    'email' => $rental->penyewa->email,
                    'no_tlpn' => $rental->penyewa->no_tlpn,
                    'alamat' => $rental->penyewa->alamat ?? '-',
                ],
                'transaksi' => $rental->transaksi ? [
                    'id' => $rental->transaksi->id,
                    'jumlah' => 'Rp ' . number_format($rental->transaksi->jumlah, 0, ',', '.'),
                    'metode_pembayaran' => $rental->transaksi->metode_pembayaran,
                    'status' => $rental->transaksi->status,
                    'bukti_pembayaran' => $rental->bukti_pembayaran,
                ] : null
            ]
        ]);
    }

    public function exportRentalPdf($id)
    {
        $rental = Penyewaan::with(['motor', 'penyewa', 'transaksi'])->findOrFail($id);
        
        $duration = \Carbon\Carbon::parse($rental->tanggal_mulai)->diffInDays($rental->tanggal_selesai) + 1;
        
        $data = [
            'rental' => $rental,
            'duration' => $duration,
            'tanggal_mulai' => \Carbon\Carbon::parse($rental->tanggal_mulai)->format('d/m/Y'),
            'tanggal_selesai' => \Carbon\Carbon::parse($rental->tanggal_selesai)->format('d/m/Y'),
        ];
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.rental-pdf', $data);
        
        return $pdf->download('penyewaan_' . $rental->id . '_' . date('Ymd') . '.pdf');
    }

    public function getMotorDetails($id)
    {
        $motor = Motor::with(['pemilik', 'tarifRental'])->findOrFail($id);
        
        return response()->json([
            'motor' => [
                'id' => $motor->id,
                'merk' => $motor->merk,
                'tipe_cc' => $motor->tipe_cc,
                'no_plat' => $motor->no_plat,
                'status' => $motor->status,
                'photo' => $motor->photo,
                'dokumen_kepemilikan' => $motor->dokumen_kepemilikan,
                'created_at' => $motor->created_at->format('d/m/Y H:i'),
                'pemilik' => [
                    'name' => $motor->pemilik->name,
                    'email' => $motor->pemilik->email,
                    'no_tlpn' => $motor->pemilik->no_tlpn,
                ],
                'tarifs' => $motor->tarifRental ? [
                    'tarif_harian' => $motor->tarifRental->tarif_harian,
                    'tarif_mingguan' => $motor->tarifRental->tarif_mingguan,
                    'tarif_bulanan' => $motor->tarifRental->tarif_bulanan,
                ] : null
            ]
        ]);
    }

    // Tarif Rental Management
    public function tarifRental()
    {
        $motors = Motor::whereIn('status', ['tersedia', 'disewa'])
            ->with(['pemilik', 'tarifRental'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $totalMotors = Motor::whereIn('status', ['tersedia', 'disewa'])->count();
        $motorsWithTarif = Motor::whereIn('status', ['tersedia', 'disewa'])
            ->whereHas('tarifRental')
            ->count();

        return view('admin.tarif-rental', compact('motors', 'totalMotors', 'motorsWithTarif'));
    }

    public function updateTarif(Request $request, $id)
    {
        $request->validate([
            'tarif_harian' => 'required|numeric|min:0',
            'tarif_mingguan' => 'required|numeric|min:0',
            'tarif_bulanan' => 'required|numeric|min:0',
        ]);

        $motor = Motor::findOrFail($id);
        
        // Update or create tarif rental
        TarifRental::updateOrCreate(
            ['motor_id' => $motor->id],
            [
                'tarif_harian' => $request->tarif_harian,
                'tarif_mingguan' => $request->tarif_mingguan,
                'tarif_bulanan' => $request->tarif_bulanan,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Tarif rental berhasil diperbarui'
        ]);
    }

    // User Management
    public function users(Request $request)
    {
        $query = User::query();

        // Filter by role if provided
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        // Filter by status if provided
        if ($request->has('status') && $request->status != '') {
            if ($request->status == 'active') {
                $query->where('is_blocked', false);
            } else {
                $query->where('is_blocked', true);
            }
        }

        // Search by name or email
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);

        $totalUsers = User::count();
        $activeUsers = User::where('is_blocked', false)->count();
        $blockedUsers = User::where('is_blocked', true)->count();
        $pemilikCount = User::where('role', 'pemilik')->count();
        $penyewaCount = User::where('role', 'penyewa')->count();

        return view('admin.users', compact(
            'users',
            'totalUsers',
            'activeUsers',
            'blockedUsers',
            'pemilikCount',
            'penyewaCount'
        ));
    }

    public function toggleBlockUser($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent blocking admin users
        if ($user->role == 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat memblokir akun admin'
            ], 403);
        }

        $user->is_blocked = !$user->is_blocked;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => $user->is_blocked ? 'User berhasil diblokir' : 'User berhasil diaktifkan',
            'is_blocked' => $user->is_blocked
        ]);
    }

    public function getReportData(Request $request)
    {
        $start = $request->input('start', date('Y-01-01'));
        $end = $request->input('end', date('Y-m-d'));

        // Get rental statistics
        $totalRentals = Penyewaan::whereBetween('created_at', [$start, $end])->count();
        $completedRentals = Penyewaan::whereBetween('created_at', [$start, $end])
            ->whereIn('status', ['selesai', 'completed'])->count();
        $activeRentals = Penyewaan::whereBetween('created_at', [$start, $end])
            ->whereIn('status', ['aktif', 'active'])->count();
        
        // Get revenue statistics
        $totalRevenue = Transaksi::where('status', 'berhasil')
            ->whereBetween('created_at', [$start, $end])
            ->sum('jumlah');
        
        $adminRevenue = $totalRevenue * 0.30;
        $ownerRevenue = $totalRevenue * 0.70;

        // Get motor statistics
        $totalMotors = Motor::count();

        // Get monthly statistics
        $startDate = \Carbon\Carbon::parse($start);
        $endDate = \Carbon\Carbon::parse($end);
        $monthlyStats = [];
        
        $currentDate = $startDate->copy();
        while ($currentDate <= $endDate) {
            $monthlyStats[] = [
                'month' => $currentDate->month,
                'month_name' => $currentDate->format('M Y'),
                'rentals' => Penyewaan::whereYear('created_at', $currentDate->year)
                    ->whereMonth('created_at', $currentDate->month)->count(),
                'revenue' => Transaksi::where('status', 'berhasil')
                    ->whereYear('created_at', $currentDate->year)
                    ->whereMonth('created_at', $currentDate->month)->sum('jumlah')
            ];
            $currentDate->addMonth();
        }

        // Get top performers
        $topMotors = Motor::withCount(['penyewaan' => function($query) use ($start, $end) {
                $query->whereBetween('created_at', [$start, $end]);
            }])
            ->with(['pemilik'])
            ->having('penyewaan_count', '>', 0)
            ->orderBy('penyewaan_count', 'desc')
            ->limit(10)
            ->get()
            ->map(function($motor) {
                return [
                    'id' => $motor->id,
                    'name' => $motor->merek . ' ' . $motor->model,
                    'owner' => $motor->pemilik->name ?? 'N/A',
                    'rental_count' => $motor->penyewaan_count
                ];
            });

        // Get top earning owners
        try {
            $topEarningOwners = User::select('users.id', 'users.name')
                ->selectRaw('COALESCE(SUM(transaksis.jumlah * 0.70), 0) as total_earnings')
                ->leftJoin('motors', 'users.id', '=', 'motors.pemilik_id')
                ->leftJoin('penyewaans', 'motors.id', '=', 'penyewaans.motor_id')
                ->leftJoin('transaksis', function($join) use ($start, $end) {
                    $join->on('penyewaans.id', '=', 'transaksis.penyewaan_id')
                         ->where('transaksis.status', '=', 'berhasil')
                         ->whereBetween('transaksis.created_at', [$start, $end]);
                })
                ->where('users.role', 'pemilik')
                ->groupBy('users.id', 'users.name')
                ->having('total_earnings', '>', 0)
                ->orderBy('total_earnings', 'desc')
                ->limit(10)
                ->get();
        } catch (\Exception $e) {
            $topEarningOwners = collect();
        }

        // Get recent transactions
        $recentTransactions = Penyewaan::with(['motor', 'penyewa', 'transaksi'])
            ->whereBetween('created_at', [$start, $end])
            ->whereHas('transaksi', function($q) {
                $q->where('status', 'berhasil');
            })
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function($rental) {
                return [
                    'id' => $rental->id,
                    'motor' => $rental->motor->merek . ' ' . $rental->motor->model,
                    'penyewa' => $rental->penyewa->name,
                    'durasi' => $rental->durasi . ' ' . $rental->tipe_durasi,
                    'total' => $rental->transaksi->jumlah ?? 0,
                    'status' => $rental->status
                ];
            });

        // Get rental statistics by motor type (CC)
        $rentalsByType = Motor::select('tipe_cc')
            ->selectRaw('COUNT(DISTINCT penyewaans.id) as total_rentals')
            ->leftJoin('penyewaans', function($join) use ($start, $end) {
                $join->on('motors.id', '=', 'penyewaans.motor_id')
                     ->whereBetween('penyewaans.created_at', [$start, $end]);
            })
            ->groupBy('tipe_cc')
            ->get()
            ->mapWithKeys(function($item) {
                return [$item->tipe_cc => $item->total_rentals];
            });

        // Get rental statistics by package type
        $rentalsByPackage = Penyewaan::select('tipe_durasi')
            ->whereBetween('created_at', [$start, $end])
            ->selectRaw('COUNT(*) as total')
            ->groupBy('tipe_durasi')
            ->get()
            ->mapWithKeys(function($item) {
                return [$item->tipe_durasi => $item->total];
            });

        // Motor status breakdown
        $motorsByStatus = [
            'tersedia' => Motor::where('status', 'tersedia')->count(),
            'disewa' => Motor::where('status', 'disewa')->count(),
            'perawatan' => Motor::where('status', 'perawatan')->count(),
        ];

        return response()->json([
            'totalRentals' => $totalRentals,
            'completedRentals' => $completedRentals,
            'activeRentals' => $activeRentals,
            'totalRevenue' => $totalRevenue,
            'adminRevenue' => $adminRevenue,
            'ownerRevenue' => $ownerRevenue,
            'monthlyStats' => $monthlyStats,
            'topMotors' => $topMotors,
            'totalMotors' => $totalMotors,
            'topEarningOwners' => $topEarningOwners,
            'recentTransactions' => $recentTransactions,
            'rentalsByType' => $rentalsByType,
            'rentalsByPackage' => $rentalsByPackage,
            'motorsByStatus' => $motorsByStatus
        ]);
    }

    public function exportReportsData(Request $request)
    {
        $format = $request->input('format', 'pdf');
        $month = $request->input('month', date('Y-m'));
        $status = $request->input('status', 'all');
        
        // Parse month and year
        $date = Carbon::parse($month . '-01');
        $year = $date->year;
        $monthNum = $date->month;
        
        // Build query for rentals
        $query = Penyewaan::with(['motor', 'penyewa', 'transaksi'])
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $monthNum);
        
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        $rentals = $query->orderBy('created_at', 'desc')->get();
        
        // Calculate totals
        $totalRevenue = $rentals->sum('harga');
        $adminRevenue = $totalRevenue * 0.30;
        
        $data = [
            'month' => $month,
            'rentals' => $rentals,
            'totalRevenue' => $totalRevenue,
            'adminRevenue' => $adminRevenue,
        ];

        if ($format === 'pdf') {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.reports-export-pdf', $data);
            $filename = 'laporan_transaksi_' . $month . '.pdf';
            return $pdf->download($filename);
        }

        // For Excel export, we can add later
        return response()->json(['message' => 'Excel export coming soon']);
    }

    public function transactionReport(Request $request)
    {
        $month = $request->input('month', date('Y-m'));
        $status = $request->input('status', 'all');
        
        // Parse month and year
        $date = Carbon::parse($month . '-01');
        $year = $date->year;
        $monthNum = $date->month;
        
        // Build query
        $query = Penyewaan::with(['motor', 'penyewa', 'transaksi'])
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $monthNum);
        
        // Filter by status if not "all"
        if ($status !== 'all') {
            $query->where('status', $status);
        }
        
        // Get transactions
        $transactions = $query->orderBy('created_at', 'desc')->get();
        
        // Calculate summary
        $totalHarga = $transactions->sum('harga');
        $totalKomisi = $totalHarga * 0.30; // Admin 30%
        $totalPemilik = $totalHarga * 0.70; // Pemilik 70%
        
        // Get available months (last 12 months)
        $availableMonths = [];
        for ($i = 0; $i < 12; $i++) {
            $monthDate = Carbon::now()->subMonths($i);
            $availableMonths[] = [
                'value' => $monthDate->format('Y-m'),
                'label' => $monthDate->format('F Y')
            ];
        }
        
        return view('admin.transaction-report', compact(
            'transactions',
            'month',
            'status',
            'totalHarga',
            'totalKomisi',
            'totalPemilik',
            'availableMonths'
        ));
    }
}
