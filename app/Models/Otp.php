<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Otp extends Model
{
    protected $fillable = [
        'email',
        'phone',
        'otp_code',
        'delivery_method',
        'expires_at',
        'is_used'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_used' => 'boolean'
    ];

    public static function generateOtp($email, $phone = null, $deliveryMethod = 'email')
    {
        // Hapus OTP lama yang belum digunakan
        if ($deliveryMethod === 'email') {
            self::where('email', $email)->where('is_used', false)->delete();
        } else {
            self::where('phone', $phone)->where('is_used', false)->delete();
        }
        
        // Generate OTP 6 digit
        $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        return self::create([
            'email' => $email,
            'phone' => $phone,
            'otp_code' => $otpCode,
            'delivery_method' => $deliveryMethod,
            'expires_at' => Carbon::now()->addMinutes(5), // OTP berlaku 5 menit
            'is_used' => false
        ]);
    }

    public function isExpired()
    {
        return Carbon::now()->isAfter($this->expires_at);
    }

    public function isValid()
    {
        return !$this->is_used && !$this->isExpired();
    }
}