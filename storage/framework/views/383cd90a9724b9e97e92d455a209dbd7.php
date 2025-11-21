<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Sistem Pendaftaran Siswa'); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('css/dashboard.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/ppdb-form.css')); ?>">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif']
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-up': 'slideUp 0.3s ease-out'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 font-sans">
    <?php if(session('success')): ?>
    <div id="success-alert" class="fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 fade-in">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            <?php echo e(session('success')); ?>

        </div>
    </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
    <div id="error-alert" class="fixed top-4 right-4 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 fade-in">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
            </svg>
            <?php echo e(session('error')); ?>

        </div>
    </div>
    <?php endif; ?>

    <?php echo $__env->yieldContent('content'); ?>

    <script>
        // Auto hide alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('#success-alert, #error-alert');
            alerts.forEach(alert => {
                if (alert) {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateX(100%)';
                    setTimeout(() => alert.remove(), 300);
                }
            });
        }, 5000);
    </script>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\Users\PC-08\Farrel_ujikom\resources\views/layouts/app.blade.php ENDPATH**/ ?>