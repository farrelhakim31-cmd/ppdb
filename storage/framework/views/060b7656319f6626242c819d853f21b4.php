<?php $__env->startSection('title', 'Status Pendaftaran PPDB'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8">
    <div class="max-w-2xl mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Status Pendaftaran</h1>
            <p class="text-gray-600">No. Pendaftaran: <?php echo e($registration->registration_number); ?></p>
        </div>

        <!-- Status Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Registration Info -->
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold"><?php echo e($registration->name); ?></h3>
                        <p class="text-blue-100"><?php echo e($registration->email); ?></p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-blue-100">Status</p>
                        <?php
                            $statusConfig = [
                                'pending' => ['label' => 'Pending', 'color' => 'bg-yellow-500'],
                                'terima' => ['label' => 'Diterima', 'color' => 'bg-green-500'],
                                'tolak' => ['label' => 'Ditolak', 'color' => 'bg-red-500']
                            ];
                            $currentStatus = $statusConfig[$registration->status] ?? ['label' => 'Pending', 'color' => 'bg-yellow-500'];
                        ?>
                        <span class="inline-block px-3 py-1 <?php echo e($currentStatus['color']); ?> text-white text-sm rounded-full">
                            <?php echo e($currentStatus['label']); ?>

                        </span>
                    </div>
                </div>
            </div>

            <!-- Data Pendaftar -->
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center mb-4">
                    <i class="fas fa-user text-blue-500 mr-2"></i>
                    <h4 class="text-lg font-semibold text-gray-800">Data Pendaftar</h4>
                </div>
                <div class="space-y-3">
                    <div class="border-l-4 border-blue-500 pl-3">
                        <p class="text-sm text-gray-600">Nama Lengkap</p>
                        <p class="font-semibold text-gray-800"><?php echo e($registration->name); ?></p>
                    </div>
                    <div class="border-l-4 border-gray-300 pl-3">
                        <p class="text-sm text-gray-600">Email</p>
                        <p class="font-semibold text-gray-800"><?php echo e($registration->email); ?></p>
                    </div>
                    <div class="border-l-4 border-gray-300 pl-3">
                        <p class="text-sm text-gray-600">No. Telepon</p>
                        <p class="font-semibold text-gray-800"><?php echo e($registration->phone ?? '-'); ?></p>
                    </div>
                    <div class="border-l-4 border-gray-300 pl-3">
                        <p class="text-sm text-gray-600">Tempat, Tanggal Lahir</p>
                        <p class="font-semibold text-gray-800"><?php echo e($registration->birth_place ?? '-'); ?>, <?php echo e($registration->birth_date ? \Carbon\Carbon::parse($registration->birth_date)->format('d F Y') : '-'); ?></p>
                    </div>
                    <div class="border-l-4 border-green-500 pl-3">
                        <p class="text-sm text-gray-600">Jenis Kelamin</p>
                        <p class="font-semibold text-gray-800"><?php echo e($registration->gender == 'L' ? 'Laki-laki' : ($registration->gender == 'P' ? 'Perempuan' : '-')); ?></p>
                    </div>
                    <div class="border-l-4 border-green-500 pl-3">
                        <p class="text-sm text-gray-600">Asal Sekolah</p>
                        <p class="font-semibold text-gray-800"><?php echo e($registration->previous_school ?? '-'); ?></p>
                    </div>
                    <div class="border-l-4 border-green-500 pl-3">
                        <p class="text-sm text-gray-600">Nama Orang Tua</p>
                        <p class="font-semibold text-gray-800"><?php echo e($registration->parent_name ?? '-'); ?></p>
                    </div>
                    <div class="border-l-4 border-blue-500 pl-3">
                        <p class="text-sm text-gray-600">Status Pembayaran</p>
                        <p class="font-semibold text-gray-800">
                            <?php if($registration->payment_status === 'paid'): ?>
                                <span class="inline-block px-2 py-1 bg-green-500 text-white text-xs rounded-full">Lunas</span>
                            <?php elseif($registration->payment_status === 'pending'): ?>
                                <span class="inline-block px-2 py-1 bg-yellow-500 text-white text-xs rounded-full">Pending</span>
                            <?php else: ?>
                                <span class="inline-block px-2 py-1 bg-red-500 text-white text-xs rounded-full">Belum Bayar</span>
                            <?php endif; ?>
                        </p>
                    </div>
                    <div class="border-l-4 border-green-500 pl-3">
                        <p class="text-sm text-gray-600">Tanggal Daftar</p>
                        <p class="font-semibold text-gray-800"><?php echo e($registration->created_at->format('d F Y H:i')); ?></p>
                    </div>
                </div>
            </div>

            <!-- Status Details -->
            <div class="p-6">
                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">Progress Pendaftaran</h4>
                    <?php
                        $steps = ['pending', 'terima', 'tolak'];
                        $currentStep = array_search($registration->status, $steps) + 1;
                        $totalSteps = count($steps);
                        $percentage = ($currentStep / $totalSteps) * 100;
                    ?>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600">Progress</span>
                            <span class="font-semibold"><?php echo e($currentStep); ?>/<?php echo e($totalSteps); ?> (<?php echo e(round($percentage)); ?>%)</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: <?php echo e($percentage); ?>%"></div>
                        </div>
                        <div class="text-center mt-3">
                            <span class="text-sm text-gray-600">
                                Status: <?php echo e($currentStatus['label']); ?>

                            </span>
                        </div>
                    </div>
                </div>

                <!-- Final Status Message -->
                <?php if($registration->status == 'terima'): ?>
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-600 text-2xl mr-3"></i>
                            <div>
                                <h5 class="font-semibold text-green-800">Selamat! Anda Diterima</h5>
                                <p class="text-green-700 text-sm">Silakan datang ke sekolah untuk melakukan daftar ulang</p>
                            </div>
                        </div>
                    </div>
                <?php elseif($registration->status == 'tolak'): ?>
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-times-circle text-red-600 text-2xl mr-3"></i>
                            <div>
                                <h5 class="font-semibold text-red-800">Pendaftaran Ditolak</h5>
                                <p class="text-red-700 text-sm">Mohon maaf, pendaftaran tidak dapat diterima</p>
                            </div>
                        </div>
                    </div>
                <?php elseif($registration->status == 'pending'): ?>
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-clock text-yellow-600 text-2xl mr-3"></i>
                            <div>
                                <h5 class="font-semibold text-yellow-800">Status Pending</h5>
                                <?php if($registration->payment_status === 'paid'): ?>
                                    <p class="text-yellow-700 text-sm">Pembayaran sudah dikonfirmasi. Menunggu verifikasi admin.</p>
                                <?php else: ?>
                                    <p class="text-yellow-700 text-sm">Menunggu konfirmasi pembayaran dari bagian keuangan.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Back Button -->
                <div class="text-center">
                    <a href="<?php echo e(route('siswa.dashboard')); ?>" class="bg-gray-500 text-white py-3 px-6 rounded-lg hover:bg-gray-600 transition-colors font-semibold">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>

        <!-- Back Link -->
        <div class="text-center mt-6">
            <a href="<?php echo e(route('siswa.dashboard')); ?>" class="text-blue-600 hover:text-blue-800 font-medium">
                ← Kembali ke Dashboard Siswa
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC-08\Farrel_ujikom\resources\views/student/status.blade.php ENDPATH**/ ?>