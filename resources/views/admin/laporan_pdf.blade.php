<!DOCTYPE html>
<html>
<head>
    <title>Laporan Dashboard Admin</title>
    <style>
        body { 
            font-family: sans-serif; 
            font-size: 12px; 
        }
        .header { 
            text-align: center; 
            margin-bottom: 30px; 
        }
        .table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 20px; 
        }
        .table th, .table td { 
            border: 1px solid #ddd; 
            padding: 8px; 
            text-align: left; 
        }
        .table th { 
            background-color: #f2f2f2; 
        }
        .summary-box { 
            padding: 10px; 
            background: #e9ecef; 
            margin-bottom: 20px; 
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN DATA SISTEM UMKM</h2>
        <p>Periode: {{ $periode }}</p>
    </div>

    <div class="summary-box">
        <strong>Ringkasan Statistik:</strong>
        <ul>
            <li>Total UMKM: {{ $totalUmkm }}</li>
            <li>Total Mitra: {{ $totalMitra }}</li>
            <li>Total Dana Keluar: Rp{{ number_format($totalUangKeluar, 0, ',', '.') }}</li>
            <li>Total Dana Dibayarkan: Rp{{ number_format($totalDanaMasuk, 0, ',', '.') }}</li>
        </ul>
    </div>

    <h3>Daftar Mitra</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Nama Mitra</th>
                <th>Email</th>
                <th>Tanggal Bergabung</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mitraList as $mitra)
            <tr>
                <td>{{ $mitra->name }}</td>
                <td>{{ $mitra->email }}</td>
                <td>{{ $mitra->created_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Daftar UMKM</h3>
    <table border="1" width="100%" cellpadding="5">
        <thead>
            <tr>
                <th>Nama UMKM</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Saldo Pinjaman</th>
            </tr>
        </thead>
        <tbody>
            @forelse($umkmList as $u)
            <tr>
                <td>{{ $u->nama_usaha }}</td>
                <td>{{ $u->kategori }}</td>
                <td>{{ $u->status }}</td>
                <td>Rp{{ number_format($u->saldo_pinjaman, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" align="center">Data Tidak Tersedia</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>