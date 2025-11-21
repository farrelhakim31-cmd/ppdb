<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

echo "=== TEST KIRIM EMAIL LANGSUNG ===\n\n";

$testEmail = 'farreltugas16@gmail.com';

try {
    echo "Mengirim ke: {$testEmail}\n";
    
    Mail::raw('Ini adalah test email dari sistem PPDB. Jika Anda menerima email ini, berarti sistem email sudah berfungsi dengan baik!', function($message) use ($testEmail) {
        $message->to($testEmail)
                ->subject('TEST EMAIL - Sistem PPDB Berhasil!');
    });
    
    Log::info("TEST: Email berhasil dikirim ke {$testEmail}");
    
    echo "\n✅ EMAIL BERHASIL DIKIRIM!\n\n";
    echo "Silakan cek:\n";
    echo "1. Inbox: {$testEmail}\n";
    echo "2. Folder Spam/Junk\n";
    echo "3. Search: from:farreltugas16@gmail.com\n\n";
    
    echo "Jika email tidak muncul dalam 2-3 menit, kemungkinan:\n";
    echo "- Masuk ke folder Spam (paling sering)\n";
    echo "- Delay dari Gmail server\n";
    echo "- Filter email aktif\n";
    
} catch (\Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "\nDetail:\n" . $e->getTraceAsString() . "\n";
}
