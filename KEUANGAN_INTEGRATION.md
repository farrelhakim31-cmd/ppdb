# Sistem Keuangan - Integrasi PPDB

## Role Keuangan Terintegrasi Penuh

### **Dashboard Keuangan** (`/keuangan/dashboard`)
- ✅ **Manajemen Tagihan** - Kelola tagihan siswa reguler
- ✅ **Verifikasi Pembayaran** - Verifikasi semua pembayaran (siswa + PPDB)  
- ✅ **Pembayaran PPDB** - Monitor khusus pembayaran pendaftaran

### **Fitur PPDB untuk Keuangan:**

#### 1. **Monitor PPDB** (`/keuangan/ppdb`)
- Lihat semua pendaftaran PPDB
- Status pembayaran setiap pendaftar
- Filter berdasarkan status pembayaran

#### 2. **Detail PPDB** (`/keuangan/ppdb/{id}`)
- Data lengkap pendaftar
- Status pembayaran detail
- Lihat bukti pembayaran
- Verifikasi langsung dari halaman detail

#### 3. **Verifikasi Terintegrasi** (`/payments/verification`)
- Verifikasi pembayaran siswa reguler
- Verifikasi pembayaran PPDB
- Tampilan terpadu dengan label PPDB

### **Login Keuangan:**
- **Email**: `keuangan@test.com`
- **Password**: `password`
- **Auto redirect** ke dashboard keuangan

### **Akses Kontrol:**
- Hanya role `admin` dan `keuangan` yang bisa akses
- Middleware keamanan di semua controller keuangan
- Redirect otomatis berdasarkan role saat login

### **Workflow Lengkap:**
1. **Siswa daftar PPDB** → Upload bukti bayar Rp 500.000
2. **Staff keuangan login** → Dashboard keuangan
3. **Monitor pembayaran** → `/keuangan/ppdb` atau `/payments/verification`
4. **Verifikasi pembayaran** → Setujui/tolak
5. **Proses berlanjut** → Admin PPDB lanjutkan verifikasi berkas

Role keuangan sekarang memiliki kontrol penuh atas semua aspek pembayaran dalam sistem!