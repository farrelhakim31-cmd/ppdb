@extends('layouts.admin')

@section('title', 'Detail Pendaftaran')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Detail Pendaftaran</h1>
        <a href="{{ route('admin.ppdb.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Data Pendaftar</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Nomor Pendaftaran:</strong><br>
                            <span class="h5 text-primary">{{ $registration->registration_number }}</span>
                        </div>
                        <div class="col-md-6">
                            <strong>Status:</strong><br>
                            @php
                                $statusClass = [
                                    'pending' => 'warning',
                                    'terima' => 'success',
                                    'tolak' => 'danger'
                                ];
                                $statusText = [
                                    'pending' => 'Menunggu Verifikasi',
                                    'terima' => 'Diterima',
                                    'tolak' => 'Ditolak'
                                ];
                            @endphp
                            <span class="badge bg-{{ $statusClass[$registration->status] ?? 'secondary' }} fs-6">
                                {{ $statusText[$registration->status] ?? 'Status Tidak Diketahui' }}
                            </span>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tr>
                                <td width="200"><strong>Nama Lengkap</strong></td>
                                <td>: {{ $registration->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Email</strong></td>
                                <td>: {{ $registration->email }}</td>
                            </tr>
                            <tr>
                                <td><strong>No. Telepon</strong></td>
                                <td>: {{ $registration->phone }}</td>
                            </tr>
                            <tr>
                                <td><strong>Tempat, Tanggal Lahir</strong></td>
                                <td>: {{ $registration->birth_place }}, {{ $registration->birth_date->format('d F Y') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Jenis Kelamin</strong></td>
                                <td>: {{ $registration->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Alamat</strong></td>
                                <td>: {{ $registration->address }}</td>
                            </tr>
                            <tr>
                                <td><strong>Asal Sekolah</strong></td>
                                <td>: {{ $registration->school_origin }}</td>
                            </tr>
                            <tr>
                                <td><strong>Nama Orang Tua</strong></td>
                                <td>: {{ $registration->parent_name }}</td>
                            </tr>
                            <tr>
                                <td><strong>No. Telepon Orang Tua</strong></td>
                                <td>: {{ $registration->parent_phone }}</td>
                            </tr>
                            <tr>
                                <td><strong>Pekerjaan Orang Tua</strong></td>
                                <td>: {{ $registration->parent_job }}</td>
                            </tr>
                            <tr>
                                <td><strong>Status Pembayaran</strong></td>
                                <td>: 
                                    @if($registration->payment_status === 'paid')
                                        <span class="badge bg-success">Lunas (Dikonfirmasi Keuangan)</span>
                                    @elseif($registration->payment_status === 'pending')
                                        <span class="badge bg-warning">Menunggu Konfirmasi</span>
                                    @else
                                        <span class="badge bg-danger">Belum Bayar</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Daftar</strong></td>
                                <td>: {{ $registration->created_at->format('d F Y H:i') }}</td>
                            </tr>
                            @if($registration->verified_at)
                            <tr>
                                <td><strong>Tanggal Verifikasi</strong></td>
                                <td>: {{ $registration->verified_at->format('d F Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Diverifikasi oleh</strong></td>
                                <td>: {{ $registration->verifier->name ?? 'Admin' }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>

                    @if($registration->documents && $registration->documents->count() > 0)
                    <h6 class="mt-4">Dokumen Pendukung:</h6>
                    <div class="row">
                        @foreach($registration->documents as $document)
                        <div class="col-md-4 mb-2">
                            <a href="{{ Storage::url($document->url) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-file"></i> {{ $document->nama_file ?? 'Dokumen ' . $loop->iteration }}
                            </a>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Aksi</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.ppdb.requirements', $registration) }}" class="btn btn-warning w-100 mb-2">
                        <i class="fas fa-clipboard-check"></i> Cek Ketentuan
                    </a>
                    
                    @if($registration->payment_status !== 'paid')
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Menunggu Konfirmasi Pembayaran</strong><br>
                            <small>Pembayaran harus dikonfirmasi oleh bagian keuangan sebelum dapat diverifikasi.</small>
                        </div>
                    @endif

                    @if($registration->status == 'pending' && $registration->payment_status === 'paid')
                    <button class="btn btn-primary w-100 mb-2" data-bs-toggle="modal" data-bs-target="#verifyModal">
                        <i class="fas fa-clipboard-check"></i> Verifikasi Berkas
                    </button>
                    
                    <form method="POST" action="{{ route('admin.ppdb.accept', $registration) }}" class="mb-2">
                        @csrf
                        <button type="submit" class="btn btn-success w-100" 
                                onclick="return confirm('Terima pendaftar ini?')">
                            <i class="fas fa-check"></i> Terima Pendaftar
                        </button>
                    </form>
                    
                    <form method="POST" action="{{ route('admin.ppdb.reject', $registration) }}" class="mb-2">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100" 
                                onclick="return confirm('Tolak pendaftar ini?')">
                            <i class="fas fa-times"></i> Tolak Pendaftar
                        </button>
                    </form>
                    @elseif($registration->status == 'pending' && $registration->payment_status !== 'paid')
                        <button class="btn btn-secondary w-100" disabled>
                            <i class="fas fa-clock"></i> Menunggu Konfirmasi Pembayaran
                        </button>
                    @endif

                    <button onclick="window.print()" class="btn btn-secondary w-100 mb-2">
                        <i class="fas fa-print"></i> Cetak Detail
                    </button>
                    
                    <button class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="fas fa-trash"></i> Hapus Data Siswa
                    </button>
                </div>
            </div>

            <div class="card shadow mt-3">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0">Riwayat Status</h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <i class="fas fa-plus-circle text-primary"></i>
                            <span>Pendaftaran dibuat</span>
                            <small class="text-muted d-block">{{ $registration->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                        @if($registration->verified_at)
                        <div class="timeline-item">
                            <i class="fas fa-check-circle text-info"></i>
                            <span>Berkas diverifikasi</span>
                            <small class="text-muted d-block">{{ $registration->verified_at->format('d/m/Y H:i') }}</small>
                        </div>
                        @endif
                        @if($registration->status == 'accepted')
                        <div class="timeline-item">
                            <i class="fas fa-thumbs-up text-success"></i>
                            <span>Pendaftar diterima</span>
                        </div>
                        @elseif($registration->status == 'rejected')
                        <div class="timeline-item">
                            <i class="fas fa-times-circle text-danger"></i>
                            <span>Pendaftar ditolak</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Verify Modal -->
<div class="modal fade" id="verifyModal" tabindex="-1">
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

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
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
                <p>Anda akan menghapus semua data untuk:</p>
                <ul>
                    <li><strong>Nama:</strong> {{ $registration->name }}</li>
                    <li><strong>No. Pendaftaran:</strong> {{ $registration->registration_number }}</li>
                    <li><strong>Email:</strong> {{ $registration->email }}</li>
                </ul>
                <p>Data yang akan dihapus:</p>
                <ul>
                    <li>Data pendaftaran siswa</li>
                    <li>Akun pengguna (jika ada)</li>
                    <li>Dokumen pendukung ({{ $registration->documents->count() }} file)</li>
                    <li>Data pembayaran</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form method="POST" action="{{ route('admin.ppdb.destroy', $registration) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Ya, Hapus Semua Data</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.timeline-item {
    padding: 10px 0;
    border-left: 2px solid #e9ecef;
    padding-left: 20px;
    position: relative;
}
.timeline-item i {
    position: absolute;
    left: -8px;
    background: white;
    padding: 2px;
}
</style>
@endsection