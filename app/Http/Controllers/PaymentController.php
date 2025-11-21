<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\PpdbRegistration;
use Illuminate\Http\Request;
use App\Services\SystemService;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'ppdb_registration_id' => 'required|exists:ppdb_registrations,id',
            'amount' => 'required|numeric|min:0',
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        $registration = PpdbRegistration::findOrFail($request->ppdb_registration_id);
        
        // Upload bukti pembayaran
        $file = $request->file('payment_proof');
        $filename = 'payment_' . $registration->registration_number . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('payment-proofs', $filename, 'public');

        // Buat pembayaran dengan status pending
        $payment = Payment::create([
            'ppdb_registration_id' => $registration->id,
            'amount' => $request->amount,
            'payment_date' => now(),
            'status' => 'pending',
            'payment_proof' => $path,
            'description' => 'Biaya Pendaftaran PPDB',
            'receipt_number' => 'PAY' . time() . rand(1000, 9999)
        ]);

        // Kirim notifikasi ke keuangan
        SystemService::notifyKeuangan(
            'Pembayaran PPDB Baru',
            "Pembayaran untuk pendaftaran {$registration->registration_number} perlu diverifikasi",
            'info'
        );

        return redirect()->route('siswa.status')->with('success', 'Pembayaran berhasil diupload dan menunggu verifikasi dari bagian keuangan.');
    }
}