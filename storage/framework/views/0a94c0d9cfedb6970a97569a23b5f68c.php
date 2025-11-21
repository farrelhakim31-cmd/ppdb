<?php $__env->startSection('title', 'Buat Tagihan Baru'); ?>
<?php $__env->startSection('page-title', 'Buat Tagihan Baru'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header bg-white">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Form Tagihan Baru</h5>
            <a href="<?php echo e(route('bills.index')); ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <form action="<?php echo e(route('bills.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-medium">Siswa <span class="text-danger">*</span></label>
                        <select name="student_id" class="form-select" required>
                            <option value="">Pilih Siswa</option>
                            <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($student->id); ?>" <?php echo e(request('student_id') == $student->id ? 'selected' : ''); ?>><?php echo e($student->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-medium">Jenis Tagihan <span class="text-danger">*</span></label>
                        <select name="type" class="form-select" required>
                            <option value="">Pilih Jenis</option>
                            <option value="spp">SPP</option>
                            <option value="uniform">Seragam</option>
                            <option value="book">Buku</option>
                            <option value="exam">Ujian</option>
                            <option value="other">Lainnya</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-medium">Jumlah Tagihan <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="amount" class="form-control" placeholder="0" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-medium">Jatuh Tempo <span class="text-danger">*</span></label>
                        <input type="date" name="due_date" class="form-control" required>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-medium">Keterangan <span class="text-danger">*</span></label>
                <textarea name="description" class="form-control" rows="4" placeholder="Masukkan keterangan tagihan..." required></textarea>
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="send_email" id="send_email" checked>
                    <label class="form-check-label" for="send_email">
                        <i class="fas fa-envelope me-1"></i>Kirim notifikasi tagihan ke email siswa
                    </label>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-2"></i>Simpan Tagihan
                </button>
                <button type="reset" class="btn btn-outline-warning">
                    <i class="fas fa-undo me-2"></i>Reset
                </button>
                <a href="<?php echo e(route('bills.index')); ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-2"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.keuangan', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC-08\Farrel_ujikom\resources\views/admin/bills/create.blade.php ENDPATH**/ ?>