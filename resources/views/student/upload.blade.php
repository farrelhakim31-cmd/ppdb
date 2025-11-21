@extends('partials.main')

@section('content')
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Upload</h6>
            <h1 class="mb-5">Upload Berkas</h1>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <form action="{{ route('student.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="file" class="form-control" id="ijazah" name="ijazah" accept=".pdf,.jpg,.jpeg,.png">
                                <label for="ijazah">Ijazah/Raport</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating">
                                <input type="file" class="form-control" id="kip" name="kip" accept=".pdf,.jpg,.jpeg,.png">
                                <label for="kip">KIP/KKS/Akta/KK</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <small class="text-muted">Format: PDF/JPG (Max 2MB)</small>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary w-100 py-3" type="submit">Upload Berkas</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection