<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\PpdbRegistration;

echo "=== Checking Unpaid Registrations ===\n\n";

$unpaid = PpdbRegistration::where('payment_status', 'unpaid')
    ->with('user')
    ->get();

echo "Total Belum Bayar: " . $unpaid->count() . "\n\n";

if ($unpaid->isEmpty()) {
    echo "✓ Semua pendaftar sudah bayar!\n";
} else {
    foreach ($unpaid as $p) {
        echo "ID: {$p->id}\n";
        echo "Name: " . ($p->name ?? 'N/A') . "\n";
        echo "Email: " . ($p->email ?? 'N/A') . "\n";
        echo "User ID: " . ($p->user_id ?? 'NULL') . "\n";
        echo "User Email: " . ($p->user ? $p->user->email : 'NO USER') . "\n";
        echo "User Name: " . ($p->user ? $p->user->name : 'NO USER') . "\n";
        echo "Payment Status: " . ($p->payment_status ?? 'N/A') . "\n";
        echo "---\n";
    }
}

echo "\n=== Summary ===\n";
echo "Total Unpaid: " . $unpaid->count() . "\n";
echo "With User: " . $unpaid->filter(fn($p) => $p->user)->count() . "\n";
echo "With Email: " . $unpaid->filter(fn($p) => $p->user && $p->user->email)->count() . "\n";
