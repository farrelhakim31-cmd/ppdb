<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Registration;
use Illuminate\Http\Request;

class KeuanganInvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('registration')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('keuangan.invoices.index', compact('invoices'));
    }

    public function create()
    {
        $registrations = \App\Models\PpdbRegistration::orderBy('name')->get();
        return view('keuangan.invoices.create', compact('registrations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'registration_id' => 'required|exists:registrations,id',
            'type' => 'required|string',
            'description' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date|after:today',
            'priority' => 'nullable|string'
        ]);

        Invoice::create([
            'invoice_number' => Invoice::generateInvoiceNumber(),
            'registration_id' => $request->registration_id,
            'type' => $request->type,
            'description' => $request->description,
            'amount' => $request->amount,
            'due_date' => $request->due_date,
            'priority' => $request->priority ?? 'normal'
        ]);

        return redirect()->route('keuangan.invoices.index')
            ->with('success', 'Tagihan berhasil dibuat');
    }

    public function show(Invoice $invoice)
    {
        return view('keuangan.invoices.show', compact('invoice'));
    }

    public function markAsPaid(Invoice $invoice)
    {
        $invoice->update([
            'status' => 'paid',
            'paid_at' => now()
        ]);

        return back()->with('success', 'Tagihan berhasil ditandai sebagai lunas');
    }
}