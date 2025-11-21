@extends('layouts.minimal')

@section('title', 'Halaman Tidak Ditemukan')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4">
    <div class="max-w-md w-full text-center">
        <div class="mb-8">
            <div class="w-24 h-24 bg-red-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-exclamation-triangle text-4xl text-red-600"></i>
            </div>
            <h1 class="text-6xl font-bold text-gray-900 mb-2">404</h1>
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Halaman Tidak Ditemukan</h2>
            <p class="text-gray-600 mb-8">Maaf, halaman yang Anda cari tidak dapat ditemukan.</p>
        </div>
        
        <div class="space-y-3">
            <a href="{{ route('home') }}" 
               class="block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                <i class="fas fa-home mr-2"></i>Kembali ke Beranda
            </a>
            <button onclick="history.back()" 
                    class="block w-full bg-gray-100 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-200 transition-colors font-medium">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Halaman Sebelumnya
            </button>
        </div>
    </div>
</div>
@endsection