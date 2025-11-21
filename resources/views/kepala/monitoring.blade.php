@extends('layouts.kepala-sekolah')

@section('title', 'Monitoring Real-time')

@section('content')
<div class="row">
    <!-- Live Stats -->
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-broadcast-tower me-2"></i>Status Sistem Real-time</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3">
                        <div class="border-end">
                            <h3 class="text-success" id="onlineUsers">0</h3>
                            <small class="text-muted">Pengguna Online</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border-end">
                            <h3 class="text-info" id="todayRegistrations">0</h3>
                            <small class="text-muted">Pendaftar Hari Ini</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border-end">
                            <h3 class="text-warning" id="pendingVerifications">0</h3>
                            <small class="text-muted">Menunggu Verifikasi</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <h3 class="text-primary" id="systemLoad">Normal</h3>
                        <small class="text-muted">Beban Sistem</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Log -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-history me-2"></i>Log Aktivitas Terkini</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Aktivitas</th>
                                <th>User</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="activityLog">
                            <tr>
                                <td colspan="4" class="text-center text-muted">Memuat data...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Simulasi data real-time
function updateStats() {
    document.getElementById('onlineUsers').textContent = Math.floor(Math.random() * 50) + 10;
    document.getElementById('todayRegistrations').textContent = Math.floor(Math.random() * 20) + 5;
    document.getElementById('pendingVerifications').textContent = Math.floor(Math.random() * 15) + 2;
}

// Update setiap 5 detik
setInterval(updateStats, 5000);
updateStats();
</script>
@endsection