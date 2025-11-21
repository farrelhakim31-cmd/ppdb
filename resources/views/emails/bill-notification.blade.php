<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #f8f9fa; padding: 30px; border: 1px solid #dee2e6; }
        .bill-details { background: white; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .bill-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #eee; }
        .bill-row:last-child { border-bottom: none; }
        .label { font-weight: bold; color: #666; }
        .value { color: #333; }
        .amount { font-size: 24px; font-weight: bold; color: #007bff; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
        .btn { display: inline-block; padding: 12px 30px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Tagihan Pembayaran</h2>
            <p>SMK BAKTI NUSANTARA 666</p>
        </div>
        
        <div class="content">
            <p>Kepada Yth. <strong>{{ $bill->student->name }}</strong>,</p>
            
            <p>Kami informasikan bahwa terdapat tagihan pembayaran yang perlu diselesaikan:</p>
            
            <div class="bill-details">
                <div class="bill-row">
                    <span class="label">Keterangan:</span>
                    <span class="value">{{ $bill->description }}</span>
                </div>
                <div class="bill-row">
                    <span class="label">Jumlah Tagihan:</span>
                    <span class="amount">Rp {{ number_format($bill->amount, 0, ',', '.') }}</span>
                </div>
                <div class="bill-row">
                    <span class="label">Jatuh Tempo:</span>
                    <span class="value">{{ date('d F Y', strtotime($bill->due_date)) }}</span>
                </div>
                <div class="bill-row">
                    <span class="label">Status:</span>
                    <span class="value">
                        @if($bill->status == 'paid')
                            <span style="color: green;">Lunas</span>
                        @else
                            <span style="color: orange;">Belum Dibayar</span>
                        @endif
                    </span>
                </div>
            </div>
            
            <p>Mohon untuk segera melakukan pembayaran sebelum tanggal jatuh tempo.</p>
            
            <p style="margin-top: 30px;">Terima kasih atas perhatian dan kerjasamanya.</p>
        </div>
        
        <div class="footer">
            <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
            <p>&copy; {{ date('Y') }} SMK BAKTI NUSANTARA 666. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
