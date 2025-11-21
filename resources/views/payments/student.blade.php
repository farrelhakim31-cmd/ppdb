@extends('partials.main')

@section('content')
<div class="container-fluid py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0"><i class="fas fa-receipt me-2 text-primary"></i>Riwayat Pembayaran</h5>
                    </div>
                    <div class="card-body p-0">
                        @forelse($payments as $payment)
                        <div class="payment-item border-bottom p-4">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="badge bg-light text-dark me-2">{{ $payment->payment_code }}</span>
                                        {!! $payment->status_badge !!}
                                    </div>
                                    <h6 class="mb-1">{{ $payment->type_name }}</h6>
                                    <p class="text-muted mb-2">{{ $payment->created_at->format('d F Y, H:i') }}</p>
                                    @if($payment->notes)
                                    <small class="text-muted">{{ $payment->notes }}</small>
                                    @endif
                                </div>
                                <div class="text-end">
                                    <div class="h5 mb-0 text-success">Rp {{ number_format($payment->amount, 0, ',', '.') }}</div>
                                    @if($payment->proof_image)
                                    <button class="btn btn-sm btn-outline-primary mt-2" onclick="viewProof('{{ asset('storage/' . $payment->proof_image) }}')">
                                        <i class="fas fa-eye"></i> Lihat Bukti
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-5">
                            <i class="fas fa-receipt fa-3x text-muted mb-3"></i>
                            <h6 class="text-muted">Belum ada riwayat pembayaran</h6>
                            <p class="text-muted">Upload bukti pembayaran untuk memulai</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0"><i class="fas fa-plus me-2"></i>Upload Bukti Pembayaran</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('payments.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Jenis Pembayaran</label>
                                <select name="type" class="form-select" required>
                                    <option value="">Pilih jenis</option>
                                    <option value="registration">Biaya Pendaftaran</option>
                                    <option value="spp">SPP</option>
                                    <option value="uniform">Seragam</option>
                                    <option value="book">Buku</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jumlah Pembayaran</label>
                                <input type="number" name="amount" class="form-control" placeholder="0" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Bukti Pembayaran</label>
                                <input type="file" name="proof_image" class="form-control" accept="image/*" required>
                                <small class="text-muted">Format: JPG, PNG (Max: 2MB)</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Catatan (Opsional)</label>
                                <textarea name="notes" class="form-control" rows="3" placeholder="Tambahkan catatan..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-upload me-2"></i>Upload Bukti
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Info Pembayaran -->
                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-header bg-light">
                        <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informasi Pembayaran</h6>
                    </div>
                    <div class="card-body">
                        <div class="payment-info">
                            <div class="info-item mb-3">
                                <strong>Bank Transfer:</strong>
                                <div class="mt-1">
                                    <small class="text-muted">BCA: 1234567890</small><br>
                                    <small class="text-muted">a.n. SMK Negeri 1</small>
                                </div>
                            </div>
                            <div class="info-item">
                                <strong>Biaya Pendaftaran:</strong>
                                <div class="text-success fw-bold">Rp 250.000</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Bukti Pembayaran -->
<div class="modal fade" id="proofModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bukti Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="proofImage" src="" class="img-fluid rounded" alt="Bukti Pembayaran">
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.payment-item:last-child { border-bottom: none !important; }
.card { border-radius: 12px; }
.payment-info .info-item { padding: 0.75rem 0; border-bottom: 1px solid #f1f1f1; }
.payment-info .info-item:last-child { border-bottom: none; }
</style>
@endpush

<script>
function viewProof(imageUrl) {
    document.getElementById('proofImage').src = imageUrl;
    new bootstrap.Modal(document.getElementById('proofModal')).show();
}
</script>
@endsection