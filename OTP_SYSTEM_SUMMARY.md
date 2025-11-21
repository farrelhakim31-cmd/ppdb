# Sistem OTP untuk Siswa - PPDB Online

## Fitur yang Sudah Dibuat

### 1. Database & Model
- ✅ **Migration**: `2025_01_22_000001_create_otps_table.php`
- ✅ **Model**: `app/Models/Otp.php`
  - Generate OTP 6 digit
  - Validasi expired (5 menit)
  - Validasi sudah digunakan

### 2. Controller
- ✅ **OtpController**: `app/Http/Controllers/OtpController.php`
  - `showOtpForm()` - Tampilkan form OTP
  - `sendOtp()` - Generate dan kirim OTP
  - `verifyOtp()` - Verifikasi kode OTP
  - `resendOtp()` - Kirim ulang OTP

### 3. View
- ✅ **OTP Verification**: `resources/views/auth/otp-verification.blade.php`
  - Form input OTP dengan auto-submit
  - Countdown timer 60 detik
  - Tombol resend OTP
  - Responsive design dengan Tailwind CSS

### 4. Routes
- ✅ **OTP Routes** di `routes/web.php`:
  - `GET /otp-verification` - Form OTP
  - `POST /otp-verify` - Verifikasi OTP
  - `POST /otp-resend` - Kirim ulang OTP

### 5. Authentication Update
- ✅ **AuthController** diupdate:
  - Siswa → Redirect ke OTP setelah login
  - Admin/Kepala/Keuangan → Login langsung

## Cara Testing

### 1. Akses Halaman Test
```
http://localhost:8000/test-otp
```

### 2. Login dengan Akun Siswa
- **Email**: siswa@gmail.com **Password**: password
- **Email**: siswa@test.com **Password**: password123
- **Email**: Farrel31@gmail.com **Password**: password

### 3. Flow Testing
1. Login dengan akun siswa
2. Sistem generate OTP dan redirect ke halaman verifikasi
3. Kode OTP ditampilkan (untuk development)
4. Masukkan kode OTP (auto-submit saat 6 digit)
5. Berhasil masuk ke dashboard siswa

## Keamanan OTP

### Validasi
- ✅ OTP hanya berlaku 5 menit
- ✅ OTP hanya bisa digunakan sekali
- ✅ OTP hanya untuk role siswa
- ✅ Session validation

### Development Features
- 🔧 Kode OTP ditampilkan di halaman (hapus di production)
- 🔧 Alert menampilkan kode OTP baru saat resend

## Production Checklist

### Untuk Production:
1. **Hapus tampilan kode OTP** di:
   - `OtpController@sendOtp()` - hapus `'otp_code' => $otp->otp_code`
   - `OtpController@resendOtp()` - hapus `'otp_code' => $otp->otp_code`
   - View OTP - hapus bagian development

2. **Setup Email Service**:
   - Konfigurasi SMTP di `.env`
   - Uncomment dan sesuaikan `Mail::raw()` di `OtpController`

3. **Rate Limiting**:
   - Tambah throttling untuk prevent spam OTP

## Status: ✅ READY FOR TESTING

Sistem OTP sudah lengkap dan siap untuk ditest. Semua siswa yang login akan diminta memasukkan kode OTP, sementara admin/kepala/keuangan login langsung tanpa OTP.