@extends('layouts.verifikator')

@section('title', 'Dashboard Verifikator')
@section('page-title', 'Dashboard Verifikator Administrasi')

@section('content')
<!-- Welcome Card -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-clipboard-check fa-3x opacity-75"></i>
                    </div>
                    <div>
                        <h4 class="card-title mb-1">Selamat Datang, {{ Auth::user()->name }}</h4>
                        <p class="card-text mb-0">Verifikator Administrasi PPDB</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card stat-card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1">Menunggu Verifikasi</h6>
                        <h4 class="mb-0">{{ $pendingVerification }}</h4>
                    </div>
                    <i class="fas fa-clock fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card stat-card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1">Diverifikasi Hari Ini</h6>
                        <h4 class="mb-0">{{ $verifiedToday }}</h4>
                    </div>
                    <i class="fas fa-check-circle fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card stat-card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1">Total Diproses</h6>
                        <h4 class="mb-0">{{ $totalProcessed }}</h4>
                    </div>
                    <i class="fas fa-tasks fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pending Registrations -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Pendaftaran Menunggu Verifikasi</h5>
                <a href="{{ route('verifikator.index') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-list me-1"></i>Lihat Semua
                </a>
            </div>
            <div class="card-body">
                @forelse($recentRegistrations as $registration)
                <div class="d-flex align-items-center justify-content-between p-3 mb-2 bg-light rounded">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-user-graduate text-primary fa-2x"></i>
                        </div>
                        <div>
                            <h6 class="mb-1">{{ $registration->name }}</h6>
                            <small class="text-muted">{{ $registration->registration_number }} • {{ $registration->email }}</small>
                            <br>
                            <small class="text-muted">Daftar: {{ $registration->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-warning mb-2">Pending</span>
                        <br>
                        <a href="{{ route('verifikator.show', $registration->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye me-1"></i>Verifikasi
                        </a>
                    </div>
                </div>
                @empty
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-check-double fa-3x mb-3"></i>
                    <p>Semua pendaftaran sudah diverifikasi</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection