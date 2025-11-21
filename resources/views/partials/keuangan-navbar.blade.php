<nav class="navbar navbar-expand-lg navbar-dark bg-success shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('keuangan.dashboard') }}">
            <i class="fas fa-coins me-2"></i>
            <span class="fw-bold">Keuangan PPDB</span>
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#keuanganNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="keuanganNavbar">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('keuangan.dashboard') ? 'active' : '' }}" href="{{ route('keuangan.dashboard') }}">
                        <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('payments.verification') ? 'active' : '' }}" href="{{ route('payments.verification') }}">
                        <i class="fas fa-check-circle me-1"></i>Verifikasi Pembayaran
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('keuangan.ppdb*') ? 'active' : '' }}" href="{{ route('keuangan.ppdb') }}">
                        <i class="fas fa-user-graduate me-1"></i>PPDB Keuangan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('bills.*') ? 'active' : '' }}" href="{{ route('bills.index') }}">
                        <i class="fas fa-file-invoice me-1"></i>Kelola Tagihan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('audit.logs') ? 'active' : '' }}" href="{{ route('audit.logs') }}">
                        <i class="fas fa-history me-1"></i>Audit Log
                    </a>
                </li>
            </ul>
            
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user-circle me-2"></i>
                        {{ auth()->user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><h6 class="dropdown-header">{{ auth()->user()->email }}</h6></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>