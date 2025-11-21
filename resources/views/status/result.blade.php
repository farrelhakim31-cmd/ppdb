@extends('layouts.minimal')

@section('title', 'Status Pendaftaran')

@section('content')
<div class="min-h-screen bg-gray-50 py-6">
    <div class="max-w-lg mx-auto px-4">
        <!-- Header Card -->
        <div class="bg-white rounded-2xl shadow-sm p-6 mb-4 text-center">
            <img src="{{ asset('img/logo-sekolah.png') }}" alt="Logo" class="w-12 h-12 mx-auto mb-3">
            <h1 class="text-xl font-bold text-gray-900 mb-1">Status Pendaftaran</h1>
            <p class="text-sm text-gray-600 mb-3">SMK BAKTI NUSANTARA 666</p>
            <div class="inline-block bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium">
                {{ $registration->registration_number }}
            </div>
        </div>

        <!-- Student Info Card -->
        <div class="bg-white rounded-2xl shadow-sm p-6 mb-4">
            <div class="text-center mb-4">
                <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold mx-auto mb-3">
                    {{ substr($registration->name, 0, 1) }}
                </div>
                <h2 class="text-lg font-bold text-gray-900 mb-2">{{ $registration->name }}</h2>
                <p class="text-sm text-gray-600 mb-1">{{ $registration->email }}</p>
                <p class="text-sm text-gray-600">{{ $registration->phone }}</p>
            </div>
            @php
                $statusConfig = [
                    'pending' => ['label' => 'Pending', 'color' => 'yellow'],
                    'terima' => ['label' => 'Diterima', 'color' => 'green'],
                    'tolak' => ['label' => 'Ditolak', 'color' => 'red']
                ];
                $currentStatus = $statusConfig[$registration->status] ?? ['label' => 'Pending', 'color' => 'yellow'];
            @endphp
            <div class="text-center">
                <span class="inline-block bg-{{ $currentStatus['color'] }}-100 text-{{ $currentStatus['color'] }}-800 px-4 py-2 rounded-lg text-sm font-medium">
                    {{ $currentStatus['label'] }}
                </span>
            </div>
        </div>

        <!-- Progress Card -->
        <div class="bg-white rounded-2xl shadow-sm p-6 mb-4">
            <h3 class="text-lg font-bold text-gray-900 mb-4 text-center">Progress Pendaftaran</h3>
            
            @php
                $steps = ['pending' => 'Sedang Diproses', 'terima' => 'Diterima', 'tolak' => 'Ditolak'];
                $currentStep = array_search($registration->status, array_keys($steps)) + 1;
                $totalSteps = count($steps);
            @endphp
            
            <div class="mb-4">
                <div class="flex justify-between text-sm text-gray-600 mb-2">
                    <span>Langkah {{ $currentStep }} dari {{ $totalSteps }}</span>
                    <span>{{ round(($currentStep / $totalSteps) * 100) }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: {{ ($currentStep / $totalSteps) * 100 }}%"></div>
                </div>
            </div>
            
            <div class="text-center">
                <div class="text-sm text-gray-600 mb-2">Status Saat Ini:</div>
                <div class="font-medium text-gray-900">
                    {{ $steps[$registration->status] ?? 'Sedang Diproses' }}
                </div>
            </div>
        </div>

        <!-- Status Cards -->
        <div class="space-y-4 mb-4">
            <!-- Documents Card -->
            <div class="bg-white rounded-2xl shadow-sm p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-file-alt text-blue-600"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900">Dokumen</h3>
                            <p class="text-sm text-gray-600">{{ $registration->documents->count() }} dokumen</p>
                        </div>
                    </div>
                    @if($registration->documents->count() > 0)
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-sm">
                            <i class="fas fa-check mr-1"></i>Lengkap
                        </span>
                    @else
                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-lg text-sm">
                            <i class="fas fa-clock mr-1"></i>Belum
                        </span>
                    @endif
                </div>
            </div>

            <!-- Payment Card -->
            <div class="bg-white rounded-2xl shadow-sm p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-credit-card text-green-600"></i>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900">Pembayaran</h3>
                            <p class="text-sm text-gray-600">Rp 500.000</p>
                        </div>
                    </div>
                    @if($registration->payment_status == 'paid')
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-sm">
                            <i class="fas fa-check mr-1"></i>Lunas
                        </span>
                    @elseif($registration->payment_status == 'pending')
                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-lg text-sm">
                            <i class="fas fa-clock mr-1"></i>Pending
                        </span>
                    @else
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-lg text-sm">
                            <i class="fas fa-times mr-1"></i>Belum
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Final Status Message -->
        @if($registration->status == 'terima')
            <div class="bg-green-50 border border-green-200 rounded-2xl p-6 text-center mb-4">
                <i class="fas fa-check-circle text-green-600 text-3xl mb-3"></i>
                <h3 class="text-lg font-bold text-green-800 mb-2">Selamat! Anda Diterima</h3>
                <p class="text-green-700 text-sm mb-4">Silakan datang ke sekolah untuk daftar ulang</p>
                <div class="bg-white rounded-lg p-4 text-left text-sm">
                    <p class="mb-1"><strong>Waktu:</strong> Senin - Jumat, 08:00 - 15:00</p>
                    <p><strong>Tempat:</strong> Kantor Tata Usaha</p>
                </div>
            </div>
        @elseif($registration->status == 'tolak')
            <div class="bg-red-50 border border-red-200 rounded-2xl p-6 text-center mb-4">
                <i class="fas fa-times-circle text-red-600 text-3xl mb-3"></i>
                <h3 class="text-lg font-bold text-red-800 mb-2">Pendaftaran Ditolak</h3>
                <p class="text-red-700 text-sm">Mohon maaf, pendaftaran tidak dapat diterima</p>
            </div>
        @elseif($registration->status == 'pending')
            <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-6 text-center mb-4">
                <i class="fas fa-clock text-yellow-600 text-3xl mb-3"></i>
                <h3 class="text-lg font-bold text-yellow-800 mb-2">Status Pending</h3>
                <p class="text-yellow-700 text-sm">Pendaftaran sedang dalam proses review</p>
            </div>
        @endif

        <!-- Actions -->
        <div class="space-y-3">
            <a href="{{ route('status.index') }}" class="block bg-gray-100 text-gray-700 px-4 py-3 rounded-lg hover:bg-gray-200 transition-colors text-center">
                <i class="fas fa-search mr-2"></i>Cek Status Lain
            </a>
            <a href="{{ route('home') }}" class="block bg-blue-600 text-white px-4 py-3 rounded-lg hover:bg-blue-700 transition-colors text-center">
                <i class="fas fa-home mr-2"></i>Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection