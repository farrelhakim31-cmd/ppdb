# Cara Mengirim Tagihan ke Email di HP

## Konfigurasi Email Sudah Siap ✅
Email sudah dikonfigurasi menggunakan Gmail:
- Email: farreltugas16@gmail.com
- SMTP: smtp.gmail.com
- Port: 587
- Encryption: TLS

## Cara Mengirim Tagihan ke Email

### Metode 1: Dari Halaman Bills Create
1. Buka browser di HP
2. Akses: `http://127.0.0.1:8000/bills/create`
3. Login sebagai admin/keuangan
4. Isi form tagihan:
   - Pilih siswa
   - Jenis tagihan
   - Jumlah
   - Jatuh tempo
   - Keterangan
5. **Pastikan checkbox "Kirim notifikasi tagihan ke email siswa" DICENTANG** ✅
6. Klik "Simpan Tagihan"
7. Email akan otomatis terkirim ke email siswa

### Metode 2: Dari Halaman Keuangan PPDB (Lebih Mudah)
1. Buka browser di HP
2. Akses: `http://127.0.0.1:8000/keuangan/ppdb`
3. Login sebagai keuangan
4. Cari siswa dengan status "Belum Bayar"
5. Klik tombol **icon invoice** (📄) di kolom Aksi
6. Modal form akan muncul
7. Isi form tagihan
8. **Pastikan checkbox "Kirim notifikasi ke email" DICENTANG** ✅
9. Klik "Buat Tagihan"
10. Email akan otomatis terkirim

### Metode 3: Dari Daftar Siswa Belum Lunas
1. Akses: `http://127.0.0.1:8000/bills-unpaid-students`
2. Lihat daftar siswa yang belum lunas
3. Klik "Buat Tagihan" pada siswa yang dipilih
4. Siswa akan otomatis terpilih di form
5. Isi detail tagihan
6. Centang checkbox kirim email
7. Submit form

## Format Email yang Dikirim

Email yang diterima siswa berisi:
- **Header**: Logo dan nama sekolah
- **Keterangan tagihan**: Deskripsi lengkap
- **Jumlah tagihan**: Dalam format Rupiah
- **Jatuh tempo**: Tanggal batas pembayaran
- **Status**: Belum Dibayar/Lunas
- **Footer**: Informasi sekolah

## Troubleshooting

### Email Tidak Terkirim?
1. Pastikan koneksi internet aktif
2. Cek email siswa sudah benar
3. Pastikan checkbox "Kirim email" dicentang
4. Cek spam folder di email penerima

### Cara Cek Email Terkirim
1. Setelah submit, akan muncul notifikasi:
   - "Tagihan berhasil dibuat dan email telah dikirim" ✅
2. Cek inbox email siswa
3. Jika tidak ada, cek folder Spam/Junk

## Testing Email

Untuk test kirim email:
1. Buat tagihan untuk siswa dengan email Anda sendiri
2. Centang checkbox kirim email
3. Submit
4. Cek inbox email Anda
5. Email akan datang dari: farreltugas16@gmail.com

## Akses dari HP

### Jika Server di Komputer yang Sama
- Gunakan: `http://127.0.0.1:8000` atau `http://localhost:8000`

### Jika Server di Komputer Lain (Jaringan Lokal)
1. Cari IP komputer server (cmd > ipconfig)
2. Gunakan: `http://[IP-KOMPUTER]:8000`
   Contoh: `http://192.168.1.100:8000`

### Menjalankan Server Laravel
```bash
cd C:\Users\PC-08\Farrel_ujikom
php artisan serve
```

Atau untuk akses dari HP lain di jaringan:
```bash
php artisan serve --host=0.0.0.0 --port=8000
```

## Catatan Penting

⚠️ **PENTING**: 
- Checkbox "Kirim email" harus DICENTANG untuk mengirim email
- Email hanya terkirim saat membuat tagihan BARU
- Pastikan email siswa valid dan aktif
- Email dikirim dari: farreltugas16@gmail.com
- Nama pengirim: "SMK Bakti Nusantara 666"

✅ **Fitur Otomatis**:
- Email terformat dengan template profesional
- Gradient biru sesuai tema aplikasi
- Responsive untuk dibuka di HP
- Informasi lengkap tagihan

## Login Credentials

**Admin/Keuangan**:
- Email: (sesuai data di database)
- Password: (sesuai data di database)

Untuk melihat user keuangan, cek tabel `users` dengan role = 'keuangan'
