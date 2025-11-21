@extends('partials.main')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Notifikasi Pembayaran</h4>
                    <a href="{{ route('admin.payment-notifications.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Kirim Notifikasi
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Siswa</th>
                                    <th>Judul</th>
                                    <th>Jumlah</th>
                                    <th>Jatuh Tempo</th>
                                    <th>Status</th>
                                    <th>Tanggal Kirim</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($notifications as $notification)
                                <tr>
                                    <td>{{ $notification->user->name }}</td>
                                    <td>{{ $notification->title }}</td>
                                    <td>Rp {{ number_format($notification->amount, 0, ',', '.') }}</td>
                                    <td>{{ $notification->due_date->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $notification->status === 'paid' ? 'success' : 'warning' }}">
                                            {{ $notification->status === 'paid' ? 'Lunas' : 'Belum Bayar' }}
                                        </span>
                                    </td>
                                    <td>{{ $notification->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada notifikasi</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    {{ $notifications->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection