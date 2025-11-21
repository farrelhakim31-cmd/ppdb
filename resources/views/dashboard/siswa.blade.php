@extends('layouts.siswa')

@section('title', 'Dashboard Siswa')
@section('page-title', 'Dashboard Siswa')

@section('content')
<!-- Welcome Card -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-user-graduate fa-3x opacity-75"></i>
                    </div>
                    <div>
                        <h4 class="card-title mb-1">Selamat Datang, {{ Auth::user()->name }}!</h4>
                        <p class="card-text mb-0">Portal Siswa SMK BAKTI NUSANTARA 666</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status Pendaftaran -->
@if($registration ?? false)
<div class="card mb-4">
    <div class="card-header bg-white">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Status Pendaftaran PPDB</h5>
            @php
                $statusColors = ['pending' => 'warning', 'terima' => 'success', 'tolak' => 'danger'];
                $statusLabels = ['pending' => 'Pending', 'terima' => 'Diterima', 'tolak' => 'Ditolak'];
            @endphp
            <span class="badge bg-{{ $statusColors[$registration->status] ?? 'secondary' }}">
                {{ $statusLabels[$registration->status] ?? 'Pending' }}
            </span>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>No. Pendaftaran:</strong> {{ $registration->registration_number ?? 'N/A' }}</p>
                <p><strong>Tanggal Daftar:</strong> {{ $registration->created_at ? $registration->created_at->format('d/m/Y H:i') : 'N/A' }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Status Pembayaran:</strong> 
                    <span class="badge bg-{{ isset($registration->payment) && $registration->payment->status == 'verified' ? 'success' : 'warning' }}">
                        {{ isset($registration->payment) ? ucfirst($registration->payment->status) : 'Belum Bayar' }}
                    </span>
                </p>
            </div>
        </div>
        
        <div class="mt-3">
            @if($registration->payment_status == 'unpaid')
                <a href="{{ route('ppdb.payment', $registration->registration_number) }}" class="btn btn-primary">
                    <i class="fas fa-credit-card me-2"></i>Bayar Sekarang
                </a>
            @endif
        </div>
    </div>
</div>
@else
<div class="card mb-4 border-warning">
    <div class="card-body text-center">
        <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
        <h5>Belum Mendaftar PPDB</h5>
        <p class="text-muted">Anda belum melakukan pendaftaran PPDB. Silakan daftar terlebih dahulu.</p>
        <a href="{{ route('ppdb.register') }}" class="btn btn-warning">
            <i class="fas fa-user-plus me-2"></i>Daftar PPDB
        </a>
    </div>
</div>
@endif

<!-- Menu Cards -->
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="fas fa-credit-card fa-3x text-success mb-3"></i>
                <h5 class="card-title">Pembayaran</h5>
                <p class="card-text">Kelola pembayaran dan upload bukti bayar</p>
                <a href="{{ $registration ? route('ppdb.payment', $registration->registration_number) : '#' }}" class="btn btn-success">
                    {{ $registration && $registration->payment_status == 'unpaid' ? 'Bayar Sekarang' : 'Form Pembayaran' }}
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="fas fa-upload fa-3x text-warning mb-3"></i>
                <h5 class="card-title">Upload Dokumen</h5>
                <p class="card-text">Upload dokumen persyaratan PPDB</p>
                <a href="{{ $registration ? route('ppdb.documents', $registration->registration_number) : '#' }}" class="btn btn-warning">
                    Upload Dokumen
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="fas fa-search fa-3x text-primary mb-3"></i>
                <h5 class="card-title">Status Pendaftaran</h5>
                <p class="card-text">Lihat detail status pendaftaran PPDB</p>
                <a href="{{ route('siswa.status') }}" class="btn btn-primary">Lihat Status</a>
            </div>
        </div>
    </div>
    

</div>
@endsection