@extends('layouts.app')

@section('title', 'Kelola Tagihan Keuangan')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-emerald-100 py-8">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Kelola Tagihan</h1>
                <p class="text-gray-600">Sistem Keuangan PPDB</p>
            </div>
            <a href="{{ route('keuangan.invoices.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium">
                <i class="fas fa-plus mr-2"></i>
                Buat Tagihan Baru
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <i class="fas fa-file-invoice text-green-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Total Tagihan</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $invoices->total() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <i class="fas fa-check-circle text-blue-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Lunas</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $invoices->where('status', 'paid')->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-yellow-100 rounded-lg">
                        <i class="fas fa-clock text-yellow-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Belum Bayar</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $invoices->where('status', 'unpaid')->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-red-100 rounded-lg">
                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-600">Terlambat</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $invoices->where('status', 'overdue')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800">Daftar Tagihan</h3>
                <div class="flex space-x-2">
                    <select class="border border-gray-300 rounded px-3 py-1 text-sm">
                        <option>Semua Status</option>
                        <option>Belum Bayar</option>
                        <option>Lunas</option>
                        <option>Terlambat</option>
                    </select>
                    <input type="text" placeholder="Cari siswa..." class="border border-gray-300 rounded px-3 py-1 text-sm">
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Invoice</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Siswa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jatuh Tempo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($invoices as $invoice)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $invoice->invoice_number }}</div>
                                <div class="text-xs text-gray-500">{{ $invoice->created_at->format('d/m/Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $invoice->registration->name }}</div>
                                <div class="text-sm text-gray-500">{{ $invoice->registration->registration_number }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ ucfirst($invoice->type) }}</div>
                                <div class="text-sm text-gray-500">{{ $invoice->description }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $invoice->due_date->format('d M Y') }}</div>
                                @if($invoice->isOverdue())
                                    <div class="text-xs text-red-500">Terlambat {{ abs($invoice->days_until_due) }} hari</div>
                                @else
                                    <div class="text-xs text-gray-500">{{ $invoice->days_until_due }} hari lagi</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($invoice->status === 'paid')
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-check mr-1"></i>Lunas
                                    </span>
                                @elseif($invoice->isOverdue())
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>Terlambat
                                    </span>
                                @else
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-1"></i>Belum Bayar
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    @if($invoice->status !== 'paid')
                                        <form action="{{ route('keuangan.invoices.mark-paid', $invoice) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs" onclick="return confirm('Tandai sebagai lunas?')">
                                                <i class="fas fa-check mr-1"></i>Terima
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('keuangan.invoices.show', $invoice) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs">
                                        <i class="fas fa-eye mr-1"></i>Lihat
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                <i class="fas fa-file-invoice text-4xl text-gray-300 mb-4"></i>
                                <p>Belum ada tagihan yang dibuat</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $invoices->links() }}
            </div>
        </div>
    </div>
</div>
@endsection