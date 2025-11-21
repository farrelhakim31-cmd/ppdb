<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\SystemService;
use App\Models\PpdbRegistration;

class SendBillNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $registrationId;
    protected $amount;

    public function __construct($registrationId, $amount)
    {
        $this->registrationId = $registrationId;
        $this->amount = $amount;
    }

    public function handle()
    {
        $registration = PpdbRegistration::find($this->registrationId);
        
        if ($registration) {
            // Kirim notifikasi ke keuangan
            SystemService::notifyKeuangan(
                'Tagihan PPDB Baru',
                "Tagihan sebesar Rp " . number_format($this->amount, 0, ',', '.') . " untuk pendaftaran {$registration->registration_number} ({$registration->name}) perlu dibuat",
                'warning'
            );
            
            // Log activity
            SystemService::logActivity('bill_notification_sent', $registration, "Bill notification sent for registration {$registration->registration_number}");
        }
    }
}