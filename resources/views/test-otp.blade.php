<!DOCTYPE html>
<html>
<head>
    <title>Test OTP System</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Test Sistem OTP</h4>
                    </div>
                    <div class="card-body">
                        <h5>Langkah Testing:</h5>
                        <ol>
                            <li>Buka halaman login: <a href="{{ route('login') }}" target="_blank">{{ route('login') }}</a></li>
                            <li>Login dengan salah satu akun siswa berikut:</li>
                        </ol>
                        
                        <div class="alert alert-info">
                            <h6>Akun Siswa untuk Testing:</h6>
                            <ul class="mb-0">
                                <li><strong>Email:</strong> siswa@gmail.com <strong>Password:</strong> password</li>
                                <li><strong>Email:</strong> siswa@test.com <strong>Password:</strong> password123</li>
                                <li><strong>Email:</strong> Farrel31@gmail.com <strong>Password:</strong> password</li>
                            </ul>
                        </div>
                        
                        <div class="alert alert-warning">
                            <h6>Yang Akan Terjadi:</h6>
                            <ol class="mb-0">
                                <li>Setelah login dengan akun siswa, pilih metode pengiriman OTP</li>
                                <li>Sistem akan generate dan kirim OTP sesuai pilihan</li>
                                <li>Anda akan diarahkan ke halaman verifikasi OTP</li>
                                <li>Kode OTP akan ditampilkan di halaman (untuk development)</li>
                                <li>Masukkan kode OTP untuk masuk ke dashboard siswa</li>
                            </ol>
                        </div>
                        
                        <div class="alert alert-success">
                            <h6>Fitur OTP yang Sudah Dibuat:</h6>
                            <ul class="mb-0">
                                <li>✅ Generate OTP 6 digit</li>
                                <li>✅ OTP berlaku 5 menit</li>
                                <li>✅ Pilihan pengiriman: Email, SMS, WhatsApp</li>
                                <li>✅ Countdown timer 60 detik untuk resend</li>
                                <li>✅ Auto-submit saat OTP 6 digit dimasukkan</li>
                                <li>✅ Validasi OTP expired dan sudah digunakan</li>
                                <li>✅ Hanya untuk role siswa (admin/kepala/keuangan login langsung)</li>
                                <li>✅ Integrasi Twilio untuk SMS & WhatsApp</li>
                            </ul>
                        </div>
                        
                        <div class="alert alert-info">
                            <h6>Konfigurasi SMS & WhatsApp:</h6>
                            <p class="mb-2">Untuk mengaktifkan SMS dan WhatsApp, tambahkan ke file .env:</p>
                            <pre class="mb-0" style="font-size: 12px;">
TWILIO_SID=your_twilio_account_sid
TWILIO_TOKEN=your_twilio_auth_token
TWILIO_FROM=+1234567890
TWILIO_WHATSAPP_FROM=+14155238886</pre>
                        </div>
                        
                        <a href="{{ route('login') }}" class="btn btn-primary">Test Login dengan OTP</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>