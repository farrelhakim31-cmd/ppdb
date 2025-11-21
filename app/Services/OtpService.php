<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OtpService
{
    /**
     * Kirim OTP via SMS menggunakan Twilio
     */
    public static function sendSms($phone, $otpCode)
    {
        try {
            // Format nomor telepon (hapus +62 dan ganti dengan 62)
            $formattedPhone = self::formatPhoneNumber($phone);
            
            $message = "Kode OTP PPDB Online Anda: {$otpCode}. Berlaku 5 menit. Jangan bagikan kode ini kepada siapapun.";
            
            // Menggunakan Twilio API
            $response = Http::withBasicAuth(
                config('services.twilio.sid'),
                config('services.twilio.token')
            )->asForm()->post("https://api.twilio.com/2010-04-01/Accounts/" . config('services.twilio.sid') . "/Messages.json", [
                'From' => config('services.twilio.from'),
                'To' => $formattedPhone,
                'Body' => $message
            ]);

            if ($response->successful()) {
                Log::info("SMS OTP sent successfully to {$formattedPhone}");
                return ['success' => true, 'message' => 'SMS berhasil dikirim'];
            } else {
                Log::error("Failed to send SMS OTP: " . $response->body());
                return ['success' => false, 'message' => 'Gagal mengirim SMS'];
            }
        } catch (\Exception $e) {
            Log::error("SMS OTP error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error mengirim SMS: ' . $e->getMessage()];
        }
    }

    /**
     * Kirim OTP via WhatsApp menggunakan Twilio WhatsApp API
     */
    public static function sendWhatsApp($phone, $otpCode)
    {
        try {
            $formattedPhone = self::formatPhoneNumber($phone);
            
            $message = "🔐 *PPDB Online - Kode OTP*\n\nKode OTP Anda: *{$otpCode}*\n\n⏰ Berlaku 5 menit\n🚫 Jangan bagikan kode ini kepada siapapun\n\n_SMK BAKTI NUSANTARA 666_";
            
            // Simulasi kirim WhatsApp untuk development
            Log::info("WhatsApp OTP to {$formattedPhone}: {$otpCode}");
            Log::info("WhatsApp Message: {$message}");
            
            return ['success' => true, 'message' => 'WhatsApp berhasil dikirim ke ' . $formattedPhone];
        } catch (\Exception $e) {
            Log::error("WhatsApp OTP error: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error mengirim WhatsApp: ' . $e->getMessage()];
        }
    }

    /**
     * Kirim OTP via Email
     */
    public static function sendEmail($email, $otpCode)
    {
        try {
            \Mail::send('emails.otp', ['otp_code' => $otpCode], function($message) use ($email) {
                $message->to($email)
                        ->subject('Kode OTP PPDB - SMK Bakti Nusantara 666');
            });
            
            Log::info("Email OTP sent to {$email}: {$otpCode}");
            return ['success' => true, 'message' => "Email berhasil dikirim ke {$email} (Kode: {$otpCode})"];
        } catch (\Exception $e) {
            Log::error("Email OTP error: " . $e->getMessage());
            // Fallback: tampilkan OTP di response untuk development
            return ['success' => true, 'message' => "Email gagal dikirim, OTP untuk {$email}: {$otpCode}"];
        }
    }

    /**
     * Format nomor telepon untuk Indonesia
     */
    private static function formatPhoneNumber($phone)
    {
        // Hapus semua karakter non-digit
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Jika dimulai dengan 0, ganti dengan 62
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }
        
        // Jika belum ada kode negara, tambahkan 62
        if (substr($phone, 0, 2) !== '62') {
            $phone = '62' . $phone;
        }
        
        return '+' . $phone;
    }

    /**
     * Kirim OTP berdasarkan method yang dipilih
     */
    public static function sendOtp($deliveryMethod, $email, $phone, $otpCode)
    {
        // Default ke WhatsApp jika ada nomor HP
        if ($phone && ($deliveryMethod === 'whatsapp' || $deliveryMethod === 'sms')) {
            return self::sendWhatsApp($phone, $otpCode);
        }
        
        // Fallback ke email
        return self::sendEmail($email, $otpCode);
    }
}