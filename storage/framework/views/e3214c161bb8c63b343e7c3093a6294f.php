<?php $__env->startSection('title', 'Daftar Akun - PPDB Online'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen flex items-center justify-center px-4 py-12">
    <div class="max-w-md w-full">
        <!-- Header -->
        <div class="text-center mb-8">
            <img src="<?php echo e(asset('img/logo-sekolah.svg')); ?>" alt="Logo SMK BAKTI NUSANTARA 666" class="w-20 h-16 object-contain mx-auto mb-4">
            <h1 class="text-2xl font-bold text-gray-900">Daftar Akun</h1>
            <p class="text-gray-600 mt-2">Buat akun untuk mengakses PPDB Online</p>
        </div>

        <!-- Register Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <?php if($errors->any()): ?>
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                        <span class="text-red-700 font-medium">Terjadi kesalahan:</span>
                    </div>
                    <ul class="mt-2 text-red-600 text-sm">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('register.store')); ?>" class="space-y-4">
                <?php echo csrf_field(); ?>
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="<?php echo e(old('name')); ?>" 
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="<?php echo e(old('email')); ?>" 
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                </div>
                
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Nomor WhatsApp (Opsional)</label>
                    <input type="text" 
                           id="phone" 
                           name="phone" 
                           value="<?php echo e(old('phone')); ?>" 
                           placeholder="08xxxxxxxxxx"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    <p class="text-xs text-gray-500 mt-1">Untuk menerima OTP via WhatsApp</p>
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                </div>
                
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                    <input type="password" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                </div>
                
                <button type="submit" 
                        class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    Daftar Akun
                </button>
            </form>
            
            <div class="text-center mt-6">
                <p class="text-sm text-gray-600 mb-2">Sudah punya akun?</p>
                <a href="<?php echo e(route('login')); ?>" 
                   class="text-blue-600 hover:text-blue-700 transition-colors text-sm font-medium">
                    Login di sini
                </a>
            </div>
            
            <div class="text-center mt-4">
                <a href="<?php echo e(route('home')); ?>" 
                   class="text-gray-600 hover:text-blue-600 transition-colors text-sm">
                    ← Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.minimal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PC-08\Farrel_ujikom\resources\views/auth/register.blade.php ENDPATH**/ ?>