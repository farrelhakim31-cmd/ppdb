<?php $__env->startSection('title', 'Verifikasi Pembayaran'); ?>
<?php $__env->startSection('page-title', 'Verifikasi Pembayaran'); ?>

<?php $__env->startSection('content'); ?>
<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card stat-card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1">Pending</h6>
                        <h4 class="mb-0"><?php echo e($pendingCount ?? 0); ?></h4>
                    </div>
                    <i class="fas fa-clock fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card stat-card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1">Verified</h6>
                        <h4 class="mb-0"><?php echo e($verifiedCount ?? 0); ?></h4>
                    </div>
                    <i class="fas fa-check-circle fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card stat-card bg-danger text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1">Rejected</h6>
                        <h4 class="mb-0"><?php echo e($rejectedCount ?? 0); ?></h4>
                    </div>
                    <i class="fas fa-times-circle fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payments Table -->
<div class="card">
    <div class="card-header bg-white">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Daftar Pembayaran</h5>
            <div class="d-flex gap-2">
                <select class="form-select form-select-sm" style="width: auto;">
                    <option>Semua Status</option>
                    <option>Pending</option>
                    <option>Verified</option>
                    <option>Rejected</option>
                </select>
                <input type="text" class="form-control form-control-sm" placeholder="Cari siswa..." style="width: 200px;">
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Siswa</th>
                        <th>Jenis Pembayaran</th>
                        <th>Jumlah</th>
                        <th>Metode Bayar</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $payments ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <div>
                                <div class="fw-medium"><?php echo e($payment->student_name); ?></div>
                                <?php if($payment->student): ?>
                                    <small class="text-muted"><?php echo e($payment->student->student_id ?? 'ID: ' . $payment->student->id); ?></small>
                                <?php elseif($payment->ppdbRegistration): ?>
                                    <small class="text-muted">PPDB: <?php echo e($payment->ppdbRegistration->no_pendaftaran); ?></small>
                                <?php else: ?>
                                    <small class="text-muted">ID: <?php echo e($payment->id); ?></small>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-info"><?php echo e($payment->payment_type_name); ?></span>
                        </td>
                        <td class="fw-bold">Rp <?php echo e(number_format($payment->amount, 0, ',', '.')); ?></td>
                        <td>
                            <?php if($payment->payment_method === 'bank_transfer'): ?>
                                <span class="badge bg-primary">Transfer Bank</span>
                            <?php elseif($payment->payment_method === 'e_wallet'): ?>
                                <span class="badge bg-info">E-Wallet</span>
                            <?php elseif($payment->payment_method === 'cash'): ?>
                                <span class="badge bg-success">Tunai</span>
                            <?php else: ?>
                                <span class="badge bg-secondary"><?php echo e($payment->payment_method ?? 'Tidak diketahui'); ?></span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($payment->created_at->format('d/m/Y H:i')); ?></td>
                        <td>
                            <?php if($payment->status === 'pending'): ?>
                                <span class="badge bg-warning">Pending</span>
                            <?php elseif($payment->status === 'verified'): ?>
                                <span class="badge bg-success">Verified</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Rejected</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="<?php echo e(route('payments.show', $payment->id)); ?>" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <?php if($payment->status === 'pending'): ?>
                                    <form action="<?php echo e(route('payments.verify', $payment->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-outline-success btn-sm" onclick="return confirm('Verifikasi pembayaran ini?')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fas fa-inbox fa-3x mb-3"></i>
                            <p class="mb-0">Belum ada data pembayaran</p>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if(isset($payments) && $payments->hasPages()): ?>
        <div class="card-footer bg-white">
            <?php echo e($payments->links()); ?>

        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.keuangan', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC-08\Farrel_ujikom\resources\views/keuangan/payments/index.blade.php ENDPATH**/ ?>