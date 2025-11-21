@extends('layouts.admin')

@section('title', 'Detail Pembayaran PPDB')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detail Pembayaran</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>No. Pendaftaran:</strong></div>
                        <div class="col-sm-8">{{ $payment->ppdbRegistration->registration_number }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>Nama:</strong></div>
                        <div class="col-sm-8">{{ $payment->ppdbRegistration->name }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>Email:</strong></div>
                        <div class="col-sm-8">{{ $payment->ppdbRegistration->email }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>Metode Pembayaran:</strong></div>
                        <div class="col-sm-8">
                            @if($payment->payment_method)
                                <span class="badge badge-info">{{ strtoupper($payment->payment_method) }}</span>
                            @else
                                <span class="text-muted">Tidak tersedia</span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>Jumlah Pembayaran:</strong></div>
                        <div class="col-sm-8">Rp {{ number_format($payment->amount, 0, ',', '.') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>Tanggal Upload:</strong></div>
                        <div class="col-sm-8">{{ $payment->created_at->format('d M Y, H:i') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>Status:</strong></div>
                        <div class="col-sm-8">
                            @if($payment->status == 'pending')
                                <span class="badge badge-warning">Menunggu Verifikasi</span>
                            @elseif($payment->status == 'verified')
                                <span class="badge badge-success">Terverifikasi</span>
                            @else
                                <span class="badge badge-danger">Ditolak</span>
                            @endif
                        </div>
                    </div>
                    
                    @if($payment->verified_at)
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>Diverifikasi oleh:</strong></div>
                        <div class="col-sm-8">{{ $payment->verifiedBy->name ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4"><strong>Tanggal Verifikasi:</strong></div>
                        <div class="col-sm-8">{{ $payment->verified_at->format('d M Y, H:i') }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Bukti Pembayaran</h3>
                </div>
                <div class="card-body text-center">
                    @if($payment->payment_proof)
                        <img src="{{ Storage::url($payment->payment_proof) }}" class="img-fluid mb-3" style="max-height: 300px;">
                        <br>
                        <a href="{{ Storage::url($payment->payment_proof) }}" target="_blank" class="btn btn-sm btn-primary">
                            <i class="fas fa-external-link-alt"></i> Lihat Full Size
                        </a>
                    @else
                        <p class="text-muted">Tidak ada bukti pembayaran</p>
                    @endif
                </div>
            </div>
            
            @if($payment->status == 'pending')
            <div class="card mt-3">
                <div class="card-header">
                    <h3 class="card-title">Verifikasi Pembayaran</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('keuangan.ppdb.verify', $payment->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Keputusan Verifikasi</label>
                            <select name="action" class="form-control" required>
                                <option value="">Pilih Keputusan</option>
                                <option value="approve">Setujui Pembayaran</option>
                                <option value="reject">Tolak Pembayaran</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Catatan (Opsional)</label>
                            <textarea name="notes" class="form-control" rows="3" placeholder="Tambahkan catatan jika diperlukan"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success btn-block">
                            <i class="fas fa-check"></i> Simpan Keputusan
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
    
    <div class="row mt-3">
        <div class="col-12">
            <a href="{{ route('keuangan.dashboard') }}" class="btn btn-secondary mr-2">
                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
            </a>
            <a href="{{ route('keuangan.ppdb') }}" class="btn btn-outline-secondary">
                <i class="fas fa-list"></i> Daftar PPDB
            </a>
        </div>
    </div>
</div>
@endsection