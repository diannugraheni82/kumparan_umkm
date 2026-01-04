<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi UMKM - Admin</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <style>
        body { 
            background-color: #f4f7f6; 
            font-family: 'Inter', sans-serif; 
        }
        .card { 
            border: none; 
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); 
        }
        .table thead th { 
            background-color: #f8f9fa; 
            text-transform: uppercase; 
            font-size: 0.8rem; 
            letter-spacing: 0.05em; 
            color: #6c757d; 
            border-top: none; 
        }
        .badge-status { 
            font-size: 0.75rem; 
            padding: 0.5em 1em; 
            font-weight: 600; 
        }
        .btn-verifikasi { 
            transition: all 0.2s; 
            font-weight: 600; 
            border-radius: 8px; 
        }
        .btn-verifikasi:hover { 
            transform: translateY(-1px); 
            box-shadow: 0 4px 6px rgba(0,0,0,0.1); 
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Verifikasi UMKM</h2>
                <p class="text-muted mb-0">Kelola pendaftaran UMKM di bawah ini.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="btn btn-link text-decoration-none fw-bold">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4 py-3">Nama Usaha</th>
                                <th class="text-center py-3">Status</th>
                                <th class="text-center py-3 pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($daftarUmkm as $umkm)
                            <tr>
                                <td class="ps-4 py-3">
                                    <span class="fw-semibold text-dark">{{ $umkm->nama_usaha }}</span>
                                </td>
                                <td class="text-center">
                                    @if($umkm->status == 'aktif')
                                        <span class="badge rounded-pill bg-success bg-opacity-10 text-success badge-status">
                                            <i class="bi bi-check-circle me-1"></i> AKTIF
                                        </span>
                                    @elseif($umkm->status == 'ditolak')
                                        <span class="badge rounded-pill bg-danger bg-opacity-10 text-danger badge-status">
                                            <i class="bi bi-x-circle me-1"></i> DITOLAK
                                        </span>
                                    @else
                                        <span class="badge rounded-pill bg-warning bg-opacity-10 text-warning badge-status">
                                            <i class="bi bi-clock-history me-1"></i> PENDING
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center pe-4">
                                    @if($umkm->status !== 'aktif')
                                        <form action="{{ route('admin.verifikasi.update', $umkm->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="aktif">
                                            
                                            <button type="submit" class="btn btn-success btn-sm btn-verifikasi px-3 py-2">
                                                <i class="bi bi-shield-check me-1"></i> Terima / Verifikasi
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted small fst-italic">
                                            <i class="bi bi-patch-check-fill text-primary"></i> Sudah Diverifikasi
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>