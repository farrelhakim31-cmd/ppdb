<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Otp;
use App\Models\User;

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

    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'phone' => 'nullable|string|max:20',
                'password' => 'required|string|confirmed',
            ]);

            $user = \App\Models\User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'role' => 'siswa',
            ]);

            // Simpan data user di session untuk OTP
            session([
                'otp_email' => $user->email,
                'otp_phone' => $user->phone,
                'otp_session_time' => now()
            ]);
            
            // Redirect ke halaman pilihan metode pengiriman OTP
            return redirect()->route('otp.delivery-choice')->with('success', 'Akun berhasil dibuat! Silakan verifikasi dengan OTP.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan saat membuat akun.'])->withInput();
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            
            // Redirect berdasarkan role dengan pengecekan ketat
            switch ($user->role) {
                case 'siswa':
                    return redirect()->intended(route('siswa.dashboard'));
                case 'admin':
                    return redirect()->intended(route('admin-panitia.dashboard'));
                case 'kepala':
                    return redirect()->intended(route('kepala.dashboard'));
                case 'keuangan':
                    return redirect()->intended(route('keuangan.dashboard'));
                case 'verifikator':
                    return redirect()->intended(route('verifikator-admin.dashboard'));
                default:
                    Auth::logout();
                    return back()->withErrors(['email' => 'Role tidak valid.']);
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('home');
    }
}