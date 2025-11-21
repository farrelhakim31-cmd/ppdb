<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'PPDB Online'); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="<?php echo e(asset('css/minimal.css')); ?>" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <?php echo $__env->yieldContent('head'); ?>
</head>
<body class="bg-gray-50 text-gray-800">
    <?php echo $__env->yieldContent('content'); ?>
</body>
</html><?php /**PATH C:\Users\PC-08\Farrel_ujikom\resources\views/layouts/minimal.blade.php ENDPATH**/ ?>