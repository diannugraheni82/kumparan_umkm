<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dashboard UMKM - Kumparan</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #f4f8ff;
            font-family: 'Inter', system-ui, sans-serif;
        }

        .card {
            border-radius: 1.25rem;
            border: none;
            transition: .3s;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(13, 110, 253, .15);
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #0d6efd;
        }

        .stat-gradient {
            background: linear-gradient(135deg, #0d6efd, #4f9bff);
            color: #fff;
        }

        .stat-card-body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 100%;
        }

        .badge-soft {
            background: rgba(13, 110, 253, .15);
            color: #0d6efd;
            font-weight: 600;
            border-radius: 999px;
            padding: .45rem 1rem;
        }

        .form-card {
            background: linear-gradient(135deg, #ffffff, #f1f6ff);
        }

        .form-control {
            border-radius: .75rem;
            padding: .75rem 1rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0d6efd, #4f9bff);
            border: none;
            border-radius: 999px;
            font-weight: 600;
            padding: .7rem;
        }

        .btn-primary:hover {
            box-shadow: 0 8px 20px rgba(13, 110, 253, .35);
        }

        .chart-box {
            position: relative;
            height: 260px;
        }

        .news-img {
            height: 160px;
            object-fit: cover;
            border-radius: 1rem 1rem 0 0;
        }

        .news-card .card-body {
            padding: 1rem 1.1rem;
        }

        .news-title {
            font-size: 0.95rem;
            font-weight: 600;
            color: #0d6efd;
            text-decoration: none;
        }

        .news-title:hover {
            text-decoration: underline;
        }

        .btn-bayar {
            padding: .35rem .9rem;
            font-size: .85rem;
            border-radius: 999px;
        }

        .bg-primary-subtle {
            background-color: rgba(13, 110, 253, 0.1) !important;
            color: #0d6efd !important;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0;
        }

        .navbar-umkm {
            background-color: #ffffff !important;
            border-bottom: 3px solid #0d6efd;
            padding: 12px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .brand-logo {
            font-size: 1.5rem;
            font-weight: 800;
            color: #1a202c !important;
            text-decoration: none !important;
            letter-spacing: -0.5px;
            text-transform: uppercase;
            margin-left: 50px;
        }

        .navbar-umkm .nav-link {
            color: #4a5568 !important;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none !important;
            display: flex;
            align-items: center;
            margin-right: 30px;
        }

        .navbar-umkm .nav-link:hover {
            color: #000000 !important;
        }

        .user-avatar {
            background-color: #0d6efd !important;
            color: white !important;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
            margin-right: 10px;
        }

        .dropdown-toggle::after {
            vertical-align: middle !important;
        }
    .notif-scroll::-webkit-scrollbar {
        width: 4px;
    }
    .notif-scroll::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    .notif-scroll::-webkit-scrollbar-thumb {
        background: #ced4da;
        border-radius: 10px;
    }
    .dropdown-menu {
        animation: fadeIn 0.3s ease;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-umkm sticky-top shadow-sm bg-white">
        <div class="container-fluid px-4">
            <a class="brand-logo text-decoration-none fw-bold" href="{{ route('umkm.dashboard') }}">
                KUMPARAN<span class="text-primary">.</span>
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item me-3">
                        <a class="nav-link" href="{{ url('/umkm/edit-data') }}">
                            <i class="bi bi-pencil-square me-1"></i> Edit Data
                        </a>
                    </li>

                    <li class="nav-item me-3">
                        <a class="nav-link text-nowrap" href="{{ route('umkm.semua_event') }}">
                            <i class="bi bi-calendar-event me-1"></i> Event Tersedia
                        </a>
                    </li>

                    <li class="nav-item dropdown me-3 list-unstyled">
                        <a class="nav-link position-relative" href="#" id="navbarDropdownNotif" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-bell fs-5 text-secondary"></i>
                            @if($notifikasiKerjasama->count() > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                                    {{ $notifikasiKerjasama->count() }}
                                    <span class="visually-hidden">unread messages</span>
                                </span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 py-3" aria-labelledby="navbarDropdownNotif" style="width: 350px;">
                        <li class="px-3 mb-2">
                             <h6 class="fw-bold mb-0">Permintaan Kerjasama</h6>
                        </li>
        
                <div class="notif-scroll" style="max-height: 400px; overflow-y: auto;">
                    @forelse($notifikasiKerjasama as $notif)
                        <li><hr class="dropdown-divider opacity-50"></li>
                        <li class="px-3 py-2">
                            <div class="d-flex align-items-start">
                                <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3">
                                    <i class="bi bi-briefcase text-primary"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-1 small">
                                        <span class="fw-bold">{{ $notif->mitra->name }}</span> ingin menjalin kerjasama.
                                    </p>
                                    <span class="text-muted" style="font-size: 0.75rem;">{{ $notif->created_at->diffForHumans() }}</span>
                                    
                                    <div class="d-flex gap-2 mt-2">
                                        <form action="{{ route('umkm.acc_kerjasama', $notif->id) }}" method="POST" class="flex-grow-1">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm w-100 rounded-pill" style="font-size: 0.7rem;">
                                                Terima
                                            </button>
                                        </form>

                                        <form action="{{ route('umkm.tolak_kerjasama', $notif->id) }}" method="POST" class="flex-grow-1">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger btn-sm w-100 rounded-pill" style="font-size: 0.7rem;">
                                                Tolak
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li><hr class="dropdown-divider opacity-50"></li>
                        <li class="text-center py-4">
                            <i class="bi bi-envelope-open text-muted fs-2 d-block mb-2"></i>
                            <span class="text-muted small">Tidak ada permintaan baru</span>
                        </li>
                    @endforelse
                </div>

                <li><hr class="dropdown-divider opacity-50"></li>
                <li class="text-center mt-2">
                    <a href="#" class="text-primary small text-decoration-none fw-semibold">Lihat Semua Riwayat</a>
                </li>
            </ul>
        </li>

                    <li class="nav-item dropdown list-unstyled">
                        <a class="nav-link position-relative hide-arrow" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-bell fs-5"></i>
                            @if(isset($unreadCount) && $unreadCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                                    {{ $unreadCount }}
                                </span>
                            @endif
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-0" aria-labelledby="notifDropdown" style="width: 320px; border-radius: 12px; overflow: hidden;">
                            <li class="bg-primary text-white px-3 py-2 fw-bold small">Notifikasi</li>
                            <div style="max-height: 350px; overflow-y: auto;">
                            @foreach($notifikasi as $notif)
                                <li class="px-3 py-2 border-bottom @if(!$notif->dibaca) bg-light @endif">
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold small text-dark">{{ $notif->judul }}</span>
                                        <span class="text-muted small mb-1" style="font-size: 0.8rem;">{{ $notif->pesan }}</span>
                                        
                                        @if($notif->kategori == 'kolaborasi' && $notif->status == 'pending')
                                            <div class="d-flex gap-2 mt-1 mb-1">
                                                <form action="{{ route('umkm.acc_kerjasama', $notif->id) }}" method="POST" class="flex-grow-1">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success w-100 py-1" style="font-size: 0.7rem;">Terima</button>
                                                </form>
                                                <form action="{{ route('umkm.tolak_kerjasama', $notif->id) }}" method="POST" class="flex-grow-1">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-danger w-100 py-1" style="font-size: 0.7rem;">Tolak</button>
                                                </form>
                                            </div>
                                        @endif
                                        <small class="text-muted" style="font-size: 0.65rem;">{{ $notif->created_at->diffForHumans() }}</small>
                                    </div>
                                </li>
                            @endforeach

                            {{-- Bagian Highlight Event Baru --}}
                            @if($events->count() > 0)
                                <li class="bg-light px-3 py-1 small fw-bold text-muted border-bottom">Event Terbaru</li>
                                @foreach($events->take(3) as $event) {{-- Ambil 3 event teratas --}}
                                    <li class="px-3 py-2 border-bottom">
                                        <a href="{{ route('umkm.detail_event', $event->id) }}" class="text-decoration-none d-flex align-items-center">
                                            <div class="flex-shrink-0 me-2">
                                                <i class="bi bi-megaphone-fill text-primary"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <span class="d-block fw-bold text-dark small" style="line-height: 1.2;">{{ $event->nama_event }}</span>
                                                <small class="text-muted" style="font-size: 0.7rem;">{{ \Carbon\Carbon::parse($event->tanggal_event)->format('d M') }} • {{ $event->lokasi }}</small>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            @endif

                            @if($notifikasi->isEmpty() && $events->isEmpty())
                                <li class="text-center py-4">
                                    <i class="bi bi-bell-slash text-muted d-block fs-3 mb-2"></i>
                                    <span class="text-muted small">Belum ada aktivitas</span>
                                </li>
                            @endif
                        </div>                     @if($notifikasi->count() > 0)
                                <li>
                                    <a href="#" class="dropdown-item text-center small py-2 bg-light text-primary fw-bold">Lihat Semua</a>
                                </li>
                            @endif
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center p-0" href="#" id="userDrop" data-bs-toggle="dropdown">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 36px; height: 36px; font-weight: 700; font-size: 0.875rem;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="fw-bold d-none d-md-inline">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                            <li>
                                <a class="dropdown-item py-2" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-person me-2 text-muted"></i>Profil
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger py-2">
                                        <i class="bi bi-box-arrow-right me-2"></i>Keluar
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-5">
        <div class="mb-4">
            <h3 class="fw-bold text-primary mb-1">Dashboard UMKM</h3>
            <p class="text-muted">
                Halo, <strong>{{ Auth::user()->name }}</strong> · {{ $umkm->nama_usaha }}
            </p>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card stat-gradient h-100">
                    <div class="card-body stat-card-body">
                        <small>Limit Pinjaman</small>
                        <h4 class="fw-bold mt-2">Rp {{ number_format($umkm->limit_pinjaman,0,',','.') }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body stat-card-body">
                        <small class="text-muted">Saldo Pinjaman</small>
                        <h4 class="fw-bold text-primary mt-2">Rp {{ number_format($umkm->saldo_pinjaman,0,',','.') }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body stat-card-body">
                        <small class="text-muted">Status UMKM</small>
                        <div class="mt-3">
                            <span class="badge-soft">{{ ucfirst($umkm->status) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-8">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <div class="card-title mb-3">Grafik Pencairan Modal</div>
                        <div class="chart-box">
                            <canvas id="chartPinjaman"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body d-flex flex-column justify-content-center">
                        <div class="card-title mb-3 text-center">Sisa Limit</div>
                        <div class="chart-box">
                            <canvas id="chartLimit"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card form-card shadow-sm">
                    <div class="card-body">
                        <div class="card-title mb-2">Ajukan Pinjaman Modal</div>
                        <p class="text-muted small mb-3">
                            Maksimal: <strong class="text-primary">Rp {{ number_format($maxPinjaman,0,',','.') }}</strong>
                        </p>
                        <form action="{{ route('umkm.ajukan-pinjaman') }}" method="POST">
                            @csrf
                            <input type="number" name="jumlah_modal" class="form-control mb-3" placeholder="Masukkan jumlah pinjaman" min="10000" max="{{ $maxPinjaman }}" required>
                            <button class="btn btn-primary w-100">Ajukan Sekarang</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="card-title mb-3">Riwayat Pinjaman</div>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th>Nominal</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="align-middle">
                        @forelse($riwayatPinjaman as $p)
                            <tr class="table-row-hover">
                                <td class="text-start ps-4">
                                    <div class="fw-bold text-dark">Rp {{ number_format($p->jumlah_pinjaman, 0, ',', '.') }}</div>
                                    <small class="text-muted text-uppercase" style="font-size: 0.7rem;">ID: #PYM-{{ $p->id }}</small>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                        <i class="bi bi-calendar3 text-primary"></i>
                                        <span>{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge rounded-pill {{ $p->status_pelunasan == 'lunas' ? 'bg-light-success text-success' : 'bg-light-warning text-warning' }} px-3 py-2">
                                        <i class="bi {{ $p->status_pelunasan == 'lunas' ? 'bi-check-circle-fill' : 'bi-clock-history' }} me-1"></i>
                                        {{ ucfirst(str_replace('_', ' ', $p->status_pelunasan)) }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    @if($p->status_pelunasan == 'lunas')
                                        <a href="{{ route('umkm.cetakBukti', $p->id) }}" class="btn btn-sm btn-action btn-outline-danger">
                                            <i class="bi bi-file-earmark-pdf"></i> <span class="d-none d-md-inline">PDF</span>
                                        </a>
                                    @else
                                        <a href="{{ route('umkm.bayar', $p->id) }}" class="btn btn-sm btn-action btn-primary shadow-sm">
                                            <i class="bi bi-wallet2 me-1"></i> Bayar
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <img src="https://cdn-icons-png.flaticon.com/512/4076/4076432.png" alt="Empty" style="width: 80px; opacity: 0.5;" class="mb-3">
                                    <p class="text-muted fw-medium">Belum ada riwayat pinjaman ditemukan</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold text-primary mb-0">Hot News UMKM</h5>
                <span class="badge-soft">Update Terkini</span>
            </div>
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="card shadow-sm news-card h-100">
                        <img src="https://images.unsplash.com/photo-1601597111158-2fceff292cdc" class="news-img" alt="UMKM Digital">
                        <div class="card-body">
                            <a href="https://www.google.com/search?q=UMKM+go+digital+Indonesia" target="_blank" class="news-title">UMKM Go Digital Dorong Pertumbuhan Ekonomi Lokal</a>
                            <p class="text-muted small mt-2 mb-0">Digitalisasi membantu UMKM menjangkau pasar lebih luas dan efisien.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm news-card h-100">
                        <img src="https://images.unsplash.com/photo-1591696331111-ef9586a5b17a?auto=format&fit=crop&w=900&q=80" class="news-img" alt="Modal UMKM">
                        <div class="card-body">
                            <a href="https://www.google.com/search?q=bantuan+modal+UMKM+2025" target="_blank" class="news-title">Pemerintah Perluas Akses Modal untuk UMKM</a>
                            <p class="text-muted small mt-2 mb-0">Program pembiayaan diharapkan mendorong daya saing UMKM nasional.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm news-card h-100">
                        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f" class="news-img" alt="UMKM Ekspor">
                        <div class="card-body">
                            <a href="https://www.google.com/search?q=UMKM+ekspor+Indonesia" target="_blank" class="news-title">Produk UMKM Indonesia Mulai Tembus Pasar Ekspor</a>
                            <p class="text-muted small mt-2 mb-0">Kualitas produk lokal kini mampu bersaing di pasar internasional.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            new Chart(document.getElementById('chartPinjaman'), {
                type: 'line',
                data: {
                    labels: @json($labels),
                    datasets: [{
                        data: @json($values),
                        borderColor: '#0d6efd',
                        backgroundColor: 'rgba(13,110,253,.12)',
                        fill: true,
                        tension: .4,
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true } }
                }
            });

            new Chart(document.getElementById('chartLimit'), {
                type: 'doughnut',
                data: {
                    labels: ['Terpakai', 'Sisa'],
                    datasets: [{
                        data: [
                            {{ $umkm->saldo_pinjaman }},
                            {{ $umkm->limit_pinjaman - $umkm->saldo_pinjaman }}
                        ],
                        backgroundColor: ['#0d6efd', '#cfe2ff'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: { legend: { position: 'bottom' } }
                }
            });
        });
    </script>
</body>

</html>