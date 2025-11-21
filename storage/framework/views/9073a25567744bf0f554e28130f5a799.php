<?php $__env->startSection('title', 'Dashboard Siswa'); ?>
<?php $__env->startSection('page-title', 'Dashboard Siswa'); ?>

<?php $__env->startSection('content'); ?>
<!-- Welcome Card -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-user-graduate fa-3x opacity-75"></i>
                    </div>
                    <div>
                        <h4 class="card-title mb-1">Selamat Datang, <?php echo e(Auth::user()->name); ?>!</h4>
                        <p class="card-text mb-0">Portal Siswa SMK BAKTI NUSANTARA 666</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status Pendaftaran -->
<?php if($registration ?? false): ?>
<div class="card mb-4">
    <div class="card-header bg-white">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Status Pendaftaran PPDB</h5>
            <?php
                $statusColors = ['pending' => 'warning', 'terima' => 'success', 'tolak' => 'danger'];
                $statusLabels = ['pending' => 'Pending', 'terima' => 'Diterima', 'tolak' => 'Ditolak'];
            ?>
            <span class="badge bg-<?php echo e($statusColors[$registration->status] ?? 'secondary'); ?>">
                <?php echo e($statusLabels[$registration->status] ?? 'Pending'); ?>

            </span>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>No. Pendaftaran:</strong> <?php echo e($registration->registration_number ?? 'N/A'); ?></p>
                <p><strong>Tanggal Daftar:</strong> <?php echo e($registration->created_at ? $registration->created_at->format('d/m/Y H:i') : 'N/A'); ?></p>
            </div>
            <div class="col-md-6">
                <p><strong>Status Pembayaran:</strong> 
                    <span class="badge bg-<?php echo e(isset($registration->payment) && $registration->payment->status == 'verified' ? 'success' : 'warning'); ?>">
                        <?php echo e(isset($registration->payment) ? ucfirst($registration->payment->status) : 'Belum Bayar'); ?>

                    </span>
                </p>
            </div>
        </div>
        
        <div class="mt-3">
            <?php if($registration->payment_status == 'unpaid'): ?>
                <a href="<?php echo e(route('ppdb.payment', $registration->registration_number)); ?>" class="btn btn-primary">
                    <i class="fas fa-credit-card me-2"></i>Bayar Sekarang
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php else: ?>
<div class="card mb-4 border-warning">
    <div class="card-body text-center">
        <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
        <h5>Belum Mendaftar PPDB</h5>
        <p class="text-muted">Anda belum melakukan pendaftaran PPDB. Silakan daftar terlebih dahulu.</p>
        <a href="<?php echo e(route('ppdb.register')); ?>" class="btn btn-warning">
            <i class="fas fa-user-plus me-2"></i>Daftar PPDB
        </a>
    </div>
</div>
<?php endif; ?>

<!-- Menu Cards -->
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="fas fa-credit-card fa-3x text-success mb-3"></i>
                <h5 class="card-title">Pembayaran</h5>
                <p class="card-text">Kelola pembayaran dan upload bukti bayar</p>
                <a href="<?php echo e($registration ? route('ppdb.payment', $registration->registration_number) : '#'); ?>" class="btn btn-success">
                    <?php echo e($registration && $registration->payment_status == 'unpaid' ? 'Bayar Sekarang' : 'Form Pembayaran'); ?>

                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="fas fa-upload fa-3x text-warning mb-3"></i>
                <h5 class="card-title">Upload Dokumen</h5>
                <p class="card-text">Upload dokumen persyaratan PPDB</p>
                <a href="<?php echo e($registration ? route('ppdb.documents', $registration->registration_number) : '#'); ?>" class="btn btn-warning">
                    Upload Dokumen
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="fas fa-search fa-3x text-primary mb-3"></i>
                <h5 class="card-title">Status Pendaftaran</h5>
                <p class="card-text">Lihat detail status pendaftaran PPDB</p>
                <a href="<?php echo e(route('siswa.status')); ?>" class="btn btn-primary">Lihat Status</a>
            </div>
        </div>
    </div>
    

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.siswa', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC-08\Farrel_ujikom\resources\views/dashboard/siswa.blade.php ENDPATH**/ ?>