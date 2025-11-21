# Sistem Pembayaran PPDB - Update

## Fitur Baru: Pembayaran Wajib Saat Pendaftaran

### Alur Pendaftaran Baru:
1. **Siswa mengisi formulir pendaftaran** → `/ppdb/register`
2. **Redirect ke halaman pembayaran** → `/ppdb/payment/{registration_number}`
3. **Upload bukti pembayaran** → Biaya Rp 500.000
4. **Verifikasi pembayaran oleh staff keuangan** → `/payments/verification`
5. **Proses verifikasi berkas** → Setelah pembayaran disetujui

### Informasi Pembayaran:
- **Biaya Pendaftaran**: Rp 500.000
- **Bank**: BCA
- **No. Rekening**: 1234567890
- **Atas Nama**: SMK Negeri 1

### Status Pembayaran:
- **Pending**: Menunggu verifikasi
- **Verified**: Pembayaran disetujui
- **Rejected**: Pembayaran ditolak

### Fitur untuk Staff Keuangan:
- Verifikasi bukti pembayaran PPDB
- Lihat data pendaftar dan nomor registrasi
- Setujui/tolak pembayaran

### Routes Baru:
- `GET /ppdb/payment/{registration_number}` - Halaman pembayaran
- `POST /ppdb/payment/{registration_number}` - Proses upload bukti

### Database Changes:
- Tabel `payments` ditambah kolom `ppdb_registration_id`
- Relasi antara `PpdbRegistration` dan `Payment`

Sistem sekarang memastikan siswa harus melakukan pembayaran sebelum pendaftaran dapat diproses lebih lanjut.