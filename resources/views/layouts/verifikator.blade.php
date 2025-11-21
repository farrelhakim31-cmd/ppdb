<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Verifikator')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar { min-height: 100vh; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); }
        .content-wrapper { background-color: #f8f9fa; min-height: 100vh; }
        .card { border: none; box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); }
        .stat-card { transition: transform 0.2s; }
        .stat-card:hover { transform: translateY(-2px); }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-lg-2 px-0 sidebar">
                <div class="p-3">
                    <h5 class="text-white mb-4">
                        <i class="fas fa-clipboard-check me-2"></i>Verifikator
                    </h5>
                    <nav class="nav flex-column">
                        <a class="nav-link text-white {{ request()->routeIs('verifikator.dashboard') ? 'bg-white bg-opacity-25 rounded' : '' }}" href="{{ route('verifikator.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                        <a class="nav-link text-white {{ request()->routeIs('verifikator.index') ? 'bg-white bg-opacity-25 rounded' : '' }}" href="{{ route('verifikator.index') }}">
                            <i class="fas fa-list me-2"></i>Daftar Pendaftar
                        </a>
                        <a class="nav-link text-white {{ request()->routeIs('verifikator.pending') ? 'bg-white bg-opacity-25 rounded' : '' }}" href="#">
                            <i class="fas fa-clock me-2"></i>Menunggu Verifikasi
                        </a>
                        <a class="nav-link text-white {{ request()->routeIs('verifikator.verified') ? 'bg-white bg-opacity-25 rounded' : '' }}" href="#">
                            <i class="fas fa-check-circle me-2"></i>Sudah Diverifikasi
                        </a>
                        <a class="nav-link text-white {{ request()->routeIs('verifikator.rejected') ? 'bg-white bg-opacity-25 rounded' : '' }}" href="#">
                            <i class="fas fa-times-circle me-2"></i>Ditolak
                        </a>
                        <a class="nav-link text-white {{ request()->routeIs('verifikator.reports') ? 'bg-white bg-opacity-25 rounded' : '' }}" href="#">
                            <i class="fas fa-chart-bar me-2"></i>Laporan
                        </a>
                    </nav>
                </div>
                <div class="mt-auto p-3">
                    <div class="dropdown">
                        <a class="nav-link text-white dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-user-check me-2"></i>{{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><span class="dropdown-item-text">Verifikator</span></li>
                            <li><span class="dropdown-item-text">{{ auth()->user()->email }}</span></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
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
                        <span class="navbar-brand">@yield('page-title', 'Dashboard Verifikator')</span>
                        <div class="navbar-nav ms-auto">
                            <span class="badge bg-success me-3">VERIFIKATOR</span>
                            <span class="nav-link">{{ now()->format('d M Y, H:i') }}</span>
                        </div>
                    </div>
                </nav>

                <div class="p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>