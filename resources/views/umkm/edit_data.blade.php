<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil UMKM</title>
    
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
    body {
        background-color: #f8f9fa;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    .card {
        border: none;
        transition: all 0.3s ease;
    }

    .form-control {
        border: 1px solid #e2e8f0;
        padding: 0.75rem 1rem;
        border-radius: 10px;
        transition: all 0.2s ease-in-out;
        font-size: 0.95rem;
    }

    .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1); /* Diperbaiki */
        outline: none;
    }

    .form-label {
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.025em;
        margin-bottom: 0.6rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
        border: none;
        padding: 0.7rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.2);
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(13, 110, 253, 0.3);
        background: linear-gradient(135deg, #0b5ed7 0%, #094eb3 100%);
    }

    .btn-light {
        background-color: #f1f5f9;
        border: none;
        color: #64748b !important;
        padding: 0.7rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
    }

    .btn-light:hover {
        background-color: #e2e8f0;
        color: #475569 !important;
    }

    .bg-opacity-10 {
        background-color: rgba(13, 110, 253, 0.1) !important;
    }
</style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-0 pt-4 px-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3">
                                <i class="bi bi-pencil-square text-primary fs-4"></i>
                            </div>
                            <h2 class="h4 fw-bold mb-0">Edit Profil Usaha</h2>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('umkm.update') }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="mb-4">
                                <label for="nama_usaha" class="form-label fw-semibold text-secondary">
                                    Nama Usaha
                                </label>
                                <input type="text" 
                                       name="nama_usaha" 
                                       id="nama_usaha"
                                       value="{{ $umkm->nama_usaha }}" 
                                       class="form-control form-control-lg @error('nama_usaha') is-invalid @enderror" 
                                       placeholder="Masukkan nama usaha Anda"
                                       required>
                                @error('nama_usaha')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="deskripsi" class="form-label fw-semibold text-secondary">
                                    Deskripsi Usaha
                                </label>
                                <textarea name="deskripsi" 
                                          id="deskripsi"
                                          class="form-control @error('deskripsi') is-invalid @enderror" 
                                          rows="5" 
                                          placeholder="Ceritakan detail usaha Anda..."
                                          required style="resize: none;">{{ $umkm->deskripsi }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex align-items-center pt-3 border-top">
                                <button type="submit" class="btn btn-primary px-4 py-2 fw-bold rounded-3 me-3">
                                    <i class="bi bi-save me-2"></i>Simpan Perubahan
                                </button>
                                <a href="{{ route('umkm.dashboard') }}" class="btn btn-light px-4 py-2 fw-semibold text-secondary rounded-3">
                                    Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
