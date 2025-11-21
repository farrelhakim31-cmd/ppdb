@extends('layouts.keuangan')

@section('title', 'Verifikasi Pembayaran')
@section('page-title', 'Verifikasi Pembayaran')

@section('content')
<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card stat-card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1">Pending</h6>
                        <h4 class="mb-0">{{ $pendingCount ?? 0 }}</h4>
                    </div>
                    <i class="fas fa-clock fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card stat-card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1">Verified</h6>
                        <h4 class="mb-0">{{ $verifiedCount ?? 0 }}</h4>
                    </div>
                    <i class="fas fa-check-circle fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card stat-card bg-danger text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1">Rejected</h6>
                        <h4 class="mb-0">{{ $rejectedCount ?? 0 }}</h4>
                    </div>
                    <i class="fas fa-times-circle fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payments Table -->
<div class="card">
    <div class="card-header bg-white">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Daftar Pembayaran</h5>
            <div class="d-flex gap-2">
                <select class="form-select form-select-sm" style="width: auto;">
                    <option>Semua Status</option>
                    <option>Pending</option>
                    <option>Verified</option>
                    <option>Rejected</option>
                </select>
                <input type="text" class="form-control form-control-sm" placeholder="Cari siswa..." style="width: 200px;">
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Siswa</th>
                        <th>Jenis Pembayaran</th>
                        <th>Jumlah</th>
                        <th>Metode Bayar</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments ?? [] as $payment)
                    <tr>
                        <td>
                            <div>
                                <div class="fw-medium">{{ $payment->student_name }}</div>
                                @if($payment->student)
                                    <small class="text-muted">{{ $payment->student->student_id ?? 'ID: ' . $payment->student->id }}</small>
                                @elseif($payment->ppdbRegistration)
                                    <small class="text-muted">PPDB: {{ $payment->ppdbRegistration->no_pendaftaran }}</small>
                                @else
                                    <small class="text-muted">ID: {{ $payment->id }}</small>
                                @endif
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $payment->payment_type_name }}</span>
                        </td>
                        <td class="fw-bold">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                        <td>
                            @if($payment->payment_method === 'bank_transfer')
                                <span class="badge bg-primary">Transfer Bank</span>
                            @elseif($payment->payment_method === 'e_wallet')
                                <span class="badge bg-info">E-Wallet</span>
                            @elseif($payment->payment_method === 'cash')
                                <span class="badge bg-success">Tunai</span>
                            @else
                                <span class="badge bg-secondary">{{ $payment->payment_method ?? 'Tidak diketahui' }}</span>
                            @endif
                        </td>
                        <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            @if($payment->status === 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($payment->status === 'verified')
                                <span class="badge bg-success">Verified</span>
                            @else
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('payments.show', $payment->id) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($payment->status === 'pending')
                                    <form action="{{ route('payments.verify', $payment->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-success btn-sm" onclick="return confirm('Verifikasi pembayaran ini?')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fas fa-inbox fa-3x mb-3"></i>
                            <p class="mb-0">Belum ada data pembayaran</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(isset($payments) && $payments->hasPages())
        <div class="card-footer bg-white">
            {{ $payments->links() }}
        </div>
        @endif
    </div>
</div>
@endsection