<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mitra - Kumparan</title>
    
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-blue: #0d6efd;
            --dark-navy: #1a365d;
            --bg-light: #f4f7fa;
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: var(--bg-light); 
            color: #2d3748; 
        }

        .navbar-mitra { 
            background: #ffffff; 
            padding: 0.8rem 2rem; 
            border-bottom: 3px solid var(--primary-blue); 
            z-index: 1060;
        }
        .brand-logo { 
            font-size: 1.25rem; 
            font-weight: 800; 
            letter-spacing: 1px; 
            color: var(--dark-navy); 
            text-decoration: none; 
        }
        .navbar-mitra .nav-link { 
            color: #4a5568 !important; 
            font-weight: 600; 
            transition: 0.2s; 
            font-size: 0.9rem;
        }
        .navbar-mitra .nav-link:hover, .navbar-mitra .nav-link.active { 
            color: var(--primary-blue) !important; 
        }

        /* Card Styling */
        .card-umkm { 
            border: none; 
            border-radius: 20px; 
            background: white;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05); 
            transition: 0.3s; 
            border: 1px solid rgba(0,0,0,0.03); 
        }
        .card-umkm:hover { transform: translateY(-5px); }

        .btn-mitra { 
            background: #2b6cb0; 
            color: white; 
            border-radius: 12px; 
            font-weight: 600; 
            padding: 8px 24px;
            border: none; 
            transition: 0.3s; 
        }
        .btn-mitra:hover { background: #2c5282; color: white; }

        .performa-chart { height: 8px; border-radius: 10px; background: #edf2f7; overflow: hidden; }
        .badge-validated { background: #c6f6d5; color: #22543d; font-weight: 700; font-size: 0.7rem; border-radius: 8px; padding: 4px 8px; }
        .hide-arrow::after { display: none !important; }
        
        .dropdown-menu { 
            border-radius: 12px; 
            border: none; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important; 
            padding: 0.5rem;
        }
        .dropdown-item {
            border-radius: 8px;
            padding: 0.6rem 1rem;
            font-size: 0.85rem;
            font-weight: 500;
        }

        /* Search Bar Style */
        .search-container {
            background: white;
            border-radius: 15px;
            padding: 10px 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            border: 1px solid rgba(0,0,0,0.05);
        }
        .search-input {
            border: none;
            outline: none;
            width: 100%;
            padding: 8px;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-mitra sticky-top shadow-sm">
        <div class="container-fluid">
            <a class="brand-logo" href="/mitra/dashboard">
                KUMPARAN<span class="text-primary">.</span>
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    
                    <li class="nav-item me-2">
                        <a class="nav-link {{ request()->is('mitra/eksplorasi*') ? 'active' : '' }}" href="{{ route('mitra.eksplorasi') }}">
                            <i class="bi bi-people me-1"></i> Partner Saya
                        </a>
                    </li>

                    <li class="nav-item dropdown me-2">
                        <a class="nav-link dropdown-toggle {{ request()->is('mitra/events*') ? 'active' : '' }}" href="#" id="eventDrop" data-bs-toggle="dropdown">
                            <i class="bi bi-calendar-event me-1"></i> Event Saya
                        </a>
                        <ul class="dropdown-menu shadow">
                            <li>
                                <a class="dropdown-item" href="{{ route('mitra.events.create') }}">
                                    <i class="bi bi-plus-circle me-2"></i>Buat Event Baru
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('mitra.events.index') }}">
                                    <i class="bi bi-card-list me-2"></i>Daftar Event
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown me-3">
                        <a class="nav-link dropdown-toggle hide-arrow position-relative p-0" href="#" id="notifDropdown" data-bs-toggle="dropdown">
                            <i class="bi bi-bell fs-5"></i>
                            @if($unreadCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                                    {{ $unreadCount }}
                                </span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end p-0 overflow-hidden" style="width: 300px;">
                            <li class="bg-light px-3 py-2 fw-bold border-bottom small">Notifikasi</li>
                            <div style="max-height: 300px; overflow-y: auto;">
                                @forelse($notifikasi as $notif)
                                    <li>
                                        <a class="dropdown-item py-2 border-bottom small {{ !$notif->dibaca ? 'bg-light' : '' }}" href="#">
                                            <div class="fw-bold">{{ $notif->judul }}</div>
                                            <div class="text-muted text-wrap">{{ Str::limit($notif->pesan, 45) }}</div>
                                        </a>
                                    </li>
                                @empty
                                    <li class="text-center py-4 text-muted small">Tidak ada notifikasi</li>
                                @endforelse
                            </div>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center p-0" href="#" id="userDrop" data-bs-toggle="dropdown">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-weight: 700; font-size: 0.8rem;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="fw-bold d-none d-md-inline">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i>Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Keluar</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <header class="mb-4 text-center">
                    <h4 class="fw-bold text-dark m-0">Eksplorasi UMKM Terverifikasi</h4>
                    <p class="text-muted">Cari dan ajukan kolaborasi dengan UMKM yang telah dikurasi oleh Admin</p>
                </header>

                <div class="mb-5">
                    <form action="{{ route('mitra.dashboard') }}" method="GET">
                        <div class="search-container d-flex align-items-center">
                            <i class="bi bi-search text-primary fs-5 me-2"></i>
                            <input type="text" name="search" class="search-input" placeholder="Cari UMKM berdasarkan nama atau kategori bisnis..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-primary rounded-3 px-4 ms-2">Cari</button>
                        </div>
                    </form>
                </div>

                <div class="row g-4">
                    @forelse($umkms as $umkm)
                    <div class="col-md-6 col-xl-4">
                        <div class="card card-umkm h-100">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="bg-primary bg-opacity-10 p-3 rounded-3">
                                        <i class="bi bi-shop fs-3 text-primary"></i>
                                    </div>
                                    <span class="badge badge-validated">
                                        <i class="bi bi-patch-check-fill me-1"></i>TERVERIFIKASI
                                    </span>
                                </div>
                                <h5 class="fw-bold mb-1">{{ $umkm->nama_usaha }}</h5>
                                <p class="text-muted small mb-3">
                                    <i class="bi bi-geo-alt me-1"></i>{{ $umkm->alamat_usaha ?? 'Lokasi tidak tersedia' }}
                                </p>

                                <div class="mb-4">
                                    <div class="d-flex justify-content-between small mb-1">
                                        <span class="text-muted">Kelengkapan Data</span>
                                        <span class="fw-bold text-primary">85%</span>
                                    </div>
                                    <div class="performa-chart">
                                        <div class="progress-bar bg-primary" style="width: 85%; height: 100%"></div>
                                    </div>
                                </div>

                                <div class="d-grid gap-2">
                                    <a href="{{ route('mitra.umkm.show', $umkm->id) }}" class="btn btn-mitra">
                                        Lihat Profil
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-5 bg-white rounded-4 shadow-sm border">
                        <div class="py-5">
                            <i class="bi bi-search fs-1 text-muted opacity-25"></i>
                            <h5 class="mt-3 fw-bold text-dark">Tidak Ada Hasil</h5>
                            <p class="text-muted">Maaf, saat ini belum ada UMKM yang dapat kami tampilkan.</p>
                            <a href="{{ route('mitra.dashboard') }}" class="btn btn-primary mt-2">Reset Pencarian</a>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>