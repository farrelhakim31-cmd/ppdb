@extends('layouts.keuangan')

@section('title', 'Keuangan PPDB')
@section('page-title', 'Keuangan PPDB')

@section('content')
<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card stat-card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1">Total Pendaftar</h6>
                        <h4 class="mb-0">{{ $totalRegistrations ?? 0 }}</h4>
                    </div>
                    <i class="fas fa-users fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1">Sudah Bayar</h6>
                        <h4 class="mb-0">{{ $paidRegistrations ?? 0 }}</h4>
                    </div>
                    <i class="fas fa-check-circle fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card bg-danger text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1">Belum Bayar</h6>
                        <h4 class="mb-0">{{ $unpaidRegistrations ?? 0 }}</h4>
                    </div>
                    <i class="fas fa-exclamation-circle fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1">Total Pemasukan</h6>
                        <h4 class="mb-0">Rp {{ number_format($totalIncome ?? 0, 0, ',', '.') }}</h4>
                    </div>
                    <i class="fas fa-money-bill-wave fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Registration List -->
<div class="card">
    <div class="card-header bg-white">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Daftar Pendaftar PPDB</h5>
            <div class="d-flex gap-2">
                <form method="POST" action="{{ route('keuangan.ppdb.send-bulk-reminder') }}" class="d-inline" onsubmit="return confirm('Kirim email pengingat ke semua pendaftar yang belum bayar?')">
                    @csrf
                    <button type="submit" class="btn btn-warning btn-sm">
                        <i class="fas fa-envelope me-1"></i>Kirim Email Pengingat
                    </button>
                </form>
                <select class="form-select form-select-sm" style="width: auto;">
                    <option>Semua Status</option>
                    <option>Belum Bayar</option>
                    <option>Sudah Bayar</option>
                    <option>Pending Verifikasi</option>
                </select>
                <input type="text" class="form-control form-control-sm" placeholder="Cari nama..." style="width: 200px;">
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No. Pendaftaran</th>
                        <th>Nama Siswa</th>
                        <th>Jurusan</th>
                        <th>Biaya Pendaftaran</th>
                        <th>Metode Bayar</th>
                        <th>Status Pembayaran</th>
                        <th>Tanggal Daftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($registrations ?? [] as $registration)
                    <tr>
                        <td class="fw-bold">{{ $registration->registration_number }}</td>
                        <td>
                            <div>
                                <div class="fw-medium">{{ $registration->full_name }}</div>
                                <small class="text-muted">{{ $registration->email }}</small>
                            </div>
                        </td>
                        <td>{{ $registration->major }}</td>
                        <td class="fw-bold">Rp {{ number_format($registration->payment->amount ?? 300000, 0, ',', '.') }}</td>
                        <td>
                            @if($registration->payment_method === 'bank_transfer')
                                <span class="badge bg-primary">Transfer Bank</span>
                            @elseif($registration->payment_method === 'e_wallet')
                                <span class="badge bg-info">E-Wallet</span>
                            @elseif($registration->payment_method === 'cash')
                                <span class="badge bg-success">Tunai</span>
                            @elseif($registration->payment_method === 'qris')
                                <span class="badge bg-warning">QRIS</span>
                            @else
                                <span class="badge bg-secondary">-</span>
                            @endif
                        </td>
                        <td>
                            @if($registration->payment_status === 'paid')
                                <span class="badge bg-success">Sudah Bayar</span>
                            @elseif($registration->payment_status === 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @else
                                <span class="badge bg-danger">Belum Bayar</span>
                            @endif
                        </td>
                        <td>{{ $registration->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('keuangan.ppdb.detail', $registration->id) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($registration->payment_status === 'pending')
                                    <form action="{{ route('keuangan.ppdb.verify', $registration->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-success btn-sm" onclick="return confirm('Verifikasi pembayaran ini?')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif
                                @if($registration->payment_status === 'unpaid')
                                    <button type="button" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#billModal{{ $registration->id }}">
                                        <i class="fas fa-file-invoice"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="fas fa-inbox fa-3x mb-3"></i>
                            <p class="mb-0">Belum ada data pendaftar</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(isset($registrations) && $registrations->hasPages())
        <div class="card-footer bg-white">
            {{ $registrations->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Bill Modals -->
@foreach($registrations ?? [] as $registration)
<div class="modal fade" id="billModal{{ $registration->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Buat Tagihan - {{ $registration->full_name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('keuangan.ppdb.create-bill', $registration->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Jenis Tagihan</label>
                        <select name="type" class="form-select" required>
                            <option value="">Pilih Jenis</option>
                            <option value="spp">SPP</option>
                            <option value="uniform">Seragam</option>
                            <option value="book">Buku</option>
                            <option value="exam">Ujian</option>
                            <option value="other">Lainnya</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Tagihan</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="amount" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jatuh Tempo</label>
                        <input type="date" name="due_date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea name="description" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="send_email" id="send_email{{ $registration->id }}" checked>
                        <label class="form-check-label" for="send_email{{ $registration->id }}">
                            <i class="fas fa-envelope me-1"></i>Kirim notifikasi ke email
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Buat Tagihan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection