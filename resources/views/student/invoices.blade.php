@extends('layouts.app')

@section('title', 'Tagihan Saya')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8">
    <div class="max-w-4xl mx-auto px-4">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Tagihan Pembayaran</h1>
            <p class="text-gray-600">{{ $registration->name }} - {{ $registration->registration_number }}</p>
        </div>

        @if($invoices->count() > 0)
            <div class="space-y-6">
                @foreach($invoices as $invoice)
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-xl font-bold">{{ $invoice->invoice_number }}</h3>
                                <p class="text-blue-100">{{ $invoice->description }}</p>
                            </div>
                            <div class="text-right">
                                @if($invoice->status === 'paid')
                                    <span class="inline-block px-3 py-1 bg-green-500 text-white text-sm rounded-full">Lunas</span>
                                @elseif($invoice->isOverdue())
                                    <span class="inline-block px-3 py-1 bg-red-500 text-white text-sm rounded-full">Terlambat</span>
                                @else
                                    <span class="inline-block px-3 py-1 bg-yellow-500 text-white text-sm rounded-full">Belum Bayar</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="border-l-4 border-blue-500 pl-4">
                                <p class="text-sm text-gray-600">Jenis Tagihan</p>
                                <p class="font-bold text-gray-800">{{ ucfirst($invoice->type) }}</p>
                            </div>
                            <div class="border-l-4 border-green-500 pl-4">
                                <p class="text-sm text-gray-600">Jumlah</p>
                                <p class="font-bold text-2xl text-gray-800">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</p>
                            </div>
                            <div class="border-l-4 border-red-500 pl-4">
                                <p class="text-sm text-gray-600">Jatuh Tempo</p>
                                <p class="font-bold text-gray-800">{{ $invoice->due_date->format('d F Y') }}</p>
                                @if($invoice->isOverdue())
                                    <p class="text-xs text-red-500">Terlambat {{ abs($invoice->days_until_due) }} hari</p>
                                @else
                                    <p class="text-xs text-gray-500">{{ $invoice->days_until_due }} hari lagi</p>
                                @endif
                            </div>
                        </div>

                        @if($invoice->status === 'paid')
                            <div class="mt-6 bg-green-50 border border-green-200 rounded-lg p-4">
                                <div class="flex items-center">
                                    <i class="fas fa-check-circle text-green-600 text-xl mr-3"></i>
                                    <div>
                                        <h5 class="font-semibold text-green-800">Pembayaran Lunas</h5>
                                        <p class="text-green-700 text-sm">Dibayar pada {{ $invoice->paid_at->format('d F Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        @elseif($invoice->isOverdue())
                            <div class="mt-6 bg-red-50 border border-red-200 rounded-lg p-4">
                                <div class="flex items-center">
                                    <i class="fas fa-exclamation-triangle text-red-600 text-xl mr-3"></i>
                                    <div>
                                        <h5 class="font-semibold text-red-800">Pembayaran Terlambat</h5>
                                        <p class="text-red-700 text-sm">Segera lakukan pembayaran untuk menghindari denda</p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <i class="fas fa-clock text-yellow-600 text-xl mr-3"></i>
                                        <div>
                                            <h5 class="font-semibold text-yellow-800">Menunggu Pembayaran</h5>
                                            <p class="text-yellow-700 text-sm">Silakan lakukan pembayaran sebelum jatuh tempo</p>
                                        </div>
                                    </div>
                                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                        Bayar Sekarang
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-xl p-8 text-center">
                <i class="fas fa-file-invoice text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Belum Ada Tagihan</h3>
                <p class="text-gray-600">Saat ini tidak ada tagihan yang perlu dibayar</p>
            </div>
        @endif
    </div>
</div>
@endsection