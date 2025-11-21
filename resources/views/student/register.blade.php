@extends('partials.main')

@section('content')
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Pendaftaran</h6>
            <h1 class="mb-5">Registrasi Akun Siswa</h1>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <form action="{{ route('student.register') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                                <label for="email">Email</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="tel" class="form-control" id="phone" name="phone" placeholder="No HP">
                                <label for="phone">No HP</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                <label for="password">Password</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="otp" name="otp" placeholder="OTP">
                                <label for="otp">OTP</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary w-100 py-3" type="submit">Buat Akun</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection