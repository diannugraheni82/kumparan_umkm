<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Event Saya - Kumparan</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { 
            --primary-blue: #0d6efd; 
            --bg-light: #f4f7fa; 
        }
        
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: var(--bg-light); 
            color: #2d3748; 
        }
        
        .card-custom { 
            border: none; 
            border-radius: 16px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.04); 
            background: #ffffff; 
        }
                
        .table thead th { 
            background-color: #f8fafc; 
            text-transform: uppercase; 
            font-size: 0.75rem; 
            letter-spacing: 0.05em; 
            color: #64748b; 
            border-top: none; 
            padding: 16px; 
        }
        
        .table tbody td { 
            padding: 16px; 
            border-bottom: 1px solid #f1f5f9; 
        }
        
        .btn-primary { 
            background: #2b6cb0; 
            border: none; 
            border-radius: 10px; 
            padding: 10px 20px; 
            font-weight: 600; 
            transition: 0.3s; 
        }
        
        .btn-primary:hover { 
            background: #1a4373; 
            transform: translateY(-1px); 
        }
        
        .badge-status { 
            font-weight: 700; 
            font-size: 0.85rem; 
        }
        
        .action-btn {
             width: 35px; 
             height: 35px; 
             display: inline-flex; 
             align-items: center; 
             justify-content: center; 
             border-radius: 8px; 
             transition: 0.2s; 
        }
        
        .action-btn:hover { 
            transform: scale(1.1); 
        }
    </style>
</head>
<body>
    <main class="container py-5">
        <div class="mb-3">
            <a href="{{ route('mitra.dashboard') }}" class="text-decoration-none small text-muted hover-primary">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
            </a>
        </div>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
            <div>
                <h3 class="fw-bold m-0">Daftar Event Saya</h3>
                <p class="text-muted small m-0">Kelola dan pantau event kolaborasi yang telah Anda publikasikan</p>
            </div>
            <a href="{{ route('mitra.events.create') }}" class="btn btn-primary shadow-sm">
                <i class="bi bi-plus-lg me-1"></i> Buat Event Baru
            </a>
        </div>

        <div class="card card-custom overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">Detail Event</th>
                            <th>Waktu Pelaksanaan</th>
                            <th>Lokasi</th>
                            <th class="text-center">Kapasitas UMKM</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($events as $event)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-dark">{{ $event->nama_event }}</div>
                                <small class="text-muted d-block mb-2">ID: #EVT-{{ $event->id }}</small>

                                <div class="mt-2">
                                    <span class="text-muted" style="font-size: 0.65rem; text-transform: uppercase; font-weight: 700;">UMKM Terdaftar:</span>
                                    <div class="d-flex flex-wrap gap-1 mt-1">
                                        @forelse($event->umkms as $umkm)
                                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 fw-normal" 
                                                style="font-size: 0.7rem; border-radius: 6px; cursor: help;"
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="top" 
                                                data-bs-html="true"
                                                title="<strong>{{ $umkm->name }}</strong><br><small>Mendaftar: {{ \Carbon\Carbon::parse($umkm->pivot->created_at)->format('d M Y') }}</small>">
                                                <i class="bi bi-shop me-1"></i>{{ Str::limit($umkm->name, 15) }}
                                            </span>
                                        @empty
                                            <span class="text-muted small italic" style="font-size: 0.7rem; font-style: italic;">Belum ada pendaftar</span>
                                        @endforelse
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="icon-shape bg-light text-primary rounded-circle me-2 p-2" style="line-height: 0;">
                                        <i class="bi bi-calendar3 small"></i>
                                    </div>
                                    <span class="small fw-600">{{ \Carbon\Carbon::parse($event->tanggal)->format('d M Y') }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-start">
                                    <i class="bi bi-geo-alt text-danger me-2 mt-1"></i>
                                    <span class="small text-muted">{{ Str::limit($event->lokasi, 35) }}</span>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="badge-status">
                                    <span class="text-primary">{{ $event->umkms_count ?? 0 }}</span>
                                    <span class="text-muted mx-1">/</span>
                                    <span class="text-dark">{{ $event->kuota }}</span>
                                </div>
                                <div class="progress mt-2" style="height: 4px; width: 80px; margin: 0 auto;">
                                    @php 
                                        $percentage = ($event->kuota > 0) ? (($event->umkms_count ?? 0) / $event->kuota) * 100 : 0; 
                                    @endphp
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $percentage }}%"></div>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="#" class="action-btn bg-info bg-opacity-10 text-info" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="#" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn bg-danger bg-opacity-10 text-danger border-0" 
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus event ini?')" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="py-5">
                                    <img src="https://illustrations.popsy.co/gray/calendar.svg" alt="empty" style="width: 120px;" class="mb-3 opacity-50">
                                    <h5 class="fw-bold">Belum Ada Event</h5>
                                    <p class="text-muted small">Anda belum mempublikasikan event kolaborasi apapun.</p>
                                    <a href="{{ route('mitra.events.create') }}" class="btn btn-outline-primary btn-sm rounded-pill px-4 mt-2">
                                        Buat Sekarang
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        })
    </script>
</body>
</html>