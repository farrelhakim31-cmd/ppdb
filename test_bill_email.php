<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Bill;
use App\Mail\BillNotification;
use Illuminate\Support\Facades\Mail;

echo "=== TEST EMAIL TAGIHAN ===\n\n";

// Ambil bill terakhir atau buat dummy
$bill = Bill::latest()->first();

if (!$bill) {
    echo "❌ Tidak ada data tagihan\n";
    echo "Silakan buat tagihan dulu dari halaman keuangan\n";
    exit;
}

echo "Bill ID: {$bill->id}\n";
echo "Deskripsi: {$bill->description}\n";
echo "Jumlah: Rp " . number_format($bill->amount, 0, ',', '.') . "\n\n";

try {
    $emailTo = 'farreltugas16@gmail.com';
    
    Mail::to($emailTo)->send(new BillNotification($bill));
    
    echo "✅ Email tagihan berhasil dikirim!\n";
    echo "Tujuan: {$emailTo}\n";
    echo "Subject: Tagihan Pembayaran - {$bill->description}\n\n";
    echo "Silakan cek inbox atau folder spam!\n";
    
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
