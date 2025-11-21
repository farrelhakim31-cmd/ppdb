<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kode OTP PPDB</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #007bff; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #f8f9fa; padding: 30px; border-radius: 0 0 8px 8px; }
        .otp-box { background: white; padding: 20px; border-radius: 8px; margin: 20px 0; text-align: center; border: 2px dashed #007bff; }
        .otp-code { font-size: 32px; font-weight: bold; color: #007bff; letter-spacing: 5px; }
        .footer { text-align: center; margin-top: 30px; color: #666; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔐 Kode OTP PPDB</h1>
            <p>SMK Bakti Nusantara 666</p>
        </div>
        
        <div class="content">
            <p>Halo,</p>
            
            <p>Berikut adalah kode OTP untuk verifikasi pendaftaran PPDB Online:</p>
            
            <div class="otp-box">
                <p style="margin: 0; font-size: 14px; color: #666;">Kode OTP Anda:</p>
                <div class="otp-code"><?php echo e($otp_code); ?></div>
                <p style="margin: 10px 0 0 0; font-size: 12px; color: #999;">Berlaku selama 5 menit</p>
            </div>
            
            <p><strong>Penting:</strong></p>
            <ul>
                <li>Jangan bagikan kode ini kepada siapapun</li>
                <li>Kode akan kedaluwarsa dalam 5 menit</li>
                <li>Gunakan kode ini untuk melanjutkan proses pendaftaran</li>
            </ul>
            

        </div>
        
        <div class="footer">
            <p>SMK Bakti Nusantara 666<br>
            Jl. Raya Cileunyi, Bandung, Jawa Barat<br>
            Telp: 022-87654321</p>
        </div>
    </div>
</body>
</html><?php /**PATH C:\Users\PC-08\Farrel_ujikom\resources\views/emails/otp.blade.php ENDPATH**/ ?>