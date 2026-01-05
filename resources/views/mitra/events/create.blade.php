<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Event Baru - Kumparan</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
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
        }
        
        .card-form { 
            border: none; 
            border-radius: 20px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.05); 
        }

        .form-control { 
            border-radius: 10px; 
            padding: 12px; 
            border: 1px solid #e2e8f0; 
        }
        
        .form-control:focus { 
            box-shadow: 0 0 0 0.25 
            margin-left: rgba(13, 110, 253, 0.1); 
            border-color: var(--primary-blue); 
        }
        .btn-submit { 
            background: #2b6cb0; 
            color: white; 
            border-radius: 12px; 
            padding: 12px; 
            font-weight: 600; 
            transition: 0.3s; 
            border: none; 
        }
        .btn-submit:hover {
            background: #1a4373; 
            color: white; 
            transform: translateY(-2px); 
        }
    </style>
</head>
<body>

    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <a href="{{ route('mitra.dashboard') }}" class="text-decoration-none small mb-3 d-inline-block text-muted">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
                </a>
                
                <div class="card card-form p-4 p-md-5">
                    <div class="mb-4">
                        <h4 class="fw-bold m-0">Buat Event Baru</h4>
                        <p class="text-muted small">Publikasikan event kolaborasi Anda untuk menarik mitra UMKM</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger border-0 shadow-sm rounded-3">
                            <ul class="mb-0 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('mitra.events.store') }}" method="POST">
                        @csrf <div class="mb-3">
                            <label class="form-label small fw-bold">Nama Event</label>
                            <input type="text" name="nama_event" class="form-control @error('nama_event') is-invalid @enderror" 
                                   value="{{ old('nama_event') }}" placeholder="Contoh: Bazar UMKM Digital 2026" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">Tanggal Pelaksanaan</label>
                                <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" 
                                       value="{{ old('tanggal') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small fw-bold">Kuota Peserta (UMKM)</label>
                                <input type="number" name="kuota" class="form-control @error('kuota') is-invalid @enderror" 
                                       value="{{ old('kuota') }}" placeholder="0" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold">Lokasi Event</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="bi bi-geo-alt text-muted"></i>
                                </span>
                                <input type="text" name="lokasi" class="form-control border-start-0 @error('lokasi') is-invalid @enderror" 
                                       value="{{ old('lokasi') }}" placeholder="Contoh: Gedung JCC atau Online (Zoom)" required>
                            </div>
                            <small class="text-muted" style="font-size: 0.75rem;">Masukkan alamat lengkap atau link pertemuan jika online.</small>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label fw-bold">Deskripsi Event</label>
                            <textarea 
                                name="deskripsi" 
                                id="deskripsi" 
                                rows="5" 
                                class="form-control @error('deskripsi') is-invalid @enderror" 
                                placeholder="Jelaskan detail acara, syarat pendaftaran, atau agenda kegiatan..."
                                required>{{ old('deskripsi') }}</textarea>
                            
                            @error('deskripsi')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <div class="form-text">Berikan informasi selengkap mungkin agar menarik minat UMKM.</div>
                        </div>

                        <form action="{{ route('mitra.events.store') }}" method="POST">
                            @csrf <button type="submit">Kirim</button>
                        </form>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>