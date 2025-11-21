@extends('layouts.admin')

@section('title', 'Detail Pembayaran')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Detail Pembayaran</h1>
        <div>
            <a href="{{ route('keuangan.dashboard') }}" class="btn btn-secondary mr-2">
                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
            </a>
            <a href="{{ route('payments.verification') }}" class="btn btn-outline-secondary">
                <i class="fas fa-list"></i> Daftar Pembayaran
            </a>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Jumlah:</strong> Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                    <p><strong>Metode:</strong> {{ $payment->payment_method }}</p>
                    <p><strong>Tanggal:</strong> {{ $payment->payment_date->format('d/m/Y') }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Status:</strong> 
                        <span class="badge badge-{{ $payment->status === 'verified' ? 'success' : 'warning' }}">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </p>
                    @if($payment->payment_proof)
                    <p><strong>Bukti Pembayaran:</strong></p>
                    <img src="{{ Storage::url($payment->payment_proof) }}" class="img-fluid" style="max-width: 300px;">
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection