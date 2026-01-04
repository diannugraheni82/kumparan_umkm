<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Event - KUMPARAN</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root { 
            --primary-blue: #1e40af; 
            --accent-blue: #3b82f6; 
            --soft-blue: #dbeafe; 
        }
        body { 
            background-color: #f8fafc; 
            font-family: sans-serif; 
        }
        .card { 
            border-radius: 16px; 
            border: 1px solid var(--soft-blue); 
        }
        .text-blue-primary { 
            color: var(--primary-blue) !important; 
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="mb-4">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-light border">
                <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card shadow-sm p-4 h-100 bg-white">
                    <div class="badge bg-primary bg-opacity-10 text-primary mb-3 px-3 py-2 rounded-pill d-inline-block" style="width: fit-content;">
                        Detail Informasi Event
                    </div>
                    <h2 class="fw-bold text-dark mb-4">{{ $event->nama_event }}</h2>
                    
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-calendar3 fs-4 text-blue-primary me-3"></i>
                                <div>
                                    <small class="text-muted d-block">Tanggal Pelaksanaan</small>
                                    <span class="fw-bold">{{ \Carbon\Carbon::parse($event->tanggal)->format('d F Y') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-geo-alt fs-4 text-danger me-3"></i>
                                <div>
                                    <small class="text-muted d-block">Lokasi</small>
                                    <span class="fw-bold">{{ $event->lokasi }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-people fs-4 text-success me-3"></i>
                                <div>
                                    <small class="text-muted d-block">Maksimal Kuota</small>
                                    <span class="fw-bold">{{ $event->kuota }} UMKM</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm p-4 bg-white">
                    <h6 class="fw-bold text-blue-primary mb-3">Pendaftar Terkini</h6>
                    <hr class="mt-0">
                    <ul class="list-unstyled mb-0">
                        @forelse($pendaftar as $p)
                            <li class="mb-3 d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-bold small">{{ $p->name }}</div>
                                    <small class="text-muted" style="font-size: 0.7rem;">{{ $p->created_at }}</small>
                                </div>
                                <i class="bi bi-check-circle-fill text-success"></i>
                            </li>
                        @empty
                            <li class="text-center py-4 text-muted small">Belum ada pendaftar</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>