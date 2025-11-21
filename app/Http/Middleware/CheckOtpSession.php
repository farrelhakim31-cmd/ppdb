<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckOtpSession
{
    public function handle(Request $request, Closure $next)
    {
        $email = session('otp_email');
        $sessionTime = session('otp_session_time');
        
        // Jika ada session OTP, cek apakah sudah expired
        if ($email && $sessionTime) {
            // Jika session sudah expired (15 menit), hapus session
            if (now()->diffInMinutes($sessionTime) > 15) {
                session()->forget(['otp_email', 'otp_delivery_method', 'otp_session_time']);
                
                // Jika request adalah AJAX, return JSON response
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Session expired',
                        'redirect' => route('login')
                    ], 419);
                }
                
                // Jika bukan AJAX, redirect ke login
                return redirect()->route('login')->withErrors(['error' => 'Session expired. Silakan login ulang.']);
            }
        }
        
        return $next($request);
    }
}