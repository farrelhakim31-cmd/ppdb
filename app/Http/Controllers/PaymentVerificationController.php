<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentVerificationController extends Controller
{
    public function index()
    {
        $pendingCount = Payment::where('status', 'pending')->count();
        $verifiedCount = Payment::where('status', 'verified')->count();
        $rejectedCount = Payment::where('status', 'rejected')->count();
        
        $payments = Payment::with(['student', 'ppdbRegistration.user', 'bill'])
            ->latest()
            ->paginate(15);

        return view('keuangan.payments.index', compact(
            'pendingCount',
            'verifiedCount',
            'rejectedCount',
            'payments'
        ));
    }

    public function show($id)
    {
        $payment = Payment::with('student')->findOrFail($id);
        
        return view('keuangan.payments.show', compact('payment'));
    }

    public function verify(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        
        $payment->update([
            'status' => 'verified',
            'verified_at' => now(),
            'verified_by' => auth()->id()
        ]);

        return redirect()->back()->with('success', 'Pembayaran berhasil diverifikasi');
    }
}