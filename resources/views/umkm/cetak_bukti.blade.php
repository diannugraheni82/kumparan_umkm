<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pencairan Modal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body { 
            font-family: 'Courier New', Courier, monospace; 
            background-color: #f4f7f6; 
        }

        .container-struk { 
            max-width: 500px; 
            margin: 30px auto; 
            background: #fff; 
            padding: 30px; 
            border: 1px solid #ddd; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.05); 
        }

        .header { 
            text-align: center; 
            border-bottom: 2px dashed #444; 
            padding-bottom: 20px; 
            margin-bottom: 20px; 
        }

        .status { 
            color: #059669; 
            font-weight: bold; 
            text-transform: uppercase; 
            border: 2px solid #059669; 
            display: inline-block; 
            padding: 5px 15px; 
            margin-top: 10px; 
            border-radius: 5px; 
        }
        
        .label { 
            color: #666; 
            width: 150px; 
        }
        
        .total { 
            font-size: 1.2em; 
            font-weight: bold; 
            background-color: #f8fafc; 
        }
        
        .footer { 
            margin-top: 30px; 
            font-size: 0.8em; 
            color: #999; 
            text-align: center; 
            border-top: 1px solid #eee; 
            pt-3; 
        }

        @media print {
            .no-print { 
                display: none; 
            }
            
            .container-struk { 
                border: none; 
                box-shadow: none; 
                margin: 0; 
                max-width: 100%; 
            }
        }
    </style>
</head>
<body>

    <div class="container-struk">
        <div class="header">
            <h2 class="fw-bold mb-1">BUKTI PENCAIRAN MODAL</h2>
            <p class="text-muted mb-2">Sistem Pembiayaan UMKM Digital</p>
            <div class="status">
                <i class="bi bi-check-circle-fill me-1"></i> Berhasil / Success
            </div>
        </div>

        <table class="table table-borderless">
            <tbody>
                <tr>
                    <td class="label">ID Transaksi</td>
                    <td class="fw-bold text-end">#PM-{{ str_pad($pinjam->id, 5, '0', STR_PAD_LEFT) }}</td>
                </tr>
                <tr>
                    <td class="label">Nama Usaha</td>
                    <td class="text-end">{{ $pinjam->umkm->nama_usaha }}</td>
                </tr>
                <tr>
                    <td class="label">Tanggal Cair</td>
                    <td class="text-end">{{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d F Y H:i') }} WIB</td>
                </tr>
                <tr>
                    <td class="label">Bank Tujuan</td>
                    <td class="text-end">{{ $pinjam->umkm->nama_bank ?? 'Bank Default' }}</td>
                </tr>
                <tr>
                    <td class="label">No. Rekening</td>
                    <td class="text-end">{{ $pinjam->umkm->nomor_rekening ?? 'XXXXXXXX' }}</td>
                </tr>
                <tr>
                    <td class="label">Jatuh Tempo</td>
                    <td class="text-end">{{ \Carbon\Carbon::parse($pinjam->tenggat_waktu)->format('d F Y') }}</td>
                </tr>
                <tr class="total">
                    <td class="label py-3">Jumlah Cair</td>
                    <td class="py-3 text-end text-primary fs-4 fw-bolder">Rp {{ number_format($pinjam->jumlah_pinjaman, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="text-center my-4">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ Request::url() }}" alt="QR Transaction">
            <p class="small text-muted mt-2" style="font-size: 10px;">Scan untuk verifikasi digital</p>
        </div>

        <div class="footer pt-3">
            <p class="mb-1">Struk ini dihasilkan secara otomatis oleh sistem dan berlaku sebagai bukti transfer yang sah dalam simulasi ini.</p>
            <p class="fw-bold text-dark">&copy; 2026 Kumparan Digital</p>
        </div>
    </div>

    <script>
        window.onload = function() {
        }
    </script>
</body>
</html>