@extends('layouts.app')

@section('title', 'Status Pendaftaran PPDB')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Header -->
            <div class="text-center mb-4">
                <h2 class="fw-bold">Status Pendaftaran PPDB</h2>
                <p class="text-muted">No. Pendaftaran: {{ $registration->registration_number }}</p>
            </div>

            <!-- User Info Card -->
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Informasi Pendaftar</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nama:</strong> {{ $registration->name }}</p>
                            <p><strong>Email:</strong> {{ $registration->email }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Telepon:</strong> {{ $registration->phone }}</p>
                            <p><strong>Status:</strong> 
                                <span class="badge bg-{{ $registration->status == 'accepted' ? 'success' : ($registration->status == 'verified' ? 'info' : ($registration->status == 'rejected' ? 'danger' : 'warning')) }}">
                                    {{ $registration->status == 'accepted' ? 'Diterima' : ($registration->status == 'verified' ? 'Diverifikasi' : ($registration->status == 'rejected' ? 'Ditolak' : 'Menunggu')) }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Progress Card -->
            <div class="card shadow mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Progress Pendaftaran</h5>
                </div>
                <div class="card-body">
                    @php
                        $steps = [
                            ['name' => 'Data Pribadi', 'status' => !empty($registration->name) && !empty($registration->email)],
                            ['name' => 'Upload Dokumen', 'status' => (is_array($missingDocs) && count($missingDocs) == 0)],
                            ['name' => 'Pembayaran', 'status' => $registration->payment_status == 'paid'],
                            ['name' => 'Verifikasi Admin', 'status' => in_array($registration->status, ['verified', 'accepted'])]
                        ];
                        $completed = collect($steps)->where('status', true)->count();
                    @endphp
                    
                    <div class="row">
                        @foreach($steps as $index => $step)
                        <div class="col-md-3 mb-3">
                            <div class="text-center">
                                <div class="mb-2">
                                    <i class="fas {{ $step['status'] ? 'fa-check-circle text-success' : 'fa-clock text-warning' }} fa-2x"></i>
                                </div>
                                <h6 class="fw-bold">{{ $step['name'] }}</h6>
                                <small class="text-muted">{{ $step['status'] ? 'Selesai' : 'Menunggu' }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-3">
                        <div class="progress">
                            <div class="progress-bar bg-success" style="width: {{ ($completed/4)*100 }}%"></div>
                        </div>
                        <small class="text-muted">{{ $completed }}/4 tahap selesai</small>
                    </div>
                </div>
            </div>

            <!-- Payment Card -->
            <div class="card shadow mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Informasi Pembayaran</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Biaya Pendaftaran:</strong> Rp 500.000</p>
                            <p><strong>Status Pembayaran:</strong> 
                                <span class="badge bg-{{ $registration->payment_status == 'paid' ? 'success' : ($registration->payment_status == 'pending' ? 'warning' : 'danger') }}">
                                    {{ $registration->payment_status == 'paid' ? 'Lunas' : ($registration->payment_status == 'pending' ? 'Menunggu Verifikasi' : 'Belum Bayar') }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            @if($registration->payment_status != 'paid')
                                <a href="{{ route('ppdb.payment', $registration->registration_number) }}" class="btn btn-primary">
                                    <i class="fas fa-credit-card me-2"></i>Bayar Sekarang
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documents Card -->
            <div class="card shadow mb-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Status Dokumen</h5>
                </div>
                <div class="card-body">
                    @if(is_array($missingDocs) && count($missingDocs) > 0)
                        <div class="alert alert-warning">
                            <strong>Dokumen yang masih kurang:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($missingDocs as $docType)
                                    <li>{{ $requiredDocs[$docType] ?? $docType }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <a href="{{ route('ppdb.documents', $registration->registration_number) }}" class="btn btn-warning">
                            <i class="fas fa-upload me-2"></i>Upload Dokumen
                        </a>
                    @else
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>Semua dokumen sudah lengkap
                        </div>
                    @endif
                </div>
            </div>

            <!-- Final Status Card -->
            @if($registration->status == 'accepted')
                <div class="card shadow border-success">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Status Akhir</h5>
                    </div>
                    <div class="card-body text-center">
                        <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
                        <h4 class="text-success">Selamat! Pendaftaran Diterima</h4>
                        <p>Silakan datang ke sekolah untuk daftar ulang</p>
                    </div>
                </div>
            @elseif($registration->status == 'rejected')
                <div class="card shadow border-danger">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">Status Akhir</h5>
                    </div>
                    <div class="card-body text-center">
                        <i class="fas fa-times-circle fa-4x text-danger mb-3"></i>
                        <h4 class="text-danger">Pendaftaran Ditolak</h4>
                        <p>Hubungi admin untuk informasi lebih lanjut</p>
                    </div>
                </div>
            @else
                <div class="card shadow border-info">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Status Akhir</h5>
                    </div>
                    <div class="card-body text-center">
                        <i class="fas fa-hourglass-half fa-4x text-info mb-3"></i>
                        <h4 class="text-info">Sedang Diproses</h4>
                        <p>Mohon tunggu verifikasi dari admin</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection