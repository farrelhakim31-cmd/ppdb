@extends('layouts.minimal')

@section('title', 'PPDB Online - SMK BAKTI NUSANTARA 666')

@section('content')
<div class="min-h-screen flex flex-col">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('img/logo-sekolah.svg') }}" alt="Logo SMK BAKTI NUSANTARA 666" class="w-12 h-10 object-contain">
                <h1 class="text-xl font-semibold text-gray-900">SMK BAKTI NUSANTARA 666</h1>
            </div>
            <nav class="hidden md:flex space-x-6">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-600 transition-colors">Beranda</a>
                <a href="{{ route('ppdb.index') }}" class="text-gray-600 hover:text-blue-600 transition-colors">Info PPDB</a>
                <a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">Login</a>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 flex items-center justify-center px-4 py-12">
        <div class="max-w-4xl mx-auto text-center">
            <!-- Logo & Title -->
            <div class="mb-8">
                <img src="{{ asset('img/logo-sekolah.svg') }}" alt="Logo SMK BAKTI NUSANTARA 666" class="w-24 h-20 object-contain mx-auto mb-4">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-2">PPDB Online</h1>
                <p class="text-xl text-gray-600">SMK BAKTI NUSANTARA 666</p>
            </div>

            <!-- Action Buttons -->
            <div class="grid md:grid-cols-2 gap-4 max-w-md mx-auto mb-12">
                <a href="{{ route('login', ['redirect' => route('ppdb.register')]) }}" 
                   class="bg-blue-600 text-white px-6 py-4 rounded-xl hover:bg-blue-700 transition-all duration-200 flex items-center justify-center space-x-2 shadow-lg hover:shadow-xl">
                    <i class="fas fa-user-plus"></i>
                    <span class="font-medium">Daftar Sekarang</span>
                </a>
                <a href="{{ route('login') }}" 
                   class="bg-white text-gray-700 px-6 py-4 rounded-xl hover:bg-gray-50 transition-all duration-200 flex items-center justify-center space-x-2 border border-gray-200 shadow-lg hover:shadow-xl">
                    <i class="fas fa-sign-in-alt"></i>
                    <span class="font-medium">Login Siswa</span>
                </a>
            </div>

            <!-- Info Cards -->
            <div class="grid md:grid-cols-3 gap-6 max-w-4xl mx-auto">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-calendar-alt text-blue-600"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Jadwal Pendaftaran</h3>
                    <p class="text-gray-600 text-sm">Periode pendaftaran PPDB Online tahun ajaran baru</p>
                </div>
                
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-file-alt text-green-600"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Persyaratan</h3>
                    <p class="text-gray-600 text-sm">Dokumen dan syarat yang harus dipenuhi calon siswa</p>
                </div>
                
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-graduation-cap text-purple-600"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Program Keahlian</h3>
                    <p class="text-gray-600 text-sm">Berbagai jurusan dan program keahlian yang tersedia</p>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-6">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <p class="text-gray-600 text-sm">© 2024 SMK BAKTI NUSANTARA 666. All rights reserved.</p>
        </div>
    </footer>
</div>
@endsection