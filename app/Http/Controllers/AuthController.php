<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            
            // Redirect based on role
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

        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'no_tlpn' => 'required|string|max:15',
            'role' => 'required|in:penyewa,pemilik',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_tlpn' => $request->no_tlpn,
            'role' => $request->role,
        ]);

        Auth::login($user);

        // Redirect based on role
        switch ($user->role) {
            case 'pemilik':
                return redirect()->route('owner.dashboard');
            case 'penyewa':
                return redirect()->route('renter.dashboard');
            default:
                return redirect()->route('renter.dashboard');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
