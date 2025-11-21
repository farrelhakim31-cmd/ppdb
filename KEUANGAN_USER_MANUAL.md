# Sistem Keuangan - User Manual

## User yang Tersedia

### Staff Keuangan
- **Email**: keuangan@test.com
- **Password**: password
- **Role**: keuangan
- **Akses**: Dashboard Keuangan, Manajemen Tagihan, Verifikasi Pembayaran

### Admin
- **Email**: admin@test.com
- **Password**: password
- **Role**: admin
- **Akses**: Semua fitur termasuk keuangan

## Fitur Sistem Keuangan

### 1. Dashboard Keuangan
- **URL**: `/keuangan/dashboard`
- **Fitur**: 
  - Akses cepat ke manajemen tagihan
  - Akses cepat ke verifikasi pembayaran

### 2. Manajemen Tagihan
- **URL**: `/bills`
- **Fitur**:
  - Lihat daftar tagihan
  - Buat tagihan baru
  - Detail tagihan dan riwayat pembayaran

### 3. Verifikasi Pembayaran
- **URL**: `/payments/verification`
- **Fitur**:
  - Lihat pembayaran yang perlu diverifikasi
  - Setujui atau tolak pembayaran
  - Lihat bukti pembayaran

## Cara Login
1. Akses `/login`
2. Masukkan email: `keuangan@test.com`
3. Masukkan password: `password`
4. Klik Login
5. Akan diarahkan ke dashboard keuangan

## Workflow Keuangan
1. **Buat Tagihan** → Pilih siswa, masukkan jumlah dan jatuh tempo
2. **Siswa Upload Bukti** → Siswa upload bukti pembayaran
3. **Verifikasi** → Staff keuangan verifikasi bukti pembayaran
4. **Selesai** → Status tagihan berubah menjadi "paid"