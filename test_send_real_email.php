<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\PpdbRegistration;
use Illuminate\Support\Facades\Mail;

echo "=== TEST KIRIM EMAIL SUNGGUHAN ===\n\n";

// Test kirim ke 1 email dulu
$registration = PpdbRegistration::with('user')
    ->where('verification_status', 'approved')
    ->first();

if (!$registration || !$registration->user) {
    echo "❌ Tidak ada data pendaftar yang disetujui\n";
    exit;
}

$user = $registration->user;
echo "Mengirim email ke: {$user->email}\n";
echo "Nama: {$user->name}\n\n";

try {
    $data = [
        'name' => $user->name,
        'registration_number' => $registration->registration_number ?? $registration->no_pendaftaran,
        'major' => $registration->major,
        'school_name' => 'SMK Bakti Nusantara 666'
    ];
    
    Mail::send('emails.acceptance', $data, function($message) use ($user) {
        $message->to($user->email)
                ->subject('Selamat! Anda Diterima di SMK Bakti Nusantara 666');
    });
    
    echo "✅ Email berhasil dikirim!\n";
    echo "Silakan cek inbox: {$user->email}\n";
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "\nDetail Error:\n";
    echo $e->getTraceAsString() . "\n";
}
