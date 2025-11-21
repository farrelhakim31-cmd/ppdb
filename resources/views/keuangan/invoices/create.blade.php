@extends('layouts.app')

@section('title', 'Buat Tagihan Baru')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8">
    <div class="max-w-2xl mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Buat Tagihan Baru</h1>
            <p class="text-gray-600">Sistem Keuangan PPDB</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Header Card -->
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold">Form Tagihan</h3>
                        <p class="text-blue-100">Lengkapi data tagihan siswa</p>
                    </div>
                    <div class="text-right">
                        <i class="fas fa-file-invoice-dollar text-2xl"></i>
                    </div>
                </div>
            </div>

            <form action="{{ route('keuangan.invoices.store') }}" method="POST">
                @csrf
                
                <!-- Form Content -->
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-user-graduate text-blue-500 mr-2"></i>
                        <h4 class="text-lg font-semibold text-gray-800">Data Siswa</h4>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="border-l-4 border-blue-500 pl-3">
                            <label class="block text-sm font-medium text-gray-600 mb-2">Siswa</label>
                            <select name="registration_id" id="student-select" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">Pilih Siswa</option>
                                @foreach($registrations as $registration)
                                <option value="{{ $registration->id }}" data-name="{{ $registration->name }}" data-email="{{ $registration->email }}" data-number="{{ $registration->registration_number }}">
                                    {{ $registration->name }} - {{ $registration->registration_number }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div id="student-info" class="hidden border-l-4 border-green-500 pl-3">
                            <p class="text-sm text-gray-600">Info Siswa</p>
                            <div class="font-semibold text-gray-800">
                                <p><span id="selected-name">-</span></p>
                                <p class="text-sm text-gray-500"><span id="selected-email">-</span></p>
                                <p class="text-sm text-gray-500">No. Daftar: <span id="selected-number">-</span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-file-invoice text-blue-500 mr-2"></i>
                        <h4 class="text-lg font-semibold text-gray-800">Detail Tagihan</h4>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="border-l-4 border-blue-500 pl-3">
                            <label class="block text-sm font-medium text-gray-600 mb-2">Jenis Tagihan</label>
                            <select name="type" id="invoice-type" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">Pilih Jenis</option>
                                <option value="registration" data-amount="500000">Biaya Pendaftaran - Rp 500.000</option>
                                <option value="administration" data-amount="250000">Biaya Administrasi - Rp 250.000</option>
                                <option value="uniform" data-amount="300000">Seragam - Rp 300.000</option>
                                <option value="book" data-amount="150000">Buku - Rp 150.000</option>
                                <option value="spp" data-amount="200000">SPP Bulan Pertama - Rp 200.000</option>
                                <option value="other">Lainnya</option>
                            </select>
                        </div>
                        
                        <div class="border-l-4 border-gray-300 pl-3">
                            <label class="block text-sm font-medium text-gray-600 mb-2">Jumlah</label>
                            <input type="number" name="amount" id="amount" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Masukkan jumlah" min="0" required>
                        </div>
                        
                        <div class="border-l-4 border-gray-300 pl-3">
                            <label class="block text-sm font-medium text-gray-600 mb-2">Jatuh Tempo</label>
                            <div class="relative">
                                <input type="date" name="due_date" class="w-full border border-gray-300 rounded-md px-3 py-2 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <div class="border-l-4 border-green-500 pl-3">
                            <label class="block text-sm font-medium text-gray-600 mb-2">Keterangan</label>
                            <textarea name="description" id="description" rows="3" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none" placeholder="Masukkan keterangan" required></textarea>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="p-6">
                    <div class="flex space-x-3">
                        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md text-sm transition-colors">
                            Simpan
                        </button>
                        <a href="{{ route('keuangan.invoices.index') }}" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded-md text-sm text-center transition-colors">
                            Kembali
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const studentSelect = document.getElementById('student-select');
    const studentInfo = document.getElementById('student-info');
    const invoiceType = document.getElementById('invoice-type');
    const amountInput = document.getElementById('amount');
    const descriptionInput = document.getElementById('description');
    
    studentSelect.addEventListener('change', function() {
        const option = this.options[this.selectedIndex];
        if (option.value) {
            document.getElementById('selected-name').textContent = option.dataset.name;
            document.getElementById('selected-email').textContent = option.dataset.email;
            document.getElementById('selected-number').textContent = option.dataset.number;
            studentInfo.classList.remove('hidden');
        } else {
            studentInfo.classList.add('hidden');
        }
    });
    
    invoiceType.addEventListener('change', function() {
        const option = this.options[this.selectedIndex];
        if (option.dataset.amount) {
            amountInput.value = option.dataset.amount;
            descriptionInput.value = option.textContent.split(' - ')[0];
        }
    });
});
</script>
@endsection