@extends('partials.main')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/form.css') }}">
@endpush

@section('content')
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Formulir</h6>
            <h1 class="mb-5">Formulir Pendaftaran</h1>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="form-container">
                    <form action="{{ route('student.form.submit') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Nama Lengkap" required>
                                <label for="name">Nama Lengkap</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="parent_name" name="parent_name" placeholder="Nama Orang Tua/Wali">
                                <label for="parent_name">Nama Orang Tua/Wali</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="school" name="school" placeholder="Asal Sekolah">
                                <label for="school">Asal Sekolah</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <textarea class="form-control" id="address" name="address" placeholder="Alamat Domisili" style="height: 100px"></textarea>
                                <label for="address">Alamat Domisili</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" id="major" name="major">
                                    <option value="">Pilih Jurusan</option>
                                    <option value="tkj">Teknik Komputer Jaringan</option>
                                    <option value="rpl">Rekayasa Perangkat Lunak</option>
                                    <option value="mm">Multimedia</option>
                                </select>
                                <label for="major">Pilihan Jurusan/Gelombang</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary w-100 py-3" type="submit">Kirim Formulir</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection