@extends('layouts.kepala-sekolah')

@section('title', 'Laporan PPDB')
@section('page-title', 'Laporan PPDB')

@section('content')
<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Total Pendaftar</p>
                        <h3 class="mb-0">0</h3>
                    </div>
                    <i class="fas fa-users fa-2x text-primary"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Diterima</p>
                        <h3 class="mb-0">0</h3>
                    </div>
                    <i class="fas fa-check fa-2x text-success"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Pending</p>
                        <h3 class="mb-0">0</h3>
                    </div>
                    <i class="fas fa-clock fa-2x text-warning"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Ditolak</p>
                        <h3 class="mb-0">0</h3>
                    </div>
                    <i class="fas fa-times fa-2x text-danger"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pencarian -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-10">
                        <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan No. Pendaftaran, Nama, atau Email..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-2"></i>Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Filter & Export -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form id="reportForm" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Periode</label>
                        <select name="period" class="form-select">
                            <option value="all">Semua Data</option>
                            <option value="7">7 Hari Terakhir</option>
                            <option value="30">30 Hari Terakhir</option>
                            <option value="90">3 Bulan Terakhir</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="all">Semua Status</option>
                            <option value="pending">Pending</option>
                            <option value="terima">Diterima</option>
                            <option value="tolak">Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Format</label>
                        <select name="type" class="form-select">
                            <option value="excel">Excel</option>
                            <option value="pdf">PDF</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter me-2"></i>Filter
                        </button>
                    </div>
                    <div class="col-md-2">
                        <button type="button" onclick="exportData()" class="btn btn-success w-100">
                            <i class="fas fa-download me-2"></i>Export
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Data Table -->
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No. Pendaftaran</th>
                                <th>Nama</th>
                                <th>Jurusan</th>
                                <th>Status</th>
                                <th>Tanggal Daftar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($registrations as $registration)
                            <tr>
                                <td>{{ $registration->registration_number }}</td>
                                <td>{{ $registration->name }}</td>
                                <td>{{ $registration->major }}</td>
                                <td>
                                    @if($registration->status == 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif($registration->status == 'terima')
                                        <span class="badge bg-success">Diterima</span>
                                    @else
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td>{{ $registration->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                    Belum ada data pendaftaran
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($registrations->hasPages())
                <div class="mt-3">
                    {{ $registrations->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection