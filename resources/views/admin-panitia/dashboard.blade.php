@extends('layouts.admin-panitia')

@section('title', 'Dashboard Admin Panitia')
@section('page-title', 'Dashboard Admin Panitia')

@section('content')
<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card stat-card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1">Total Pendaftar</h6>
                        <h4 class="mb-0">{{ $stats['total_pendaftar'] }}</h4>
                    </div>
                    <i class="fas fa-users fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1">Hari Ini</h6>
                        <h4 class="mb-0">{{ $stats['hari_ini'] }}</h4>
                    </div>
                    <i class="fas fa-user-plus fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1">Terverifikasi</h6>
                        <h4 class="mb-0">{{ $stats['terverifikasi'] }}</h4>
                    </div>
                    <i class="fas fa-check-circle fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card stat-card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1">Terbayar</h6>
                        <h4 class="mb-0">{{ $stats['terbayar'] }}</h4>
                    </div>
                    <i class="fas fa-credit-card fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Tren Pendaftaran (7 Hari)</h5>
            </div>
            <div class="card-body">
                <canvas id="trenChart" height="200"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Pendaftar per Jurusan</h5>
            </div>
            <div class="card-body">
                <canvas id="jurusanChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-md-4 mb-3">
        <a href="{{ route('admin-panitia.monitoring') }}" class="card text-decoration-none stat-card">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-clipboard-list fa-3x text-primary"></i>
                </div>
                <h5 class="card-title">Monitoring Berkas</h5>
                <p class="card-text text-muted">Lihat kelengkapan berkas pendaftar</p>
            </div>
        </a>
    </div>
    <div class="col-md-4 mb-3">
        <a href="{{ route('admin-panitia.map') }}" class="card text-decoration-none stat-card">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-map-marked-alt fa-3x text-success"></i>
                </div>
                <h5 class="card-title">Peta Sebaran</h5>
                <p class="card-text text-muted">Lihat sebaran domisili pendaftar</p>
            </div>
        </a>
    </div>
    <div class="col-md-4 mb-3">
        <a href="{{ route('admin-panitia.master-data') }}" class="card text-decoration-none stat-card">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-database fa-3x text-info"></i>
                </div>
                <h5 class="card-title">Master Data</h5>
                <p class="card-text text-muted">Kelola data referensi sistem</p>
            </div>
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <a href="{{ route('admin-panitia.reports') }}" class="card text-decoration-none stat-card">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-chart-line fa-3x text-warning"></i>
                </div>
                <h5 class="card-title">Laporan</h5>
                <p class="card-text text-muted">Analisis dan statistik PPDB</p>
            </div>
        </a>
    </div>
    <div class="col-md-4 mb-3">
        <a href="{{ route('admin-panitia.accounts') }}" class="card text-decoration-none stat-card">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-users-cog fa-3x text-danger"></i>
                </div>
                <h5 class="card-title">Kelola Akun</h5>
                <p class="card-text text-muted">Manajemen user dan role</p>
            </div>
        </a>
    </div>
    <div class="col-md-4 mb-3">
        <a href="{{ route('admin.map-settings.edit') }}" class="card text-decoration-none stat-card">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-map-marker-alt fa-3x text-secondary"></i>
                </div>
                <h5 class="card-title">Pengaturan Peta</h5>
                <p class="card-text text-muted">Atur lokasi dan koordinat sekolah</p>
            </div>
        </a>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Tren Chart
const trenCtx = document.getElementById('trenChart').getContext('2d');
new Chart(trenCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode(array_column($tren_harian, 'tanggal')) !!},
        datasets: [{
            label: 'Pendaftar',
            data: {!! json_encode(array_column($tren_harian, 'pendaftar')) !!},
            borderColor: '#007bff',
            backgroundColor: 'rgba(0, 123, 255, 0.1)',
            tension: 0.4
        }, {
            label: 'Terverifikasi',
            data: {!! json_encode(array_column($tren_harian, 'terverifikasi')) !!},
            borderColor: '#28a745',
            backgroundColor: 'rgba(40, 167, 69, 0.1)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});

// Jurusan Chart
const jurusanCtx = document.getElementById('jurusanChart').getContext('2d');
new Chart(jurusanCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($per_jurusan->pluck('major')) !!},
        datasets: [{
            data: {!! json_encode($per_jurusan->pluck('total')) !!},
            backgroundColor: [
                '#007bff',
                '#28a745',
                '#ffc107',
                '#dc3545',
                '#6f42c1'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});
</script>
@endpush