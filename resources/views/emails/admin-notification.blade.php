<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Notifikasi Penerimaan Siswa Baru</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #4f46e5; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #f8f9fa; padding: 30px; border-radius: 0 0 8px 8px; }
        .info-box { background: white; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #4f46e5; }
        .info-row { display: flex; padding: 8px 0; border-bottom: 1px solid #e5e7eb; }
        .info-label { font-weight: bold; width: 180px; color: #6b7280; }
        .info-value { flex: 1; color: #111827; }
        .footer { text-align: center; margin-top: 30px; color: #666; font-size: 12px; }
        .badge { display: inline-block; padding: 4px 12px; background: #10b981; color: white; border-radius: 12px; font-size: 12px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📋 Notifikasi Penerimaan Siswa</h1>
            <p style="margin: 0;">SMK Bakti Nusantara 666</p>
        </div>
        
        <div class="content">
            <p><span class="badge">SISWA BARU DITERIMA</span></p>
            
            <p>Halo Admin,</p>
            
            <p>Siswa baru telah diterima di sistem PPDB. Berikut detail informasinya:</p>
            
            <div class="info-box">
                <h3 style="margin-top: 0; color: #4f46e5;">Informasi Siswa</h3>
                <div class="info-row">
                    <div class="info-label">Nama Siswa:</div>
                    <div class="info-value">{{ $student_name }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">No. Pendaftaran:</div>
                    <div class="info-value">{{ $registration_number }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Jurusan:</div>
                    <div class="info-value">{{ $major }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Email:</div>
                    <div class="info-value">{{ $email }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">No. Telepon:</div>
                    <div class="info-value">{{ $phone }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Waktu Penerimaan:</div>
                    <div class="info-value">{{ $accepted_at }}</div>
                </div>
                <div class="info-row" style="border-bottom: none;">
                    <div class="info-label">Diterima Oleh:</div>
                    <div class="info-value">{{ $accepted_by }}</div>
                </div>
            </div>
            
            <p style="margin-top: 20px; padding: 15px; background: #fef3c7; border-left: 4px solid #f59e0b; border-radius: 4px;">
                <strong>⚠️ Tindak Lanjut:</strong><br>
                Silakan lakukan verifikasi akhir dan hubungi siswa untuk proses daftar ulang.
            </p>
        </div>
        
        <div class="footer">
            <p>Email ini dikirim secara otomatis oleh Sistem PPDB<br>
            SMK Bakti Nusantara 666<br>
            Jl. Raya Cileunyi, Bandung, Jawa Barat</p>
        </div>
    </div>
</body>
</html>
