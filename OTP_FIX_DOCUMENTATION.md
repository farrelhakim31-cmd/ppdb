# Perbaikan Masalah OTP "Page Expired"

## Masalah yang Diperbaiki

1. **Session Expired**: Session OTP tidak memiliki validasi waktu yang proper
2. **Tidak ada regenerasi session**: Session tidak di-regenerate setelah login berhasil
3. **Penanganan error yang kurang**: Tidak ada penanganan khusus untuk session expired

## Solusi yang Diterapkan

### 1. Validasi Session dengan Timestamp
- Menambahkan `otp_session_time` untuk tracking waktu session
- Session OTP berlaku maksimal 15 menit
- Auto-cleanup session yang expired

### 2. Middleware CheckOtpSession
- Middleware khusus untuk mengecek validitas session OTP
- Auto-redirect ke login jika session expired
- Support untuk AJAX request dengan JSON response

### 3. Perbaikan Controller
- Validasi session yang lebih robust di semua method OTP
- Regenerasi session setelah login berhasil
- Penanganan error yang lebih baik

### 4. Perbaikan Frontend
- Session countdown timer di halaman OTP
- Auto-redirect ketika session expired
- Penanganan response error dari server

### 5. Konfigurasi Session
- Session lifetime dikurangi menjadi 30 menit
- Session expire on close = true
- Driver database untuk stabilitas

## File yang Dimodifikasi

1. `app/Http/Controllers/OtpController.php` - Validasi session yang lebih baik
2. `app/Http/Controllers/AuthController.php` - Menambah session timestamp
3. `app/Http/Middleware/CheckOtpSession.php` - Middleware baru
4. `bootstrap/app.php` - Registrasi middleware
5. `routes/web.php` - Menambah middleware ke routes OTP
6. `config/session.php` - Optimasi konfigurasi session
7. `resources/views/auth/otp-verification.blade.php` - Session countdown UI
8. `.env.example` - Dokumentasi konfigurasi

## Cara Kerja

1. User login dengan role siswa
2. Session `otp_email` dan `otp_session_time` dibuat
3. User diarahkan ke pilihan delivery method
4. Middleware `CheckOtpSession` mengecek validitas session di setiap request
5. Jika session expired (>15 menit), auto-redirect ke login
6. Frontend menampilkan countdown session dan auto-redirect jika expired
7. Setelah OTP berhasil diverifikasi, session di-regenerate untuk keamanan

## Testing

1. Login sebagai siswa
2. Tunggu di halaman OTP selama >15 menit
3. Coba resend OTP atau submit form
4. Harus auto-redirect ke login dengan pesan "Session expired"

## Konfigurasi Environment

Pastikan di file `.env`:
```
SESSION_DRIVER=database
SESSION_LIFETIME=30
SESSION_EXPIRE_ON_CLOSE=true
```

## Catatan Keamanan

- Session OTP hanya berlaku 15 menit
- Session di-regenerate setelah login berhasil
- Auto-cleanup session expired
- CSRF protection tetap aktif
- Middleware validation di semua routes OTP