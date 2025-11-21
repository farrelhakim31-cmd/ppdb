<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Services\OtpService;

class OtpController extends Controller
{
    public function showOtpForm()
    {
        $email = session('otp_email');
        $sessionTime = session('otp_session_time');
        
        // Validasi session
        if (!$email || !$sessionTime) {
            session()->forget(['otp_email', 'otp_delivery_method', 'otp_session_time']);
            return redirect()->route('login')->withErrors(['error' => 'Session expired. Silakan login ulang.']);
        }
        
        // Cek apakah session sudah expired (15 menit)
        if (now()->diffInMinutes($sessionTime) > 15) {
            session()->forget(['otp_email', 'otp_delivery_method', 'otp_session_time']);
            return redirect()->route('login')->withErrors(['error' => 'Session expired. Silakan login ulang.']);
        }
        
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            session()->forget(['otp_email', 'otp_delivery_method', 'otp_session_time']);
            return redirect()->route('login')->withErrors(['error' => 'User tidak ditemukan. Silakan login ulang.']);
        }
        
        return view('auth.otp-verification', [
            'email' => $email,
            'user' => $user,
            'delivery_method' => session('otp_delivery_method', 'email')
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp_code' => 'required|string|size:6'
        ]);

        $email = session('otp_email');
        $deliveryMethod = session('otp_delivery_method', 'email');
        $sessionTime = session('otp_session_time');
        
        // Validasi session
        if (!$email || !$sessionTime) {
            session()->forget(['otp_email', 'otp_delivery_method', 'otp_session_time']);
            return redirect()->route('login')->withErrors(['error' => 'Session expired. Silakan login ulang.']);
        }
        
        // Cek apakah session sudah expired (15 menit)
        if (now()->diffInMinutes($sessionTime) > 15) {
            session()->forget(['otp_email', 'otp_delivery_method', 'otp_session_time']);
            return redirect()->route('login')->withErrors(['error' => 'Session expired. Silakan login ulang.']);
        }

        // Cari OTP yang valid berdasarkan delivery method
        $query = Otp::where('otp_code', $request->otp_code)
                    ->where('is_used', false);
        
        if ($deliveryMethod === 'email') {
            $query->where('email', $email);
        } else {
            $user = User::where('email', $email)->first();
            $query->where('phone', $user->phone);
        }
        
        $otp = $query->first();

        if (!$otp) {
            return back()->withErrors(['otp_code' => 'Kode OTP tidak valid.']);
        }

        if ($otp->isExpired()) {
            return back()->withErrors(['otp_code' => 'Kode OTP sudah kadaluarsa.']);
        }

        // Tandai OTP sebagai sudah digunakan
        $otp->update(['is_used' => true]);

        // Login user
        $user = User::where('email', $email)->first();
        Auth::login($user);
        
        // Regenerate session untuk keamanan
        $request->session()->regenerate();
        
        // Hapus session OTP
        session()->forget(['otp_email', 'otp_delivery_method', 'otp_session_time']);
        
