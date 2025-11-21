@extends('layouts.minimal')

@section('title', 'Laporan - Admin Panitia')

@section('head')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-purple-50">
    <div class="bg-white shadow-lg border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 py-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent">Laporan PPDB</h1>
                    <p class="text-slate-600 mt-1">Analisis dan Statistik Pendaftaran</p>
                </div>
                <div class="flex space-x-3">
                    <button onclick="window.print()" class="bg-gradient-to-r from-green-600 to-green-700 text-white px-6 py-3 rounded-xl hover:from-green-700 hover:to-green-800 transition-all duration-200 shadow-lg">
                        <i class="fas fa-print mr-2"></i>Print
                    </button>
                    <a href="{{ route('admin-panitia.export') }}" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg">
                        <i class="fas fa-download mr-2"></i>Export
                    </a>
                    <a href="{{ route('admin-panitia.dashboard') }}" class="bg-gradient-to-r from-slate-600 to-slate-700 text-white px-6 py-3 rounded-xl hover:from-slate-700 hover:to-slate-800 transition-all duration-200 shadow-lg">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-6">
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-slate-100">
                <div class="flex items-center">
                    <div class="p-4 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 shadow-lg">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-slate-600 font-medium">Total Pendaftar</p>
                        <p class="text-4xl font-bold text-slate-800">{{ $stats['total_pendaftar'] }}</p>
                        <p class="text-xs text-slate-500 mt-1">Semua gelombang</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 border border-slate-100">
                <div class="flex items-center">
                    <div class="p-4 rounded-2xl bg-gradient-to-br from-green-500 to-green-600 shadow-lg">
                        <i class="fas fa-check-circle text-white text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-slate-600 font-medium">Terverifikasi</p>
                        <p class="text-4xl font-bold text-slate-800">{{ $stats['terverifikasi'] }}</p>
                        <p class="text-xs text-slate-500 mt-1">{{ $stats['total_pendaftar'] > 0 ? round(($stats['terverifikasi'] / $stats['total_pendaftar']) * 100) : 0 }}% dari total</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 border border-slate-100">
                <div class="flex items-center">
                    <div class="p-4 rounded-2xl bg-gradient-to-br from-purple-500 to-purple-600 shadow-lg">
                        <i class="fas fa-credit-card text-white text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-slate-600 font-medium">Terbayar</p>
                        <p class="text-4xl font-bold text-slate-800">{{ $stats['terbayar'] }}</p>
                        <p class="text-xs text-slate-500 mt-1">{{ $stats['total_pendaftar'] > 0 ? round(($stats['terbayar'] / $stats['total_pendaftar']) * 100) : 0 }}% dari total</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Chart per Jurusan -->
            <div class="bg-white rounded-2xl shadow-lg border border-slate-100">
                <div class="px-6 py-5 border-b border-slate-200">
                    <h3 class="text-xl font-bold text-slate-800">Pendaftar per Jurusan</h3>
                </div>
                <div class="p-6">
                    <canvas id="jurusanChart" height="300"></canvas>
                </div>
            </div>

            <!-- Chart per Bulan -->
            <div class="bg-white rounded-2xl shadow-lg border border-slate-100">
                <div class="px-6 py-5 border-b border-slate-200">
                    <h3 class="text-xl font-bold text-slate-800">Tren Pendaftaran Bulanan</h3>
                </div>
                <div class="p-6">
                    <canvas id="bulanChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Detail Table -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-100">
            <div class="px-6 py-5 border-b border-slate-200">
                <h3 class="text-xl font-bold text-slate-800">Detail per Jurusan</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-gradient-to-r from-slate-50 to-purple-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Jurusan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Total Pendaftar</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Persentase</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @foreach($stats['per_jurusan'] as $jurusan)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">
                                {{ $jurusan->major ?? 'Tidak Diketahui' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                {{ $jurusan->total }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                {{ $stats['total_pendaftar'] > 0 ? round(($jurusan->total / $stats['total_pendaftar']) * 100, 1) : 0 }}%
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($jurusan->total >= 30)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Optimal</span>
                                @elseif($jurusan->total >= 20)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Cukup</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Kurang</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
// Chart per Jurusan
const jurusanCtx = document.getElementById('jurusanChart').getContext('2d');
new Chart(jurusanCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($stats['per_jurusan']->pluck('major')) !!},
        datasets: [{
            label: 'Jumlah Pendaftar',
            data: {!! json_encode($stats['per_jurusan']->pluck('total')) !!},
            backgroundColor: [
                '#3b82f6',
                '#10b981',
                '#f59e0b',
                '#ef4444',
                '#8b5cf6'
            ],
            borderRadius: 8
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Chart per Bulan
const bulanCtx = document.getElementById('bulanChart').getContext('2d');
const bulanNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
new Chart(bulanCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($stats['per_bulan']->pluck('bulan')->map(function($bulan) { return ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'][$bulan-1] ?? $bulan; })) !!},
        datasets: [{
            label: 'Pendaftar',
            data: {!! json_encode($stats['per_bulan']->pluck('total')) !!},
            borderColor: '#8b5cf6',
            backgroundColor: 'rgba(139, 92, 246, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
@endsection