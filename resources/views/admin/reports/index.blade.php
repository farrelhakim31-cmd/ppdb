@extends('layouts.admin')

@section('title', 'Laporan PPDB')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Laporan PPDB</h3>
                </div>
                <div class="card-body">
                    <form method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Tanggal Mulai</label>
                                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                            </div>
                            <div class="col-md-3">
                                <label>Tanggal Akhir</label>
                                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                            </div>
                            <div class="col-md-3">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="">Semua Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Verified</option>
                                    <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Diterima</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>&nbsp;</label>
                                <div>
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                    <a href="{{ route('admin.reports.export') }}?{{ http_build_query(request()->all()) }}" class="btn btn-success">Export Excel</a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No. Pendaftaran</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Jurusan</th>
                                    <th>Status</th>
                                    <th>Tanggal Daftar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($registrations as $registration)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $registration->registration_number }}</td>
                                    <td>{{ $registration->name }}</td>
                                    <td>{{ $registration->email }}</td>
                                    <td>{{ $registration->major }}</td>
                                    <td>
                                        @if($registration->status == 'pending')
                                            <span class="badge badge-warning">Pending</span>
                                        @elseif($registration->status == 'verified')
                                            <span class="badge badge-info">Verified</span>
                                        @elseif($registration->status == 'accepted')
                                            <span class="badge badge-success">Diterima</span>
                                        @else
                                            <span class="badge badge-danger">Ditolak</span>
                                        @endif
                                    </td>
                                    <td>{{ $registration->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $registrations->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection