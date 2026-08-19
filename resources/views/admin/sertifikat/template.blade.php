<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat Pemeriksaan Kesehatan Koperasi</title>
    <style>
        /* Pengaturan Ukuran Kertas A4 Portrait - Mencegah halaman kosong berlebih */
        @page {
            size: A4 portrait;
            margin: 0;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #000000;
            margin: 0;
            padding: 0;
            font-size: 14px;
        }

        .page-container {
            position: relative;
            width: 210mm;
            height: 297mm;
            overflow: hidden;
        }

        /* Memaksa halaman 1 selesai dan lanjut ke halaman 2 secara bersih */
        .page-break {
            page-break-after: always;
            break-after: page;
        }

        .bg-template {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        /* Styling Posisi Teks Dinamis */
        .text-overlay {
            position: absolute;
            font-weight: bold;
            font-size: 14px;
            z-index: 10;
        }

        /* 
           KALIBRASI AKHIR PRESISI HALAMAN 1 (Sertifikat):
           - Nama Koperasi diturunkan sedikit lagi (top: 360px) agar pas presisi.
        */
        .pos-nama       { top: 360px; left: 320px; font-size: 15px; }
        .pos-nomor-bh   { top: 388px; left: 320px; font-size: 15px; }
        .pos-alamat     { top: 418px; left: 320px; width: 320px; line-height: 1.3; font-size: 13px; font-weight: normal; }
        
        .pos-nilai      { top: 474px; left: 320px; font-size: 15px; }
        .pos-kategori   { top: 504px; left: 320px; font-size: 15px; color: #b3261e; }

        /* Koordinat Halaman 2 (Lampiran - Data Skor dikosongkan) */
        .pos-skor-1     { top: 212px; left: 565px; text-align: center; width: 60px; }
        .pos-skor-2     { top: 256px; left: 565px; text-align: center; width: 60px; }
        .pos-skor-3     { top: 300px; left: 565px; text-align: center; width: 60px; }
        .pos-skor-4     { top: 344px; left: 565px; text-align: center; width: 60px; }
        .pos-total-skor { top: 395px; left: 565px; text-align: center; width: 60px; font-size: 15px; }
    </style>
</head>
<body>

    <!-- ================= HALAMAN 1 : SERTIFIKAT ================= -->
    <div class="page-container page-break">
        <img src="{{ public_path('assets/img/sertifikat_bg.png.png') }}" class="bg-template" alt="Sertifikat Background">

        <div class="text-overlay pos-nama">{{ $koperasi->nama_koperasi ?? '-' }}</div>
        <div class="text-overlay pos-nomor-bh">{{ $koperasi->no_badan_hukum ?? '-' }}</div>
        <div class="text-overlay pos-alamat">{{ $koperasi->alamat ?? '-' }}</div>
        <div class="text-overlay pos-nilai">{{ $pemkes->skor_pemkes ?? '-' }}</div>
        <div class="text-overlay pos-kategori">{{ strtoupper($pemkes->status_kesehatan ?? '-') }}</div>
    </div>

    <!-- ================= HALAMAN 2 : LAMPIRAN ================= -->
    <div class="page-container">
        <img src="{{ public_path('assets/img/lampiran_bg.png.png') }}" class="bg-template" alt="Lampiran Background">

        <!-- Data skor dikosongkan sesuai permintaan -->
        <div class="text-overlay pos-skor-1"></div>
        <div class="text-overlay pos-skor-2"></div>
        <div class="text-overlay pos-skor-3"></div>
        <div class="text-overlay pos-skor-4"></div>
        <div class="text-overlay pos-total-skor"></div>
    </div>

</body>
</html>