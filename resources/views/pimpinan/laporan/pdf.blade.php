<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .logo-left { float: left; width: 80px; }
        .logo-right { float: right; width: 80px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('assets/img/LAMBANG_KABUPATEN_KARAWANG.png') }}" class="logo-left">
        <img src="{{ public_path('assets/img/logo_disperindagkopukm.png') }}" class="logo-right">
        <h2>LAPORAN RAT KOPERASI</h2>
        <p>DISPERINDAGKOP UKM KABUPATEN KARAWANG</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Koperasi</th>
                <th>Tahun</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $rat)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $rat->nama_koperasi }}</td>
                <td>{{ $rat->tahun_buku }}</td>
                <td>{{ $rat->status_verifikasi }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>