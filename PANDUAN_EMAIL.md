# Panduan Pengiriman Email ke Semua Pendaftar yang Disetujui

## Status Saat Ini ✅

Sistem sudah diperbaiki dan siap mengirim email ke **SEMUA** pendaftar yang disetujui:

### Data Pendaftar yang Disetujui:
1. **Farrel hakim** - Farrel31@gmail.com ✓
2. **chandra** - chandra13@gmail.com ✓
3. **chrisna** - chrisna@gmail.com ✓
4. **dafi** - dafi@gmail.com ✓
5. **ihsan** - ihsan@gmail.com ✓

**Total: 5 pendaftar siap menerima email**

---

## Cara Menggunakan

### 1. Kirim Email ke Semua Pendaftar
1. Buka: `http://127.0.0.1:8000/admin-panitia/monitoring`
2. Klik tombol **"Kirim Email Semua"** di bagian atas
3. Konfirmasi pengiriman
4. Sistem akan mengirim email ke **SEMUA 5 pendaftar** yang disetujui

### 2. Kirim Email Individual
1. Di halaman monitoring, cari pendaftar dengan status "Disetujui"
2. Klik tombol **"Kirim"** > **"Email"** pada baris pendaftar
3. Email akan dikirim ke pendaftar tersebut

---

## Konfigurasi Email (PENTING!)

Pastikan file `.env` sudah dikonfigurasi dengan benar:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="SMK Bakti Nusantara 666"
```

### Cara Mendapatkan App Password Gmail:
1. Buka: https://myaccount.google.com/security
2. Aktifkan **2-Step Verification**
3. Buka: https://myaccount.google.com/apppasswords
4. Pilih "Mail" dan "Windows Computer"
5. Copy password yang dihasilkan (16 karakter)
6. Paste ke `MAIL_PASSWORD` di file `.env`

---

## Testing Email

### Test Tanpa Mengirim (Dry Run):
```bash
php test_bulk_email.php
```

### Test Kirim Email Sungguhan:
Edit file `test_bulk_email.php`, uncomment baris:
```php
NotificationService::sendAcceptanceEmail($registration->user, $registration);
```

Lalu jalankan:
```bash
php test_bulk_email.php
```

---

## Troubleshooting

### Jika Email Tidak Terkirim:

1. **Cek Log Laravel:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

2. **Cek Konfigurasi Email:**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

3. **Test Koneksi SMTP:**
   ```bash
   php artisan tinker
   Mail::raw('Test email', function($msg) {
       $msg->to('test@example.com')->subject('Test');
   });
   ```

### Error Umum:

- **"Connection refused"**: Cek MAIL_HOST dan MAIL_PORT
- **"Authentication failed"**: Cek MAIL_USERNAME dan MAIL_PASSWORD (gunakan App Password)
- **"No user found"**: Pastikan pendaftar memiliki user_id yang valid

---

## Perbedaan dengan Sistem Lama

### ❌ Sistem Lama (Hanya Chrisna):
- Hanya mengirim ke 1 email hardcoded
- Tidak ada validasi user
- Delay 3 detik per email

### ✅ Sistem Baru (Semua User):
- Mengirim ke **SEMUA** pendaftar yang disetujui
- Validasi user dan email lengkap
- Tanpa delay (lebih cepat)
- Logging detail untuk tracking
- Laporan lengkap: berhasil, gagal, tidak ada email

---

## Fitur Tambahan

### Filter Pendaftar:
- Filter berdasarkan jurusan
- Filter berdasarkan status (pending, approved, rejected, revision)

### Export Data:
- Klik tombol "Export" untuk download data dalam format CSV

### Monitoring Real-time:
- Lihat kelengkapan berkas setiap pendaftar
- Status verifikasi real-time
- Tanggal pendaftaran

---

## Kontak Support

Jika ada masalah, hubungi:
- Email: admin@smkbaktinusantara666.sch.id
- Telp: 022-87654321

---

**Sistem sudah siap digunakan! 🎉**
