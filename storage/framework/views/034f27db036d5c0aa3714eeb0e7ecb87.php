<?php $__env->startSection('title', 'Detail Pendaftar - Verifikator'); ?>

<?php $__env->startSection('head'); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50">
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Detail Pendaftar</h1>
                    <p class="text-gray-600"><?php echo e($registration->no_pendaftaran); ?> - <?php echo e($registration->nama_lengkap); ?></p>
                </div>
                <a href="<?php echo e(route('verifikator-admin.index')); ?>" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-6">
        <?php if(session('success')): ?>
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
            <?php echo e(session('success')); ?>

        </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Data Pendaftar -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Data Pribadi -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Data Pribadi</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <p class="mt-1 text-sm text-gray-900"><?php echo e($registration->nama_lengkap ?? $registration->name ?? '-'); ?></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <p class="mt-1 text-sm text-gray-900"><?php echo e($registration->email ?? '-'); ?></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Telepon</label>
                            <p class="mt-1 text-sm text-gray-900"><?php echo e($registration->phone ?? '-'); ?></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tempat, Tanggal Lahir</label>
                            <p class="mt-1 text-sm text-gray-900"><?php echo e($registration->birth_place ?? '-'); ?>, <?php echo e($registration->birth_date ?? '-'); ?></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                            <p class="mt-1 text-sm text-gray-900"><?php echo e($registration->gender ?? '-'); ?></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jurusan Pilihan</label>
                            <p class="mt-1 text-sm text-gray-900"><?php echo e($registration->major ?? '-'); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Data Orang Tua -->
                <?php if($registration->parentData): ?>
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Data Orang Tua</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Orang Tua</label>
                            <p class="mt-1 text-sm text-gray-900"><?php echo e($registration->parent_name ?? ($registration->parentData->nama_ayah ?? '-')); ?></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Telepon Orang Tua</label>
                            <p class="mt-1 text-sm text-gray-900"><?php echo e($registration->parent_phone ?? '-'); ?></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Pekerjaan Orang Tua</label>
                            <p class="mt-1 text-sm text-gray-900"><?php echo e($registration->parent_job ?? ($registration->parentData->pekerjaan_ayah ?? '-')); ?></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Asal Sekolah</label>
                            <p class="mt-1 text-sm text-gray-900"><?php echo e($registration->school_origin ?? '-'); ?></p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Dokumen -->
                <div class="bg-white rounded-xl shadow-lg p-6 border border-slate-100">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-slate-800">Dokumen Pendaftaran</h3>
                        <?php if($registration->documents && $registration->documents->count() > 0): ?>
                            <?php
                                $totalDocs = $registration->documents->count();
                                $validDocs = $registration->documents->where('url', '!=', '')->where('url', '!=', null)->count();
                                $invalidDocs = $totalDocs - $validDocs;
                            ?>
                            <div class="flex space-x-3">
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-medium">
                                    <i class="fas fa-file mr-1"></i><?php echo e($totalDocs); ?> Total
                                </span>
                                <?php if($validDocs > 0): ?>
                                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-medium">
                                        <i class="fas fa-check mr-1"></i><?php echo e($validDocs); ?> Valid
                                    </span>
                                <?php endif; ?>
                                <?php if($invalidDocs > 0): ?>
                                    <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-medium">
                                        <i class="fas fa-exclamation-triangle mr-1"></i><?php echo e($invalidDocs); ?> Bermasalah
                                    </span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if($registration->documents && $registration->documents->count() > 0): ?>
                        <div class="space-y-3">
                            <?php $__currentLoopData = $registration->documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center justify-between p-4 border rounded-xl hover:bg-slate-50 transition-colors duration-200 <?php echo e(empty($doc->url) ? 'border-red-200 bg-red-50' : 'border-slate-200'); ?>">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <p class="font-medium text-slate-900"><?php echo e($doc->jenis ?? 'Dokumen'); ?></p>
                                        <?php if(empty($doc->url)): ?>
                                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-medium">
                                                <i class="fas fa-exclamation-triangle mr-1"></i>Bermasalah
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <p class="text-sm text-slate-600"><?php echo e($doc->nama_file ?? 'File tidak diketahui'); ?></p>
                                    <?php if($doc->created_at): ?>
                                        <p class="text-xs text-slate-500 mt-1">
                                            <i class="fas fa-clock mr-1"></i>Diupload: <?php echo e($doc->created_at->format('d/m/Y H:i')); ?>

                                        </p>
                                    <?php endif; ?>
                                    <?php if(empty($doc->url)): ?>
                                        <p class="text-xs text-red-600 mt-1">
                                            <i class="fas fa-info-circle mr-1"></i>File mungkin gagal diupload atau terhapus dari server
                                        </p>
                                    <?php endif; ?>
                                </div>
                                <div class="flex flex-col space-y-2">
                                    <?php if($doc->url && !empty($doc->url)): ?>
                                        <div class="flex space-x-2">
                                            <?php
                                                $extension = pathinfo($doc->nama_file ?? '', PATHINFO_EXTENSION);
                                                $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);
                                            ?>
                                            
                                            <?php if($isImage): ?>
                                                <button onclick="showImageModal('<?php echo e(asset('storage/' . $doc->url)); ?>', '<?php echo e($doc->nama_file ?? 'Gambar'); ?>')"
                                                       class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-3 py-2 rounded-lg text-xs hover:from-blue-700 hover:to-blue-800 transition-all duration-200">
                                                    <i class="fas fa-eye mr-1"></i>Lihat
                                                </button>
                                            <?php else: ?>
                                                <a href="<?php echo e(asset('storage/' . $doc->url)); ?>" target="_blank" 
                                                   class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-3 py-2 rounded-lg text-xs hover:from-blue-700 hover:to-blue-800 transition-all duration-200">
                                                    <i class="fas fa-eye mr-1"></i>Lihat
                                                </a>
                                            <?php endif; ?>
                                            
                                            <a href="<?php echo e(asset('storage/' . $doc->url)); ?>" download 
                                               class="bg-gradient-to-r from-green-600 to-green-700 text-white px-3 py-2 rounded-lg text-xs hover:from-green-700 hover:to-green-800 transition-all duration-200">
                                                <i class="fas fa-download mr-1"></i>Download
                                            </a>
                                        </div>
                                    <?php else: ?>
                                        <div class="bg-gradient-to-r from-red-50 to-orange-50 border border-red-200 rounded-lg p-3">
                                            <div class="flex items-center justify-between mb-2">
                                                <span class="text-red-800 text-xs font-medium">
                                                    <i class="fas fa-exclamation-triangle mr-1"></i>Dokumen Bermasalah
                                                </span>
                                            </div>
                                            <p class="text-xs text-red-700 mb-2">Siswa perlu mengupload ulang dokumen ini</p>
                                            <div class="flex space-x-2">
                                                <button class="bg-orange-500 text-white px-3 py-1 rounded text-xs hover:bg-orange-600 transition-colors" 
                                                        onclick="notifyStudent(<?php echo e($registration->id); ?>)">
                                                    <i class="fas fa-bell mr-1"></i>Notifikasi Siswa
                                                </button>
                                                <button class="bg-red-500 text-white px-3 py-1 rounded text-xs hover:bg-red-600 transition-colors"
                                                        onclick="requestReupload(<?php echo e($registration->id); ?>)">
                                                    <i class="fas fa-redo mr-1"></i>Minta Upload Ulang
                                                </button>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-12">
                            <div class="bg-slate-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-folder-open text-slate-400 text-3xl"></i>
                            </div>
                            <h4 class="text-lg font-medium text-slate-700 mb-2">Belum Ada Dokumen</h4>
                            <p class="text-slate-500 text-sm">Siswa belum mengupload dokumen pendaftaran</p>
                            <div class="mt-4">
                                <button class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-600 transition-colors"
                                        onclick="remindUpload(<?php echo e($registration->id); ?>)">
                                    <i class="fas fa-bell mr-2"></i>Ingatkan Siswa Upload Dokumen
                                </button>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Panel Verifikasi -->
            <div class="space-y-6">
                <!-- Status Saat Ini -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Status Verifikasi</h3>
                    <div class="text-center">
                        <?php if($registration->verification_status == 'pending'): ?>
                            <div class="p-4 bg-yellow-100 rounded-lg">
                                <i class="fas fa-clock text-yellow-600 text-2xl mb-2"></i>
                                <p class="font-semibold text-yellow-800">Menunggu Verifikasi</p>
                            </div>
                        <?php elseif($registration->verification_status == 'approved'): ?>
                            <div class="p-4 bg-green-100 rounded-lg">
                                <i class="fas fa-check-circle text-green-600 text-2xl mb-2"></i>
                                <p class="font-semibold text-green-800">Disetujui</p>
                            </div>
                        <?php elseif($registration->verification_status == 'rejected'): ?>
                            <div class="p-4 bg-red-100 rounded-lg">
                                <i class="fas fa-times-circle text-red-600 text-2xl mb-2"></i>
                                <p class="font-semibold text-red-800">Ditolak</p>
                            </div>
                        <?php else: ?>
                            <div class="p-4 bg-orange-100 rounded-lg">
                                <i class="fas fa-edit text-orange-600 text-2xl mb-2"></i>
                                <p class="font-semibold text-orange-800">Perlu Perbaikan</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Form Verifikasi -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Verifikasi Administrasi</h3>
                    <form action="<?php echo e(route('verifikator-admin.verify', $registration->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="status" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                <option value="">Pilih Status</option>
                                <option value="approved">Lulus - Disetujui</option>
                                <option value="rejected">Tolak - Tidak Memenuhi Syarat</option>
                                <option value="revision">Perbaikan - Perlu Dilengkapi</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Verifikasi</label>
                            <textarea name="notes" rows="4" required 
                                      placeholder="Berikan catatan detail mengenai hasil verifikasi..."
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                            <i class="fas fa-check mr-2"></i>Simpan Verifikasi
                        </button>
                    </form>
                </div>

                <!-- Log Verifikasi -->
                <?php if($verification_logs->count() > 0): ?>
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Riwayat Verifikasi</h3>
                    <div class="space-y-3">
                        <?php $__currentLoopData = $verification_logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="border-l-4 <?php if($log->status == 'approved'): ?> border-green-500 <?php elseif($log->status == 'rejected'): ?> border-red-500 <?php else: ?> border-orange-500 <?php endif; ?> pl-4 py-2">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-medium text-sm">
                                        <?php if($log->status == 'approved'): ?>
                                            <span class="text-green-600">Disetujui</span>
                                        <?php elseif($log->status == 'rejected'): ?>
                                            <span class="text-red-600">Ditolak</span>
                                        <?php else: ?>
                                            <span class="text-orange-600">Perbaikan</span>
                                        <?php endif; ?>
                                    </p>
                                    <p class="text-xs text-gray-500"><?php echo e($log->verifier->name); ?></p>
                                    <p class="text-xs text-gray-500"><?php echo e($log->verified_at->format('d/m/Y H:i')); ?></p>
                                </div>
                            </div>
                            <p class="text-sm text-gray-700 mt-2"><?php echo e($log->notes); ?></p>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal Preview Gambar -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg max-w-4xl max-h-full overflow-auto">
        <div class="flex justify-between items-center p-4 border-b">
            <h3 id="modalTitle" class="text-lg font-semibold">Preview Dokumen</h3>
            <button onclick="closeImageModal()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <div class="p-4">
            <img id="modalImage" src="" alt="Preview" class="max-w-full h-auto">
        </div>
    </div>
