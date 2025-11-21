@extends('partials.main')

@section('content')
<style>
.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    position: relative;
    overflow: hidden;
}
.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('{{ asset('images/school-bg.jpg') }}') center/cover;
    opacity: 0.1;
    z-index: 1;
}
.hero-content {
    position: relative;
    z-index: 2;
}
.logo-animation {
    animation: float 3s ease-in-out infinite;
}
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}
.btn-modern {
    border-radius: 50px;
    padding: 15px 30px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}
.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.3);
}
.card-modern {
    border-radius: 20px;
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}
.card-modern:hover {
    transform: translateY(-5px);
}
</style>

<!-- Hero Section -->
<div class="hero-section">
    <div class="container hero-content">
        <div class="row justify-content-center text-center">
            <div class="col-lg-10">
                <div class="mb-4">
                    <img src="{{ asset('images/logo-smk.png') }}" alt="Logo SMK" class="logo-animation mb-3" style="width: 140px; height: 140px; filter: drop-shadow(0 4px 8px rgba(0,0,0,0.3));">
                </div>
                <h1 class="display-3 text-white mb-3 fw-bold" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">PPDB ONLINE</h1>
                <h2 class="h2 text-white mb-4" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">SMK BAKTI NUSANTARA 666</h2>
                <p class="lead text-white mb-5" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">Bergabunglah dengan sekolah terbaik untuk masa depan yang cerah</p>
                
                <div class="row justify-content-center g-3">
                    <div class="col-lg-4 col-md-6">
                        <a href="{{ route('ppdb.register') }}" class="btn btn-success btn-modern w-100">
                            <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <a href="{{ route('login') }}" class="btn btn-warning btn-modern w-100">
                            <i class="fas fa-sign-in-alt me-2"></i>Login Siswa
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <a href="#" class="btn btn-danger btn-modern w-100">
                            <i class="fas fa-download me-2"></i>Panduan PPDB
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Navigation Menu -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background: rgba(255,255,255,0.98); backdrop-filter: blur(15px); box-shadow: 0 2px 25px rgba(0,0,0,0.08); transition: all 0.3s ease;">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}" style="color: #2c3e50;">
            <img src="{{ asset('images/logo-smk.png') }}" alt="Logo SMK" width="50" height="50" class="me-3" style="border-radius: 50%; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <div>
                <div class="fw-bold fs-5">SMK BAKTI NUSANTARA</div>
                <small class="text-muted">PPDB Online 2024</small>
            </div>
        </a>
        
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" style="box-shadow: none;">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link fw-semibold px-3 py-2 rounded-pill" href="#" style="color: #34495e; transition: all 0.3s ease;" onmouseover="this.style.background='#e8f4fd'; this.style.color='#2980b9'" onmouseout="this.style.background='transparent'; this.style.color='#34495e'">
                        <i class="fas fa-home me-2"></i>Beranda
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold px-3 py-2 rounded-pill" href="#info" style="color: #34495e; transition: all 0.3s ease;" onmouseover="this.style.background='#e8f4fd'; this.style.color='#2980b9'" onmouseout="this.style.background='transparent'; this.style.color='#34495e'">
                        <i class="fas fa-info-circle me-2"></i>Informasi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold px-3 py-2 rounded-pill" href="#requirements" style="color: #34495e; transition: all 0.3s ease;" onmouseover="this.style.background='#e8f4fd'; this.style.color='#2980b9'" onmouseout="this.style.background='transparent'; this.style.color='#34495e'">
                        <i class="fas fa-clipboard-list me-2"></i>Persyaratan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold px-3 py-2 rounded-pill" href="#contact" style="color: #34495e; transition: all 0.3s ease;" onmouseover="this.style.background='#e8f4fd'; this.style.color='#2980b9'" onmouseout="this.style.background='transparent'; this.style.color='#34495e'">
                        <i class="fas fa-phone me-2"></i>Kontak
                    </a>
                </li>
                
                @auth
                    @if(auth()->user()->role === 'siswa')
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-success me-2 px-3 py-2" href="{{ route('siswa.dashboard') }}" style="border-radius: 25px; font-weight: 600;">
                            <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                        </a>
                    </li>
                    @elseif(auth()->user()->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-primary me-2 px-3 py-2" href="javascript:history.back()" style="border-radius: 25px; font-weight: 600;">
                            <i class="fas fa-arrow-left me-1"></i>Kembali
                        </a>
                    </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle btn btn-light px-3 py-2" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" style="border-radius: 25px; font-weight: 600; color: #2c3e50;">
                            <i class="fas fa-user-circle me-1"></i>{{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" style="border-radius: 15px; box-shadow: 0 5px 25px rgba(0,0,0,0.1);">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary text-white px-4 py-2 ms-2" href="{{ route('login') }}" style="border-radius: 25px; font-weight: 600; box-shadow: 0 3px 15px rgba(52, 152, 219, 0.3);">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<!-- Information Section -->
<section id="info" class="py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e8f4fd 100%);">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold text-primary mb-3">Informasi PPDB Online</h2>
            <p class="lead text-muted">SMK BAKTI NUSANTARA 666 - Membangun Generasi Unggul</p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="card card-modern h-100 text-center p-4">
                    <div class="mb-4">
                        <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-calendar-alt fa-2x text-white"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-3">Jadwal Pendaftaran</h5>
                    <p class="text-muted mb-4">Periode pendaftaran PPDB Online tahun ajaran 2024/2025</p>
                    <div class="alert alert-info">
                        <strong>1 Januari - 31 Maret 2024</strong>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="card card-modern h-100 text-center p-4">
                    <div class="mb-4">
                        <div class="bg-success rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-file-alt fa-2x text-white"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-3">Persyaratan</h5>
                    <p class="text-muted mb-4">Dokumen dan syarat yang harus dipenuhi calon siswa</p>
                    <a href="#requirements" class="btn btn-outline-success">Lihat Detail</a>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="card card-modern h-100 text-center p-4">
                    <div class="mb-4">
                        <div class="bg-warning rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-graduation-cap fa-2x text-white"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-3">Program Keahlian</h5>
                    <p class="text-muted mb-4">5 jurusan unggulan dengan fasilitas modern</p>
                    <div class="d-flex flex-wrap gap-1 justify-content-center">
                        <span class="badge bg-primary">PPLG</span>
                        <span class="badge bg-success">Akuntansi</span>
                        <span class="badge bg-warning">Animasi</span>
                        <span class="badge bg-info">DKV</span>
                        <span class="badge bg-danger">BDP</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Requirements Section -->
<section id="requirements" class="py-5" style="background: #ffffff;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="text-center mb-5">
                    <h2 class="display-5 fw-bold text-dark mb-3">Persyaratan Pendaftaran</h2>
                    <p class="lead text-muted">Siapkan dokumen berikut untuk proses pendaftaran PPDB Online</p>
                </div>
                
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="card card-modern h-100">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-primary rounded-circle p-3 me-3">
                                        <i class="fas fa-clipboard-list text-white"></i>
                                    </div>
                                    <h5 class="fw-bold mb-0">Dokumen Wajib</h5>
                                </div>
                                <div class="requirements-list">
                                    <div class="d-flex align-items-center mb-3 p-3 bg-light rounded">
                                        <i class="fas fa-users text-primary me-3"></i>
                                        <span>Fotokopi Kartu Keluarga</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3 p-3 bg-light rounded">
                                        <i class="fas fa-certificate text-success me-3"></i>
                                        <span>Fotokopi Akta Kelahiran</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3 p-3 bg-light rounded">
                                        <i class="fas fa-graduation-cap text-warning me-3"></i>
                                        <span>Fotokopi Ijazah/SKHUN SMP</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="card card-modern h-100">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-success rounded-circle p-3 me-3">
                                        <i class="fas fa-camera text-white"></i>
                                    </div>
                                    <h5 class="fw-bold mb-0">Dokumen Tambahan</h5>
                                </div>
                                <div class="requirements-list">
                                    <div class="d-flex align-items-center mb-3 p-3 bg-light rounded">
                                        <i class="fas fa-camera text-info me-3"></i>
                                        <span>Pas foto 3x4 (2 lembar)</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3 p-3 bg-light rounded">
                                        <i class="fas fa-heartbeat text-danger me-3"></i>
                                        <span>Surat keterangan sehat</span>
                                    </div>
                                    <div class="d-flex align-items-center mb-3 p-3 bg-light rounded">
                                        <i class="fas fa-id-card text-secondary me-3"></i>
                                        <span>Fotokopi KTP Orang Tua</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-5">
                    <div class="alert alert-warning d-inline-block">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Penting:</strong> Pastikan semua dokumen dalam format PDF atau JPG dengan ukuran maksimal 2MB
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h2 class="display-5 fw-bold text-white mb-4">Butuh Bantuan?</h2>
                <p class="lead text-white mb-5">Tim kami siap membantu Anda dalam proses pendaftaran PPDB Online</p>
                
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="text-white">
                            <i class="fas fa-phone fa-2x mb-3"></i>
                            <h5>Telepon</h5>
                            <p>(021) 123-4567</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-white">
                            <i class="fas fa-envelope fa-2x mb-3"></i>
                            <h5>Email</h5>
                            <p>ppdb@smkbaktinusantara.sch.id</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-white">
                            <i class="fas fa-map-marker-alt fa-2x mb-3"></i>
                            <h5>Alamat</h5>
                            @php
                                $mapSettings = \App\Models\MapSetting::getSettings();
                            @endphp
                            <p>{{ $mapSettings->school_address }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection