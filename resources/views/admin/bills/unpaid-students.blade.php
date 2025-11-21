@extends('layouts.keuangan')

@section('title', 'Daftar Siswa yang Harus Ditagih')
@section('page-title', 'Daftar Siswa yang Harus Ditagih')

@section('content')
<div class="card">
    <div class="card-header bg-white">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">
                <i class="fas fa-exclamation-triangle text-warning me-2"></i>Siswa Belum Lunas
            </h5>
            <a href="{{ route('bills.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th>Email</th>
                        <th>Total Tagihan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $index => $student)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $student->nisn ?? '-' }}</td>
                        <td>
                            <strong>{{ $student->name }}</strong>
                            @if($student->registration)
                            <br><small class="text-muted">{{ $student->registration->registration_number }}</small>
                            @endif
                        </td>
                        <td>{{ $student->email ?? ($student->registration->email ?? '-') }}</td>
                        <td>
                            @php
                                $totalUnpaid = \App\Models\Bill::where('student_id', $student->id)
                                    ->where('status', '!=', 'paid')
                                    ->sum('amount');
                            @endphp
                            <strong class="text-danger">Rp {{ number_format($totalUnpaid, 0, ',', '.') }}</strong>
                        </td>
                        <td>
                            @php
                                $unpaidCount = \App\Models\Bill::where('student_id', $student->id)
                                    ->where('status', '!=', 'paid')
                                    ->count();
                            @endphp
                            @if($unpaidCount > 0)
                                <span class="badge bg-warning">{{ $unpaidCount }} Tagihan Belum Lunas</span>
                            @else
                                <span class="badge bg-secondary">Belum Ada Tagihan</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('bills.create') }}?student_id={{ $student->id }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus me-1"></i>Buat Tagihan
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="fas fa-check-circle text-success fa-3x mb-3"></i>
                            <p class="text-muted">Semua siswa sudah lunas</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
