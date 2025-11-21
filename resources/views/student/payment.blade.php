@extends('partials.main')

@section('content')
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Pembayaran</h6>
            <h1 class="mb-5">Pembayaran Pendaftaran</h1>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Rincian Pembayaran</h5>
                        <table class="table">
                            <tr>
                                <td>Biaya Pendaftaran</td>
                                <td class="text-end">Rp 150.000</td>
                            </tr>
                            <tr>
                                <td>Biaya Administrasi</td>
                                <td class="text-end">Rp 25.000</td>
                            </tr>
                            <tr class="fw-bold">
                                <td>Total</td>
                                <td class="text-end">Rp 175.000</td>
                            </tr>
                        </table>
                        
                        <div class="mt-4">
                            <h6>Upload Bukti Pembayaran</h6>
                            <form action="{{ route('student.payment') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <input type="file" class="form-control" name="payment_proof" accept=".pdf,.jpg,.jpeg,.png" required>
                                    <small class="text-muted">Format: PDF/JPG (Max 2MB)</small>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nominal (Rp)</label>
                                    <input type="number" class="form-control" name="amount" placeholder="175000" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Instruksi Pembayaran</label>
                                    <textarea class="form-control" name="instructions" rows="3" placeholder="Opsional: VA/QRIS atau instruksi khusus"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Upload Bukti Bayar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection