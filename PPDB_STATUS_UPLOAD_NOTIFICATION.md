# Dokumentasi Fitur PPDB: Status, Upload Dokumen, dan Notifikasi Keuangan

## Fitur yang Telah Dibuat

### 1. Status Pendaftaran Lengkap
- **Halaman Status**: `/ppdb/status/{registrationNumber}`
- **Fitur**:
  - Progress tracking dengan 4 tahap: Data Pribadi, Upload Dokumen, Pembayaran, Verifikasi
  - Visual progress indicator dengan ikon dan warna status
  - Informasi kelengkapan dokumen real-time
  - Status pembayaran terintegrasi
  - Auto-refresh setiap 30 detik

### 2. Upload Dokumen dengan Persyaratan Spesifik
- **Dokumen Wajib**:
  - Fotokopi Kartu Keluarga
  - Fotokopi Akta Kelahiran
  - Fotokopi Ijazah/SKHUN
  - Pas foto 3x4 (2 lembar)
  - Surat keterangan sehat

- **Fitur Upload**:
  - Validasi jenis dokumen sesuai persyaratan
  - Format file: PDF, JPG, JPEG, PNG (max 2MB)
  - Preview dokumen dengan modal
  - Hapus dokumen sebelum diverifikasi
  - Status verifikasi per dokumen

### 3. Sistem Notifikasi Terintegrasi Keuangan
- **Notifikasi Otomatis**:
  - Saat pendaftaran baru → notifikasi ke keuangan untuk buat tagihan
  - Saat upload dokumen → notifikasi ke admin
  - Saat pembayaran diverifikasi → notifikasi ke admin
  - Saat dokumen diupload → notifikasi ke admin

- **Dashboard Keuangan**:
  - Panel notifikasi real-time
  - Badge counter notifikasi belum dibaca
  - Integrasi dengan sistem tagihan

## File yang Dimodifikasi/Dibuat

### Controllers
- `PPDBController.php` - Ditambahkan fitur status lengkap dan upload dokumen
- `KeuanganController.php` - Ditambahkan notifikasi dashboard
- `NotificationController.php` - Sudah ada, digunakan untuk menampilkan notifikasi

### Models
- `SystemService.php` - Ditambahkan method notifikasi dan job queue
- `SendBillNotification.php` - Job baru untuk notifikasi asinkron

### Views
- `ppdb/status.blade.php` - View status lengkap dengan progress tracking
- `ppdb/index.blade.php` - Diperbarui persyaratan dokumen
- `keuangan/dashboard.blade.php` - Ditambahkan panel notifikasi
- `notifications/index.blade.php` - View untuk semua notifikasi

### Routes
- Ditambahkan route untuk delete dokumen
- Route notifikasi sudah ada dan terintegrasi

## Cara Penggunaan

### 1. Untuk Calon Siswa
1. Daftar melalui `/ppdb/daftar`
2. Cek status di `/ppdb/status/{nomorPendaftaran}`
3. Upload dokumen sesuai persyaratan
4. Lakukan pembayaran
5. Pantau progress verifikasi

### 2. Untuk Keuangan
1. Login ke dashboard keuangan
2. Lihat notifikasi tagihan baru di panel notifikasi
3. Verifikasi pembayaran yang masuk
4. Sistem otomatis mengirim notifikasi ke admin setelah verifikasi

### 3. Untuk Admin
1. Terima notifikasi saat ada dokumen baru
2. Verifikasi dokumen yang diupload
3. Terima notifikasi saat pembayaran sudah diverifikasi keuangan
4. Proses penerimaan siswa

## Keamanan dan Validasi

### Upload Dokumen
- Validasi jenis file (PDF, JPG, JPEG, PNG)
- Validasi ukuran maksimal 2MB
- Validasi jenis dokumen sesuai persyaratan
- Pencegahan upload duplikat per jenis dokumen

### Notifikasi
- Hanya user dengan role yang sesuai yang menerima notifikasi
- Notifikasi tersimpan di database untuk audit trail
- Job queue untuk performa yang lebih baik

### Status Tracking
- Real-time update status
- Validasi nomor pendaftaran
- Proteksi akses hanya untuk pemilik pendaftaran

## Integrasi dengan Sistem Existing

### Database
- Menggunakan tabel `notifications` yang sudah ada
- Menggunakan tabel `registration_documents` yang sudah ada
- Terintegrasi dengan sistem pembayaran existing

### Authentication
- Menggunakan sistem auth Laravel yang sudah ada
- Role-based access control
- Middleware protection

### File Storage
- Menggunakan Laravel Storage dengan disk 'public'
- File tersimpan di `storage/app/public/documents/`
- URL akses melalui `Storage::url()`

## Monitoring dan Logging

### Audit Trail
- Semua aktivitas tercatat di `audit_logs`
- Tracking user yang melakukan aksi
- Timestamp dan IP address

### Error Handling
- Try-catch pada semua operasi kritikal
- Logging error ke Laravel log
- User-friendly error messages

## Performance Optimization

### Job Queue
- Notifikasi dikirim via job queue
- Menghindari blocking request
- Scalable untuk volume tinggi

### Auto Refresh
- Status page auto-refresh setiap 30 detik
- Hanya refresh jika tidak ada modal terbuka
- Optimized untuk UX

## Fitur Tambahan

### Preview Dokumen
- Modal preview untuk gambar
- Embed PDF viewer
- Download link untuk file lainnya

### Progress Indicator
- Visual progress dengan 4 tahap
- Color-coded status
- Icon representation

### Responsive Design
- Mobile-friendly interface
- Bootstrap 5 components
- Accessible design

## Testing

### Manual Testing
1. Test upload dokumen dengan berbagai format
2. Test notifikasi flow dari pendaftaran sampai verifikasi
3. Test status tracking di berbagai tahap
4. Test role-based access

### Error Scenarios
1. Upload file dengan format tidak didukung
2. Upload file lebih dari 2MB
3. Upload dokumen duplikat
4. Akses status dengan nomor pendaftaran invalid

## Maintenance

### Regular Tasks
1. Monitor job queue untuk notifikasi
2. Cleanup file dokumen yang tidak terpakai
3. Archive notifikasi lama
4. Monitor storage usage

### Backup
1. Database backup termasuk notifikasi
2. File storage backup
3. Audit log backup