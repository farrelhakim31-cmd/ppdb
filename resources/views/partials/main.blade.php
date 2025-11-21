<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>PPDB Online - Penerimaan Peserta Didik Baru</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    
    @stack('styles')
</head>

<body class="@if(request()->routeIs('home')) home-page @endif">
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="{{ route('home') }}" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <h2 class="m-0 text-primary"><i class="fa fa-graduation-cap me-3"></i>PPDB Online</h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="{{ route('home') }}" class="nav-item nav-link">Home</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">PPDB</a>
                    <div class="dropdown-menu fade-down m-0">
                        <a href="{{ route('ppdb.index') }}" class="dropdown-item">Info PPDB</a>
                        <a href="{{ route('ppdb.register') }}" class="dropdown-item">Daftar Online</a>
                    </div>
                </div>
                <a href="{{ route('about') }}" class="nav-item nav-link">Tentang</a>
                <a href="{{ route('contact') }}" class="nav-item nav-link">Kontak</a>
                @auth
                    <form method="POST" action="{{ route('logout') }}" class="d-inline" id="logoutForm">
                        @csrf
                        <button type="button" class="nav-item nav-link btn btn-link p-0 border-0" style="background: none;" onclick="confirmLogout()">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="nav-item nav-link">Login</a>
                @endauth
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    @yield('content')

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
    
    <script>
    function confirmLogout() {
        if (confirm('Anda yakin ingin keluar dari halaman ini?')) {
            document.getElementById('logoutForm').submit();
        }
    }
    </script>
</body>
</html>