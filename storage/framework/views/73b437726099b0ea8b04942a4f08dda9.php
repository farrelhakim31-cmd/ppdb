<?php $__env->startSection('title', 'Daftar Pendaftar - Verifikator'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 flex">
    <!-- Sidebar -->
    <div class="w-64 shadow-lg fixed h-full" style="background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);">
        <div class="p-6">
            <h2 class="text-xl font-bold text-white mb-6">
                <i class="fas fa-clipboard-check mr-2"></i>Verifikator
            </h2>
            <nav class="space-y-2">
                <a href="<?php echo e(route('verifikator-admin.dashboard')); ?>" class="flex items-center px-4 py-3 text-white hover:bg-white hover:bg-opacity-25 rounded-lg transition-colors">
                    <i class="fas fa-tachometer-alt mr-3"></i>Dashboard
                </a>
                <a href="<?php echo e(route('verifikator-admin.index')); ?>" class="flex items-center px-4 py-3 text-white bg-white bg-opacity-25 rounded-lg font-medium">
                    <i class="fas fa-list mr-3"></i>Daftar Pendaftar
                </a>
            </nav>
        </div>
        <div class="absolute bottom-0 w-64 p-6 border-t border-white border-opacity-25">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-white bg-opacity-25 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-white text-sm"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-white"><?php echo e(auth()->user()->name); ?></p>
                        <p class="text-xs text-white text-opacity-75">Verifikator</p>
                    </div>
                </div>
                <form action="<?php echo e(route('logout')); ?>" method="POST" class="inline">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="text-white text-opacity-75 hover:text-red-300 transition-colors">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 ml-64">
        <!-- Header -->
        <div class="bg-white shadow-lg border-b border-slate-200">
            <div class="px-6 py-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Daftar Pendaftar PPDB</h1>
                        <p class="text-slate-600 mt-1">Verifikasi Administrasi</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">VERIFIKATOR</span>
                        <span class="text-slate-500 text-sm"><?php echo e(now()->format('d M Y, H:i')); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-6 py-6">
        <!-- Filter -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-6 border border-slate-100">
            <form method="GET" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-64">
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>" 
                           placeholder="Cari nomor pendaftaran atau nama..."
                           class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                </div>
                <div>
                    <select name="status" class="px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        <option value="">Semua Status</option>
                        <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Menunggu</option>
                        <option value="approved" <?php echo e(request('status') == 'approved' ? 'selected' : ''); ?>>Disetujui</option>
                        <option value="rejected" <?php echo e(request('status') == 'rejected' ? 'selected' : ''); ?>>Ditolak</option>
                        <option value="revision" <?php echo e(request('status') == 'revision' ? 'selected' : ''); ?>>Perbaikan</option>
                    </select>
                </div>
                <button type="submit" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg hover:shadow-xl">
                    <i class="fas fa-search mr-2"></i>Filter
                </button>
            </form>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-slate-100">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-gradient-to-r from-slate-50 to-blue-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Pendaftaran</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Lengkap</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jurusan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status Verifikasi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Daftar</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__empty_1 = true; $__currentLoopData = $registrations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $registration): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <?php echo e($registration->no_pendaftaran ?? $registration->registration_number ?? '-'); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php echo e($registration->nama_lengkap ?? $registration->name ?? '-'); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php echo e($registration->jurusan_pilihan ?? $registration->major ?? '-'); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if($registration->verification_status == 'pending'): ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu</span>
                                <?php elseif($registration->verification_status == 'approved'): ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Disetujui</span>
                                <?php elseif($registration->verification_status == 'rejected'): ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                <?php else: ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">Perbaikan</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e($registration->created_at->format('d/m/Y')); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="<?php echo e(route('verifikator-admin.show', $registration->id)); ?>" 
                                   class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-4 py-2 rounded-lg text-xs hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-md hover:shadow-lg">
                                    <i class="fas fa-eye mr-1"></i>Detail
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada data pendaftar</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <?php if($registrations->hasPages()): ?>
            <div class="px-6 py-4 border-t">
                <?php echo e($registrations->links()); ?>

            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.minimal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC-08\Farrel_ujikom\resources\views/verifikator-admin/index.blade.php ENDPATH**/ ?>