@extends('layouts.keuangan')

@section('title', 'Dashboard Keuangan')
@section('page-title', 'Dashboard Keuangan')

@section('content')
<!-- Welcome Card -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-calculator fa-3x opacity-75"></i>
                    </div>
                    <div>
                        <h4 class="card-title mb-1">Selamat Datang, {{ Auth::user()->name }}!</h4>
                        <p class="card-text mb-0">Bagian Keuangan SMK BAKTI NUSANTARA 666</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Menu Cards -->
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="fas fa-file-invoice-dollar fa-3x text-primary mb-3"></i>
                <h5 class="card-title">Manajemen Tagihan</h5>
                <p class="card-text">Kelola tagihan siswa</p>
                <a href="{{ route('bills.index') }}" class="btn btn-primary">Lihat Tagihan</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                <h5 class="card-title">Verifikasi Pembayaran</h5>
                <p class="card-text">Verifikasi bukti pembayaran siswa & PPDB</p>
                <a href="{{ route('payments.verification') }}" class="btn btn-success">Verifikasi Pembayaran</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="fas fa-graduation-cap fa-3x text-info mb-3"></i>
                <h5 class="card-title">Pembayaran PPDB</h5>
                <p class="card-text">Monitor pembayaran pendaftaran</p>
                <a href="{{ route('keuangan.ppdb') }}" class="btn btn-info">Lihat PPDB</a>
            </div>
        </div>
    </div>
</div>
@endsection