<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Registration;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('registration')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('admin.invoices.index', compact('invoices'));
    }

    public function create()
    {
        $registrations = \App\Models\PpdbRegistration::orderBy('name')->get();
        return view('admin.invoices.create', compact('registrations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'registration_id' => 'required|exists:registrations,id',
            'type' => 'required|string',
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date|after:today'
        ]);

        Invoice::create([
            'invoice_number' => Invoice::generateInvoiceNumber(),
            'registration_id' => $request->registration_id,
            'type' => $request->type,
            'description' => $request->description,
            'amount' => $request->amount,
            'due_date' => $request->due_date
        ]);

        return redirect()->route('admin.invoices.index')
            ->with('success', 'Tagihan berhasil dibuat');
    }

    public function show(Invoice $invoice)
    {
        return view('admin.invoices.show', compact('invoice'));
    }

    public function markAsPaid(Invoice $invoice)
    {
        $invoice->update([
            'status' => 'paid',
            'paid_at' => now()
        ]);

        return back()->with('success', 'Tagihan berhasil ditandai sebagai lunas');
    }

    public function studentInvoices()
    {
        $user = auth()->user();
        $registration = \App\Models\PpdbRegistration::where('email', $user->email)->first();
        
        if (!$registration) {
            return redirect()->back()->with('error', 'Data pendaftaran tidak ditemukan');
        }

        $invoices = Invoice::where('registration_id', $registration->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('student.invoices', compact('invoices', 'registration'));
    }
}