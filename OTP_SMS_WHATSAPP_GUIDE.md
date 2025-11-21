# Sistem OTP dengan SMS dan WhatsApp - PPDB Online

## 🚀 Fitur yang Sudah Dibuat

### 1. Multi-Channel OTP Delivery
- ✅ **Email** - Menggunakan Laravel Mail
- ✅ **SMS** - Menggunakan Twilio SMS API
- ✅ **WhatsApp** - Menggunakan Twilio WhatsApp API

### 2. Database & Model
- ✅ **Tabel users** - Ditambah field `phone`
- ✅ **Tabel otps** - Ditambah field `phone` dan `delivery_method`
- ✅ **Model Otp** - Support multi-channel delivery

### 3. User Interface
- ✅ **Halaman Pilihan Delivery** - `/otp-delivery-choice`
- ✅ **Halaman Verifikasi OTP** - `/otp-verification`
- ✅ **Auto-detect delivery method** - Icon dan text sesuai pilihan

### 4. Service Layer
- ✅ **OtpService** - Centralized OTP delivery service
- ✅ **Format nomor Indonesia** - Auto format +62
- ✅ **Error handling** - Comprehensive error handling

## 📱 Flow Sistem OTP

```
1. Siswa Login → 2. Pilih Delivery Method → 3. Generate & Kirim OTP → 4. Verifikasi OTP → 5. Dashboard
```

### Detail Flow:
1. **Login Siswa** - Input email & password
2. **Pilih Metode** - Email, SMS, atau WhatsApp
3. **Generate OTP** - 6 digit, berlaku 5 menit
4. **Kirim OTP** - Sesuai metode yang dipilih
5. **Verifikasi** - Input kode OTP
6. **Dashboard** - Redirect ke dashboard siswa

## 🔧 Konfigurasi Twilio

### 1. Daftar Akun Twilio
- Buka [twilio.com](https://www.twilio.com)
- Daftar akun baru atau login
- Dapatkan Account SID dan Auth Token

### 2. Setup SMS
- Beli nomor telepon Twilio
- Verifikasi nomor tujuan (untuk trial account)

### 3. Setup WhatsApp
- Aktifkan Twilio WhatsApp Sandbox
- Kirim pesan "join [sandbox-name]" ke +1 415 523 8886
- Atau setup WhatsApp Business API (berbayar)

### 4. Konfigurasi .env
```env
TWILIO_SID=ACxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
TWILIO_TOKEN=your_auth_token_here
TWILIO_FROM=+1234567890
TWILIO_WHATSAPP_FROM=+14155238886
```

## 🧪 Testing

### 1. Akses Halaman Test
```
http://localhost:8000/test-otp
```

### 2. User Testing (sudah ada nomor telepon)
- **Email**: siswa@gmail.com **Password**: password **Phone**: 081234567890
- **Email**: siswa@test.com **Password**: password123 **Phone**: 081234567891
- **Email**: Farrel31@gmail.com **Password**: password **Phone**: 081234567892

### 3. Skenario Testing
1. **Email OTP** - Pilih email, cek log Laravel
2. **SMS OTP** - Pilih SMS, cek pesan masuk
3. **WhatsApp OTP** - Pilih WhatsApp, cek pesan WhatsApp
4. **Resend OTP** - Test tombol kirim ulang
5. **Expired OTP** - Tunggu 5 menit, test expired

## 📋 Format Pesan OTP

### SMS Format
```
Kode OTP PPDB Online Anda: 123456. Berlaku 5 menit. Jangan bagikan kode ini kepada siapapun.
```

### WhatsApp Format
```
🔐 *PPDB Online - Kode OTP*

Kode OTP Anda: *123456*

⏰ Berlaku 5 menit
🚫 Jangan bagikan kode ini kepada siapapun

_SMK BAKTI NUSANTARA 666_
```

## 🔒 Keamanan

### Validasi
- ✅ OTP hanya berlaku 5 menit
- ✅ OTP hanya bisa digunakan sekali
- ✅ Validasi nomor telepon format Indonesia
- ✅ Session validation
- ✅ Rate limiting (bisa ditambahkan)

### Error Handling
- ✅ Twilio API error handling
- ✅ Network error handling
- ✅ Invalid phone number handling
- ✅ Missing phone number handling

## 🚀 Production Checklist

### 1. Hapus Development Features
```php
// Hapus di OtpController
'otp_code' => $otp->otp_code // Hapus baris ini
```

### 2. Setup Email Service
- Konfigurasi SMTP di .env
- Setup email template yang proper

### 3. Setup Twilio Production
- Upgrade ke paid account
- Beli nomor telepon dedicated
- Setup WhatsApp Business API

### 4. Rate Limiting
```php
// Tambah di routes/web.php
Route::middleware(['throttle:5,1'])->group(function () {
    // OTP routes
});
```

### 5. Logging & Monitoring
- Setup proper logging
- Monitor delivery success rate
- Alert untuk failed deliveries

## 📊 Biaya Estimasi (Twilio)

### SMS
- **Indonesia**: ~$0.05 per SMS
- **1000 siswa**: ~$50

### WhatsApp
- **Conversation-based pricing**
- **Business-initiated**: $0.005-0.009 per conversation
- **1000 siswa**: ~$5-9

## 🛠️ Troubleshooting

### 1. SMS Tidak Terkirim
- Cek Twilio credentials
- Cek format nomor telepon
- Cek saldo Twilio account

### 2. WhatsApp Tidak Terkirim
- Cek WhatsApp sandbox setup
- Cek nomor sudah join sandbox
- Cek WhatsApp Business API status

### 3. Error "Phone not available"
- User belum input nomor telepon
- Redirect ke form update profile

## 📞 Support

Untuk bantuan teknis:
1. Cek log Laravel: `storage/logs/laravel.log`
2. Cek Twilio console untuk delivery status
3. Test dengan nomor telepon yang sudah terverifikasi

---

## Status: ✅ READY FOR TESTING

Sistem OTP multi-channel sudah lengkap dan siap untuk testing. Siswa bisa memilih pengiriman OTP via Email, SMS, atau WhatsApp sesuai preferensi mereka.