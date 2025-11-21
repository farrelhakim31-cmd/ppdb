@extends('layouts.admin')

@section('title', 'Kelola PPDB')
@section('page-title', 'Kelola PPDB')

@section('content')
<!-- Filter Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card stat-card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1">Pending</h6>
                        <h4 class="mb-0">{{ $registrations->where('status', 'pending')->count() }}</h4>
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
                        <h6 class="card-title mb-1">Verified</h6>
                        <h4 class="mb-0">{{ $registrations->where('status', 'terima')->count() }}</h4>
                    </div>
                    <i class="fas fa-check-circle fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1">Diterima</h6>
                        <h4 class="mb-0">{{ $registrations->where('status', 'terima')->count() }}</h4>
                    </div>
                    <i class="fas fa-user-check fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card bg-danger text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1">Ditolak</h6>
                        <h4 class="mb-0">{{ $registrations->where('status', 'tolak')->count() }}</h4>
                    </div>
                    <i class="fas fa-user-times fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Report Form -->
<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="card-title mb-0"><i class="fas fa-chart-bar me-2"></i>Laporan PPDB</h5>
    </div>
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Tanggal Mulai</label>
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Tanggal Akhir</label>
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="terima" {{ request('status') == 'terima' ? 'selected' : '' }}>Diterima</option>
                    <option value="tolak" {{ request('status') == 'tolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="{{ route('admin.ppdb.export') }}?{{ http_build_query(request()->all()) }}" class="btn btn-success">Export CSV</a>
                    <a href="{{ route('admin.ppdb.export-pdf') }}?{{ http_build_query(request()->all()) }}" class="btn btn-danger">Export PDF</a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Registration List -->
<div class="card">
    <div class="card-header bg-white">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Daftar Pendaftar PPDB</h5>
            <div class="d-flex gap-2">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari nama..." value="{{ request('search') }}" style="width: 200px;">
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive" style="overflow-x: auto;">
            <table class="table table-hover mb-0" style="min-width: 1200px;">
                <thead class="table-light">
                    <tr>
                        <th>No. Pendaftaran</th>
                        <th>Nama Siswa</th>
                        <th>Email</th>
                        <th>Status Pembayaran</th>
                        <th>Status Pendaftaran</th>
                        <th>Tanggal Daftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($registrations as $registration)
                    <tr>
                        <td class="fw-bold">{{ $registration->registration_number }}</td>
                        <td>{{ $registration->name }}</td>
                        <td>{{ $registration->email }}</td>
                        <td>
                            @if($registration->payment_status === 'paid')
                                <span class="badge bg-success">Lunas</span>
                            @elseif($registration->payment_status === 'pending')
                                <a href="{{ route('ppdb.status', $registration->registration_number) }}" class="badge bg-warning text-decoration-none">Pending</a>
                            @else
                                <a href="{{ route('ppdb.status', $registration->registration_number) }}" class="badge bg-danger text-decoration-none">Belum Bayar</a>
                            @endif
                        </td>
                        <td>
                            @if($registration->status === 'pending')
                                <span class="badge bg-warning">Pending Verifikasi</span>
                            @elseif($registration->status === 'terima')
                                <span class="badge bg-success">Diterima</span>
                            @elseif($registration->status === 'tolak')
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </td>
                        <td>{{ $registration->created_at->format('d/m/Y') }}</td>
                        <td style="white-space: nowrap;">
                            <a href="{{ route('admin.ppdb.show', $registration) }}" class="btn btn-outline-primary btn-sm me-1">
                                <i class="fas fa-eye"></i>
                            </a>
                            
                            @if($registration->payment_status === 'paid')
                                @if($registration->status === 'pending' || $registration->status === 'tolak')
                                    <form method="POST" action="{{ route('admin.ppdb.accept', $registration) }}" class="d-inline me-1">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Yakin terima siswa {{ $registration->name }}?')">
                                            Terima
                                        </button>
                                    </form>
                                @endif
                                
                                @if($registration->status === 'pending' || $registration->status === 'terima')
                                    <form method="POST" action="{{ route('admin.ppdb.reject', $registration) }}" class="d-inline me-1">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin tolak siswa {{ $registration->name }}?')">
                                            Ditolak
                                        </button>
                                    </form>
                                @endif
                            @endif
                            
                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $registration->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fas fa-inbox fa-3x mb-3"></i>
                            <p class="mb-0">Belum ada data pendaftar</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Verification Modals -->
        @foreach($registrations as $registration)
        @if($registration->status === 'pending' && $registration->payment_status === 'paid')
        <div class="modal fade" id="verifyModal{{ $registration->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('admin.ppdb.verify', $registration) }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Verifikasi Pendaftar</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <strong>Nama:</strong> {{ $registration->name }}<br>
                                <strong>No. Pendaftaran:</strong> {{ $registration->registration_number }}<br>
                                <strong>Status Pembayaran:</strong> 
                                <span class="badge bg-success">Sudah Dikonfirmasi Keuangan</span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status Verifikasi</label>
                                <select name="verification_status" class="form-select" required>
                                    <option value="">Pilih Status</option>
                                    <option value="lulus">✓ Lulus - Data & Berkas Lengkap</option>
                                    <option value="tolak">✗ Tolak - Tidak Memenuhi Syarat</option>
                                    <option value="perbaikan">⚠ Perbaikan - Perlu Dilengkapi</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Catatan Verifikasi</label>
                                <textarea name="verification_notes" class="form-control" rows="3" placeholder="Berikan catatan detail hasil verifikasi..." required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Verifikasi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
        @endforeach
        
        <!-- Delete Modals -->
        @foreach($registrations as $registration)
        <div class="modal fade" id="deleteModal{{ $registration->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Hapus Data Siswa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Peringatan!</strong> Tindakan ini tidak dapat dibatalkan.
                        </div>
                        <p>Anda akan menghapus:</p>
                        <ul>
                            <li><strong>Nama:</strong> {{ $registration->name }}</li>
                            <li><strong>No. Pendaftaran:</strong> {{ $registration->registration_number }}</li>
                            <li><strong>Email:</strong> {{ $registration->email }}</li>
                        </ul>
                        <p>Data yang akan dihapus:</p>
                        <ul>
                            <li>Data pendaftaran siswa</li>
                            <li>Akun pengguna (jika ada)</li>
                            <li>Dokumen pendukung</li>
                            <li>Data pembayaran</li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <form method="POST" action="{{ route('admin.ppdb.destroy', $registration) }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Ya, Hapus Data</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        
        @if($registrations->hasPages())
        <div class="card-footer bg-white">
            {{ $registrations->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Info Alert -->
<div class="alert alert-info mt-4">
    <i class="fas fa-info-circle me-2"></i>
    <strong>Alur Kerja PPDB:</strong>
    <ol class="mb-0 mt-2">
        <li>Siswa melakukan pendaftaran dan upload berkas</li>
        <li>Siswa melakukan pembayaran</li>
        <li>Keuangan mengkonfirmasi pembayaran</li>
        <li><strong>Admin memverifikasi berkas dan menerima/menolak pendaftar</strong></li>
    </ol>
    <div class="mt-2">
        <small class="text-muted"><i class="fas fa-user-shield"></i> <strong>Hanya Admin</strong> yang dapat menerima, menolak, atau menghapus data siswa setelah pembayaran dikonfirmasi keuangan.</small>
    </div>
</div>
@endsection