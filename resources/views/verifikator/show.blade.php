@extends('layouts.verifikator')

@section('title', 'Verifikasi Pendaftar')
@section('page-title', 'Verifikasi Pendaftar')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <!-- Data Pendaftar -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Data Pendaftar</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">No. Pendaftaran</label>
                            <p class="fw-bold">{{ $registration->registration_number }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">Nama Lengkap</label>
                            <p class="fw-bold">{{ $registration->name }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">Email</label>
                            <p>{{ $registration->email }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">No. Telepon</label>
                            <p>{{ $registration->phone ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Tempat, Tanggal Lahir</label>
                            <p>{{ $registration->birth_place ?? '-' }}, {{ $registration->birth_date ? \Carbon\Carbon::parse($registration->birth_date)->format('d F Y') : '-' }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">Jenis Kelamin</label>
                            <p>{{ $registration->gender == 'L' ? 'Laki-laki' : ($registration->gender == 'P' ? 'Perempuan' : '-') }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">Asal Sekolah</label>
                            <p>{{ $registration->previous_school ?? '-' }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">Nama Orang Tua</label>
                            <p>{{ $registration->parent_name ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Berkas Dokumen -->
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Berkas Dokumen</h5>
            </div>
            <div class="card-body">
                @forelse($registration->documents ?? [] as $document)
                <div class="d-flex align-items-center justify-content-between p-3 mb-2 border rounded">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-file-pdf text-danger fa-2x me-3"></i>
                        <div>
                            <h6 class="mb-1">{{ $document->document_type }}</h6>
                            <small class="text-muted">{{ $document->original_name }}</small>
                        </div>
                    </div>
                    <div class="text-end">
                        @if($document->validation_status == 'valid')
                            <span class="badge bg-success mb-2">Valid</span>
                        @elseif($document->validation_status == 'invalid')
                            <span class="badge bg-danger mb-2">Invalid</span>
                        @else
                            <span class="badge bg-secondary mb-2">Belum Divalidasi</span>
                        @endif
                        <br>
                        <button class="btn btn-sm btn-outline-primary me-1" onclick="viewDocument('{{ $document->file_path }}')">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-success" onclick="validateDocument({{ $document->id }}, 'valid')">
                            <i class="fas fa-check"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger" onclick="validateDocument({{ $document->id }}, 'invalid')">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                @empty
                <div class="text-center py-4 text-muted">
                    <i class="fas fa-file-upload fa-2x mb-2"></i>
                    <p>Belum ada berkas yang diupload</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Status & Verifikasi -->
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Status & Verifikasi</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Status Saat Ini</label>
                    <div>
                        @if($registration->status == 'pending')
                            <span class="badge bg-warning fs-6">Pending</span>
                        @elseif($registration->status == 'terima')
                            <span class="badge bg-success fs-6">Diterima</span>
                        @elseif($registration->status == 'tolak')
                            <span class="badge bg-danger fs-6">Ditolak</span>
                        @endif
                    </div>
                </div>

                @if($registration->verification_notes)
                <div class="mb-3">
                    <label class="form-label">Catatan Verifikasi</label>
                    <div class="alert alert-info">
                        {{ $registration->verification_notes }}
                    </div>
                </div>
                @endif

                <form method="POST" action="{{ route('verifikator.verify', $registration->id) }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Hasil Verifikasi</label>
                        <select class="form-select" name="status" required>
                            <option value="">Pilih Status</option>
                            <option value="terima">Terima</option>
                            <option value="tolak">Tolak</option>
                            <option value="perbaikan">Perlu Perbaikan</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea class="form-control" name="notes" rows="3" 
                                  placeholder="Berikan catatan untuk keputusan verifikasi..."></textarea>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Verifikasi
                        </button>
                        <a href="{{ route('verifikator.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function viewDocument(filePath) {
    window.open('/storage/' + filePath, '_blank');
}

function validateDocument(documentId, status) {
    const notes = prompt('Catatan validasi (opsional):');
    
    fetch(`{{ route('verifikator.validate-document', '') }}/${documentId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            status: status,
            notes: notes
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => {
        alert('Terjadi kesalahan saat memvalidasi dokumen');
    });
}
</script>
@endpush