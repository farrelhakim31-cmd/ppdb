# Database Master Data PPDB

## Struktur Tabel Master Data

### 1. Gelombang Pendaftaran (`gelombang`)
- `id` - Primary key
- `nama` - Nama gelombang (Gelombang 1, Gelombang 2, dst)
- `tanggal_mulai` - Tanggal mulai pendaftaran
- `tanggal_selesai` - Tanggal selesai pendaftaran
- `biaya_pendaftaran` - Biaya pendaftaran untuk gelombang ini
- `is_active` - Status aktif gelombang

### 2. Jurusan (`jurusan`)
- `id` - Primary key
- `kode` - Kode jurusan (TKJ, RPL, MM)
- `nama` - Nama lengkap jurusan
- `deskripsi` - Deskripsi jurusan
- `kuota` - Kuota siswa per jurusan
- `is_active` - Status aktif jurusan

### 3. Tahun Ajaran (`tahun_ajaran`)
- `id` - Primary key
- `nama` - Nama tahun ajaran (2024/2025)
- `tahun_mulai` - Tahun mulai
- `tahun_selesai` - Tahun selesai
- `is_active` - Status aktif tahun ajaran

### 4. Jenis Dokumen (`jenis_dokumen`)
- `id` - Primary key
- `nama` - Nama dokumen
- `deskripsi` - Deskripsi dokumen
- `is_required` - Apakah dokumen wajib
- `format_file` - Format file yang diizinkan
- `max_size_kb` - Ukuran maksimal file (KB)
- `is_active` - Status aktif

### 5. Jenis Pembayaran (`jenis_pembayaran`)
- `id` - Primary key
- `nama` - Nama jenis pembayaran
- `deskripsi` - Deskripsi pembayaran
- `nominal` - Nominal pembayaran
- `kategori` - Kategori (pendaftaran, daftar_ulang, spp, lainnya)
- `is_active` - Status aktif

### 6. Agama (`agama`)
- `id` - Primary key
- `nama` - Nama agama
- `is_active` - Status aktif

### 7. Wilayah Administratif

#### Provinsi (`provinsi`)
- `id` - Primary key
- `kode` - Kode provinsi
- `nama` - Nama provinsi

#### Kabupaten (`kabupaten`)
- `id` - Primary key
- `kode` - Kode kabupaten
- `nama` - Nama kabupaten
- `provinsi_id` - Foreign key ke tabel provinsi

#### Kecamatan (`kecamatan`)
- `id` - Primary key
- `kode` - Kode kecamatan
- `nama` - Nama kecamatan
- `kabupaten_id` - Foreign key ke tabel kabupaten

#### Kelurahan (`kelurahan`)
- `id` - Primary key
- `kode` - Kode kelurahan
- `nama` - Nama kelurahan
- `kode_pos` - Kode pos
- `kecamatan_id` - Foreign key ke tabel kecamatan

## Relasi dengan Tabel Utama

Tabel `ppdb_registrations` memiliki relasi dengan master data:
- `gelombang_id` - Relasi ke tabel gelombang
- `jurusan_id` - Relasi ke tabel jurusan
- `tahun_ajaran_id` - Relasi ke tabel tahun_ajaran
- `agama_id` - Relasi ke tabel agama
- `provinsi_id` - Relasi ke tabel provinsi
- `kabupaten_id` - Relasi ke tabel kabupaten
- `kecamatan_id` - Relasi ke tabel kecamatan
- `kelurahan_id` - Relasi ke tabel kelurahan

## Cara Menjalankan Migration dan Seeder

```bash
# Jalankan migration
php artisan migrate

# Jalankan seeder untuk mengisi data master
php artisan db:seed --class=MasterDataSeeder

# Atau jalankan semua seeder
php artisan db:seed
```

## Model yang Tersedia

- `App\Models\Gelombang`
- `App\Models\Jurusan`
- `App\Models\TahunAjaran`
- `App\Models\JenisDokumen`
- `App\Models\JenisPembayaran`
- `App\Models\Agama`
- `App\Models\Provinsi`
- `App\Models\Kabupaten`
- `App\Models\Kecamatan`
- `App\Models\Kelurahan`

## Contoh Penggunaan

```php
// Mendapatkan semua jurusan aktif
$jurusan = Jurusan::where('is_active', true)->get();

// Mendapatkan gelombang yang sedang aktif
$gelombang = Gelombang::where('is_active', true)
    ->where('tanggal_mulai', '<=', now())
    ->where('tanggal_selesai', '>=', now())
    ->first();

// Mendapatkan kabupaten berdasarkan provinsi
$kabupaten = Kabupaten::where('provinsi_id', $provinsi_id)->get();
```