</div>

<script>
function showImageModal(imageUrl, title) {
    document.getElementById('modalImage').src = imageUrl;
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('imageModal').classList.remove('hidden');
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('imageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImageModal();
    }
});

// Notification functions
function notifyStudent(registrationId) {
    if (confirm('Kirim notifikasi ke siswa tentang dokumen bermasalah?')) {
        fetch(`/verifikator-admin/notify-student/${registrationId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Notifikasi berhasil dikirim ke siswa!');
            }
        })
        .catch(error => {
            alert('Terjadi kesalahan saat mengirim notifikasi');
        });
    }
}

function requestReupload(registrationId) {
    if (confirm('Minta siswa untuk upload ulang dokumen?')) {
        fetch(`/verifikator-admin/request-reupload/${registrationId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Permintaan upload ulang berhasil dikirim!');
            }
        })
        .catch(error => {
            alert('Terjadi kesalahan saat mengirim permintaan');
        });
    }
}

function remindUpload(registrationId) {
    if (confirm('Ingatkan siswa untuk upload dokumen?')) {
        fetch(`/verifikator-admin/notify-student/${registrationId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                message: 'Silakan upload dokumen pendaftaran Anda untuk melengkapi berkas PPDB.'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Reminder berhasil dikirim ke siswa!');
            }
        })
        .catch(error => {
            alert('Terjadi kesalahan saat mengirim reminder');
        });
    }
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.minimal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC-08\Farrel_ujikom\resources\views/verifikator-admin/show.blade.php ENDPATH**/ ?>