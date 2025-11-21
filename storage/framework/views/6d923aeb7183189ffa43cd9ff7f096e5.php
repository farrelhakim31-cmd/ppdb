<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Dashboard Kepala Sekolah'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; margin: 0; }
        .container-fluid { padding: 0; }
        .sidebar { background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); min-height: 100vh; padding: 0; }
        .nav-link { color: rgba(255,255,255,0.8) !important; padding: 12px 20px; border-radius: 8px; margin: 5px 15px; transition: all 0.3s; }
        .nav-link:hover { color: white !important; background: rgba(255,255,255,0.15); transform: translateX(5px); }
        .nav-link.active { color: white !important; background: rgba(255,255,255,0.2); font-weight: 600; }
        .card { border: none; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .content-wrapper { background-color: #f8f9fa; min-height: 100vh; }
        .bg-blue { background-color: #007bff !important; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row g-0">
            <div class="col-md-2 sidebar">
                <div class="p-3">
                    <nav class="nav flex-column">
                        <a class="nav-link <?php echo e(request()->routeIs('kepala.dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('kepala.dashboard')); ?>">
                            Dashboard
                        </a>
                        <a class="nav-link <?php echo e(request()->routeIs('kepala.reports') ? 'active' : ''); ?>" href="<?php echo e(route('kepala.reports')); ?>">
                            Laporan
                        </a>
                    </nav>
                </div>
                <div class="mt-auto p-3">
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-outline-light btn-sm w-100">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-md-10 content-wrapper">
                <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
                    <div class="container-fluid">
                        <span class="navbar-brand"><?php echo $__env->yieldContent('page-title', 'Dashboard Kepala Sekolah'); ?></span>
                        <div class="navbar-nav ms-auto">
                            <span class="badge bg-blue me-3">KEPALA SEKOLAH</span>
                            <span class="nav-link"><?php echo e(now()->format('d M Y, H:i')); ?></span>
                        </div>
                    </div>
                </nav>

                <div class="p-4">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-exclamation-circle me-2"></i><?php echo e(session('error')); ?>

                        </div>
                    <?php endif; ?>

                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html><?php /**PATH C:\Users\PC-08\Farrel_ujikom\resources\views/layouts/kepala-sekolah.blade.php ENDPATH**/ ?>