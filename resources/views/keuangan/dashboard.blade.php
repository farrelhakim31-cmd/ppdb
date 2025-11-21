@extends('layouts.keuangan')

@section('title', 'Dashboard Keuangan')
@section('page-title', 'Dashboard Keuangan')

@section('content')
<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card stat-card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1">Total Pendapatan</h6>
                        <h4 class="mb-0">Rp {{ number_format($totalIncome ?? 0, 0, ',', '.') }}</h4>
                    </div>
                    <i class="fas fa-money-bill-wave fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card stat-card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1">Pembayaran Pending</h6>
                        <h4 class="mb-0">{{ $pendingPayments ?? 0 }}</h4>
                    </div>
                    <i class="fas fa-clock fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card stat-card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1">Pembayaran Hari Ini</h6>
                        <h4 class="mb-0">{{ $todayPayments ?? 0 }}</h4>
                    </div>
                    <i class="fas fa-calendar-day fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card stat-card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1">Total Siswa</h6>
                        <h4 class="mb-0">{{ $totalStudents ?? 0 }}</h4>
                    </div>
                    <i class="fas fa-users fa-2x opacity-75"></i>
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
                <h5 class="card-title mb-0">Pembayaran Terbaru</h5>
            </div>
            <div class="card-body">
                @forelse($recentPayments ?? [] as $payment)
                <div class="d-flex justify-content-between align-items-center p-3 mb-2 bg-light rounded">
                    <div>
                        <h6 class="mb-1">{{ $payment->student_name }}</h6>
                        <small class="text-muted">{{ $payment->type }}</small>
                    </div>
                    <div class="text-end">
                        <span class="fw-bold text-success">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span><br>
                        <small class="text-muted">{{ $payment->created_at->format('d/m/Y') }}</small>
                    </div>
                </div>
                @empty
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-inbox fa-2x mb-2"></i>
                    <p>Belum ada pembayaran</p>
                </div>
                @endforelse
                <div class="mt-3">
                    <a href="{{ route('payments.verification') }}" class="btn btn-outline-primary btn-sm">
                        Lihat Semua Pembayaran <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-4">
        <!-- Notifikasi -->
        <div class="card mb-3">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Notifikasi Terbaru</h5>
                @if($notifications->count() > 0)
                    <span class="badge bg-danger">{{ $notifications->count() }}</span>
                @endif
            </div>
            <div class="card-body p-0" style="max-height: 300px; overflow-y: auto;">
                @forelse($notifications as $notification)
                    <div class="p-3 border-bottom notification-item {{ $notification->type }}">
                        <div class="d-flex align-items-start">
                            <div class="notification-icon me-3">
                                @if($notification->type == 'warning')
                                    <i class="fas fa-exclamation-triangle text-warning"></i>
                                @elseif($notification->type == 'success')
                                    <i class="fas fa-check-circle text-success"></i>
                                @elseif($notification->type == 'danger')
                                    <i class="fas fa-times-circle text-danger"></i>
                                @else
                                    <i class="fas fa-info-circle text-info"></i>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 fs-6">{{ $notification->title }}</h6>
                                <p class="mb-1 text-muted small">{{ $notification->message }}</p>
                                <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-bell-slash fa-2x mb-2"></i>
                        <p class="mb-0">Tidak ada notifikasi baru</p>
                    </div>
                @endforelse
                @if($notifications->count() > 0)
                    <div class="p-3 text-center">
                        <a href="{{ route('notifications.index') }}" class="btn btn-sm btn-outline-primary">
                            Lihat Semua Notifikasi
                        </a>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Menu Cepat -->
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Menu Cepat</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('payments.verification') }}" class="btn btn-outline-primary">
                        <i class="fas fa-check-circle me-2"></i>Verifikasi Pembayaran
                    </a>
                    <a href="{{ route('keuangan.ppdb') }}" class="btn btn-outline-success">
                        <i class="fas fa-user-graduate me-2"></i>PPDB Keuangan
                    </a>
                    <a href="{{ route('notifications.index') }}" class="btn btn-outline-info">
                        <i class="fas fa-bell me-2"></i>Notifikasi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.notification-item {
    transition: background-color 0.2s ease;
}

.notification-item:hover {
    background-color: #f8f9fa;
}

.notification-icon {
    width: 24px;
    text-align: center;
}

.stat-card {
    border: none;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: transform 0.2s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
}
</style>
@endpush