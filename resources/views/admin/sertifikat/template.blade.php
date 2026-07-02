<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        @page { size: A4 landscape; margin: 10px; }
        body { font-family: 'Helvetica', sans-serif; color: #022c22; margin: 0; padding: 0; }
        .border-container { 
            border: 8px solid #008f5d; 
            padding: 20px; 
            height: 550px; /* Dibatasi agar pas satu halaman */
            position: relative;
        }
        .header { text-align: center; margin-bottom: 20px; }
        .title { font-size: 32px; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; color: #008f5d; margin-bottom: 5px; }
        .subtitle { font-size: 16px; font-weight: 600; margin-bottom: 20px; }
        .recipient { font-size: 24px; font-weight: 800; border-bottom: 2px solid #008f5d; display: inline-block; padding-bottom: 2px; margin: 10px 0; }
        .content { margin-top: 10px; line-height: 1.4; text-align: center; }
        .badge { 
            margin-top: 20px; 
            font-size: 18px; 
            font-weight: 800; 
            background-color: #008f5d; 
            color: white; 
            padding: 8px 15px; 
            display: inline-block; 
            border-radius: 8px;
        }
        .footer { margin-top: 30px; text-align: right; width: 95%; }
    </style>
</head>
<body>
    <div class="border-container">
        <div class="header">
            <div class="title">Sertifikat Kesehatan Koperasi</div>
            <div class="subtitle">Dinas Koperasi dan UKM Karawang</div>
        </div>

        <div class="content">
            <p style="margin: 5px;">Dengan ini menyatakan bahwa:</p>
            <div class="recipient">{{ $nama }}</div>
            <p style="margin: 5px;">Telah dilakukan penilaian kesehatan koperasi dengan hasil:</p>
            
            <div class="badge">STATUS: {{ strtoupper($status) }}</div>
            <p style="font-size: 16px; margin-top: 15px;">
                Dengan total skor penilaian: <strong>{{ $skor }}</strong>
            </p>
        </div>

        <div class="footer">
            <p style="margin: 2px;">Karawang, {{ $tanggal }}</p>
            <br><br><br><br>
            <p style="margin: 2px;"><strong>Kepala Dinas Koperasi & UKM</strong></p>
        </div>
    </div>
</body>
</html>