<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Penerimaan Siswa Baru</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #28a745; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #f8f9fa; padding: 30px; border-radius: 0 0 8px 8px; }
        .info-box { background: white; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .footer { text-align: center; margin-top: 30px; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 SELAMAT!</h1>
            <h2>Anda Diterima di <?php echo e($school_name); ?></h2>
        </div>
        
        <div class="content">
            <p>Yth. <strong><?php echo e($name); ?></strong>,</p>
            
            <p>Dengan bangga kami informasikan bahwa Anda telah <strong>DITERIMA</strong> sebagai siswa baru di <?php echo e($school_name); ?>.</p>
            
            <div class="info-box">
                <h3>Informasi Pendaftaran:</h3>
                <ul>
                    <li><strong>Nama:</strong> <?php echo e($name); ?></li>
                    <li><strong>No. Pendaftaran:</strong> <?php echo e($registration_number); ?></li>
                    <li><strong>Jurusan:</strong> <?php echo e($major); ?></li>
                </ul>
            </div>
            
            <p><strong>Langkah Selanjutnya:</strong></p>
            <ol>
                <li>Lakukan daftar ulang sesuai jadwal yang ditentukan</li>
                <li>Siapkan dokumen yang diperlukan</li>
                <li>Hubungi sekolah untuk informasi lebih lanjut</li>
            </ol>
            
            <p>Selamat bergabung dengan keluarga besar <?php echo e($school_name); ?>!</p>
        </div>
        
        <div class="footer">
            <p><?php echo e($school_name); ?><br>
            Jl. Raya Cileunyi, Bandung, Jawa Barat<br>
            Telp: 022-87654321</p>
        </div>
    </div>
</body>
</html><?php /**PATH C:\Users\PC-08\Farrel_ujikom\resources\views/emails/acceptance.blade.php ENDPATH**/ ?>