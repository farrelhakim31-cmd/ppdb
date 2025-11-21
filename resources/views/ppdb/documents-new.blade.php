@extends('layouts.app')

@section('title', 'Upload Dokumen')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Upload Dokumen</h1>
            <p class="text-gray-600">{{ $registration->name }} - {{ $registration->registration_number }}</p>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-600 mr-3"></i>
                    <span class="text-green-800">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Upload Form -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white p-6">
                <div class="flex items-center">
                    <i class="fas fa-cloud-upload-alt text-2xl mr-3"></i>
                    <h3 class="text-xl font-semibold">Upload Semua Dokumen</h3>
                </div>
            </div>
            
            <div class="p-6">
                <form action="{{ route('ppdb.upload-documents', $registration->registration_number) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <!-- Required Documents -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Kartu Keluarga -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-users mr-2 text-blue-500"></i>Fotokopi Kartu Keluarga (KK)
                            </label>
                            <input type="file" name="kk" class="w-full px-3 py-2 border border-gray-300 rounded-lg" accept=".pdf,.jpg,.jpeg,.png">
                            <p class="text-xs text-gray-500 mt-1">Format: PDF, JPG, PNG • Max: 2MB</p>
                        </div>

                        <!-- Akta Kelahiran -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-certificate mr-2 text-blue-500"></i>Fotokopi Akta Kelahiran (legalisir)
                            </label>
                            <input type="file" name="akta" class="w-full px-3 py-2 border border-gray-300 rounded-lg" accept=".pdf,.jpg,.jpeg,.png">
                            <p class="text-xs text-gray-500 mt-1">Format: PDF, JPG, PNG • Max: 2MB</p>
                        </div>

                        <!-- Ijazah -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-graduation-cap mr-2 text-blue-500"></i>Fotokopi Ijazah/SKHUN SMP/MTs (legalisir)
                            </label>
                            <input type="file" name="ijazah" class="w-full px-3 py-2 border border-gray-300 rounded-lg" accept=".pdf,.jpg,.jpeg,.png">
                            <p class="text-xs text-gray-500 mt-1">Format: PDF, JPG, PNG • Max: 2MB</p>
                        </div>

                        <!-- Pas Foto -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-camera mr-2 text-blue-500"></i>Pas foto 3x4 (2 lembar) background merah
                            </label>
                            <input type="file" name="pas_foto" class="w-full px-3 py-2 border border-gray-300 rounded-lg" accept=".jpg,.jpeg,.png">
                            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG • Max: 2MB</p>
                        </div>

                        <!-- Surat Sehat -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-heartbeat mr-2 text-blue-500"></i>Surat keterangan sehat dari dokter/puskesmas
                            </label>
                            <input type="file" name="surat_sehat" class="w-full px-3 py-2 border border-gray-300 rounded-lg" accept=".pdf,.jpg,.jpeg,.png">
                            <p class="text-xs text-gray-500 mt-1">Format: PDF, JPG, PNG • Max: 2MB</p>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors font-semibold flex items-center">
                            <i class="fas fa-upload mr-2"></i>Upload Semua Dokumen
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Documents List -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-gray-500 to-gray-600 text-white p-6">
                <div class="flex items-center">
                    <i class="fas fa-folder-open text-2xl mr-3"></i>
                    <h3 class="text-xl font-semibold">Dokumen Terupload</h3>
                </div>
            </div>
            
            <div class="p-6">
                @if($registration->documents()->count() > 0)
                    <div class="space-y-4">
                        @foreach($registration->documents()->get() as $doc)
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                            @if(str_contains($doc->nama_file, '.pdf'))
                                                <i class="fas fa-file-pdf text-red-500 text-xl"></i>
                                            @else
                                                <i class="fas fa-file-image text-blue-500 text-xl"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-800">{{ $doc->jenis }}</h4>
                                            <p class="text-sm text-gray-600">{{ $doc->nama_file }}</p>
                                            <p class="text-xs text-gray-500">{{ $doc->created_at->format('d M Y, H:i') }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        @if($doc->valid)
                                            <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full">
                                                <i class="fas fa-check-circle mr-1"></i>Valid
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 bg-yellow-100 text-yellow-800 text-sm rounded-full">
                                                <i class="fas fa-clock mr-1"></i>Menunggu Validasi
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-folder-open text-6xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500 text-lg">Belum ada dokumen yang diupload</p>
                        <p class="text-gray-400 text-sm">Silakan upload dokumen pendukung di atas</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Back Button -->
        <div class="text-center mt-8">
            <a href="{{ route('siswa.dashboard') }}" class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition-colors font-semibold inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>
@endsection