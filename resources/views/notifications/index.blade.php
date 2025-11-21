@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-bell me-2"></i>Notifikasi</h5>
                    <span class="badge bg-primary">{{ $notifications->total() }} Total</span>
                </div>
                <div class="card-body p-0">
                    @forelse($notifications as $notification)
                        <div class="notification-item p-4 border-bottom {{ $notification->read_at ? 'read' : 'unread' }}">
                            <div class="d-flex align-items-start">
                                <div class="notification-icon me-3">
                                    @if($notification->type == 'warning')
                                        <div class="bg-warning rounded-circle p-2">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    @elseif($notification->type == 'success')
                                        <div class="bg-success rounded-circle p-2">
                                            <i class="fas fa-check-circle text-white"></i>
                                        </div>
                                    @elseif($notification->type == 'danger')
                                        <div class="bg-danger rounded-circle p-2">
                                            <i class="fas fa-times-circle text-white"></i>
                                        </div>
                                    @else
                                        <div class="bg-info rounded-circle p-2">
                                            <i class="fas fa-info-circle text-white"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1 {{ $notification->read_at ? 'text-muted' : 'fw-bold' }}">
                                                {{ $notification->title }}
                                            </h6>
                                            <p class="mb-2 text-muted">{{ $notification->message }}</p>
                                            <small class="text-muted">
                                                <i class="fas fa-clock me-1"></i>
                                                {{ $notification->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                        <div class="notification-actions">
                                            @if(!$notification->read_at)
                                                <a href="{{ route('notifications.read', $notification->id) }}" 
                                                   class="btn btn-sm btn-outline-primary"
                                                   title="Tandai sebagai dibaca">
                                                    <i class="fas fa-check"></i>
                                                </a>
                                            @else
                                                <span class="badge bg-success">Dibaca</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Tidak ada notifikasi</h5>
                            <p class="text-muted">Notifikasi akan muncul di sini ketika ada aktivitas baru</p>
                        </div>
                    @endforelse
                </div>
                
                @if($notifications->hasPages())
                    <div class="card-footer">
                        {{ $notifications->links() }}
                    </div>
                @endif
            </div>
            
            <!-- Tombol Kembali -->
            <div class="text-center mt-4">
                @if(auth()->user()->role == 'keuangan')
                    <a href="{{ route('keuangan.dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                    </a>
                @elseif(auth()->user()->role == 'admin')
                    <a href="{{ route('admin-panitia.dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                    </a>
                @else
                    <a href="{{ route('siswa.dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.notification-item {
    transition: all 0.2s ease;
}

.notification-item:hover {
    background-color: #f8f9fa;
}

.notification-item.unread {
    background-color: #f8f9ff;
    border-left: 4px solid #007bff;
}

.notification-item.read {
    opacity: 0.8;
}

.notification-icon {
    width: 40px;
    text-align: center;
}

.notification-actions {
    min-width: 80px;
    text-align: right;
}
</style>
@endsection