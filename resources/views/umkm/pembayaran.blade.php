<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pembayaran</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        :root {
            --primary-blue: #2563eb;
            --dark-slate: #1e293b;
            --soft-gray: #64748b;
        }

        body {
            background-color: #f1f5f9;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }

        .payment-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .payment-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.08);
            border: none;
            width: 100%;
            max-width: 450px;
            padding: 40px;
        }

        .icon-circle {
            width: 72px;
            height: 72px;
            background: #eff6ff;
            color: var(--primary-blue);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
        }

        .order-summary-box {
            background-color: #f8fafc;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 32px;
            border: 1px solid #e2e8f0;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 0.9rem;
        }

        .summary-label { color: var(--soft-gray); }
        .summary-value { color: var(--dark-slate); font-weight: 600; }

        .divider {
            border-top: 2px dashed #e2e8f0;
            margin: 16px 0;
        }

        .total-label { font-weight: 700; color: var(--dark-slate); }
        .total-amount { font-weight: 800; color: var(--primary-blue); font-size: 1.5rem; }

        .btn-pay-now {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            border: none;
            padding: 16px;
            border-radius: 14px;
            font-weight: 700;
            width: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .btn-pay-now:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37, 99, 235, 0.4);
            color: white;
        }

        .btn-cancel {
            color: var(--soft-gray);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            display: block;
            text-align: center;
            margin-top: 16px;
            transition: color 0.2s;
        }

        .btn-cancel:hover { color: #ef4444; }

        .security-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 32px;
            font-size: 0.75rem;
            color: var(--soft-gray);
        }
    </style>
</head>
<body>

    <div class="payment-wrapper">
        <div class="payment-card">
            <div class="text-center">
                <div class="icon-circle">
                    <i class="bi bi-wallet2 fs-2"></i>
                </div>
                <h4 class="fw-bold text-dark">Konfirmasi Bayar</h4>
                <p class="text-muted small mb-4">Pastikan nominal sesuai dengan tagihan Anda</p>
            </div>

            <div class="order-summary-box">
                <div class="summary-row">
                    <span class="summary-label">ID Pinjaman</span>
                    <span class="summary-value">#{{ $pinjaman->id }}</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Pengguna</span>
                    <span class="summary-value">{{ Auth::user()->name }}</span>
                </div>
                
                <div class="divider"></div>
                
                <div class="d-flex justify-content-between align-items-center">
                    <span class="total-label">Total Tagihan</span>
                    <span class="total-amount">Rp {{ number_format($pinjaman->jumlah_pinjaman, 0, ',', '.') }}</span>
                </div>
            </div>

            <button id="pay-button" class="btn-pay-now">
                <i class="bi bi-shield-lock-fill me-2"></i> Bayar Sekarang
            </button>
            
            <a href="{{ route('umkm.dashboard') }}" class="btn-cancel">
                Batal dan Kembali
            </a>

            <div class="security-badge">
                <i class="bi bi-patch-check-fill text-success"></i>
                Securely processed by <strong>Midtrans</strong>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    
    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    window.location.href = "{{ route('umkm.pembayaranSukses', $pinjaman->id) }}";
                },
                onPending: function(result) {
                    alert("Silahkan selesaikan pembayaran sesuai petunjuk di QR Code/VA.");
                    window.location.href = "{{ route('umkm.dashboard') }}";
                },
                onError: function(result) {
                    window.location.href = "{{ route('umkm.dashboard') }}?status=error";
                },
                onClose: function() {
                    alert('Pembayaran dibatalkan oleh pengguna.');
                }
            });
        });
    </script>
</body>
</html>