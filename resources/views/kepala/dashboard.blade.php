@extends('layouts.kepala-sekolah')

@section('title', 'Dashboard Kepala Sekolah')
@section('page-title', 'Dashboard Kepala Sekolah')

@section('content')
<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card stat-card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1">Total Pendaftar</h6>
                        <h4 class="mb-0">{{ $totalPendaftar }}</h4>
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
                        <h6 class="card-title mb-1">Diterima</h6>
                        <h4 class="mb-0">{{ $diterima }}</h4>
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
                        <h6 class="card-title mb-1">Pending</h6>
                        <h4 class="mb-0">{{ $pending }}</h4>
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
                        <h6 class="card-title mb-1">Terverifikasi</h6>
                        <h4 class="mb-0">{{ $rasioTerverifikasi }}%</h4>
                    </div>
                    <i class="fas fa-certificate fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-lg-12 mb-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Tren Pendaftaran (7 Hari Terakhir)</h5>
            </div>
            <div class="card-body">
                <canvas id="trenHarianChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-md-6 mb-3">
        <a href="{{ route('kepala.reports') }}" class="card text-decoration-none stat-card">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-chart-line fa-3x text-primary"></i>
                </div>
                <h5 class="card-title">Laporan PPDB</h5>
                <p class="card-text text-muted">Analisis dan statistik lengkap</p>
            </div>
        </a>
    </div>
    <div class="col-md-6 mb-3">
        <a href="{{ route('kepala.export') }}" class="card text-decoration-none stat-card">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-download fa-3x text-success"></i>
                </div>
                <h5 class="card-title">Export Data</h5>
                <p class="card-text text-muted">Unduh laporan dalam berbagai format</p>
            </div>
        </a>
    </div>
</div>



@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Tren Harian Chart
const trenCtx = document.getElementById('trenHarianChart').getContext('2d');
new Chart(trenCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode(array_column($trenHarian, 'tanggal')) !!},
        datasets: [{
            label: 'Pendaftar',
            data: {!! json_encode(array_column($trenHarian, 'pendaftar')) !!},
            borderColor: '#6f42c1',
            backgroundColor: 'rgba(111, 66, 193, 0.1)',
            tension: 0.1
        }, {
            label: 'Terverifikasi',
            data: {!! json_encode(array_column($trenHarian, 'terverifikasi')) !!},
            borderColor: '#28a745',
            backgroundColor: 'rgba(40, 167, 69, 0.1)',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top'
            }
        }
    }
});
</script>
@endsection