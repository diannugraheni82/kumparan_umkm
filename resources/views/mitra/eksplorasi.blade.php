<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partner Bisnis Saya</title>
        <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body { 
            background-color: #f8f9fa; 
            font-family: 'Inter', sans-serif; 
        }
        
        .card-partner { 
            transition: all 0.3s ease; 
            border-radius: 20px !important; 
        }
        
        .card-partner:hover { 
            transform: translateY(-8px); 
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1) !important; 
        }
        
        .icon-box { 
            width: 55px; 
            height: 55px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
        }
        
        .bg-success-soft { 
            background-color: #e8f5e9; 
        }
        
        .btn-sm { 
            padding: 0.5rem 1rem; 
            font-size: 0.75rem; 
        }
        
        .border-dashed { 
            border: 2px dashed #dee2e6 !important; 
        }
        
        .empty-state-container { 
            background: linear-gradient(145deg, #ffffff, #f1f1f1); 
        }
        
        .text-truncate-2 { 
            display: -webkit-box; 
            -webkit-line-clamp: 1; 
            -webkit-box-orient: vertical; 
            overflow: hidden; 
        }
    </style>
</head>
<body>

<main class="container py-5">
    <header class="mb-5 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <h4 class="fw-bold text-dark m-0">Partner Bisnis Saya</h4>
            <p class="text-muted mb-0">Daftar UMKM yang telah menyetujui kolaborasi dengan Anda</p>
        </div>
        <div class="stats-badge bg-white shadow-sm border px-3 py-2 rounded-pill d-inline-block">
            <span class="text-muted small fw-bold">Total Partner: </span>
            <span class="text-primary fw-bold">{{ $umkmsJoined->count() }}</span>
        </div>
    </header>

    <div class="row g-4">
        @forelse($umkmsJoined as $umkm)
        <div class="col-md-6 col-lg-4">
            <div class="card card-partner h-100 shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-box bg-success bg-opacity-10 p-3 rounded-circle me-3">
                            <i class="bi bi-handshake text-success fs-4"></i>
                        </div>
                        <div class="overflow-hidden">
                            <h6 class="fw-bold m-0 text-dark text-truncate-2">{{ $umkm->nama_usaha }}</h6>
                            <span class="badge rounded-pill bg-success-soft text-success border border-success border-opacity-10" style="font-size: 0.65rem;">
                                <i class="bi bi-patch-check-fill me-1"></i>VERIFIED PARTNER
                            </span>
                        </div>
                    </div>

                    <div class="info-list mb-4 bg-light p-3 rounded-3">
                        <div class="d-flex align-items-center text-muted small mb-2">
                            <i class="bi bi-calendar-check me-2 text-primary"></i>
                            <span>Terjalin: <b>{{ $umkm->pivot->created_at ? $umkm->pivot->created_at->format('d M Y') : '-' }}</b></span>
                        </div>
                        <div class="d-flex align-items-center text-muted small">
                            <i class="bi bi-briefcase me-2 text-primary"></i>
                            <span>Kategori: <b>{{ ucwords($umkm->kategori ?? 'UMKM') }}</b></span>
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col-6">
                            <a href="{{ route('mitra.umkm.show', $umkm->id) }}" class="btn btn-outline-primary btn-sm w-100 rounded-3 fw-bold">
                                <i class="bi bi-eye me-1"></i> Detail
                            </a>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-primary btn-sm w-100 rounded-3 fw-bold shadow-sm">
                                <i class="bi bi-chat-dots me-1"></i> Chat
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="empty-state-container p-5 rounded-4 border border-dashed">
                <h5 class="fw-bold text-dark">Belum Ada Partner Aktif</h5>
                <p class="text-muted mx-auto mb-4" style="max-width: 400px;">
                    Anda belum memiliki kerjasama yang disetujui. Silakan cari UMKM potensial melalui menu eksplorasi.
                </p>
                <a href="{{ route('mitra.dashboard') }}" class="btn btn-primary rounded-pill px-5 py-2 fw-bold shadow">
                    <i class="bi bi-search me-2"></i> Mulai Cari Partner
                </a>
            </div>
        </div>
        @endforelse
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>