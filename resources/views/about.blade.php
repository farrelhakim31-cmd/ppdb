@extends('partials.main')

@section('content')
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 400px;">
                <div class="position-relative h-100">
                    <img class="img-fluid position-absolute w-100 h-100" src="img/about.jpg" alt="" style="object-fit: cover;">
                </div>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                <h6 class="section-title bg-white text-start text-primary pe-3">Tentang Kami</h6>
                <h1 class="mb-4">Selamat Datang di PPDB Online</h1>
                <p class="mb-4">Sistem Penerimaan Peserta Didik Baru (PPDB) Online adalah platform digital yang memudahkan calon siswa untuk mendaftar ke sekolah pilihan mereka.</p>
                <p class="mb-4">Dengan sistem ini, proses pendaftaran menjadi lebih mudah, transparan, dan efisien.</p>
                <div class="row gy-2 gx-4 mb-4">
                    <div class="col-sm-6">
                        <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Pendaftaran Online 24/7</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Proses Transparan</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Verifikasi Real-time</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Pembayaran Digital</p>
                    </div>
                </div>
                <a class="btn btn-primary py-3 px-5 mt-2" href="{{ route('ppdb.register') }}">Daftar Sekarang</a>
            </div>
        </div>
    </div>
</div>
@endsection