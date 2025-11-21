<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PpdbRegistration;

class UpdatePpdbStatusSeeder extends Seeder
{
    public function run(): void
    {
        // Update existing registrations to use new status system
        $statusMapping = [
            'pending' => 'draft',
            'verified' => 'verifikasi_administrasi', 
            'accepted' => 'lulus',
            'rejected' => 'tidak_lulus'
        ];

        foreach ($statusMapping as $oldStatus => $newStatus) {
            PpdbRegistration::where('status', $oldStatus)
                ->update(['status' => $newStatus]);
        }

        // Update registrations with paid status to 'terbayar'
        PpdbRegistration::where('payment_status', 'paid')
            ->where('status', 'draft')
            ->update(['status' => 'terbayar']);
    }
}