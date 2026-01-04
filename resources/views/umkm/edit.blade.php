<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Profil UMKM - Kumparan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background-color: #f4f8ff;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .navbar-umkm {
            background: #ffffff;
            border-bottom: 3px solid #0d6efd;
            padding: 0.75rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .brand-logo {
            font-size: 1.5rem;
            font-weight: 800;
            color: #1e293b !important;
            text-decoration: none !important;
            letter-spacing: -0.5px;
        }

        .card-edit {
            border-radius: 1.25rem;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            background: white;
        }

        .form-label {
            font-weight: 600;
            color: #475569;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }

        .form-control, .form-select {
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
            transition: all 0.2s;
        }

        .form-control:focus {
            background-color: #fff;
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13,110,253,0.1);
        }

        .btn-save {
            background: linear-gradient(135deg, #0d6efd 0%, #4f9bff 100%);
            border: none;
            border-radius: 999px;
            padding: 0.75rem 2.5rem;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(13,110,253,0.3);
            color: white;
        }

        .user-avatar {
            width: 35px; height: 35px;
            background-color: #0d6efd;
            color: white;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-umkm sticky-top">
        <div class="container">
            <a class="brand-logo" href="{{ route('umkm.dashboard') }}">
                KUMPARAN<span class="text-primary">.</span>
            </a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item me-3">
                        <a class="nav-link fw-600" href="{{ route('umkm.dashboard') }}"><i class="bi bi-grid-1x2 me-2"></i>Dashboard</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" data-bs-toggle="dropdown">
                            <div class="user-avatar">C</div>
                            <span class="fw-600">Cerave Citra</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profil Saya</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="dropdown-item text-danger">Keluar</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7">
                
                <div class="card card-edit">
                    <div class="card-body p-4 p-md-5">
                        <div class="mb-4 text-center">
                            <h3 class="fw-bold text-dark mb-1">Edit Profil Usaha</h3>
                            <p class="text-muted">Perbarui informasi UMKM Anda di bawah ini</p>
                        </div>

                        <form id="formEditUmkm" action="{{ route('umkm.update') }}" method="POST">
                            @csrf
                            @method('PATCH') 

                            <div class="row g-4">
                                <div class="col-12">
                                    <label class="form-label">Nama Usaha</label>
                                    <input type="text" name="nama_usaha" class="form-control" value="{{ $umkm->nama_usaha ?? 'Warung Berkah Jaya' }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Bidang Usaha</label>
                                    <select name="bidang_usaha" class="form-select">
                                        <option value="Kuliner" selected>Kuliner</option>
                                        <option value="Fashion">Fashion</option>
                                        <option value="Jasa">Jasa</option>
                                        <option value="Kerajinan">Kerajinan</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Email Bisnis</label>
                                    <input type="email" name="email_bisnis" class="form-control" value="berkah@usaha.com">
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Alamat Lengkap Usaha</label>
                                    <textarea name="alamat" class="form-control" rows="3">Jl. Sudirman No. 123, Jakarta Selatan</textarea>
                                </div>

                                <div class="col-12 mt-5">
                                    <div class="d-flex justify-content-end gap-3">
                                        <a href="{{ route('umkm.dashboard') }}" class="btn btn-light rounded-pill px-4 fw-600 text-muted">Batal</a>
                                        <button type="button" onclick="confirmSave()" class="btn btn-save">
                                            <i class="bi bi-check2-all me-2"></i>Simpan Perubahan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form> 
                    </div>
                </div>

                <p class="text-center text-muted mt-4 small">
                    &copy; 2026 Dashboard UMKM Kumparan.
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function confirmSave() {
            Swal.fire({
                title: 'Simpan Perubahan?',
                text: "Pastikan semua data yang Anda masukkan sudah benar.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0d6efd',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal',
                borderRadius: '15px'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Harap tunggu sebentar',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading()
                        }
                    });
                    document.getElementById('formEditUmkm').submit();
                }
            })
        }
    </script>
</body>
</html>