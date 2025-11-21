<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PpdbRegistration;
use App\Jobs\SendNotificationJob;
use Carbon\Carbon;

class SendPaymentReminders extends Command
{
    protected $signature = 'ppdb:send-payment-reminders';
    protected $description = 'Send payment reminders to registrants who haven\'t paid';

    public function handle()
    {
        $this->info('Sending payment reminders...');

        // Cari pendaftar yang belum bayar dan sudah 3 hari sejak daftar
        $registrations = PpdbRegistration::where('payment_status', '!=', 'paid')
            ->where('status', 'pending')
            ->where('created_at', '<=', Carbon::now()->subDays(3))
            ->where('created_at', '>=', Carbon::now()->subDays(7)) // Jangan kirim jika sudah lebih dari 7 hari
            ->get();

        $count = 0;
        foreach ($registrations as $registration) {
            // Cek apakah sudah pernah kirim reminder hari ini
            $lastReminder = $registration->notifications()
                ->where('type', 'payment_reminder')
                ->whereDate('created_at', Carbon::today())
                ->first();

            if (!$lastReminder) {
                SendNotificationJob::dispatch($registration->id, 'payment_reminder');
                $count++;
            }
        }

        $this->info("Payment reminders sent to {$count} registrants.");
        return 0;
    }
}