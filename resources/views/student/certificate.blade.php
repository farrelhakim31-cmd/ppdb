@extends('partials.main')

@section('content')
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Sertifikat</h6>
            <h1 class="mb-5">Cetak Kartu/Resume</h1>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Kartu Pendaftaran</h5>
                        <p class="card-text">Selamat! Pendaftaran Anda telah berhasil diverifikasi.</p>
                        
                        <div class="row mt-4">
                            <div class="col-md-6 mb-3">
                                <div class="border p-3 rounded">
                                    <i class="fas fa-id-card fa-3x text-primary mb-3"></i>
                                    <h6>Kartu Pendaftaran</h6>
                                    <p class="small">Cetak kartu pendaftaran sebagai bukti resmi</p>
                                    <a href="{{ route('student.print.card') }}" class="btn btn-primary" target="_blank">
                                        <i class="fas fa-print"></i> Cetak Kartu
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="border p-3 rounded">
                                    <i class="fas fa-file-pdf fa-3x text-success mb-3"></i>
                                    <h6>Bukti Pembayaran</h6>
                                    <p class="small">Download bukti pembayaran dalam format PDF</p>
                                    <a href="{{ route('student.download.receipt') }}" class="btn btn-success" target="_blank">
                                        <i class="fas fa-download"></i> Download PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="alert alert-info mt-4">
                            <i class="fas fa-info-circle"></i>
                            <strong>Informasi:</strong> Simpan kartu pendaftaran dan bukti pembayaran sebagai dokumen penting untuk proses selanjutnya.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection