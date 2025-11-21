<?php $__env->startSection('title', 'Daftar Siswa yang Harus Ditagih'); ?>
<?php $__env->startSection('page-title', 'Daftar Siswa yang Harus Ditagih'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header bg-white">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">
                <i class="fas fa-exclamation-triangle text-warning me-2"></i>Siswa Belum Lunas
            </h5>
            <a href="<?php echo e(route('bills.index')); ?>" class="btn btn-outline-secondary">
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
                    <?php $__empty_1 = true; $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($index + 1); ?></td>
                        <td><?php echo e($student->nisn ?? '-'); ?></td>
                        <td>
                            <strong><?php echo e($student->name); ?></strong>
                            <?php if($student->registration): ?>
                            <br><small class="text-muted"><?php echo e($student->registration->registration_number); ?></small>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e($student->email ?? ($student->registration->email ?? '-')); ?></td>
                        <td>
                            <?php
                                $totalUnpaid = \App\Models\Bill::where('student_id', $student->id)
                                    ->where('status', '!=', 'paid')
                                    ->sum('amount');
                            ?>
                            <strong class="text-danger">Rp <?php echo e(number_format($totalUnpaid, 0, ',', '.')); ?></strong>
                        </td>
                        <td>
                            <?php
                                $unpaidCount = \App\Models\Bill::where('student_id', $student->id)
                                    ->where('status', '!=', 'paid')
                                    ->count();
                            ?>
                            <?php if($unpaidCount > 0): ?>
                                <span class="badge bg-warning"><?php echo e($unpaidCount); ?> Tagihan Belum Lunas</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Belum Ada Tagihan</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="<?php echo e(route('bills.create')); ?>?student_id=<?php echo e($student->id); ?>" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus me-1"></i>Buat Tagihan
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="fas fa-check-circle text-success fa-3x mb-3"></i>
                            <p class="text-muted">Semua siswa sudah lunas</p>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.keuangan', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC-08\Farrel_ujikom\resources\views/admin/bills/unpaid-students.blade.php ENDPATH**/ ?>