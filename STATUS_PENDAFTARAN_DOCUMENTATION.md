# Dokumentasi Sistem Status Pendaftaran PPDB

## Overview
Sistem status pendaftaran telah diperbarui untuk memberikan tracking yang lebih detail dan transparan kepada siswa mengenai progress pendaftaran mereka.

## Status Timeline
Berikut adalah alur status pendaftaran yang baru:

1. **Draft** - Status awal ketika siswa baru mendaftar
2. **Dikirim** - Ketika data dan dokumen sudah lengkap
3. **Verifikasi Administrasi** - Sedang diverifikasi oleh admin
4. **Menunggu Pembayaran** - Menunggu pembayaran dari siswa
5. **Terbayar** - Pembayaran sudah diterima
6. **Verifikasi Keuangan** - Pembayaran sedang diverifikasi keuangan
7. **Lulus** - Diterima di sekolah
8. **Tidak Lulus** - Tidak diterima
9. **Cadangan** - Masuk daftar cadangan

## Auto Status Update
Sistem akan otomatis mengupdate status berdasarkan kondisi:

- **Draft → Dikirim**: Ketika data pribadi lengkap dan minimal 3 dokumen terupload
- **Dikirim → Menunggu Pembayaran**: Ketika pembayaran diupload (status pending)
- **Menunggu Pembayaran → Terbayar**: Ketika pembayaran diverifikasi (status paid)

## Perubahan Database
- Migration: `2025_01_22_000005_update_ppdb_registration_status_enum.php`
- Seeder: `UpdatePpdbStatusSeeder.php` untuk update data existing

## Model Methods
- `getStatusLabel()`: Mendapatkan label status dalam bahasa Indonesia
- `getStatusColor()`: Mendapatkan warna Bootstrap untuk status
- `getStatusTimeline()`: Mendapatkan timeline status untuk UI
- `updateStatusBasedOnConditions()`: Auto update status berdasarkan kondisi

## View Updates
- File: `resources/views/student/status.blade.php`
- Menampilkan timeline visual status pendaftaran
- Responsive design dengan animasi
- Action buttons yang contextual berdasarkan status

## Controller Updates
- File: `app/Http/Controllers/PPDBController.php`
- Default status pendaftaran: 'draft'
- Auto status update saat upload dokumen dan pembayaran

## CSS Features
- Timeline visual dengan icons dan connectors
- Pulse animation untuk status aktif
- Responsive design untuk mobile
- Hover effects dan smooth transitions