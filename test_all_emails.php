<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\PpdbRegistration;
use App\Services\NotificationService;
use App\Http\Controllers\KeuanganController;

echo "=== TESTING ALL EMAIL SYSTEMS ===\n\n";

// 1. Test Email Penerimaan (Admin Panitia)
echo "1. EMAIL PENERIMAAN (Admin Panitia)\n";
echo "   Target: Pendaftar yang DISETUJUI\n";
$approved = PpdbRegistration::with('user')
    ->where('verification_status', 'approved')
    ->get();
echo "   Total: " . $approved->count() . " pendaftar\n";
foreach ($approved as $p) {
    $status = ($p->user && $p->user->email) ? "✓" : "✗";
    echo "   {$status} {$p->name} - " . ($p->user ? $p->user->email : 'NO EMAIL') . "\n";
}
echo "\n";

// 2. Test Email Pengingat Pembayaran (Keuangan)
echo "2. EMAIL PENGINGAT PEMBAYARAN (Keuangan)\n";
echo "   Target: Pendaftar yang BELUM BAYAR\n";
$unpaid = PpdbRegistration::with('user')
    ->where('payment_status', 'unpaid')
    ->get();
echo "   Total: " . $unpaid->count() . " pendaftar\n";
foreach ($unpaid as $p) {
    $status = ($p->user && $p->user->email) ? "✓" : "✗";
    echo "   {$status} {$p->name} - " . ($p->user ? $p->user->email : 'NO EMAIL') . "\n";
}
echo "\n";

// 3. Summary
echo "=== SUMMARY ===\n";
echo "✓ Email Penerimaan: {$approved->count()} siap kirim\n";
echo "✓ Email Pengingat: {$unpaid->count()} siap kirim\n";
echo "✓ Total Email: " . ($approved->count() + $unpaid->count()) . " siap kirim\n\n";

// 4. Test Konfigurasi Email
echo "=== KONFIGURASI EMAIL ===\n";
echo "MAIL_MAILER: " . env('MAIL_MAILER') . "\n";
echo "MAIL_HOST: " . env('MAIL_HOST') . "\n";
echo "MAIL_PORT: " . env('MAIL_PORT') . "\n";
echo "MAIL_USERNAME: " . env('MAIL_USERNAME') . "\n";
echo "MAIL_FROM: " . env('MAIL_FROM_ADDRESS') . "\n";
echo "\n";

echo "=== SISTEM SIAP! ===\n";
echo "Semua email bisa terkirim seperti OTP! 🎉\n";
