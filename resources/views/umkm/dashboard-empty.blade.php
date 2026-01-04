<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard UMKM - KUMPARAN</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-blue: #2563eb;
            --dark-slate: #0f172a;
            --light-slate: #1e293b;
            --text-gray: #cbd5e1;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--dark-slate);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #e5e7eb;
            min-height: 100vh;
        }

        /* Navbar Styling */
        .navbar-umkm {
            background: #ffffff;
            padding: 0.8rem 0;
            border-bottom: 4px solid var(--primary-blue);
        }

        .brand-logo {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--dark-slate);
            text-decoration: none;
        }

        /* Hero Section */
        .content-wrapper {
            max-width: 1200px;
            margin: auto;
            padding: 4rem 2rem;
        }

        .headline {
            font-size: clamp(2.2rem, 5vw, 3.2rem);
            font-weight: 800;
            color: #ffffff;
            line-height: 1.2;
            margin-bottom: 1.5rem;
        }

        .sub-headline {
            font-size: 1.25rem;
            color: var(--text-gray);
            max-width: 800px;
            margin-bottom: 2.5rem;
            line-height: 1.6;
        }

        /* Buttons & Cards */
        .btn-cta-bold {
            background: var(--primary-blue);
            color: #ffffff !important;
            padding: 16px 42px;
            border-radius: 14px;
            font-weight: 800;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 12px 30px rgba(37, 99, 235, 0.4);
            transition: all 0.3s ease;
        }

        .btn-cta-bold:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(37, 99, 235, 0.5);
        }

        .stats-grid-clean {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-top: 4rem;
        }

        .clean-card {
            background: #ffffff;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            border-bottom: 6px solid var(--primary-blue);
            transition: transform 0.3s ease;
        }

        .clean-card:hover {
            transform: translateY(-5px);
        }

        .card-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 700;
            color: #64748b;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .card-value {
            font-size: 2.4rem;
            font-weight: 800;
            color: var(--dark-slate);
        }

        .article-card {
            margin-top: 5rem;
            background: var(--light-slate);
            border-radius: 24px;
            padding: 3rem;
        }

        .article-title {
            font-size: 1.8rem;
            font-weight: 800;
            color: #60a5fa;
            margin-bottom: 1.2rem;
        }

        .article-p {
            font-size: 1.1rem;
            color: var(--text-gray);
            line-height: 1.8;
        }

        /* Utilities */
        .hide-arrow::after {
            display: none !important;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            font-weight: 700;
            font-size: 0.875rem;
        }

        @media (max-width: 768px) {
            .content-wrapper { padding: 2.5rem 1.2rem; }
            .article-card { padding: 2rem; }
        }
    </style>
</head>

<body>
    <div class="umkm-dashboard">
        <nav class="navbar navbar-expand-lg navbar-umkm sticky-top shadow-sm">
            <div class="container-fluid px-4 mx-4">
                <a class="brand-logo" href="{{ route('umkm.dashboard') }}">
                    KUMPARAN<span class="text-primary">.</span>
                </a>

                <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto align-items-center">
                        <li class="nav-item dropdown mt-2 mt-lg-0">
                            <a class="nav-link dropdown-toggle d-flex align-items-center p-0 hide-arrow" href="#" id="userDrop" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2 user-avatar">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <span class="fw-bold d-none d-md-inline text-dark">
                                    {{ Auth::user()->name }}
                                </span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="userDrop">
                                <li>
                                    <a class="dropdown-item py-2" href="{{ route('profile.edit') }}">
                                        <i class="bi bi-person me-2 text-muted"></i>Profil
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger py-2">
                                            <i class="bi bi-box-arrow-right me-2"></i>Keluar
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="content-wrapper">
            <header>
                <h1 class="headline">
                    Bangun Profil UMKM Anda,<br>
                    Raih Akses Pendanaan Lebih Besar
                </h1>

                <p class="sub-headline">
                    Lengkapi data usaha agar sistem dapat menghitung kapasitas pendanaan 
                    dan menampilkan performa bisnis Anda secara profesional.
                </p>

                <a href="{{ route('umkm.create') }}" class="btn-cta-bold">
                    Lengkapi Profil UMKM <i class="fas fa-arrow-right"></i>
                </a>
            </header>

            <section class="stats-grid-clean">
                <div class="clean-card">
                    <span class="card-label">Estimasi Kapasitas Pendanaan</span>
                    <div class="card-value">Rp 0</div>
                </div>

                <div class="clean-card">
                    <span class="card-label">Total Aset & Inventaris</span>
                    <div class="card-value">0 Item</div>
                </div>

                <div class="clean-card">
                    <span class="card-label">Status Verifikasi</span>
                    <div class="card-value text-secondary" style="font-size: 1.8rem;">Belum Verifikasi</div>
                </div>
            </section>

            <section class="article-card">
                <h2 class="article-title">Kenapa Data UMKM Penting?</h2>
                <p class="article-p">
                    Sistem menilai kelayakan usaha dari aset, stok, dan konsistensi data. 
                    UMKM dengan pencatatan rapi memiliki peluang pendanaan lebih besar karena tingkat risiko yang lebih mudah terukur.
                </p>
            </section>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>