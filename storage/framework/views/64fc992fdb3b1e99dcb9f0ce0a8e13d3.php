<?php $__env->startSection('title', 'Laporan PPDB'); ?>
<?php $__env->startSection('page-title', 'Laporan PPDB'); ?>

<?php $__env->startSection('content'); ?>
<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Total Pendaftar</p>
                        <h3 class="mb-0">0</h3>
                    </div>
                    <i class="fas fa-users fa-2x text-primary"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Diterima</p>
                        <h3 class="mb-0">0</h3>
                    </div>
                    <i class="fas fa-check fa-2x text-success"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Pending</p>
                        <h3 class="mb-0">0</h3>
                    </div>
                    <i class="fas fa-clock fa-2x text-warning"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">Ditolak</p>
                        <h3 class="mb-0">0</h3>
                    </div>
                    <i class="fas fa-times fa-2x text-danger"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pencarian -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-10">
                        <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan No. Pendaftaran, Nama, atau Email..." value="<?php echo e(request('search')); ?>">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-2"></i>Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Filter & Export -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form id="reportForm" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Periode</label>
                        <select name="period" class="form-select">
                            <option value="all">Semua Data</option>
                            <option value="7">7 Hari Terakhir</option>
                            <option value="30">30 Hari Terakhir</option>
                            <option value="90">3 Bulan Terakhir</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="all">Semua Status</option>
                            <option value="pending">Pending</option>
                            <option value="terima">Diterima</option>
                            <option value="tolak">Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Format</label>
                        <select name="type" class="form-select">
                            <option value="excel">Excel</option>
                            <option value="pdf">PDF</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter me-2"></i>Filter
                        </button>
                    </div>
                    <div class="col-md-2">
                        <button type="button" onclick="exportData()" class="btn btn-success w-100">
                            <i class="fas fa-download me-2"></i>Export
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Data Table -->
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No. Pendaftaran</th>
                                <th>Nama</th>
                                <th>Jurusan</th>
                                <th>Status</th>
                                <th>Tanggal Daftar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $registrations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $registration): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($registration->registration_number); ?></td>
                                <td><?php echo e($registration->name); ?></td>
                                <td><?php echo e($registration->major); ?></td>
                                <td>
                                    <?php if($registration->status == 'pending'): ?>
                                        <span class="badge bg-warning">Pending</span>
                                    <?php elseif($registration->status == 'terima'): ?>
                                        <span class="badge bg-success">Diterima</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Ditolak</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($registration->created_at->format('d/m/Y H:i')); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                    Belum ada data pendaftaran
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <?php if($registrations->hasPages()): ?>
                <div class="mt-3">
                    <?php echo e($registrations->links()); ?>

                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.kepala-sekolah', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC-08\Farrel_ujikom\resources\views/kepala/reports.blade.php ENDPATH**/ ?>