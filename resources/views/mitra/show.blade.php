<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail UMKM - {{ $umkm->nama_usaha }}</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f4f7fa;
            color: #2d3748;
        }
        .card-detail {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        .card-header-custom {
            background: linear-gradient(45deg, #0d6efd, #004fb0);
            color: white;
            padding: 2rem;
            border: none;
        }
        .info-label {
            font-weight: 700;
            color: #4a5568;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 1px;
            margin-bottom: 5px;
            display: block;
        }
        .info-content {
            background: #f8fafc;
            padding: 15px;
            border-radius: 12px;
            border-left: 4px solid #0d6efd;
            margin-bottom: 20px;
        }
        .btn-back {
            border-radius: 10px;
            padding: 10px 25px;
            font-weight: 600;
            transition: 0.3s;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                <div class="card card-detail">
                    <div class="card-header-custom text-center">
                        <i class="bi bi-shop fs-1 mb-3"></i>
                        <h2 class="fw-bold mb-0">{{ $umkm->nama_usaha }}</h2>
                        <span class="badge bg-white text-primary mt-2">Profil Terverifikasi</span>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <div class="row">
                            <div class="col-12 mb-4">
                                <span class="info-label"><i class="bi bi-info-circle me-2"></i>Deskripsi Usaha</span>
                                <div class="info-content">
                                    {{ $umkm->deskripsi }}
                                </div>
                            </div>

                            <div class="col-12 mb-4">
                                <span class="info-label"><i class="bi bi-geo-alt me-2"></i>Alamat Lengkap</span>
                                <div class="info-content">
                                    {{ $umkm->alamat_usaha }}
                                </div>
                            </div>

                            <div class="col-12 mb-4">
                                <span class="info-label"><i class="bi bi-images me-2"></i>Portfolio Produk</span>
                                <div class="row g-3 mt-1">
                                    @if($umkm->portfolio_produk && count($umkm->portfolio_produk) > 0)
                                        @foreach($umkm->portfolio_produk as $produk)
                                            <div class="col-md-4 col-6">
                                                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                                                    @if(isset($produk['foto']))
                                                        <img src="{{ asset('storage/' . $produk['foto']) }}" 
                                                            class="card-img-top" 
                                                            alt="{{ $produk['nama'] }}"
                                                            style="height: 150px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-light d-flex align-items-center justify-content-center" style="height: 150px;">
                                                            <i class="bi bi-image text-muted fs-1"></i>
                                                        </div>
                                                    @endif
                                                    <div class="card-body p-2 text-center">
                                                        <h6 class="fw-bold mb-1 small">{{ $produk['nama'] }}</h6>
                                                        <p class="text-muted mb-0" style="font-size: 0.7rem;">{{ \Illuminate\Support\Str::limit($produk['detail'], 40) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-12">
                                            <div class="alert alert-light border-dashed text-center">
                                                <i class="bi bi-box2 text-muted me-2"></i> Belum ada foto produk yang diunggah.
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div> 
                    <div class="d-grid gap-2 d-md-flex justify-content-md-between align-items-center mt-4">
                        <a href="{{ route('mitra.dashboard') }}" class="btn btn-secondary btn-back shadow-sm">
                            <i class="bi bi-arrow-left me-2"></i>Kembali
                        </a>
                        <button onclick="ajukanKerjasama()" class="btn btn-primary btn-back shadow-sm">
                            <i class="bi bi-chat-dots me-2"></i>Ajukan Kerjasama
                        </button>
                    </div>
                </div>

                <p class="text-center text-muted mt-4 small">
                    &copy; 2026 KUMPARAN. - Sistem Pemberdayaan UMKM Digital
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function ajukanKerjasama() {
        Swal.fire({
            title: 'Ajukan Kerjasama?',
            text: "Sistem akan mengirim notifikasi ke UMKM dan membuka WhatsApp",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#0d6efd',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hubungi!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                prosesKirimAJAX();
            }
        });
    }

    function prosesKirimAJAX() {
        Swal.fire({
            title: 'Menghubungkan...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        fetch("{{ route('mitra.ajukan.kerjasama', $umkm->id) }}", { 
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json",
                "Accept": "application/json"
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            Swal.close(); 
            
            if (data.success) {
                const pesan = `Halo ${data.nama_umkm}, saya dari Mitra ${data.nama_mitra} tertarik untuk mengajukan kerjasama dengan usaha Anda.`;
                
                let phone = data.no_wa.replace(/[^0-9]/g, '');
                if (phone.startsWith('0')) {
                    phone = '62' + phone.substring(1);
                }
                
                const linkWa = `https://api.whatsapp.com/send?phone=${phone}&text=${encodeURIComponent(pesan)}`;
                
                window.open(linkWa, '_blank');
            } else {
                Swal.fire('Gagal', data.message || 'Tidak dapat memproses permintaan', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Terjadi kesalahan koneksi atau server', 'error');
        });
    }
    </script>
</body>
</html>