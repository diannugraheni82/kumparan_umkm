<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Event - UMKM</title>
    
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border: none;
            transition: transform 0.2s ease;
        }
        .table thead th {
            font-size: 0.85rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: #6c757d;
        }
        .table tbody td {
            font-size: 0.95rem;
        }
        .btn-outline-primary {
            border-radius: 8px;
            font-weight: 600;
        }
        .bg-light-header {
            background-color: #f1f5f9;
        }
        .pagination {
            justify-content: center;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold d-flex align-items-center mb-0">
                <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3">
                    <i class="bi bi-calendar-event text-primary"></i>
                </div>
                Daftar Event
            </h4>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light-header border-bottom">
                            <tr>
                                <th class="px-4 py-3">Nama Event</th>
                                <th class="py-3">Penyelenggara (Mitra)</th>
                                <th class="py-3">Tanggal Pelaksanaan</th>
                                <th class="py-3 text-end px-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($eventList as $item)
                            <tr>
                                <td class="px-4 fw-bold text-dark">
                                    {{ $item->judul }}
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-person-circle me-2 text-muted"></i>
                                        {{ $item->user->name ?? 'N/A' }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        {{ \Carbon\Carbon::parse($item->tanggal_event)->format('d M Y') }}
                                    </span>
                                </td>
                                <td class="text-end px-4">
                                    <a href="#" class="btn btn-outline-primary btn-sm px-3 shadow-sm">
                                        <i class="bi bi-info-circle me-1"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <div class="py-4">
                                        <i class="bi bi-calendar-x fs-1 text-muted d-block mb-3"></i>
                                        <span class="text-muted fw-medium">Tidak ada data event saat ini.</span>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-4">
            {{ $eventList->links() }}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>