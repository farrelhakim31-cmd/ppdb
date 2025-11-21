# Panduan Pengiriman Email Pengingat Pembayaran

## Status Saat Ini ✅

Sistem sudah diperbaiki dan siap mengirim email pengingat pembayaran ke **SEMUA** pendaftar yang belum bayar!

### Data Pendaftar yang Belum Bayar:
1. **cindy** - cindy23@gmail.com ✓
2. **farrel hakim** - Farrel32@gmail.com ✓
3. **althur** - althur99@gmail.com ✓
4. **chandra** - chandra13@gmail.com ✓

**Total: 4 pendaftar siap menerima email pengingat**

---

## Cara Menggunakan

### 1. Kirim Email Pengingat ke Semua yang Belum Bayar
1. Login sebagai **Keuangan**
2. Buka: `http://127.0.0.1:8000/keuangan/ppdb`
3. Klik tombol **"Kirim Email Pengingat"** di bagian atas tabel
4. Konfirmasi pengiriman
5. Sistem akan mengirim email ke **SEMUA 4 pendaftar** yang belum bayar

### 2. Fitur Lainnya
- **Verifikasi Pembayaran**: Klik tombol ✓ untuk verifikasi pembayaran yang pending
- **Buat Tagihan**: Klik tombol 📄 untuk membuat tagihan baru
- **Lihat Detail**: Klik tombol 👁️ untuk melihat detail pembayaran

---

## Isi Email Pengingat

Email yang dikirim berisi:
- ⚠️ Pengingat bahwa pembayaran belum diterima
- Informasi pendaftaran (nama, no. pendaftaran, jurusan)
- Jumlah biaya pendaftaran: **Rp 300.000**
- Cara pembayaran
- Link untuk login dan upload bukti bayar
- Kontak sekolah

---

## Perbandingan Fitur

### Admin Panitia (Monitoring):
- ✉️ **Kirim Email Semua** → Ke pendaftar yang **DISETUJUI**
- 📧 Email berisi: Penerimaan siswa baru
- Total: 5 pendaftar

### Keuangan (PPDB):
- ⚠️ **Kirim Email Pengingat** → Ke pendaftar yang **BELUM BAYAR**
- 📧 Email berisi: Pengingat pembayaran
- Total: 4 pendaftar

---

## Konfigurasi Email

Pastikan file `.env` sudah dikonfigurasi:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=farreltugas16@gmail.com
MAIL_PASSWORD=peaqyhgrliinkgao
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=farreltugas16@gmail.com
MAIL_FROM_NAME="SMK Bakti Nusantara 666"
```

✅ Konfigurasi sudah benar!

---

## Testing Email Pengingat

### Test Tanpa Mengirim:
```bash
php test_unpaid.php
```

Output:
```
Total Belum Bayar: 4
With User: 4
With Email: 4
```

### Test Kirim Email Sungguhan:
1. Login sebagai keuangan
2. Buka halaman PPDB
3. Klik "Kirim Email Pengingat"
4. Cek inbox email pendaftar

---

## Troubleshooting

### Jika Email Tidak Terkirim:

1. **Cek Log Laravel:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

2. **Cek Status Pendaftar:**
   ```bash
   php test_unpaid.php
   ```

3. **Clear Cache:**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

### Error Umum:

- **"Tidak ada pendaftar yang belum bayar"**: Semua sudah bayar, tidak perlu kirim email
- **"Email tidak ditemukan"**: Pastikan user memiliki email yang valid
- **"Connection refused"**: Cek konfigurasi SMTP di .env

---

## Workflow Lengkap

### 1. Pendaftar Daftar
- Status: `unpaid`
- Belum upload bukti bayar

### 2. Keuangan Kirim Email Pengingat ⚠️
- Email otomatis ke semua yang belum bayar
- Berisi instruksi pembayaran

### 3. Pendaftar Upload Bukti Bayar
- Status berubah: `pending`
- Menunggu verifikasi

### 4. Keuangan Verifikasi ✓
- Status berubah: `paid`
- Proses lanjut ke admin

### 5. Admin Setujui Berkas ✓
- Status: `approved`
- Email penerimaan dikirim

---

## Statistik Dashboard Keuangan

Dashboard menampilkan:
- 📊 **Total Pendaftar**: Semua pendaftar
- ✅ **Sudah Bayar**: Status `paid`
- ❌ **Belum Bayar**: Status `unpaid` (target email)
- 💰 **Total Pemasukan**: Total dari yang sudah bayar

---

## Fitur Tambahan

### Filter & Search:
- Filter berdasarkan status pembayaran
- Search berdasarkan nama
- Pagination untuk data banyak

### Export Data:
- Export laporan keuangan
- Format CSV/Excel
- Filter berdasarkan periode

### Notifikasi Real-time:
- Notifikasi saat ada pembayaran baru
- Alert untuk pembayaran pending
- Dashboard statistik real-time

---

## Keamanan

- ✓ Hanya role **keuangan** yang bisa akses
- ✓ Middleware authentication
- ✓ Logging semua aktivitas
- ✓ Validasi data sebelum kirim email

---

## Kontak Support

Jika ada masalah, hubungi:
- Email: admin@smkbaktinusantara666.sch.id
- Telp: 022-87654321

---

**Sistem Keuangan sudah siap digunakan! 💰**

**Sama seperti OTP dan Admin Panitia - Bisa kirim ke SEMUA user! 🎉**
