<?php $__env->startSection('title', 'Formulir Pendaftaran PPDB'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">Formulir Pendaftaran</h1>
            <p class="text-gray-600">Penerimaan Peserta Didik Baru (PPDB)</p>
        </div>

        <!-- Error Messages -->
        <?php if(session('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>
        
        <?php if(session('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <!-- Progress Steps -->
        <div class="flex justify-center mb-8">
            <div class="flex items-center space-x-4">
                <div class="flex items-center">
                    <div id="step1-indicator" class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-semibold">1</div>
                    <span class="ml-2 text-sm font-medium text-gray-700">Data Pribadi</span>
                </div>
                <div class="w-16 h-1 bg-gray-300 rounded"></div>
                <div class="flex items-center">
                    <div id="step2-indicator" class="w-8 h-8 bg-gray-300 text-gray-500 rounded-full flex items-center justify-center text-sm font-semibold">2</div>
                    <span class="ml-2 text-sm font-medium text-gray-500">Data Orang Tua</span>
                </div>
                <div class="w-16 h-1 bg-gray-300 rounded"></div>
                <div class="flex items-center">
                    <div id="step3-indicator" class="w-8 h-8 bg-gray-300 text-gray-500 rounded-full flex items-center justify-center text-sm font-semibold">3</div>
                    <span class="ml-2 text-sm font-medium text-gray-500">Dokumen</span>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <form id="registrationForm" action="<?php echo e(route('ppdb.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                
                <!-- Step 1: Data Pribadi -->
                <div id="step1" class="step-content p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 bg-blue-500 text-white rounded-full flex items-center justify-center mr-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800">Data Pribadi Calon Siswa</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">Nama Lengkap *</label>
                            <input type="text" name="name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('name')); ?>" placeholder="Masukkan nama lengkap" required>
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">Email *</label>
                            <input type="email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('email')); ?>" placeholder="contoh@email.com" required>
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">No. Telepon *</label>
                            <input type="text" name="phone" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('phone')); ?>" placeholder="08xxxxxxxxxx" required>
                            <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">Jenis Kelamin *</label>
                            <select name="gender" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all <?php $__errorArgs = ['gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L" <?php echo e(old('gender') == 'L' ? 'selected' : ''); ?>>Laki-laki</option>
                                <option value="P" <?php echo e(old('gender') == 'P' ? 'selected' : ''); ?>>Perempuan</option>
                            </select>
                            <?php $__errorArgs = ['gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">Tempat Lahir *</label>
                            <input type="text" name="birth_place" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all <?php $__errorArgs = ['birth_place'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('birth_place')); ?>" placeholder="Kota tempat lahir" required>
                            <?php $__errorArgs = ['birth_place'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">Tanggal Lahir *</label>
                            <input type="date" name="birth_date" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all <?php $__errorArgs = ['birth_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('birth_date')); ?>" required>
                            <?php $__errorArgs = ['birth_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="mt-6 space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Alamat Lengkap *</label>
                        <textarea name="address" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                  rows="3" placeholder="Masukkan alamat lengkap" required><?php echo e(old('address')); ?></textarea>
                        <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">Asal Sekolah *</label>
                            <input type="text" name="school_origin" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all <?php $__errorArgs = ['school_origin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('school_origin')); ?>" placeholder="Nama sekolah asal" required>
                            <?php $__errorArgs = ['school_origin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">Pilihan Jurusan *</label>
                            <select name="major" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all <?php $__errorArgs = ['major'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <option value="">Pilih Jurusan</option>
                                <option value="PPLG" <?php echo e(old('major') == 'PPLG' ? 'selected' : ''); ?>>Pengembangan Perangkat Lunak dan Gim (PPLG)</option>
                                <option value="DKV" <?php echo e(old('major') == 'DKV' ? 'selected' : ''); ?>>Desain Komunikasi Visual (DKV)</option>
                                <option value="ANIMASI" <?php echo e(old('major') == 'ANIMASI' ? 'selected' : ''); ?>>Animasi</option>
                                <option value="BDP" <?php echo e(old('major') == 'BDP' ? 'selected' : ''); ?>>Bisnis Daring dan Pemasaran (BDP)</option>
                                <option value="AKUNTANSI" <?php echo e(old('major') == 'AKUNTANSI' ? 'selected' : ''); ?>>Akuntansi</option>
                            </select>
                            <?php $__errorArgs = ['major'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="flex justify-end mt-8">
                        <button type="button" onclick="nextStep(2)" class="px-8 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors font-semibold">
                            Selanjutnya
                        </button>
                    </div>
                </div>

                <!-- Step 2: Data Orang Tua -->
                <div id="step2" class="step-content p-8 hidden">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 bg-blue-500 text-white rounded-full flex items-center justify-center mr-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800">Data Orang Tua/Wali</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">Nama Orang Tua/Wali *</label>
                            <input type="text" name="parent_name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all <?php $__errorArgs = ['parent_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('parent_name')); ?>" placeholder="Nama lengkap orang tua/wali" required>
                            <?php $__errorArgs = ['parent_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">No. Telepon Orang Tua *</label>
                            <input type="text" name="parent_phone" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all <?php $__errorArgs = ['parent_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   value="<?php echo e(old('parent_phone')); ?>" placeholder="08xxxxxxxxxx" required>
                            <?php $__errorArgs = ['parent_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="mt-6 space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Pekerjaan Orang Tua/Wali *</label>
                        <input type="text" name="parent_job" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all <?php $__errorArgs = ['parent_job'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               value="<?php echo e(old('parent_job')); ?>" placeholder="Pekerjaan orang tua/wali" required>
                        <?php $__errorArgs = ['parent_job'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="flex justify-between mt-8">
                        <button type="button" onclick="prevStep(1)" class="px-8 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors font-semibold">
                            Sebelumnya
                        </button>
                        <button type="button" onclick="nextStep(3)" class="px-8 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors font-semibold">
                            Selanjutnya
                        </button>
                    </div>
                </div>

                <!-- Step 3: Upload Dokumen -->
                <div id="step3" class="step-content p-8 hidden">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 bg-blue-500 text-white rounded-full flex items-center justify-center mr-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800">Upload Dokumen Pendukung</h2>
                    </div>

                    <div class="space-y-6">
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-400 transition-colors">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="text-sm text-gray-600">
                                <label for="documents" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500">
                                    <span>Upload dokumen</span>
                                    <input id="documents" name="documents[]" type="file" class="sr-only" multiple accept=".pdf,.jpg,.jpeg,.png">
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">PDF, JPG, PNG hingga 2MB per file</p>
                            <?php $__errorArgs = ['documents.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h4 class="font-semibold text-blue-800 mb-2">Dokumen yang diperlukan:</h4>
                            <ul class="text-sm text-blue-700 space-y-1">
                                <li>• Fotokopi Kartu Keluarga</li>
                                <li>• Fotokopi Akta Kelahiran</li>
                                <li>• Fotokopi Ijazah/SKHUN</li>
                                <li>• Pas foto 3x4 (2 lembar)</li>
                                <li>• Surat keterangan sehat</li>
                            </ul>
                        </div>
                    </div>

                    <div class="flex justify-between mt-8">
                        <button type="button" onclick="prevStep(2)" class="px-8 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors font-semibold">
                            Sebelumnya
                        </button>
                        <button type="submit" class="px-8 py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors font-semibold flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Daftar Sekarang
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Back to Home -->
        <div class="text-center mt-8">
            <a href="<?php echo e(route('ppdb.index')); ?>" class="text-blue-600 hover:text-blue-800 font-medium">
                ← Kembali ke Halaman Utama
            </a>
        </div>
    </div>
</div>

<script src="<?php echo e(asset('js/ppdb-form.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC-08\Farrel_ujikom\resources\views/ppdb/register.blade.php ENDPATH**/ ?>