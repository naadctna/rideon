<?php

namespace App\Http\Controllers;

use App\Models\Motor;
use App\Models\TarifRental;
use App\Models\BagiHasil;
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

        $motors = Motor::where('pemilik_id', $user->id)
                      ->with(['tarifRental', 'penyewaan'])
                      ->get();

        // Statistics
        $totalMotors = $motors->count();
        $activeMotors = $motors->where('status', 'tersedia')->count();
        $rentedMotors = $motors->where('status', 'disewa')->count();
        $maintenanceMotors = $motors->where('status', 'perawatan')->count();
        
        // Calculate total revenue
        $totalRevenue = BagiHasil::whereHas('penyewaan.motor', function($query) use ($user) {
            $query->where('pemilik_id', $user->id);
        })->sum('bagi_hasil_pemilik');

        return view('owner.dashboard', compact('motors', 'totalMotors', 'activeMotors', 'rentedMotors', 'maintenanceMotors', 'totalRevenue'));
    }

    public function createMotor()
    {
        return view('owner.create-motor');
    }

    public function storeMotor(Request $request)
    {
        $request->validate([
            'merk' => 'required|string|max:255',
            'tipe_cc' => 'required|in:100,125,150',
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
        
        $revenues = BagiHasil::whereHas('penyewaan.motor', function($query) use ($user) {
            $query->where('pemilik_id', $user->id);
        })->with(['penyewaan.motor', 'penyewaan.penyewa'])
          ->orderBy('tanggal', 'desc')
          ->paginate(10);

        $totalRevenue = BagiHasil::whereHas('penyewaan.motor', function($query) use ($user) {
            $query->where('pemilik_id', $user->id);
        })->sum('bagi_hasil_pemilik');

        return view('owner.revenue', compact('revenues', 'totalRevenue'));
    }

    public function showMotor($id)
    {
        $motor = Motor::where('id', $id)
                     ->where('pemilik_id', Auth::id())
                     ->with(['tarifRental', 'penyewaan.bagiHasil'])
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
            'tipe_cc' => 'required|in:100,125,150',
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
}
