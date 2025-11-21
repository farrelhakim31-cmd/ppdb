<?php $__env->startSection('title', 'Kelola Tagihan'); ?>
<?php $__env->startSection('page-title', 'Kelola Tagihan'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="mb-1">Manajemen Tagihan Siswa</h5>
        <p class="text-muted mb-0">Kelola dan pantau tagihan pembayaran siswa</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?php echo e(route('bills.unpaid-students')); ?>" class="btn btn-warning">
            <i class="fas fa-exclamation-triangle me-2"></i>Siswa Belum Lunas
        </a>
        <a href="<?php echo e(route('bills.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Buat Tagihan Baru
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Daftar Tagihan</h5>
            <div class="d-flex gap-2">
                <select class="form-select form-select-sm" style="width: auto;">
                    <option>Semua Status</option>
                    <option>Belum Bayar</option>
                    <option>Sudah Bayar</option>
                    <option>Terlambat</option>
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
                        <th>Jenis Tagihan</th>
                        <th>Jumlah</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $bills ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <div>
                                <div class="fw-medium"><?php echo e($bill->student->name ?? 'N/A'); ?></div>
                                <small class="text-muted"><?php echo e($bill->student->email ?? 'N/A'); ?></small>
                            </div>
                        </td>
                        <td><?php echo e($bill->type ?? 'SPP'); ?></td>
                        <td class="fw-bold">Rp <?php echo e(number_format($bill->amount, 0, ',', '.')); ?></td>
                        <td>
                            <div>
                                <?php echo e($bill->due_date->format('d/m/Y')); ?>

                                <?php if($bill->due_date->isPast() && $bill->status !== 'paid'): ?>
                                    <br><small class="text-danger"><i class="fas fa-exclamation-triangle"></i> Terlambat</small>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td>
                            <?php if($bill->status === 'paid'): ?>
                                <span class="badge bg-success">Sudah Bayar</span>
                            <?php elseif($bill->due_date->isPast()): ?>
                                <span class="badge bg-danger">Terlambat</span>
                            <?php else: ?>
                                <span class="badge bg-warning">Belum Bayar</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="<?php echo e(route('bills.show', $bill)); ?>" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo e(route('bills.edit', $bill)); ?>" class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-file-invoice fa-3x mb-3"></i>
                            <p class="mb-0">Belum ada tagihan</p>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if(isset($bills) && $bills->hasPages()): ?>
        <div class="card-footer bg-white">
            <?php echo e($bills->links()); ?>

        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.keuangan', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC-08\Farrel_ujikom\resources\views/admin/bills/index.blade.php ENDPATH**/ ?>