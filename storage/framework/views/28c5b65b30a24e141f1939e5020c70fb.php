<?php $__env->startSection('title', 'Info PPDB - SMK BAKTI NUSANTARA 666'); ?>

<?php
    $mapSettings = \App\Models\MapSetting::getSettings();
?>

<?php $__env->startSection('head'); ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-graduation-cap text-white"></i>
                </div>
                <h1 class="text-xl font-semibold text-gray-900">PPDB Online</h1>
            </div>
            <a href="<?php echo e(Auth::check() && Auth::user()->role === 'siswa' ? route('siswa.dashboard') : route('home')); ?>" class="text-gray-600 hover:text-blue-600 transition-colors">
                ← Kembali
            </a>
        </div>
    </header>

    <div class="max-w-4xl mx-auto px-4 py-12">
        <!-- Title -->
        <div class="text-center mb-12">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Penerimaan Peserta Didik Baru</h1>
            <p class="text-gray-600">Bergabunglah dengan SMK BAKTI NUSANTARA 666 untuk masa depan yang cerah</p>
        </div>

        <!-- Info Cards -->
        <div class="grid md:grid-cols-3 gap-6 mb-8">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-xl p-6 text-center">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-calendar-alt text-xl"></i>
                </div>
                <h4 class="font-semibold mb-2">Periode Pendaftaran</h4>
                <p class="text-sm opacity-90">1 Januari - 31 Maret 2025</p>
            </div>
            
            <div class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-xl p-6 text-center">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-users text-xl"></i>
                </div>
                <h4 class="font-semibold mb-2">Kuota Tersedia</h4>
                <p class="text-sm opacity-90">360 Siswa</p>
            </div>
            
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-xl p-6 text-center">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-graduation-cap text-xl"></i>
                </div>
                <h4 class="font-semibold mb-2">Program Keahlian</h4>
                <p class="text-sm opacity-90">12 Jurusan</p>
            </div>
        </div>

        <!-- Action Cards -->
        <div class="grid md:grid-cols-2 gap-6 mb-12">
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8 card-hover">
                <div class="text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <i class="fas fa-user-plus text-3xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Daftar Sekarang</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">Mulai proses pendaftaran sebagai calon siswa baru dengan sistem online yang mudah dan cepat</p>
                    <a href="<?php echo e(route('ppdb.register')); ?>" 
                       class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-8 py-4 rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all duration-300 inline-block font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <i class="fas fa-arrow-right mr-2"></i>
                        Daftar Sekarang
                    </a>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
                <div class="text-center mb-6">
                    <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <i class="fas fa-search text-3xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Cek Status Pendaftaran</h3>
                </div>
                
                <form action="<?php echo e(route('ppdb.check-status')); ?>" method="POST" class="space-y-4">
                    <?php echo csrf_field(); ?>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">Nomor Pendaftaran</label>
                        <input type="text" 
                               name="registration_number" 
                               class="w-full px-4 py-4 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-300 text-center font-mono text-lg" 
                               placeholder="PPDB2025XXXX" 
                               required>
                    </div>
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white py-4 px-4 rounded-xl hover:from-green-600 hover:to-green-700 transition-all duration-300 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        <i class="fas fa-search mr-2"></i>
                        Cek Status
                    </button>
                </form>
            </div>
        </div>

        <!-- Program Keahlian -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8 mb-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-8 text-center">Program Keahlian yang Tersedia</h3>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="text-center p-6 bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl">
                    <div class="w-16 h-16 bg-blue-500 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-laptop-code text-2xl text-white"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">Teknik Komputer & Jaringan</h4>
                    <p class="text-sm text-gray-600">Mempelajari instalasi, konfigurasi, dan maintenance sistem komputer dan jaringan</p>
                </div>
                
                <div class="text-center p-6 bg-gradient-to-br from-green-50 to-green-100 rounded-xl">
                    <div class="w-16 h-16 bg-green-500 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-mobile-alt text-2xl text-white"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">Rekayasa Perangkat Lunak</h4>
                    <p class="text-sm text-gray-600">Mengembangkan aplikasi mobile, web, dan desktop dengan teknologi terkini</p>
                </div>
                
                <div class="text-center p-6 bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl">
                    <div class="w-16 h-16 bg-purple-500 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-chart-line text-2xl text-white"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">Akuntansi & Keuangan</h4>
                    <p class="text-sm text-gray-600">Menguasai pembukuan, perpajakan, dan manajemen keuangan perusahaan</p>
                </div>
                
                <div class="text-center p-6 bg-gradient-to-br from-red-50 to-red-100 rounded-xl">
                    <div class="w-16 h-16 bg-red-500 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-bullhorn text-2xl text-white"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">Bisnis Digital Marketing</h4>
                    <p class="text-sm text-gray-600">Strategi pemasaran digital, e-commerce, dan media sosial marketing</p>
                </div>
                
                <div class="text-center p-6 bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl">
                    <div class="w-16 h-16 bg-yellow-500 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-wrench text-2xl text-white"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">Teknik Mesin</h4>
                    <p class="text-sm text-gray-600">Pemeliharaan dan perbaikan mesin industri, otomotif, dan manufaktur</p>
                </div>
                
                <div class="text-center p-6 bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl">
                    <div class="w-16 h-16 bg-indigo-500 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-bolt text-2xl text-white"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">Teknik Listrik</h4>
                    <p class="text-sm text-gray-600">Instalasi listrik, sistem tenaga, dan teknologi kelistrikan modern</p>
                </div>
            </div>
        </div>

        <!-- Persyaratan -->
        <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl border border-orange-200 p-8 mb-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center flex items-center justify-center">
                <i class="fas fa-clipboard-list text-orange-500 mr-3"></i>
                Persyaratan Pendaftaran
            </h3>
            <div class="grid md:grid-cols-2 gap-8">
                <div>
                    <h4 class="font-semibold text-gray-900 mb-4 text-lg">Dokumen yang Diperlukan:</h4>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                            <span class="text-gray-700"><strong>Fotokopi Kartu Keluarga</strong> (KK yang masih berlaku)</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                            <span class="text-gray-700"><strong>Fotokopi Akta Kelahiran</strong> (legalisir)</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                            <span class="text-gray-700"><strong>Fotokopi Ijazah/SKHUN</strong> SMP/MTs (legalisir)</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                            <span class="text-gray-700"><strong>Pas foto 3x4 (2 lembar)</strong> background merah</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                            <span class="text-gray-700"><strong>Surat keterangan sehat</strong> dari dokter/puskesmas</span>
                        </li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 mb-4 text-lg">Syarat Umum:</h4>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-blue-500 mt-1 mr-3"></i>
                            <span class="text-gray-700">Lulusan SMP/MTs sederajat</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-blue-500 mt-1 mr-3"></i>
                            <span class="text-gray-700">Usia maksimal 21 tahun</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-blue-500 mt-1 mr-3"></i>
                            <span class="text-gray-700">Sehat jasmani dan rohani</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-blue-500 mt-1 mr-3"></i>
                            <span class="text-gray-700">Tidak buta warna (untuk jurusan tertentu)</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-blue-500 mt-1 mr-3"></i>
                            <span class="text-gray-700">Mengikuti tes masuk sekolah</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Cara Menggunakan Website -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8 mb-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-8 text-center flex items-center justify-center">
                <i class="fas fa-question-circle text-blue-500 mr-3"></i>
                Cara Menggunakan Website PPDB
            </h3>
            <div class="grid md:grid-cols-2 gap-8">
                <div>
                    <h4 class="font-semibold text-gray-900 mb-4 text-lg">Langkah-langkah Pendaftaran:</h4>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">1</div>
                            <div>
                                <h5 class="font-semibold text-gray-900">Buat Akun</h5>
                                <p class="text-gray-600 text-sm">Klik "Daftar Sekarang" dan isi data diri dengan lengkap</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">2</div>
                            <div>
                                <h5 class="font-semibold text-gray-900">Verifikasi Email</h5>
                                <p class="text-gray-600 text-sm">Cek email dan masukkan kode OTP yang dikirim</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">3</div>
                            <div>
                                <h5 class="font-semibold text-gray-900">Login ke Dashboard</h5>
                                <p class="text-gray-600 text-sm">Masuk dengan email dan password yang sudah dibuat</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">4</div>
                            <div>
                                <h5 class="font-semibold text-gray-900">Isi Form Pendaftaran</h5>
                                <p class="text-gray-600 text-sm">Lengkapi biodata, pilih jurusan, dan data orang tua</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">5</div>
                            <div>
                                <h5 class="font-semibold text-gray-900">Upload Dokumen</h5>
                                <p class="text-gray-600 text-sm">Unggah semua dokumen persyaratan dalam format PDF/JPG</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">6</div>
                            <div>
                                <h5 class="font-semibold text-gray-900">Bayar Biaya Pendaftaran</h5>
                                <p class="text-gray-600 text-sm">Transfer ke rekening sekolah dan upload bukti pembayaran</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 mb-4 text-lg">Tips Penggunaan Website:</h4>
                    <div class="space-y-4">
                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                            <h5 class="font-semibold text-blue-900 mb-2">📱 Akses Multi-Device</h5>
                            <p class="text-blue-800 text-sm">Website dapat diakses melalui HP, tablet, atau komputer dengan koneksi internet</p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                            <h5 class="font-semibold text-green-900 mb-2">💾 Simpan Data Otomatis</h5>
                            <p class="text-green-800 text-sm">Data yang diisi akan tersimpan otomatis, bisa dilanjutkan kapan saja</p>
                        </div>
                        <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                            <h5 class="font-semibold text-yellow-900 mb-2">🔍 Cek Status Real-time</h5>
                            <p class="text-yellow-800 text-sm">Pantau status pendaftaran dan verifikasi dokumen secara langsung</p>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                            <h5 class="font-semibold text-purple-900 mb-2">📞 Bantuan 24/7</h5>
                            <p class="text-purple-800 text-sm">Tim support siap membantu melalui WhatsApp atau telepon sekolah</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Benefits Section -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-8 text-center">Manfaat Sistem PPDB Online</h3>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-xl border border-blue-200">
                    <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-user-graduate text-white text-xl"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-3">Bagi Calon Siswa</h4>
                    <p class="text-gray-700 text-sm leading-relaxed">Dapat mendaftar dengan mudah, memantau status pendaftaran, dan mengunggah dokumen dari rumah kapan saja.</p>
                </div>
                
                <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-xl border border-green-200">
                    <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-users-cog text-white text-xl"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-3">Bagi Panitia Sekolah</h4>
                    <p class="text-gray-700 text-sm leading-relaxed">Mempermudah proses pengumpulan dan verifikasi data calon siswa serta monitoring real-time.</p>
                </div>
                
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-6 rounded-xl border border-purple-200">
                    <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-credit-card text-white text-xl"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-3">Bagi Bagian Keuangan</h4>
                    <p class="text-gray-700 text-sm leading-relaxed">Proses pembayaran lebih tertata dengan bukti digital yang tersimpan otomatis dan aman.</p>
                </div>
                
                <div class="bg-gradient-to-br from-orange-50 to-orange-100 p-6 rounded-xl border border-orange-200">
                    <div class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-chart-bar text-white text-xl"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-3">Bagi Kepala Sekolah</h4>
                    <p class="text-gray-700 text-sm leading-relaxed">Mendapatkan laporan dan statistik pendaftaran secara real-time yang dapat diunduh kapan saja.</p>
                </div>
                
                <div class="bg-gradient-to-br from-red-50 to-red-100 p-6 rounded-xl border border-red-200">
                    <div class="w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-award text-white text-xl"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-3">Bagi Sekolah</h4>
                    <p class="text-gray-700 text-sm leading-relaxed">Meningkatkan citra sekolah dengan sistem penerimaan siswa berbasis teknologi modern.</p>
                </div>
                
                <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 p-6 rounded-xl border border-indigo-200">
                    <div class="w-12 h-12 bg-indigo-500 rounded-xl flex items-center justify-center mb-4">
                        <i class="fas fa-shield-alt text-white text-xl"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-3">Keamanan Data</h4>
                    <p class="text-gray-700 text-sm leading-relaxed">Data pendaftar tersimpan aman dengan enkripsi dan backup otomatis untuk mencegah kehilangan data.</p>
                </div>
            </div>
        </div>
        
        <!-- Map Section -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8 mb-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center flex items-center justify-center">
                <i class="fas fa-map-marker-alt text-blue-500 mr-3"></i>
                Lokasi Sekolah
            </h3>
            <div class="grid md:grid-cols-2 gap-8">
                <div>
                    <h4 class="font-semibold text-gray-900 mb-4 text-lg">Alamat Lengkap:</h4>
                    <div class="space-y-3">
                        <div class="flex items-start">
                            <i class="fas fa-map-marker-alt text-blue-500 mt-1 mr-3"></i>
                            <div>
                                <p class="font-semibold text-gray-900"><?php echo e($mapSettings->school_name); ?></p>
                                <p class="text-gray-600"><?php echo e($mapSettings->school_address); ?></p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-phone text-green-500 mt-1 mr-3"></i>
                            <div>
                                <p class="text-gray-600">(0711) 123-4567 / 0812-3456-7890</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-envelope text-purple-500 mt-1 mr-3"></i>
                            <div>
                                <p class="text-gray-600">info@smkbaktinusantara666.sch.id</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6">
                        <h5 class="font-semibold text-gray-900 mb-3">Akses Transportasi:</h5>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <i class="fas fa-bus text-orange-500 mr-2"></i>
                                <span class="text-sm text-gray-600">Angkutan umum tersedia</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-car text-blue-500 mr-2"></i>
                                <span class="text-sm text-gray-600">Parkir luas untuk kendaraan pribadi</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-motorcycle text-red-500 mr-2"></i>
                                <span class="text-sm text-gray-600">Area parkir motor tersedia</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div id="schoolMap" style="height: 350px; border-radius: 12px; border: 2px solid #e5e7eb;"></div>
                    <p class="text-xs text-gray-500 mt-2 text-center">Klik dan drag untuk menjelajahi peta</p>
                </div>
            </div>
        </div>

        <!-- Contact Info -->
        <div class="bg-gradient-to-r from-gray-800 to-gray-900 text-white rounded-xl p-8 mt-8">
            <h3 class="text-2xl font-bold mb-6 text-center">Informasi Kontak</h3>
            <div class="grid md:grid-cols-3 gap-6 text-center">
                <div>
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-map-marker-alt text-xl"></i>
                    </div>
                    <h4 class="font-semibold mb-2">Alamat Sekolah</h4>
                    <p class="text-sm opacity-90"><?php echo e($mapSettings->school_address); ?></p>
                </div>
                
                <div>
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-phone text-xl"></i>
                    </div>
                    <h4 class="font-semibold mb-2">Telepon</h4>
                    <p class="text-sm opacity-90">(0711) 123-4567<br>0812-3456-7890</p>
                </div>
                
                <div>
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-envelope text-xl"></i>
                    </div>
                    <h4 class="font-semibold mb-2">Email</h4>
                    <p class="text-sm opacity-90">info@smkbaktinusantara666.sch.id<br>ppdb@smkbaktinusantara666.sch.id</p>
                </div>
            </div>
            
            <div class="text-center mt-8 pt-6 border-t border-white/20">
                <p class="text-sm opacity-75">
                    © 2025 SMK BAKTI NUSANTARA 666. Sistem PPDB Online - Mudah, Cepat, dan Terpercaya
                </p>
            </div>
        </div>
    </div>
</div>

<script>
// Initialize school location map
if (document.getElementById('schoolMap')) {
    var schoolMap = L.map('schoolMap').setView([<?php echo e($mapSettings->latitude); ?>, <?php echo e($mapSettings->longitude); ?>], <?php echo e($mapSettings->zoom_level); ?>);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(schoolMap);
    
    // Add school marker
    L.marker([<?php echo e($mapSettings->latitude); ?>, <?php echo e($mapSettings->longitude); ?>]).addTo(schoolMap)
        .bindPopup('<div class="p-2"><h5 class="font-bold text-blue-600"><?php echo e($mapSettings->school_name); ?></h5><p class="text-sm"><?php echo e($mapSettings->school_address); ?></p></div>')
        .openPopup();
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.minimal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC-08\Farrel_ujikom\resources\views/ppdb/index.blade.php ENDPATH**/ ?>