        // Redirect ke dashboard siswa
        return redirect()->route('siswa.dashboard');
    }

    public function resendOtp(Request $request)
    {
        $email = session('otp_email');
        $deliveryMethod = session('otp_delivery_method', 'email');
        $sessionTime = session('otp_session_time');
        
        // Validasi session
        if (!$email || !$sessionTime) {
            return response()->json([
                'success' => false,
                'message' => 'Session expired',
                'redirect' => route('login')
            ]);
        }
        
        // Cek apakah session sudah expired (15 menit)
        if (now()->diffInMinutes($sessionTime) > 15) {
            session()->forget(['otp_email', 'otp_delivery_method', 'otp_session_time']);
            return response()->json([
                'success' => false,
                'message' => 'Session expired',
                'redirect' => route('login')
            ]);
        }

        $user = User::where('email', $email)->first();
        
        // Generate OTP baru
        $otp = Otp::generateOtp($email, $user->phone, $deliveryMethod);
        
        // Kirim OTP sesuai method yang dipilih
        $result = OtpService::sendOtp($deliveryMethod, $email, $user->phone, $otp->otp_code);
        
        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => $result['message']
            ]);
        }
        
        $deliveryText = [
            'email' => 'email',
            'sms' => 'SMS',
            'whatsapp' => 'WhatsApp'
        ];
        
        return response()->json([
            'success' => true,
            'message' => "Kode OTP baru telah dikirim ke {$deliveryText[$deliveryMethod]} Anda"
        ]);
    }
    
    public function chooseDeliveryMethod(Request $request)
    {
        $email = session('otp_email');
        $sessionTime = session('otp_session_time');
        
        // Validasi session
        if (!$email || !$sessionTime) {
            session()->forget(['otp_email', 'otp_delivery_method', 'otp_session_time']);
            return redirect()->route('login')->withErrors(['error' => 'Session expired. Silakan login ulang.']);
        }
        
        // Cek apakah session sudah expired (15 menit)
        if (now()->diffInMinutes($sessionTime) > 15) {
            session()->forget(['otp_email', 'otp_delivery_method', 'otp_session_time']);
            return redirect()->route('login')->withErrors(['error' => 'Session expired. Silakan login ulang.']);
        }
        
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            session()->forget(['otp_email', 'otp_delivery_method', 'otp_session_time']);
            return redirect()->route('login')->withErrors(['error' => 'User tidak ditemukan. Silakan login ulang.']);
        }
        
        return view('auth.otp-delivery-choice', [
            'email' => $email,
            'user' => $user
        ]);
    }
    
    public function setDeliveryMethod(Request $request)
    {
        $request->validate([
            'delivery_method' => 'required|in:email,sms,whatsapp'
        ]);
        
        $email = session('otp_email');
        $sessionTime = session('otp_session_time');
        
        // Validasi session
        if (!$email || !$sessionTime) {
            session()->forget(['otp_email', 'otp_delivery_method', 'otp_session_time']);
            return redirect()->route('login')->withErrors(['error' => 'Session expired. Silakan login ulang.']);
        }
        
        // Cek apakah session sudah expired (15 menit)
        if (now()->diffInMinutes($sessionTime) > 15) {
            session()->forget(['otp_email', 'otp_delivery_method', 'otp_session_time']);
            return redirect()->route('login')->withErrors(['error' => 'Session expired. Silakan login ulang.']);
        }
        
        $user = User::where('email', $email)->first();
        $deliveryMethod = $request->delivery_method;
        
        // Validasi phone jika pilih SMS atau WhatsApp
        if (in_array($deliveryMethod, ['sms', 'whatsapp']) && !$user->phone) {
            return back()->withErrors([
                'delivery_method' => 'Nomor telepon tidak tersedia. Silakan pilih email atau lengkapi profil Anda.'
            ]);
        }
        
        // Generate dan kirim OTP - prioritas WhatsApp jika ada nomor HP
        $otp = Otp::generateOtp($email, $user->phone, $deliveryMethod);
        
        // Jika pilih WhatsApp/SMS dan ada nomor HP, kirim ke WhatsApp
        if (in_array($deliveryMethod, ['sms', 'whatsapp']) && $user->phone) {
            $result = OtpService::sendWhatsApp($user->phone, $otp->otp_code);
        } else {
            $result = OtpService::sendEmail($email, $otp->otp_code);
        }
        
        if (!$result['success']) {
            return back()->withErrors([
                'delivery_method' => $result['message']
            ]);
        }
        
        // Simpan delivery method di session
        session(['otp_delivery_method' => $deliveryMethod]);
        
        $deliveryText = [
            'email' => 'email',
            'sms' => 'SMS',
            'whatsapp' => 'WhatsApp'
        ];
        
        return redirect()->route('otp.form')->with('success', "Kode OTP telah dikirim ke {$deliveryText[$deliveryMethod]} Anda");
    }
}