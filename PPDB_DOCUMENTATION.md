# Sistem PPDB Online - SMK BAKTI NUSANTARA 666

## Deskripsi
Sistem Penerimaan Peserta Didik Baru (PPDB) Online adalah aplikasi web yang memungkinkan calon siswa untuk mendaftar secara online dengan mudah, cepat, dan aman.

## Fitur Utama

### 1. Halaman Pendaftaran Multi-Step
- **Step 1: Data Pribadi**
  - Nama lengkap
  - Email
  - Nomor telepon
  - Jenis kelamin
  - Tempat & tanggal lahir
  - Alamat lengkap
  - Asal sekolah

- **Step 2: Data Orang Tua/Wali**
  - Nama orang tua/wali
  - Nomor telepon orang tua
  - Pekerjaan orang tua

- **Step 3: Upload Dokumen**
  - Upload dokumen pendukung (PDF, JPG, PNG)
  - Validasi ukuran file (maksimal 2MB)
  - Preview file yang diupload

### 2. Validasi Real-time
- Validasi email format
- Validasi nomor telepon
- Validasi tanggal lahir
- Validasi nama (hanya huruf dan spasi)
- Validasi alamat (minimal 10 karakter)

### 3. Status Pendaftaran
- Cek status dengan nomor pendaftaran
- Status: Pending, Terverifikasi, Diterima, Ditolak
- Informasi lengkap data pendaftar
- Fitur cetak status

### 4. Desain Modern
- Responsive design dengan Tailwind CSS
- Animasi smooth transitions
- Progress indicator
- Loading states
- Notifikasi real-time

## Teknologi yang Digunakan

### Backend
- **Laravel 11** - PHP Framework
- **MySQL** - Database
- **Eloquent ORM** - Database abstraction

### Frontend
- **Tailwind CSS** - Utility-first CSS framework
- **Font Awesome** - Icon library
- **Vanilla JavaScript** - Form interactions dan validasi

### Fitur Keamanan
- CSRF Protection
- Input validation dan sanitization
- File upload validation
- XSS Protection

## Struktur Database

### Tabel: ppdb_registrations
```sql
- id (Primary Key)
- registration_number (Unique)
- name
- email
- phone
- birth_date
- birth_place
- gender (L/P)
- address
- school_origin
- parent_name
- parent_phone
- parent_job
- status (pending/verified/accepted/rejected)
- documents (JSON)
- verified_at
- verified_by
- created_at
- updated_at
```

## Routes

### Public Routes
- `GET /ppdb` - Halaman utama PPDB
- `GET /ppdb/register` - Form pendaftaran
- `POST /ppdb/register` - Proses pendaftaran
- `GET /ppdb/status/{registrationNumber}` - Status pendaftaran
- `POST /ppdb/check-status` - Cek status pendaftaran

### Admin Routes (Protected)
- `GET /admin/ppdb` - Dashboard admin PPDB
- `GET /admin/ppdb/{registration}` - Detail pendaftaran
- `POST /admin/ppdb/{registration}/verify` - Verifikasi berkas
- `POST /admin/ppdb/{registration}/accept` - Terima pendaftar
- `POST /admin/ppdb/{registration}/reject` - Tolak pendaftar

## File Structure

```
app/
├── Http/Controllers/
│   ├── PPDBController.php          # Controller utama PPDB
│   └── Admin/PpdbAdminController.php # Controller admin
├── Models/
│   └── PpdbRegistration.php        # Model pendaftaran
resources/views/
├── ppdb/
│   ├── index.blade.php             # Halaman utama
│   ├── register.blade.php          # Form pendaftaran
│   └── status.blade.php            # Status pendaftaran
└── layouts/
    └── app.blade.php               # Layout utama
public/
├── css/
│   └── ppdb-form.css              # CSS khusus PPDB
└── js/
    └── ppdb-form.js               # JavaScript form
```

## Instalasi dan Setup

1. **Clone Repository**
   ```bash
   git clone [repository-url]
   cd Farrel_ujikom
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Setup**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. **Storage Link**
   ```bash
   php artisan storage:link
   ```

6. **Run Application**
   ```bash
   php artisan serve
   ```

## Konfigurasi

### File Upload
- Maksimal ukuran: 2MB per file
- Format yang didukung: PDF, JPG, JPEG, PNG
- Storage: `storage/app/public/ppdb-documents/`

### Email Configuration
Update `.env` file untuk konfigurasi email:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
```

## Penggunaan

### Untuk Calon Siswa
1. Akses halaman PPDB: `/ppdb`
2. Klik "Daftar Sekarang"
3. Isi form pendaftaran step by step
4. Upload dokumen pendukung
5. Submit pendaftaran
6. Catat nomor pendaftaran
7. Cek status secara berkala

### Untuk Admin
1. Login ke sistem admin
2. Akses menu PPDB
3. Verifikasi berkas pendaftar
4. Ubah status pendaftaran
5. Generate laporan

## Fitur Keamanan

### Input Validation
- Server-side validation dengan Laravel
- Client-side validation dengan JavaScript
- Sanitasi input untuk mencegah XSS

### File Upload Security
- Validasi tipe file
- Validasi ukuran file
- Rename file untuk keamanan
- Storage di direktori yang aman

### Database Security
- Prepared statements (Eloquent ORM)
- Mass assignment protection
- Foreign key constraints

## Performance Optimization

### Frontend
- Minified CSS dan JavaScript
- Lazy loading untuk gambar
- Optimized animations
- Responsive images

### Backend
- Database indexing
- Query optimization
- Caching untuk data statis
- File compression

## Browser Support
- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

## Mobile Responsiveness
- Fully responsive design
- Touch-friendly interface
- Optimized for mobile forms
- Progressive Web App ready

## Troubleshooting

### Common Issues

1. **File Upload Error**
   - Periksa permission folder storage
   - Pastikan ukuran file tidak melebihi limit
   - Cek format file yang diupload

2. **Email Not Sending**
   - Verifikasi konfigurasi SMTP
   - Cek firewall dan port
   - Pastikan credentials benar

3. **Database Connection Error**
   - Periksa konfigurasi database di .env
   - Pastikan MySQL service berjalan
   - Cek user privileges

## Maintenance

### Regular Tasks
- Backup database harian
- Cleanup file temporary
- Monitor disk space
- Update dependencies

### Monitoring
- Log error aplikasi
- Monitor performance
- Track user activities
- Database health check

## Support
Untuk bantuan teknis, hubungi:
- Email: support@smkbaktinusantara666.sch.id
- Phone: (0711) 123-4567

## License
Copyright © 2025 SMK BAKTI NUSANTARA 666. All rights reserved.