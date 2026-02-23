<?php

namespace App\Http\Controllers;

use App\Models\Motor;
use App\Models\TarifRental;
use App\Models\Revenue;
use App\Models\Penyewaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controller as BaseController;

class OwnerController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $user = Auth::user();
        
        if ($user->role !== 'pemilik') {
            return redirect()->route('login')->with('error', 'Access denied');
        }

        // Auto-update status penyewaan yang sudah lewat tanggal selesai
        Penyewaan::updateExpiredRentals();

        $motors = Motor::where('pemilik_id', $user->id)
                      ->with(['tarifRental', 'penyewaan'])
                      ->get();

        // Statistics
        $totalMotors = $motors->count();
        $activeMotors = $motors->where('status', 'tersedia')->count();
        $rentedMotors = $motors->where('status', 'disewa')->count();
        $maintenanceMotors = $motors->where('status', 'perawatan')->count();
        
        // Calculate total revenue
        $totalRevenue = Revenue::where('user_id', $user->id)
                              ->where('tipe', 'pemilik')
                              ->sum('jumlah');

        // Get active bookings with renter contact info
        $activeBookings = Penyewaan::with(['penyewa', 'motor'])
            ->whereHas('motor', function($query) use ($user) {
                $query->where('pemilik_id', $user->id);
            })
            ->whereIn('status', ['approved', 'active'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Get completed bookings
        $completedBookings = Penyewaan::with(['penyewa', 'motor', 'transaksi'])
            ->whereHas('motor', function($query) use ($user) {
                $query->where('pemilik_id', $user->id);
            })
            ->where('status', 'completed')
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();

        return view('owner.dashboard', compact('motors', 'totalMotors', 'activeMotors', 'rentedMotors', 'maintenanceMotors', 'totalRevenue', 'activeBookings', 'completedBookings'));
    }

    public function createMotor()
    {
        return view('owner.create-motor');
    }

    public function storeMotor(Request $request)
    {
        $request->validate([
            'merk' => 'required|string|max:255',
            'tipe_cc' => 'required|numeric|min:50|max:2000',
            'no_plat' => 'required|string|unique:motors,no_plat',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'dokumen_kepemilikan' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048',
        ]);

        $motor = new Motor();
        $motor->pemilik_id = Auth::id();
        $motor->merk = $request->merk;
        $motor->tipe_cc = $request->tipe_cc;
        $motor->no_plat = $request->no_plat;
        $motor->status = 'pending'; // Waiting for admin verification

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('motor_photos', 'public');
            $motor->photo = $photoPath;
        }

        // Handle document upload
        if ($request->hasFile('dokumen_kepemilikan')) {
            $docPath = $request->file('dokumen_kepemilikan')->store('motor_documents', 'public');
            $motor->dokumen_kepemilikan = $docPath;
        }

        $motor->save();

        return redirect()->route('owner.dashboard')->with('success', 'Motor berhasil didaftarkan. Menunggu verifikasi admin.');
    }

    public function revenue()
    {
        $user = Auth::user();
        
        $revenues = Revenue::where('user_id', $user->id)
                          ->where('tipe', 'pemilik')
                          ->with(['transaksi.penyewaan.motor'])
                          ->orderBy('created_at', 'desc')
                          ->paginate(10);

        $totalRevenue = Revenue::where('user_id', $user->id)
                              ->where('tipe', 'pemilik')
                              ->sum('jumlah');

        return view('owner.revenue', compact('revenues', 'totalRevenue'));
    }

    public function downloadRevenuePdf()
    {
        $user = Auth::user();
        
        // Get all revenue records for this owner
        $revenues = Revenue::where('user_id', $user->id)
                          ->where('tipe', 'pemilik')
                          ->with(['transaksi.penyewaan.motor', 'transaksi.penyewaan.penyewa'])
                          ->orderBy('created_at', 'desc')
                          ->get();

        // Calculate total revenue
        $totalRevenue = Revenue::where('user_id', $user->id)
                              ->where('tipe', 'pemilik')
                              ->sum('jumlah');
        
        // Prepare data for PDF
        $data = [
            'revenues' => $revenues,
            'totalRevenue' => $totalRevenue,
            'owner' => $user,
            'date' => now()->format('d/m/Y')
        ];
        
        // Generate PDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('owner.revenue-pdf', $data);
        
        // Set paper size and orientation
        $pdf->setPaper('A4', 'portrait');
        
        // Generate filename
        $filename = 'laporan_pendapatan_' . str_replace(' ', '_', $user->name) . '_' . date('Ymd') . '.pdf';
        
        // Download PDF and stop execution
        return $pdf->download($filename);
    }

    public function showMotor($id)
    {
        $motor = Motor::where('id', $id)
                     ->where('pemilik_id', Auth::id())
                     ->with(['tarifRental', 'penyewaan'])
                     ->firstOrFail();

        return view('owner.show-motor', compact('motor'));
    }

    public function editMotor($id)
    {
        $motor = Motor::where('id', $id)
                     ->where('pemilik_id', Auth::id())
                     ->firstOrFail();

        return view('owner.edit-motor', compact('motor'));
    }

    public function updateMotor(Request $request, $id)
    {
        $motor = Motor::where('id', $id)
                     ->where('pemilik_id', Auth::id())
                     ->firstOrFail();

        $request->validate([
            'merk' => 'required|string|max:255',
            'tipe_cc' => 'required|numeric|min:50|max:2000',
            'no_plat' => 'required|string|unique:motors,no_plat,' . $motor->id,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'dokumen_kepemilikan' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048',
        ]);

        $motor->merk = $request->merk;
        $motor->tipe_cc = $request->tipe_cc;
        $motor->no_plat = $request->no_plat;

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($motor->photo && Storage::disk('public')->exists($motor->photo)) {
                Storage::disk('public')->delete($motor->photo);
            }
            
            $photoPath = $request->file('photo')->store('motor_photos', 'public');
            $motor->photo = $photoPath;
        }

        // Handle document upload
        if ($request->hasFile('dokumen_kepemilikan')) {
            // Delete old document if exists
            if ($motor->dokumen_kepemilikan && Storage::disk('public')->exists($motor->dokumen_kepemilikan)) {
                Storage::disk('public')->delete($motor->dokumen_kepemilikan);
            }
            
            $docPath = $request->file('dokumen_kepemilikan')->store('motor_documents', 'public');
            $motor->dokumen_kepemilikan = $docPath;
        }

        $motor->save();

        return redirect()->route('owner.dashboard')->with('success', 'Data motor berhasil diperbarui.');
    }

    public function deleteMotor($id)
    {
        $motor = Motor::where('id', $id)
                     ->where('pemilik_id', Auth::id())
                     ->firstOrFail();

        // Check if motor is currently rented
        if ($motor->status === 'disewa') {
            return redirect()->route('owner.dashboard')->with('error', 'Motor yang sedang disewa tidak dapat dihapus.');
        }

        // Delete associated files
        if ($motor->photo && Storage::disk('public')->exists($motor->photo)) {
            Storage::disk('public')->delete($motor->photo);
        }
        
        if ($motor->dokumen_kepemilikan && Storage::disk('public')->exists($motor->dokumen_kepemilikan)) {
            Storage::disk('public')->delete($motor->dokumen_kepemilikan);
        }

        // Delete associated tarif rental if exists
        if ($motor->tarifRental) {
            $motor->tarifRental->delete();
        }

        $motor->delete();

        return redirect()->route('owner.dashboard')->with('success', 'Motor berhasil dihapus.');
    }

    public function setMaintenance($id)
    {
        $motor = Motor::where('id', $id)
                     ->where('pemilik_id', Auth::id())
                     ->firstOrFail();

        if ($motor->status === 'disewa') {
            return redirect()->route('owner.dashboard')->with('error', 'Motor yang sedang disewa tidak dapat diubah ke status perawatan.');
        }

        $motor->status = ($motor->status === 'perawatan') ? 'tersedia' : 'perawatan';
        $motor->save();

        $message = ($motor->status === 'perawatan') ? 'Motor berhasil diatur ke status perawatan.' : 'Motor berhasil dikembalikan ke status tersedia.';
        
        return redirect()->route('owner.dashboard')->with('success', $message);
    }

    public function getMotorDetails($id)
    {
        $motor = Motor::where('id', $id)
                     ->where('pemilik_id', Auth::id())
                     ->with(['tarifRental'])
                     ->firstOrFail();
        
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
                'tarifs' => $motor->tarifRental ? [
                    'tarif_harian' => $motor->tarifRental->tarif_harian,
                    'tarif_mingguan' => $motor->tarifRental->tarif_mingguan,
                    'tarif_bulanan' => $motor->tarifRental->tarif_bulanan,
                ] : null
            ]
        ]);
    }

    public function motors()
    {
        $user = Auth::user();
        
        if ($user->role !== 'pemilik') {
            return redirect()->route('login')->with('error', 'Access denied');
        }

        $motors = Motor::where('pemilik_id', $user->id)
                      ->with(['tarifRental', 'penyewaan'])
                      ->orderBy('created_at', 'desc')
                      ->paginate(10);

        // Statistics
        $totalMotors = Motor::where('pemilik_id', $user->id)->count();
        $activeMotors = Motor::where('pemilik_id', $user->id)->where('status', 'tersedia')->count();
        $rentedMotors = Motor::where('pemilik_id', $user->id)->where('status', 'disewa')->count();
        $maintenanceMotors = Motor::where('pemilik_id', $user->id)->where('status', 'perawatan')->count();
        $pendingMotors = Motor::where('pemilik_id', $user->id)->where('status', 'pending')->count();

        return view('owner.motors', compact('motors', 'totalMotors', 'activeMotors', 'rentedMotors', 'maintenanceMotors', 'pendingMotors'));
    }
}
