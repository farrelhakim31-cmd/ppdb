<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pengingat Pembayaran PPDB</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #f59e0b; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #f8f9fa; padding: 30px; border-radius: 0 0 8px 8px; }
        .info-box { background: white; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #f59e0b; }
        .amount-box { background: #fff3cd; padding: 15px; border-radius: 8px; text-align: center; margin: 20px 0; }
        .footer { text-align: center; margin-top: 30px; color: #666; }
        .btn { display: inline-block; padding: 12px 24px; background: #f59e0b; color: white; text-decoration: none; border-radius: 6px; margin: 10px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⚠️ PENGINGAT PEMBAYARAN</h1>
            <h2>{{ $school_name }}</h2>
        </div>
        
        <div class="content">
            <p>Yth. <strong>{{ $name }}</strong>,</p>
            
            <p>Kami ingin mengingatkan bahwa pembayaran pendaftaran PPDB Anda <strong>belum kami terima</strong>.</p>
            
            <div class="info-box">
                <h3>Informasi Pendaftaran:</h3>
                <ul>
                    <li><strong>Nama:</strong> {{ $name }}</li>
                    <li><strong>No. Pendaftaran:</strong> {{ $registration_number }}</li>
                    <li><strong>Jurusan:</strong> {{ $major }}</li>
                </ul>
            </div>
            
            <div class="amount-box">
                <h3 style="margin: 0; color: #f59e0b;">Biaya Pendaftaran</h3>
                <h2 style="margin: 10px 0; font-size: 32px;">Rp {{ number_format($amount, 0, ',', '.') }}</h2>
            </div>
            
            <p><strong>Cara Pembayaran:</strong></p>
            <ol>
                <li>Transfer ke rekening sekolah</li>
                <li>Upload bukti pembayaran di portal PPDB</li>
                <li>Tunggu verifikasi dari bagian keuangan</li>
            </ol>
            
            <div style="text-align: center; margin: 30px 0;">
                <a href="http://127.0.0.1:8000/siswa/dashboard" class="btn">Login & Upload Bukti Bayar</a>
            </div>
            
            <p style="color: #dc2626; font-weight: bold;">⚠️ Segera lakukan pembayaran agar proses pendaftaran Anda dapat dilanjutkan!</p>
            
            <p>Jika Anda sudah melakukan pembayaran, harap abaikan email ini atau hubungi kami untuk konfirmasi.</p>
        </div>
        
        <div class="footer">
            <p>{{ $school_name }}<br>
            Jl. Raya Cileunyi, Bandung, Jawa Barat<br>
            Telp: 022-87654321<br>
            Email: info@smkbaktinusantara666.sch.id</p>
        </div>
    </div>
</body>
</html>
