@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')

@section('content')
<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-6 col-md-3 mb-3">
        <div class="card stat-card bg-primary text-white">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1 small">Total Pendaftar</h6>
                        <h4 class="mb-0">{{ $stats->total ?? 0 }}</h4>
                    </div>
                    <i class="fas fa-users fa-lg opacity-75 d-none d-sm-block"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-3">
        <div class="card stat-card bg-success text-white">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1 small">Diterima</h6>
                        <h4 class="mb-0">{{ $stats->terima ?? 0 }}</h4>
                    </div>
                    <i class="fas fa-check-circle fa-lg opacity-75 d-none d-sm-block"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-3">
        <div class="card stat-card bg-warning text-white">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1 small">Pending</h6>
                        <h4 class="mb-0">{{ $stats->pending ?? 0 }}</h4>
                    </div>
                    <i class="fas fa-clock fa-lg opacity-75 d-none d-sm-block"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-3">
        <div class="card stat-card bg-danger text-white">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1 small">Ditolak</h6>
                        <h4 class="mb-0">{{ $stats->tolak ?? 0 }}</h4>
                    </div>
                    <i class="fas fa-times-circle fa-lg opacity-75 d-none d-sm-block"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Cards -->
<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Pendaftar Terbaru</h5>
            </div>
            <div class="card-body">
                @forelse($recentRegistrations ?? [] as $registration)
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center p-3 mb-2 bg-light rounded">
                    <div class="mb-2 mb-sm-0">
                        <h6 class="mb-1">{{ $registration->name }}</h6>
                        <small class="text-muted d-block d-sm-inline">{{ $registration->email }}</small>
                    </div>
                    <div class="text-start text-sm-end">
                        @php
                            $statusColors = ['pending' => 'warning', 'terima' => 'success', 'tolak' => 'danger'];
                            $statusLabels = ['pending' => 'Pending', 'terima' => 'Diterima', 'tolak' => 'Ditolak'];
                        @endphp
                        <span class="badge bg-{{ $statusColors[$registration->status] ?? 'secondary' }}">
                            {{ $statusLabels[$registration->status] ?? 'Pending' }}
                        </span><br>
                        <small class="text-muted">{{ $registration->created_at->format('d/m/Y') }}</small>
                    </div>
                </div>
                @empty
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-inbox fa-2x mb-2"></i>
                    <p>Belum ada pendaftar</p>
                </div>
                @endforelse
                <div class="mt-3">
                    <a href="{{ route('admin.ppdb.index') }}" class="btn btn-outline-primary btn-sm">
                        Lihat Semua Pendaftar <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Menu Admin</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.ppdb.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-users me-2"></i>Kelola PPDB
                    </a>
                    <a href="#" class="btn btn-outline-success">
                        <i class="fas fa-user-tie me-2"></i>Manajemen User
                    </a>
                    <a href="#" class="btn btn-outline-warning">
                        <i class="fas fa-cog me-2"></i>Pengaturan Sistem
                    </a>
                    <a href="#" class="btn btn-outline-info">
                        <i class="fas fa-chart-bar me-2"></i>Laporan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection