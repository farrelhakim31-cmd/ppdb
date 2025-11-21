@extends('layouts.minimal')

@section('title', 'Cek Status Pendaftaran')

@section('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center px-4">
    <div class="max-w-md w-full">
        <!-- Header Card -->
        <div class="bg-white rounded-2xl shadow-sm p-6 mb-4 text-center">
            <img src="{{ asset('img/logo-sekolah.png') }}" alt="Logo" class="w-12 h-12 mx-auto mb-3">
            <h1 class="text-xl font-bold text-gray-900 mb-1">Cek Status Pendaftaran</h1>
            <p class="text-sm text-gray-600">SMK BAKTI NUSANTARA 666</p>
        </div>

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-2xl mb-4 text-sm">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            </div>
        @endif

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <form action="{{ route('status.check') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Pendaftaran</label>
                    <input type="text" 
                           name="registration_number" 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('registration_number') border-red-500 @enderror"
                           placeholder="PPDB20240001"
                           value="{{ old('registration_number') }}"
                           required>
                    @error('registration_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    <i class="fas fa-search mr-2"></i>Cek Status
                </button>
            </form>
        </div>

        <!-- Back Link -->
        <div class="text-center mt-4">
            <a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                <i class="fas fa-arrow-left mr-1"></i>Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection