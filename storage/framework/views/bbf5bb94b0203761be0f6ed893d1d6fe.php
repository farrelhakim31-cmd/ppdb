<?php $__env->startSection('title', 'Monitoring Berkas - Admin Panitia'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-purple-50">
    <div class="bg-white shadow-lg border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 py-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent">Monitoring Berkas</h1>
                    <p class="text-slate-600 mt-1">Kelengkapan Berkas Pendaftar</p>
                </div>
                <div class="flex space-x-3">
                    <form method="POST" action="<?php echo e(route('admin-panitia.send-bulk-email')); ?>" class="inline" onsubmit="return confirm('Kirim email ke semua pendaftar yang disetujui?')">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg">
                            <i class="fas fa-envelope mr-2"></i>Kirim Email Semua
                        </button>
                    </form>
                    <a href="<?php echo e(route('admin-panitia.export')); ?>" class="bg-gradient-to-r from-green-600 to-green-700 text-white px-6 py-3 rounded-xl hover:from-green-700 hover:to-green-800 transition-all duration-200 shadow-lg">
                        <i class="fas fa-download mr-2"></i>Export
                    </a>
                    <a href="<?php echo e(route('admin-panitia.dashboard')); ?>" class="bg-gradient-to-r from-slate-600 to-slate-700 text-white px-6 py-3 rounded-xl hover:from-slate-700 hover:to-slate-800 transition-all duration-200 shadow-lg">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-6">
        <!-- Filter -->
        <div class="bg-white rounded-2xl shadow-lg p-4 lg:p-6 mb-4 lg:mb-6 border border-slate-100">
            <form method="GET" class="space-y-4 lg:space-y-0 lg:flex lg:flex-wrap lg:gap-4">
                <div class="flex-1 lg:min-w-64">
                    <label class="block text-sm font-medium text-slate-700 mb-2 lg:hidden">Jurusan</label>
                    <select name="jurusan" class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-purple-500 text-sm lg:text-base">
                        <option value="">Semua Jurusan</option>
                        <?php $__currentLoopData = $jurusan_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jurusan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($jurusan); ?>" <?php echo e(request('jurusan') == $jurusan ? 'selected' : ''); ?>><?php echo e($jurusan); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="flex-1 lg:flex-none lg:min-w-48">
                    <label class="block text-sm font-medium text-slate-700 mb-2 lg:hidden">Status</label>
                    <select name="status" class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-purple-500 text-sm lg:text-base">
                        <option value="">Semua Status</option>
                        <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Menunggu</option>
                        <option value="approved" <?php echo e(request('status') == 'approved' ? 'selected' : ''); ?>>Disetujui</option>
                        <option value="rejected" <?php echo e(request('status') == 'rejected' ? 'selected' : ''); ?>>Ditolak</option>
                        <option value="revision" <?php echo e(request('status') == 'revision' ? 'selected' : ''); ?>>Perbaikan</option>
                    </select>
                </div>
                <button type="submit" class="w-full lg:w-auto bg-gradient-to-r from-purple-600 to-purple-700 text-white px-6 py-3 rounded-xl hover:from-purple-700 hover:to-purple-800 transition-all duration-200 shadow-lg text-sm lg:text-base">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
            </form>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-slate-100">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-gradient-to-r from-slate-50 to-purple-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">No. Pendaftaran</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Jurusan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Kelengkapan Berkas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        <?php $__empty_1 = true; $__currentLoopData = $pendaftar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">
                                <?php echo e($p->registration_number ?? $p->no_pendaftaran ?? '-'); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                <?php echo e($p->name ?? $p->nama_lengkap ?? '-'); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                <?php echo e($p->major ?? $p->jurusan_pilihan ?? '-'); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php
                                    $totalDocs = $p->documents ? $p->documents->count() : 0;
                                    $validDocs = $p->documents ? $p->documents->where('file_path', '!=', '')->where('file_path', '!=', null)->count() : 0;
                                    $percentage = $totalDocs > 0 ? round(($validDocs / $totalDocs) * 100) : 0;
                                ?>
                                <div class="flex items-center">
                                    <div class="w-16 bg-slate-200 rounded-full h-2 mr-3">
                                        <div class="bg-gradient-to-r from-blue-500 to-purple-500 h-2 rounded-full" style="width: <?php echo e($percentage); ?>%"></div>
                                    </div>
                                    <span class="text-xs font-medium text-slate-600"><?php echo e($validDocs); ?>/<?php echo e($totalDocs); ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if($p->verification_status == 'pending'): ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                                <?php elseif($p->verification_status == 'approved'): ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                                <?php elseif($p->verification_status == 'rejected'): ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                <?php else: ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">Perbaikan</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                <?php echo e($p->created_at->format('d/m/Y')); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <?php if($p->verification_status == 'approved'): ?>
                                    <div class="flex space-x-1">
                                        <form method="POST" action="<?php echo e(route('admin-panitia.accept-student', $p->id)); ?>" class="inline">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded-lg text-xs hover:bg-green-700" onclick="return confirm('Terima siswa dan kirim notifikasi?')">
                                                <i class="fas fa-check mr-1"></i>Terima
                                            </button>
                                        </form>
                                        <div class="btn-group">
                                            <button class="bg-blue-600 text-white px-3 py-1 rounded-lg text-xs hover:bg-blue-700 dropdown-toggle" data-bs-toggle="dropdown">
                                                <i class="fas fa-paper-plane mr-1"></i>Kirim
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <form method="POST" action="<?php echo e(route('admin-panitia.send-notification', $p->id)); ?>" class="inline">
                                                        <?php echo csrf_field(); ?>
                                                        <input type="hidden" name="type" value="email">
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="fas fa-envelope mr-2"></i>Email
                                                        </button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <form method="POST" action="<?php echo e(route('admin-panitia.send-notification', $p->id)); ?>" class="inline">
                                                        <?php echo csrf_field(); ?>
                                                        <input type="hidden" name="type" value="whatsapp">
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="fab fa-whatsapp mr-2"></i>WhatsApp
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-slate-500">Tidak ada data pendaftar</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <?php if($pendaftar->hasPages()): ?>
            <div class="px-6 py-4 border-t">
                <?php echo e($pendaftar->links()); ?>

            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.minimal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC-08\Farrel_ujikom\resources\views/admin-panitia/monitoring.blade.php ENDPATH**/ ?>