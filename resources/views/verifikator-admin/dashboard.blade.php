@extends('layouts.minimal')

@section('title', 'Dashboard Verifikator Administrasi')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 flex">
    <!-- Sidebar -->
    <div class="w-64 shadow-lg fixed h-full" style="background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);">
        <div class="p-6">
            <h2 class="text-xl font-bold text-white mb-6">
                <i class="fas fa-clipboard-check mr-2"></i>Verifikator
            </h2>
            <nav class="space-y-2">
                <a href="{{ route('verifikator-admin.dashboard') }}" class="flex items-center px-4 py-3 text-white bg-white bg-opacity-25 rounded-lg font-medium">
                    <i class="fas fa-tachometer-alt mr-3"></i>Dashboard
                </a>
                <a href="{{ route('verifikator-admin.index') }}" class="flex items-center px-4 py-3 text-white hover:bg-white hover:bg-opacity-25 rounded-lg transition-colors">
                    <i class="fas fa-list mr-3"></i>Daftar Pendaftar
                </a>
            </nav>
        </div>
        <div class="absolute bottom-0 w-64 p-6 border-t border-white border-opacity-25">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-white bg-opacity-25 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-white text-sm"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-white">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-white text-opacity-75">Verifikator</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-white text-opacity-75 hover:text-red-300 transition-colors">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 ml-64">
        <!-- Header -->
        <div class="bg-white shadow-lg border-b border-slate-200">
            <div class="px-6 py-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Dashboard Verifikator</h1>
                        <p class="text-slate-600 mt-1">Kelola verifikasi pendaftaran PPDB</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">VERIFIKATOR</span>
                        <span class="text-slate-500 text-sm">{{ now()->format('d M Y, H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-6 py-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-slate-100">
                <div class="flex items-center">
                    <div class="p-4 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 shadow-lg">
                        <i class="fas fa-users text-white text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-slate-600 font-medium">Total Pendaftar</p>
                        <p class="text-3xl font-bold text-slate-800">{{ $stats['total'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-slate-100">
                <div class="flex items-center">
                    <div class="p-4 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-500 shadow-lg">
                        <i class="fas fa-clock text-white text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-slate-600 font-medium">Menunggu</p>
                        <p class="text-3xl font-bold text-slate-800">{{ $stats['pending'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-slate-100">
                <div class="flex items-center">
                    <div class="p-4 rounded-2xl bg-gradient-to-br from-emerald-500 to-green-600 shadow-lg">
                        <i class="fas fa-check text-white text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-slate-600 font-medium">Disetujui</p>
                        <p class="text-3xl font-bold text-slate-800">{{ $stats['approved'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-slate-100">
                <div class="flex items-center">
                    <div class="p-4 rounded-2xl bg-gradient-to-br from-red-500 to-rose-600 shadow-lg">
                        <i class="fas fa-times text-white text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-slate-600 font-medium">Ditolak</p>
                        <p class="text-3xl font-bold text-slate-800">{{ $stats['rejected'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-slate-100">
                <div class="flex items-center">
                    <div class="p-4 rounded-2xl bg-gradient-to-br from-purple-500 to-indigo-600 shadow-lg">
                        <i class="fas fa-edit text-white text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-slate-600 font-medium">Perbaikan</p>
                        <p class="text-3xl font-bold text-slate-800">{{ $stats['revision'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Verifications -->
        <div class="bg-white rounded-2xl shadow-lg border border-slate-100">
            <div class="px-6 py-5 border-b border-slate-200 bg-gradient-to-r from-slate-50 to-blue-50 rounded-t-2xl">
                <h3 class="text-xl font-bold text-slate-800">Verifikasi Terbaru</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Pendaftaran</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Verifikator</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recent_verifications as $log)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $log->registration->no_pendaftaran ?? $log->registration->registration_number ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $log->registration->nama_lengkap ?? $log->registration->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($log->status == 'approved')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                                @elseif($log->status == 'rejected')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">Perbaikan</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $log->verifier->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $log->verified_at->format('d/m/Y H:i') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada verifikasi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection