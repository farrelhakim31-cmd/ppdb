# Troubleshooting Guide - PPDB Online

## Masalah Umum dan Solusi

### 1. Kesalahan Saat Menyimpan Data Pendaftaran

#### Penyebab Umum:
- **Cache Path Error**: Laravel tidak dapat menemukan path cache yang valid
- **Database Connection**: Masalah koneksi ke database
- **File Upload**: Masalah dengan upload dokumen
- **Validation Error**: Data tidak sesuai dengan validasi

#### Solusi:

1. **Bersihkan Cache Laravel**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   php artisan route:clear
   ```

2. **Periksa Konfigurasi Database**
   - Pastikan file `.env` memiliki konfigurasi database yang benar
   - Test koneksi database: `php artisan migrate:status`

3. **Periksa Permission Storage**
   ```bash
   php artisan storage:link
   mkdir storage/app/public/ppdb-documents
   ```

4. **Periksa Log Error**
   - Lihat file `storage/logs/laravel.log` untuk detail error
   - Aktifkan debug mode di `.env`: `APP_DEBUG=true`

### 2. Error Route Not Found

#### Penyebab:
- Route tidak terdefinisi dengan benar
- Cache route yang corrupt

#### Solusi:
```bash
php artisan route:clear
php artisan route:cache
```

### 3. Error File Upload

#### Penyebab:
- Ukuran file terlalu besar
- Format file tidak didukung
- Direktori storage tidak ada

#### Solusi:
1. Periksa konfigurasi PHP:
   - `upload_max_filesize = 2M`
   - `post_max_size = 8M`

2. Pastikan direktori ada:
   ```bash
   mkdir storage/app/public/ppdb-documents
   ```

### 4. Error Database Migration

#### Penyebab:
- Tabel sudah ada
- Kolom duplikat
- Foreign key constraint

#### Solusi:
```bash
php artisan migrate:fresh --seed
```

### 5. Error Validation

#### Penyebab:
- Data tidak sesuai dengan rules validasi
- Format data salah

#### Solusi:
- Periksa format email: harus valid email
- Periksa format telepon: hanya angka, +, -, dan spasi
- Periksa tanggal lahir: harus sebelum hari ini
- Periksa nama: hanya huruf dan spasi

## Langkah Debugging

1. **Aktifkan Debug Mode**
   ```env
   APP_DEBUG=true
   LOG_LEVEL=debug
   ```

2. **Periksa Log**
   ```bash
   tail -f storage/logs/laravel.log
   ```

3. **Test Database Connection**
   ```bash
   php artisan tinker
   DB::connection()->getPdo();
   ```

4. **Test File Upload**
   - Pastikan direktori `storage/app/public/ppdb-documents` ada
   - Periksa permission direktori

## Konfigurasi Optimal

### File .env
```env
APP_NAME="PPDB Online"
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_TIMEZONE=Asia/Jakarta
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ppdb_database
DB_USERNAME=root
DB_PASSWORD=

FILESYSTEM_DISK=local
```

### PHP Configuration
```ini
upload_max_filesize = 2M
post_max_size = 8M
max_execution_time = 300
memory_limit = 256M
```

## Kontak Support

Jika masalah masih berlanjut, hubungi tim development dengan informasi:
1. Error message lengkap
2. Langkah yang dilakukan sebelum error
3. Screenshot error (jika ada)
4. File log error