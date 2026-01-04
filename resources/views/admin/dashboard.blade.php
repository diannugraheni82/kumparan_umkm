<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - KUMPARAN</title>
        
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        :root { 
            --primary-blue: #1e40af; 
            --accent-blue: #3b82f6;  
            --light-blue: #eff6ff;   
            --soft-blue: #dbeafe;    
        }

        body { 
            background-color: #f8fafc; 
            font-family: 'Inter', 'Segoe UI', Roboto, sans-serif; 
        }

        .navbar-mitra-style { 
            background-color: #ffffff; 
            border-bottom: 2px solid var(--soft-blue); 
        }

        .container-fluid {
            margin-left: 50px;
            margin-right: 30px;
        }

        .card { 
            border-radius: 16px; 
            transition: all 0.3s ease; 
            border: 1px solid var(--soft-blue);
        }
        .card:hover { 
            transform: translateY(-5px); 
            box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important; 
        }

        .bg-blue-primary { background-color: var(--primary-blue) !important; }
        .bg-blue-accent { background-color: var(--accent-blue) !important; }
        .text-blue-primary { color: var(--primary-blue) !important; }
        
        .btn-blue { 
            background-color: var(--primary-blue); 
            color: white; 
            border-radius: 8px;
        }
        .btn-blue:hover { 
            background-color: #1e3a8a; 
            color: white; 
        }

        .notif-scroll { max-height: 350px; overflow-y: auto; }
        .border-bottom-dashed { border-bottom: 1px dashed var(--soft-blue); }
        
        .table thead th {
            background-color: var(--light-blue);
            color: var(--primary-blue);
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            border: none;
        }
        .table tbody tr {
            border-bottom: 1px solid #f1f5f9;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand navbar-light navbar-mitra-style sticky-top shadow-sm">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold" href="{{ route('admin.dashboard') }}" style="font-size: 1.5rem; color:black;">
                KUMPARAN<span style="color: var(--accent-blue);">.</span>
            </a>
            
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item dropdown me-3">
                    <a class="nav-link position-relative p-2" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-bell text-blue-primary fs-5"></i>
                        @if(isset($totalNotif) && $totalNotif > 0)
                            <span class="position-absolute top-1 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                                {{ $totalNotif }}
                            </span>
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-end shadow-lg p-0 mt-2 border-0" style="width: 320px; border-radius: 12px; overflow: hidden;">
                        <div class="p-3 bg-blue-primary text-white text-center">
                            <h6 class="mb-0">Pusat Notifikasi</h6>
                        </div>
                        <div class="notif-scroll">
                            @if(($totalNotif ?? 0) > 0)
                                @foreach($notifBaru as $notif)
                                    <div class="p-3 border-bottom">
                                        <small class="text-blue-primary fw-bold">UMKM Baru</small>
                                        <p class="mb-0 small text-muted">{{ $notif->nama_usaha }} menunggu verifikasi.</p>
                                    </div>
                                @endforeach
                            @else
                                <div class="p-4 text-center text-muted small">Tidak ada aktivitas baru</div>
                            @endif
                        </div>
                        <a href="{{ route('admin.verifikasi.index') }}" class="dropdown-item text-center py-2 small fw-bold text-blue-primary bg-light">Lihat Semua</a>
                    </div>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link d-flex align-items-center" href="#" data-bs-toggle="dropdown">
                        <div class="bg-blue-accent text-white rounded-circle d-flex align-items-center justify-content-center fw-bold me-2" style="width: 35px; height: 35px;">
                            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <span class="fw-bold text-dark d-none d-md-inline small">{{ Auth::user()->name ?? 'Admin' }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i>Edit Profil</a></li>
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
    </nav>

    <div class="container py-5">
        <div class="row g-4 mb-4">
            <div class="col-lg-8">
                <div class="card shadow-sm p-4 h-100 bg-white">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="fw-bold text-muted text-uppercase small mb-0">Perbandingan Pengguna</h6>
                        <i class="bi bi-pie-chart text-blue-primary fs-5"></i>
                    </div>
                    <div style="height: 300px;">
                        <canvas id="userChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="card p-4 shadow-sm h-100 bg-white">
                            <h6 class="fw-bold mb-3 small text-muted text-uppercase">Cetak Laporan</h6>
                            <form action="{{ route('admin.verifikasi.cetak') }}" method="GET">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <label class="small text-muted mb-1">Dari:</label>
                                        <input type="date" name="tgl_mulai" class="form-control form-control-sm border-soft" required>
                                    </div>
                                    <div class="col-6">
                                        <label class="small text-muted mb-1">Sampai:</label>
                                        <input type="date" name="tgl_selesai" class="form-control form-control-sm" required>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <button type="submit" class="btn btn-blue w-100 btn-sm fw-bold">
                                            <i class="bi bi-file-earmark-pdf me-1"></i> CETAK PDF
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card p-4 bg-blue-accent text-white shadow-sm border-0 h-100">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="mb-1 small text-uppercase fw-bold opacity-75">Total Dana Dibayarkan</p>
                            <h4 class="fw-bold text-white mb-0">Rp{{ number_format($totalDanaMasuk ?? 0, 0, ',', '.') }}</h4>
                                </div>
                                <i class="bi bi-cash-stack fs-1 opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        

        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0 bg-white">
                    <div class="card-header bg-transparent border-0 p-4 pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold mb-0 text-blue-primary"><i class="bi bi-wallet2 me-2"></i>Daftar Penyaluran Dana</h5>
                            <span class="badge bg-light text-blue-primary border">Status: Lunas</span>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th class="px-4">Nama UMKM</th>
                                        <th>Pemilik</th>
                                        <th class="text-end">Jumlah Pinjaman</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pinjamanList as $pinjaman)
                                    <tr>
                                        <td class="px-4">
                                            <div class="fw-bold text-dark">{{ $pinjaman->umkm->nama_usaha ?? 'Usaha Unknown' }}</div>
                                        </td>
                                        <td>{{ $pinjaman->umkm->user->name ?? 'Admin' }}</td>
                                        <td class="text-end fw-bold text-success">
                                            Rp{{ number_format($pinjaman->jumlah_pinjaman, 0, ',', '.') }}
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-success-subtle text-success rounded-pill px-3 border border-success">
                                                {{ ucfirst($pinjaman->status_pelunasan) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted small">
                                            Belum ada data pinjaman yang berstatus lunas.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card shadow-sm h-100 bg-white">
                    <div class="card-header bg-transparent border-0 p-4 pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold mb-0 text-blue-primary"><i class="bi bi-shop me-2"></i>UMKM Terbaru</h5>
                            <a href="{{ route('admin.verifikasi.index') }}" class="btn btn-outline-primary btn-sm rounded-pill fw-bold">Lihat Semua</a>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table align-middle border-0">
                                <thead>
                                    <tr>
                                        <th>Nama Usaha</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($umkmList as $item)
                                    <tr>
                                        <td>
                                            <div class="fw-bold text-dark">{{ $item->nama_usaha }}</div>
                                            <span class="text-muted" style="font-size: 0.75rem;">{{ $item->kategori }}</span>
                                        </td>
                                        <td class="text-center">
                                            @if($item->status == 'aktif')
                                                <span class="badge bg-success-subtle text-success border border-success px-3">Aktif</span>
                                            @else
                                                <span class="badge bg-warning-subtle text-warning border border-warning px-3">Pending</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="2" class="text-center py-5 text-muted">Belum ada UMKM mendaftar</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm h-100 bg-white">
                    <div class="card-header bg-transparent border-0 p-4 pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold mb-0 text-blue-primary">Event Terbaru</h5>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        @forelse($eventList as $event)
                        <div class="d-flex align-items-start mb-3 pb-3 border-bottom-dashed">
                            <div class="bg-blue-accent bg-opacity-10 rounded-3 p-2 me-3 text-blue-primary">
                                <i class="bi bi-calendar-event fs-5"></i>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <a href="{{ route('admin.event.show', $event->id) }}" class="text-decoration-none">
                                    <div class="small fw-bold text-primary text-truncate">{{ $event->nama_event }}</div>
                                </a>                                
                                <div class="text-muted" style="font-size: 0.65rem;">
                                    {{ \Carbon\Carbon::parse($event->tanggal)->format('d M Y') }}
                                </div>
                            </div>
                        </div>
                        @empty
                            <p class="text-center py-5 text-muted small">Belum ada event tersimpan</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const ctx = document.getElementById('userChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Pelaku UMKM', 'Mitra Terdaftar'],
                datasets: [{
                    data: [{{ $totalUmkm ?? 0 }}, {{ $totalMitra ?? 0 }}],
                    backgroundColor: ['#3b82f6', '#1e40af'],
                    borderWidth: 5,
                    borderColor: '#ffffff',
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { 
                    legend: { position: 'bottom', labels: { usePointStyle: true, padding: 30, font: { size: 12 } } } 
                },
                cutout: '70%'
            }
        });
    </script>
</body>
</html>