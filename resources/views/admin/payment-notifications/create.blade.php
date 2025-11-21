@extends('partials.main')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Kirim Notifikasi Pembayaran</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.payment-notifications.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Siswa</label>
                            <select name="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                                <option value="">Pilih Siswa</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Judul</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                                   value="{{ old('title') }}" placeholder="Contoh: Pembayaran SPP Bulan Januari" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pesan</label>
                            <textarea name="message" class="form-control @error('message') is-invalid @enderror" 
                                      rows="4" placeholder="Detail pembayaran..." required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jumlah (Rp)</label>
                            <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror" 
                                   value="{{ old('amount') }}" min="0" step="1000" required>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jatuh Tempo</label>
                            <input type="date" name="due_date" class="form-control @error('due_date') is-invalid @enderror" 
                                   value="{{ old('due_date') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                            @error('due_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Kirim Notifikasi
                            </button>
                            <a href="{{ route('admin.payment-notifications.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection