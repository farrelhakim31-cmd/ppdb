<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kepala Sekolah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-warning">
        <div class="container">
            <a class="navbar-brand" href="#">Dashboard Kepala Sekolah</a>
            <form method="POST" action="{{ route('logout') }}" class="d-flex" id="logoutForm">
                @csrf
                <button class="btn btn-outline-dark" type="button" onclick="confirmLogout()">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Selamat Datang, {{ Auth::user()->name ?? 'Kepala Sekolah' }}!</h1>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Dashboard Kepala Sekolah</h5>
                        <p class="card-text">Ini adalah halaman dashboard untuk kepala sekolah.</p>
                        <a href="{{ route('home') }}" class="btn btn-warning">Kembali ke Beranda</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
    function confirmLogout() {
        if (confirm('Anda yakin ingin keluar dari halaman ini?')) {
            document.getElementById('logoutForm').submit();
        }
    }
    </script>
</body>
</html>