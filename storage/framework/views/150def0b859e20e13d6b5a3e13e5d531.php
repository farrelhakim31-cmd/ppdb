<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Dashboard Admin Panitia'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar { min-height: 100vh; background: linear-gradient(135deg, #6f42c1 0%, #e83e8c 100%); }
        .content-wrapper { background-color: #f8f9fa; min-height: 100vh; }
        .card { border: none; box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); }
        .stat-card { transition: transform 0.2s; }
        .stat-card:hover { transform: translateY(-2px); }
        .bg-purple { background-color: #6f42c1 !important; }
        .nav-link:hover { background-color: rgba(255,255,255,0.1) !important; border-radius: 0.375rem; }
        .sidebar .nav-link { margin-bottom: 0.25rem; transition: all 0.2s; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-lg-2 px-0 sidebar">
                <div class="p-3">
                    <h5 class="text-white mb-4">
                        <i class="fas fa-users-cog me-2"></i>Admin Panitia
                    </h5>
                    <nav class="nav flex-column">
                        <a class="nav-link text-white <?php echo e(request()->routeIs('admin-panitia.dashboard') ? 'bg-white bg-opacity-25 rounded' : ''); ?>" href="<?php echo e(route('admin-panitia.dashboard')); ?>">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                        <a class="nav-link text-white <?php echo e(request()->routeIs('admin-panitia.monitoring') ? 'bg-white bg-opacity-25 rounded' : ''); ?>" href="<?php echo e(route('admin-panitia.monitoring')); ?>">
                            <i class="fas fa-list me-2"></i>Monitoring Berkas
                        </a>
                        <a class="nav-link text-white <?php echo e(request()->routeIs('admin-panitia.map') ? 'bg-white bg-opacity-25 rounded' : ''); ?>" href="<?php echo e(route('admin-panitia.map')); ?>">
                            <i class="fas fa-map-marked-alt me-2"></i>Peta Sebaran
                        </a>
                        <a class="nav-link text-white <?php echo e(request()->routeIs('admin-panitia.master-data') ? 'bg-white bg-opacity-25 rounded' : ''); ?>" href="<?php echo e(route('admin-panitia.master-data')); ?>">
                            <i class="fas fa-database me-2"></i>Master Data
                        </a>
                        <a class="nav-link text-white <?php echo e(request()->routeIs('admin-panitia.reports') ? 'bg-white bg-opacity-25 rounded' : ''); ?>" href="<?php echo e(route('admin-panitia.reports')); ?>">
                            <i class="fas fa-chart-bar me-2"></i>Laporan
                        </a>
                        <a class="nav-link text-white <?php echo e(request()->routeIs('admin-panitia.accounts') ? 'bg-white bg-opacity-25 rounded' : ''); ?>" href="<?php echo e(route('admin-panitia.accounts')); ?>">
                            <i class="fas fa-users me-2"></i>Kelola Akun
                        </a>
                        <a class="nav-link text-white" href="<?php echo e(route('admin-panitia.export')); ?>">
                            <i class="fas fa-download me-2"></i>Export Data
                        </a>
                    </nav>
                </div>
                <div class="mt-auto p-3">
                    <div class="dropdown">
                        <a class="nav-link text-white dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-2"></i><?php echo e(auth()->user()->name); ?>

                        </a>
                        <ul class="dropdown-menu">
                            <li><span class="dropdown-item-text">Admin Panitia</span></li>
                            <li><span class="dropdown-item-text"><?php echo e(auth()->user()->email); ?></span></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="<?php echo e(route('logout')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-9 col-lg-10 content-wrapper">
                <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
                    <div class="container-fluid">
                        <span class="navbar-brand"><?php echo $__env->yieldContent('page-title', 'Dashboard Admin Panitia'); ?></span>
                        <div class="navbar-nav ms-auto">
                            <span class="badge bg-purple me-3">ADMIN PANITIA</span>
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

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\Users\PC-08\Farrel_ujikom\resources\views/layouts/admin-panitia.blade.php ENDPATH**/ ?>