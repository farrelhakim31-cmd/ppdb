@extends('layouts.admin')

@section('title', 'Persyaratan Pendaftaran')

@section('content')
@php
use Illuminate\Support\Facades\Storage;
@endphp
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Persyaratan Pendaftaran - {{ $registration->name }}</h1>
        <a href="{{ route('admin.ppdb.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
    
    <div class="card shadow">
                <div class="card-body">
                    <!-- Progress Bar -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Kelengkapan Persyaratan</span>
                            <span class="badge badge-{{ $completionPercentage >= 80 ? 'success' : ($completionPercentage >= 50 ? 'warning' : 'danger') }}">
                                {{ $completionPercentage }}%
                            </span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-{{ $completionPercentage >= 80 ? 'success' : ($completionPercentage >= 50 ? 'warning' : 'danger') }}" 
                                 style="width: {{ $completionPercentage }}%"></div>
                        </div>
                    </div>

                    <!-- Requirements List -->
                    <div class="row">
                        @foreach($requirements as $key => $requirement)
                        <div class="col-md-6 mb-3">
                            <div class="card border-{{ $requirement['status'] ? 'success' : 'danger' }}">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="mr-3">
                                            @if($requirement['status'])
                                                <i class="fas fa-check-circle text-success fa-2x"></i>
                                            @else
                                                <i class="fas fa-times-circle text-danger fa-2x"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <h6 class="mb-1">{{ $requirement['label'] }}</h6>
                                            <small class="text-muted">
                                                Status: 
                                                <span class="badge badge-{{ $requirement['status'] ? 'success' : 'danger' }}">
                                                    {{ $requirement['status'] ? 'Lengkap' : 'Belum Lengkap' }}
                                                </span>
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Documents Detail -->
                    @if($registration->documents()->count() > 0)
                    <div class="mt-4">
                        <h6>Detail Dokumen Pendukung</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Jenis Dokumen</th>
                                        <th>Nama File</th>
                                        <th>Ukuran</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($registration->documents()->get() as $doc)
                                    <tr>
                                        <td>{{ $doc->jenis }}</td>
                                        <td>{{ $doc->nama_file }}</td>
                                        <td>{{ $doc->ukuran_kb }} KB</td>
                                        <td>
                                            <span class="badge badge-{{ $doc->valid ? 'success' : 'warning' }}">
                                                {{ $doc->valid ? 'Valid' : 'Perlu Review' }}
                                            </span>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#documentModal{{ $doc->id }}">
                                                <i class="fas fa-eye"></i> Lihat
                                            </button>
                                            @if(!$doc->valid)
                                            <form action="{{ route('admin.ppdb.validate-document', $doc->id) }}" method="POST" class="d-inline ml-1">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                    <!-- Payment Detail -->
                    @if($registration->payment)
                    <div class="mt-4">
                        <h6>Detail Pembayaran</h6>
                        <div class="card border-info">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Jumlah:</strong> Rp {{ number_format($registration->payment->amount, 0, ',', '.') }}</p>
                                        <p><strong>Metode:</strong> {{ $registration->payment->payment_method ?? 'Transfer Bank' }}</p>
                                        <p><strong>Tanggal:</strong> {{ $registration->payment->payment_date ? $registration->payment->payment_date->format('d/m/Y') : '-' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Status:</strong> 
                                            <span class="badge badge-{{ $registration->payment->status === 'verified' ? 'success' : 'warning' }}">
                                                {{ ucfirst($registration->payment->status) }}
                                            </span>
                                        </p>
                                        @if($registration->payment->payment_proof)
                                        <p><strong>Bukti Pembayaran:</strong></p>
                                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#paymentProofModal">
                                            <i class="fas fa-receipt"></i> Lihat Bukti
                                        </button>
                                        <p class="text-muted mt-2"><small>*Validasi pembayaran hanya dapat dilakukan oleh bagian keuangan</small></p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="mt-4 text-center">
                        @if($completionPercentage >= 80 && $registration->status === 'pending')
                            <form action="{{ route('admin.ppdb.verify', $registration) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-check"></i> Verifikasi Berkas
                                </button>
                            </form>
                        @endif
                        
                        @if($registration->status === 'verified')
                            <form action="{{ route('admin.ppdb.accept', $registration) }}" method="POST" class="d-inline mr-2">
                                @csrf
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-thumbs-up"></i> Terima
                                </button>
                            </form>
                            <form action="{{ route('admin.ppdb.reject', $registration) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-thumbs-down"></i> Tolak
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
</div>

<!-- Document Modals -->
@foreach($registration->documents()->get() as $doc)
<div class="modal fade" id="documentModal{{ $doc->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $doc->jenis }} - {{ $doc->nama_file }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img src="{{ Storage::url($doc->url) }}" class="img-fluid" alt="{{ $doc->jenis }}">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Payment Proof Modal -->
@if($registration->payment && $registration->payment->payment_proof)
<div class="modal fade" id="paymentProofModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bukti Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img src="{{ Storage::url($registration->payment->payment_proof) }}" class="img-fluid" alt="Bukti Pembayaran">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endif
@endsection