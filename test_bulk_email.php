<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\PpdbRegistration;
use App\Services\NotificationService;

echo "=== Testing Bulk Email ===\n\n";

$approvedRegistrations = PpdbRegistration::with('user')
    ->where('verification_status', 'approved')
    ->get();

echo "Total Approved: " . $approvedRegistrations->count() . "\n\n";

$sent = 0;
$failed = 0;
$noEmail = 0;

foreach ($approvedRegistrations as $registration) {
    echo "Processing ID: {$registration->id} - {$registration->name}\n";
    
    try {
        if (!$registration->user) {
            echo "  ❌ No user found\n";
            $noEmail++;
            continue;
        }

        if (!$registration->user->email) {
            echo "  ❌ No email found\n";
            $noEmail++;
            continue;
        }

        echo "  ✓ User: {$registration->user->name}\n";
        echo "  ✓ Email: {$registration->user->email}\n";
        echo "  ✓ Ready to send!\n";
        
        // Uncomment to actually send
        // NotificationService::sendAcceptanceEmail($registration->user, $registration);
        
        $sent++;
        
    } catch (\Exception $e) {
        echo "  ❌ Error: " . $e->getMessage() . "\n";
        $failed++;
    }
    
    echo "\n";
}

echo "=== Summary ===\n";
echo "✓ Ready to send: {$sent}\n";
echo "❌ Failed: {$failed}\n";
echo "⚠ No email: {$noEmail}\n";
