@extends('layouts.verifikator')

@section('title', 'Daftar Pendaftar')
@section('page-title', 'Daftar Pendaftar PPDB')

@section('content')
<!-- Filter Card -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Filter & Pencarian</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('verifikator.index') }}">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="terima" {{ request('status') == 'terima' ? 'selected' : '' }}>Diterima</option>
                                <option value="tolak" {{ request('status') == 'tolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pencarian</label>
                            <input type="text" class="form-control" name="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="Nama, email, atau nomor pendaftaran">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search me-1"></i>Cari
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Data Table -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Data Pendaftar ({{ $registrations->total() }} total)</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No. Pendaftaran</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Tanggal Daftar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($registrations as $registration)
                            <tr>
                                <td>
                                    <strong>{{ $registration->registration_number }}</strong>
                                </td>
                                <td>{{ $registration->name }}</td>
                                <td>{{ $registration->email }}</td>
                                <td>
                                    @if($registration->status == 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif($registration->status == 'terima')
                                        <span class="badge bg-success">Diterima</span>
                                    @elseif($registration->status == 'tolak')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td>{{ $registration->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('verifikator.show', $registration->id) }}" 
                                       class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye me-1"></i>Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                                    <p class="text-muted">Tidak ada data pendaftar</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($registrations->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $registrations->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection