@extends('layouts.app')

@section('title', 'Pembayaran PPDB')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8">
    <div class="max-w-2xl mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Pembayaran Pendaftaran</h1>
            <p class="text-gray-600">No. Pendaftaran: {{ $registration->registration_number }}</p>
        </div>

        <!-- Payment Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Registration Info -->
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold">{{ $registration->name }}</h3>
                        <p class="text-blue-100">{{ $registration->email }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-blue-100">Status</p>
                        <span class="inline-block px-3 py-1 bg-yellow-500 text-white text-sm rounded-full">
                            Menunggu Pembayaran
                        </span>
                    </div>
                </div>
            </div>

            <!-- Payment Details -->
            <div class="p-6">
                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">Detail Pembayaran</h4>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600">Biaya Pendaftaran</span>
                            <span class="font-semibold">Rp 500.000</span>
                        </div>
                        <div class="flex justify-between items-center text-lg font-bold text-blue-600 pt-2 border-t">
                            <span>Total Pembayaran</span>
                            <span>Rp 500.000</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Methods -->
                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">Pilih Metode Pembayaran</h4>
                    
                    <!-- Bank Transfer -->
                    <div class="mb-4">
                        <h5 class="font-semibold text-gray-700 mb-3">Transfer Bank</h5>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-university text-blue-600 mr-2"></i>
                                    <span class="font-semibold text-blue-800">BCA</span>
                                </div>
                                <p class="font-mono text-sm font-bold">1234567890</p>
                                <p class="text-xs text-gray-600">a.n. PPDB Online</p>
                            </div>
                            <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-university text-red-600 mr-2"></i>
                                    <span class="font-semibold text-red-800">Mandiri</span>
                                </div>
                                <p class="font-mono text-sm font-bold">0987654321</p>
                                <p class="text-xs text-gray-600">a.n. PPDB Online</p>
                            </div>
                            <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-university text-green-600 mr-2"></i>
                                    <span class="font-semibold text-green-800">BRI</span>
                                </div>
                                <p class="font-mono text-sm font-bold">1122334455</p>
                                <p class="text-xs text-gray-600">a.n. PPDB Online</p>
                            </div>
                            <div class="bg-orange-50 border border-orange-200 rounded-lg p-3">
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-university text-orange-600 mr-2"></i>
                                    <span class="font-semibold text-orange-800">BNI</span>
                                </div>
                                <p class="font-mono text-sm font-bold">5566778899</p>
                                <p class="text-xs text-gray-600">a.n. PPDB Online</p>
                            </div>
                        </div>
                    </div>

                    <!-- E-Wallet -->
                    <div class="mb-4">
                        <h5 class="font-semibold text-gray-700 mb-3">E-Wallet</h5>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 text-center">
                                <i class="fas fa-mobile-alt text-blue-600 text-xl mb-2"></i>
                                <p class="font-semibold text-blue-800 text-sm">GoPay</p>
                                <p class="text-xs text-gray-600">081234567890</p>
                            </div>
                            <div class="bg-red-50 border border-red-200 rounded-lg p-3 text-center">
                                <i class="fas fa-mobile-alt text-red-600 text-xl mb-2"></i>
                                <p class="font-semibold text-red-800 text-sm">ShopeePay</p>
                                <p class="text-xs text-gray-600">081234567890</p>
                            </div>
                            <div class="bg-purple-50 border border-purple-200 rounded-lg p-3 text-center">
                                <i class="fas fa-mobile-alt text-purple-600 text-xl mb-2"></i>
                                <p class="font-semibold text-purple-800 text-sm">OVO</p>
                                <p class="text-xs text-gray-600">081234567890</p>
                            </div>
                            <div class="bg-green-50 border border-green-200 rounded-lg p-3 text-center">
                                <i class="fas fa-mobile-alt text-green-600 text-xl mb-2"></i>
                                <p class="font-semibold text-green-800 text-sm">DANA</p>
                                <p class="text-xs text-gray-600">081234567890</p>
                            </div>
                        </div>
                    </div>

                    <!-- Minimarket -->
                    <div class="mb-4">
                        <h5 class="font-semibold text-gray-700 mb-3">Bayar di Minimarket</h5>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            <div class="bg-red-50 border border-red-200 rounded-lg p-3 text-center">
                                <i class="fas fa-store text-red-600 text-xl mb-2"></i>
                                <p class="font-semibold text-red-800 text-sm">Alfamart</p>
                                <p class="text-xs text-gray-600">Kode: 12345</p>
                            </div>
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 text-center">
                                <i class="fas fa-store text-blue-600 text-xl mb-2"></i>
                                <p class="font-semibold text-blue-800 text-sm">Indomaret</p>
                                <p class="text-xs text-gray-600">Kode: 67890</p>
                            </div>
                            <div class="bg-green-50 border border-green-200 rounded-lg p-3 text-center">
                                <i class="fas fa-store text-green-600 text-xl mb-2"></i>
                                <p class="font-semibold text-green-800 text-sm">Lawson</p>
                                <p class="text-xs text-gray-600">Kode: 11111</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upload Payment Proof -->
                <form action="{{ route('ppdb.process-payment', $registration->registration_number) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Payment Method Selection -->
                    <div class="mb-6">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4">Pilih Metode Pembayaran</h4>
                        <select name="payment_method" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="">Pilih Metode Pembayaran</option>
                            <optgroup label="Transfer Bank">
                                <option value="bca">BCA - 1234567890</option>
                                <option value="mandiri">Mandiri - 0987654321</option>
                                <option value="bri">BRI - 1122334455</option>
                                <option value="bni">BNI - 5566778899</option>
                            </optgroup>
                            <optgroup label="E-Wallet">
                                <option value="gopay">GoPay - 081234567890</option>
                                <option value="shopeepay">ShopeePay - 081234567890</option>
                                <option value="ovo">OVO - 081234567890</option>
                                <option value="dana">DANA - 081234567890</option>
                            </optgroup>
                            <optgroup label="Minimarket">
                                <option value="alfamart">Alfamart - Kode: 12345</option>
                                <option value="indomaret">Indomaret - Kode: 67890</option>
                                <option value="lawson">Lawson - Kode: 11111</option>
                            </optgroup>
                        </select>
                        @error('payment_method')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4">Upload Bukti Pembayaran</h4>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition-colors">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-4"></i>
                            <div class="mb-4">
                                <label for="payment_proof" class="cursor-pointer">
                                    <span class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                                        Pilih File
                                    </span>
                                    <input type="file" id="payment_proof" name="payment_proof" class="hidden" accept=".jpg,.jpeg,.png,.pdf" required>
                                </label>
                            </div>
                            <p class="text-sm text-gray-500">Format: JPG, PNG, PDF (Max: 2MB)</p>
                            @error('payment_proof')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Instructions -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                        <h5 class="font-semibold text-yellow-800 mb-2">Petunjuk Pembayaran:</h5>
                        <ul class="text-sm text-yellow-700 space-y-1">
                            <li>• Transfer sesuai nominal yang tertera</li>
                            <li>• Upload bukti transfer yang jelas</li>
                            <li>• Verifikasi akan dilakukan dalam 1x24 jam</li>
                            <li>• Simpan bukti pembayaran untuk referensi</li>
                        </ul>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <button type="submit" class="flex-1 bg-green-500 text-white py-3 px-6 rounded-lg hover:bg-green-600 transition-colors font-semibold flex items-center justify-center">
                            <i class="fas fa-upload mr-2"></i>
                            Upload Bukti Pembayaran
                        </button>
                        <a href="{{ route('ppdb.status', $registration->registration_number) }}" class="flex-1 bg-gray-500 text-white py-3 px-6 rounded-lg hover:bg-gray-600 transition-colors font-semibold text-center">
                            Cek Status Nanti
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Back Link -->
        <div class="text-center mt-6">
            <a href="{{ route('siswa.dashboard') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                ← Kembali ke Dashboard Siswa
            </a>
        </div>
    </div>
</div>

<script>
document.getElementById('payment_proof').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const label = e.target.parentElement.querySelector('span');
        label.textContent = file.name;
        label.classList.add('bg-green-500');
        label.classList.remove('bg-blue-500');
    }
});
</script>
@endsection