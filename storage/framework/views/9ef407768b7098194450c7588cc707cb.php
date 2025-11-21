<?php $__env->startSection('title', 'Detail Pembayaran'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Detail Pembayaran</h1>
        <div>
            <a href="<?php echo e(route('keuangan.dashboard')); ?>" class="btn btn-secondary mr-2">
                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
            </a>
            <a href="<?php echo e(route('payments.verification')); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-list"></i> Daftar Pembayaran
            </a>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Jumlah:</strong> Rp <?php echo e(number_format($payment->amount, 0, ',', '.')); ?></p>
                    <p><strong>Metode:</strong> <?php echo e($payment->payment_method); ?></p>
                    <p><strong>Tanggal:</strong> <?php echo e($payment->payment_date->format('d/m/Y')); ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Status:</strong> 
                        <span class="badge badge-<?php echo e($payment->status === 'verified' ? 'success' : 'warning'); ?>">
                            <?php echo e(ucfirst($payment->status)); ?>

                        </span>
                    </p>
                    <?php if($payment->payment_proof): ?>
                    <p><strong>Bukti Pembayaran:</strong></p>
                    <img src="<?php echo e(Storage::url($payment->payment_proof)); ?>" class="img-fluid" style="max-width: 300px;">
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC-08\Farrel_ujikom\resources\views/keuangan/payments/show.blade.php ENDPATH**/ ?>