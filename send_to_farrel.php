<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Mail;

echo "=== KIRIM EMAIL KE farreltugas16@gmail.com ===\n\n";

try {
    // Email Penerimaan
    $data = [
        'name' => 'Farrel (Test)',
        'registration_number' => 'PPDB2024TEST',
        'major' => 'Rekayasa Perangkat Lunak',
        'school_name' => 'SMK Bakti Nusantara 666'
    ];
    
    Mail::send('emails.acceptance', $data, function($message) {
        $message->to('farreltugas16@gmail.com')
                ->subject('TEST - Selamat! Anda Diterima di SMK Bakti Nusantara 666');
    });
    
    echo "✅ Email Penerimaan berhasil dikirim!\n\n";
    
    // Email Pengingat Pembayaran
    $data2 = [
        'name' => 'Farrel (Test)',
        'registration_number' => 'PPDB2024TEST',
        'major' => 'Rekayasa Perangkat Lunak',
        'amount' => 300000,
        'school_name' => 'SMK Bakti Nusantara 666'
    ];
    
    Mail::send('emails.payment-reminder', $data2, function($message) {
        $message->to('farreltugas16@gmail.com')
                ->subject('TEST - Pengingat Pembayaran PPDB - SMK Bakti Nusantara 666');
    });
    
    echo "✅ Email Pengingat Pembayaran berhasil dikirim!\n\n";
    
    echo "=== SELESAI ===\n";
    echo "Silakan cek inbox: farreltugas16@gmail.com\n";
    echo "Atau cek folder SPAM jika tidak ada di inbox\n";
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
