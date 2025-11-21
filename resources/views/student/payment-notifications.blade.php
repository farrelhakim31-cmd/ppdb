@extends('layouts.student')

@section('student-content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-bell"></i> Notifikasi Pembayaran</h4>
                </div>
                <div class="card-body">
                    @forelse($notifications as $notification)
                    <div class="card mb-3 {{ !$notification->is_read ? 'border-primary' : '' }}">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h5 class="card-title">
                                        {{ $notification->title }}
                                        @if(!$notification->is_read)
                                            <span class="badge bg-primary ms-2">Baru</span>
                                        @endif
                                    </h5>
                                    <p class="card-text">{{ $notification->message }}</p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Jumlah:</strong> Rp {{ number_format($notification->amount, 0, ',', '.') }}
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Jatuh Tempo:</strong> {{ $notification->due_date->format('d/m/Y') }}
                                        </div>
                                    </div>
                                    <small class="text-muted">
                                        Dikirim: {{ $notification->created_at->format('d/m/Y H:i') }}
                                    </small>
                                </div>
                                <div class="ms-3">
                                    <span class="badge bg-{{ $notification->status === 'paid' ? 'success' : 'warning' }} fs-6">
                                        {{ $notification->status === 'paid' ? 'Lunas' : 'Belum Bayar' }}
                                    </span>
                                    @if(!$notification->is_read)
                                        <form action="{{ route('student.payment-notifications.read', $notification->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-primary mt-2">
                                                Tandai Dibaca
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5">
                        <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada notifikasi pembayaran</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection