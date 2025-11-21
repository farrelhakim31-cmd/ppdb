@extends('layouts.keuangan')

@section('title', 'Kelola Tagihan')
@section('page-title', 'Kelola Tagihan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="mb-1">Manajemen Tagihan Siswa</h5>
        <p class="text-muted mb-0">Kelola dan pantau tagihan pembayaran siswa</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('bills.unpaid-students') }}" class="btn btn-warning">
            <i class="fas fa-exclamation-triangle me-2"></i>Siswa Belum Lunas
        </a>
        <a href="{{ route('bills.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Buat Tagihan Baru
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Daftar Tagihan</h5>
            <div class="d-flex gap-2">
                <select class="form-select form-select-sm" style="width: auto;">
                    <option>Semua Status</option>
                    <option>Belum Bayar</option>
                    <option>Sudah Bayar</option>
                    <option>Terlambat</option>
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
                        <th>Jenis Tagihan</th>
                        <th>Jumlah</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bills ?? [] as $bill)
                    <tr>
                        <td>
                            <div>
                                <div class="fw-medium">{{ $bill->student->name ?? 'N/A' }}</div>
                                <small class="text-muted">{{ $bill->student->email ?? 'N/A' }}</small>
                            </div>
                        </td>
                        <td>{{ $bill->type ?? 'SPP' }}</td>
                        <td class="fw-bold">Rp {{ number_format($bill->amount, 0, ',', '.') }}</td>
                        <td>
                            <div>
                                {{ $bill->due_date->format('d/m/Y') }}
                                @if($bill->due_date->isPast() && $bill->status !== 'paid')
                                    <br><small class="text-danger"><i class="fas fa-exclamation-triangle"></i> Terlambat</small>
                                @endif
                            </div>
                        </td>
                        <td>
                            @if($bill->status === 'paid')
                                <span class="badge bg-success">Sudah Bayar</span>
                            @elseif($bill->due_date->isPast())
                                <span class="badge bg-danger">Terlambat</span>
                            @else
                                <span class="badge bg-warning">Belum Bayar</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('bills.show', $bill) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($bill->status !== 'paid')
                                <button type="button" class="btn btn-outline-success btn-sm" onclick="sendBillEmail({{ $bill->id }})">
                                    <i class="fas fa-envelope"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-file-invoice fa-3x mb-3"></i>
                            <p class="mb-0">Belum ada tagihan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(isset($bills) && $bills->hasPages())
        <div class="card-footer bg-white">
            {{ $bills->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function sendBillEmail(billId) {
    if (confirm('Apakah Anda yakin ingin mengirim tagihan ini ke email siswa?')) {
        fetch(`/bills/${billId}/send-email`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Email tagihan berhasil dikirim!');
            } else {
                alert('Gagal mengirim email: ' + (data.message || 'Terjadi kesalahan'));
            }
        })
        .catch(error => {
            alert('Terjadi kesalahan saat mengirim email');
        });
    }
}
</script>
@endpush