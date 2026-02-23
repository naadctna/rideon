<?php

namespace App\Http\Controllers;

use App\Models\Motor;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Jika user sudah login, redirect ke dashboard sesuai role
        if (auth()->check()) {
            $user = auth()->user();
            switch ($user->role) {
                case 'pemilik':
                    return redirect()->route('owner.dashboard');
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'penyewa':
                    return redirect()->route('renter.dashboard');
                default:
                    return redirect()->route('renter.dashboard');
            }
        }

        // Jika guest, tampilkan landing page
        $availableMotors = Motor::where('status', 'tersedia')
            ->with(['owner', 'tarifRental'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('landing', compact('availableMotors'));
    }
}