<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Tersedia - Kumparan</title>
    
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #0d6efd;
            --dark-navy: #1a365d;
            --bg-light: #f4f7fa;
            --success-green: #10b981;
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            color: #2d3748; 
        }

        .navbar-umkm {
            background: #ffffff; 
            padding: 0.8rem 2rem; 
            border-bottom: 3px solid var(--primary-blue); 
            z-index: 1060;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .brand-logo { 
            font-size: 1.25rem; 
            font-weight: 800; 
            letter-spacing: 1px; 
            color: var(--dark-navy); 
            text-decoration: none; 
        }
        
        /* Event Card Styling */
        .event-card { 
            border: none; 
            border-radius: 20px; 
            background: white;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1); 
            transition: all 0.3s ease; 
            overflow: hidden;
        }
        .event-card:hover { 
            transform: translateY(-8px); 
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .event-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #0d6efd 0%, #4f9bff 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        .event-badge {
            font-weight: 700;
            font-size: 0.65rem;
            border-radius: 20px;
            padding: 4px 12px;
            text-transform: uppercase;
        }

        .event-info {
            color: #64748b;
            font-size: 0.85rem;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 12px;
        }

        .btn-event {
            border-radius: 12px;
            font-weight: 700;
            padding: 12px 20px;
            transition: all 0.3s ease;
        }

        .btn-event-primary {
            background: linear-gradient(135deg, var(--primary-blue) 0%, #4f9bff 100%);
            color: white;
            border: none;
        }

        .progress-custom {
            height: 8px;
            border-radius: 10px;
            background: #edf2f7;
            margin-bottom: 5px;
        }

        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 20px;
            border-radius: 20px;
            margin-bottom: 40px;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-umkm sticky-top shadow-sm">
        <div class="container-fluid">
            <a class="brand-logo" href="{{ route('umkm.dashboard') }}">
                KUMPARAN<span class="text-primary">.</span>
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item me-2">
                        <a class="nav-link" href="{{ route('umkm.dashboard') }}">
                            <i class="bi bi-house me-1"></i> Dashboard
                        </a>
                    </li>
                    
                    <li class="nav-item me-2">
                        <a class="nav-link active" href="{{ route('umkm.semua_event') }}">
                            <i class="bi bi-calendar-event me-1"></i> Event Tersedia
                        </a>
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
        <div class="page-header text-center shadow-lg">
            <h2 class="fw-bold"><i class="bi bi-calendar-event me-2"></i>Event Tersedia</h2>
            <p class="mb-0">Temukan dan ikuti berbagai event menarik untuk kembangkan usaha Anda</p>
        </div>

        <div class="row g-4">
            @forelse($events as $event)
            <div class="col-md-6 col-lg-4">
                <div class="event-card h-100 shadow-sm border-0">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start mb-4">
                            <div class="event-icon me-3">
                                <i class="bi bi-rocket-takeoff"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="fw-bold mb-1 text-dark">{{ $event->nama_event }}</h5>
                                @if($event->sudah_daftar)
                                    <span class="event-badge bg-success text-white"><i class="bi bi-check2-all me-1"></i>Terdaftar</span>
                                @else
                                    <span class="event-badge bg-primary text-white text-opacity-75"><i class="bi bi-unlock me-1"></i>Tersedia</span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="event-info">
                                <i class="bi bi-calendar3 text-primary"></i>
                                <span>{{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('d F Y') }}</span>
                            </div>
                            
                            <div class="event-info">
                                <i class="bi bi-geo-alt-fill text-danger"></i>
                                <div>
                                    <span class="fw-bold text-dark d-block">Balaikota Surakarta</span>
                                    <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($event->lokasi_id) }}" 
                                       target="_blank" class="text-decoration-none small">
                                        <i class="bi bi-box-arrow-up-right me-1"></i>Buka di Maps
                                    </a>
                                </div>
                            </div>

                            <div class="event-info">
                                <i class="bi bi-people-fill text-info"></i>
                                <span>{{ $event->jumlah_pendaftar }} / {{ $event->kuota }} Peserta</span>
                            </div>
                        </div>

                        <div class="mb-4">
                            @php
                                $persentase = ($event->jumlah_pendaftar / $event->kuota) * 100;
                            @endphp
                            <div class="progress-custom">
                                <div class="progress-bar {{ $persentase >= 80 ? 'bg-danger' : ($persentase >= 50 ? 'bg-warning' : 'bg-success') }}" 
                                     style="width: {{ $persentase }}%; height: 100%;"></div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <small class="text-muted">Kapasitas</small>
                                <small class="fw-bold {{ $event->sisa_kuota <= 5 ? 'text-danger' : 'text-muted' }}">
                                    Sisa: {{ $event->sisa_kuota }} slot
                                </small>
                            </div>
                        </div>

                        @if($event->mitra)
                        <div class="p-3 bg-light rounded-3 mb-4">
                            <small class="text-muted d-block">Penyelenggara:</small>
                            <span class="fw-bold text-dark"><i class="bi bi-building me-1"></i>{{ $event->mitra->name }}</span>
                        </div>
                        @endif

                        <div class="d-grid">
                            @if($event->sudah_daftar)
                                <button class="btn btn-event btn-outline-success" disabled>
                                    <i class="bi bi-check-circle-fill me-1"></i> Anda Telah Terdaftar
                                </button>
                            @elseif($event->tersedia)
                                <form action="{{ route('umkm.daftar_event', $event->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-event btn-event-primary w-100 shadow">
                                        <i class="bi bi-plus-circle me-1"></i> Daftar Sekarang
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-event btn-secondary" disabled>
                                    <i class="bi bi-dash-circle me-1"></i> Kuota Penuh
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm text-center py-5" style="border-radius: 20px;">
                    <div class="card-body">
                        <i class="bi bi-calendar-x text-muted mb-4" style="font-size: 4rem;"></i>
                        <h4 class="fw-bold text-dark">Belum Ada Event</h4>
                        <p class="text-muted mb-4">Saat ini belum ada event baru yang dipublikasikan oleh mitra.</p>
                        <a href="{{ route('umkm.dashboard') }}" class="btn btn-primary px-4 py-2">
                            <i class="bi bi-arrow-left me-2"></i> Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>