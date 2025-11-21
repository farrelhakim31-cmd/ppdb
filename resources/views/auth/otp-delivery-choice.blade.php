@extends('layouts.minimal')

@section('title', 'Pilih Metode Pengiriman OTP - PPDB Online')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-12" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-xl shadow-lg border-0">
            <div class="text-center bg-blue-600 text-white rounded-t-xl p-4">
                <h4 class="text-xl font-bold mb-0"><i class="fas fa-paper-plane mr-2"></i>Pilih Metode Pengiriman OTP</h4>
            </div>
            <div class="p-6">
                <div class="text-center mb-6">
                    <i class="fas fa-user-circle text-4xl text-blue-600 mb-4"></i>
                    <p class="text-gray-600 mb-2">Halo, <strong>{{ $user->name }}</strong></p>
                    <p class="text-gray-600">Pilih cara pengiriman kode OTP:</p>
                </div>

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                            <span class="text-red-700">{{ $errors->first() }}</span>
                        </div>
                    </div>
                @endif

                <form action="{{ route('otp.set-delivery') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <!-- Email Option -->
                    <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="delivery_method" value="email" class="mr-3" checked>
                            <div class="flex items-center">
                                <i class="fas fa-envelope text-blue-600 text-xl mr-3"></i>
                                <div>
                                    <div class="font-medium text-gray-800">Email</div>
                                    <div class="text-sm text-gray-600">{{ $email }}</div>
                                </div>
                            </div>
                        </label>
                    </div>

                    <!-- SMS Option -->
                    <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors {{ !$user->phone ? 'opacity-50' : '' }}">
                        <label class="flex items-center cursor-pointer {{ !$user->phone ? 'cursor-not-allowed' : '' }}">
                            <input type="radio" name="delivery_method" value="sms" class="mr-3" {{ !$user->phone ? 'disabled' : '' }}>
                            <div class="flex items-center">
                                <i class="fas fa-sms text-green-600 text-xl mr-3"></i>
                                <div>
                                    <div class="font-medium text-gray-800">SMS</div>
                                    <div class="text-sm text-gray-600">
                                        {{ $user->phone ? $user->phone : 'Nomor telepon tidak tersedia' }}
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>

                    <!-- WhatsApp Option -->
                    <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors {{ !$user->phone ? 'opacity-50' : '' }}">
                        <label class="flex items-center cursor-pointer {{ !$user->phone ? 'cursor-not-allowed' : '' }}">
                            <input type="radio" name="delivery_method" value="whatsapp" class="mr-3" {{ !$user->phone ? 'disabled' : '' }}>
                            <div class="flex items-center">
                                <i class="fab fa-whatsapp text-green-500 text-xl mr-3"></i>
                                <div>
                                    <div class="font-medium text-gray-800">WhatsApp</div>
                                    <div class="text-sm text-gray-600">
                                        {{ $user->phone ? $user->phone : 'Nomor telepon tidak tersedia' }}
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>

                    @if (!$user->phone)
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <div class="flex items-start">
                                <i class="fas fa-info-circle text-yellow-500 mr-2 mt-0.5"></i>
                                <div class="text-sm">
                                    <p class="text-yellow-700 font-medium mb-1">Nomor telepon tidak tersedia</p>
                                    <p class="text-yellow-600">Untuk menggunakan SMS atau WhatsApp, silakan lengkapi nomor telepon di profil Anda.</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <button type="submit" class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                        <i class="fas fa-paper-plane mr-2"></i>Kirim Kode OTP
                    </button>
                </form>

                <div class="text-center mt-6">
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 transition-colors">
                        <i class="fas fa-arrow-left mr-1"></i>Kembali ke Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection