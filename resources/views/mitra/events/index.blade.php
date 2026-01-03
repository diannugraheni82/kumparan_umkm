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
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f4f7fa; }
        .card-custom { border: none; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        .fw-600 { font-weight: 600; }
    </style>
</head>
<body>

<main class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold m-0 text-dark">Daftar Event Saya</h4>
            <p class="text-muted small">Kelola event kolaborasi yang telah Anda publikasikan</p>
        </div>
        <a href="{{ route('mitra.events.create') }}" class="btn btn-primary rounded-3 px-4">
            <i class="bi bi-plus-lg me-1"></i> Buat Event Baru
        </a>
    </div>

    <div class="card card-custom p-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Nama Event</th>
                        <th>Tanggal Pelaksanaan</th>
                        <th>Lokasi</th>
                        <th class="text-center">Pendaftar / Kuota</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($events as $event)
                    <tr>
                        <td class="ps-3">
                            <span class="fw-600 text-dark">{{ $event->nama_event }}</span>
                        </td>
                        <td>
                            <i class="bi bi-calendar3 me-2 text-primary small"></i>
                            {{ \Carbon\Carbon::parse($event->tanggal)->format('d M Y') }}
                        </td>
                        <td>
                            <i class="bi bi-geo-alt me-1 text-danger small"></i>
                            <small class="text-muted">{{ Str::limit($event->lokasi, 40) }}</small>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                                <span class="fw-bold">{{ $event->umkms_count }}</span>
                                <span class="mx-1">/</span>
                                <span>{{ $event->kuota }}</span>
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            <div class="py-4">
                                <i class="bi bi-calendar-x d-block mb-3 opacity-25" style="font-size: 3rem;"></i>
                                <h6 class="fw-bold text-dark">Belum ada event</h6>
                                <p class="small">Mulai buat event kolaborasi Anda pertama hari ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>

</body>
</html>