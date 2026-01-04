<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->nama_event }}</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #f4f8ff;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #2d3748;
        }

        .container {
            max-width: 800px; 
        }

        .card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
        }

        .event-header-img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            background: linear-gradient(135deg, #0d6efd, #4f9bff);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .info-badge {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .info-badge i {
            font-size: 1.2rem;
            color: #0d6efd;
            margin-right: 10px;
        }

        .description-text {
            line-height: 1.8;
            color: #4a5568;
            white-space: pre-line; 
        }

        .btn-back {
            border-radius: 999px;
            padding: 10px 25px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-register {
            background: linear-gradient(135deg, #0d6efd, #4f9bff);
            border: none;
            border-radius: 999px;
            padding: 10px 30px;
            font-weight: 600;
        }

        .btn-register:hover {
            box-shadow: 0 8px 20px rgba(13, 110, 253, 0.3);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

    <div class="container py-5">
        <div class="card shadow-lg">
            <div class="event-header-img">
                <i class="bi bi-calendar-check" style="font-size: 5rem;"></i>
            </div>

            <div class="card-body p-4 p-md-5">
                <nav aria-label="breadcrumb" class="mb-3">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('umkm.dashboard') }}" class="text-decoration-none text-primary">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('umkm.event') }}" class="text-decoration-none text-primary">Event</a></li>        
                    </ol>
                </nav>

                <h2 class="fw-bold text-dark mb-4">{{ $event->nama_event }}</h2>

                <div class="row info-badge g-0">
                    <div class="col-md-6 mb-2 mb-md-0 d-flex align-items-center">
                        <i class="bi bi-calendar3"></i>
                        <div>
                            <small class="text-muted d-block">Tanggal Pelaksanaan</small>
                            <span class="fw-bold">{{ \Carbon\Carbon::parse($event->tanggal_event)->format('d F Y') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex align-items-center">
                        <i class="bi bi-geo-alt"></i>
                        <div>
                            <small class="text-muted d-block">Lokasi</small>
                            <span class="fw-bold">{{ $event->lokasi }}</span>
                        </div>
                    </div>
                </div>

                <h5 class="fw-bold mb-3">Deskripsi Event</h5>
                <p class="description-text mb-5">
                    {{ $event->deskripsi }}
                </p>

                <hr class="mb-4">

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <a href="{{ route('umkm.event') }}" class="btn btn-outline-secondary btn-back">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                    
                    <form action="{{ route('umkm.daftar_event', $event->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-register px-4">
                            <i class="bi bi-pencil-square me-2"></i>Daftar Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>