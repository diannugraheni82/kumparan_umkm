<x-app-layout>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .bg-gray-100 { background: transparent !important; }

        .umkm-dashboard {
            background: #0f172a;
            min-height: 100vh;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #e5e7eb;
        }

        .dashboard-nav {
            background: #ffffff;
            padding: 1rem 3rem;
            border-bottom: 4px solid #2563eb;
        }

        .navbar-brand-bold {
            font-size: 1.6rem;
            font-weight: 800;
            color: #0f172a;
            text-decoration: none;
        }

        .content-wrapper {
            max-width: 1200px;
            margin: auto;
            padding: 4rem 2rem;
        }

        .headline {
            font-size: 3.2rem;
            font-weight: 800;
            color: #ffffff;
        }

        .sub-headline {
            font-size: 1.3rem;
            color: #cbd5e1;
            max-width: 800px;
            margin-bottom: 2.5rem;
        }

        .btn-cta-bold {
            background: #2563eb;
            color: #ffffff;
            padding: 16px 42px;
            border-radius: 14px;
            font-weight: 800;
            text-decoration: none;
            display: inline-flex;
            gap: 12px;
            box-shadow: 0 12px 30px rgba(37, 99, 235, 0.4);
        }

        .stats-grid-clean {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 30px;
            margin-top: 4rem;
        }

        .clean-card {
            background: #ffffff;
            padding: 36px;
            border-radius: 22px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.35);
            border-bottom: 6px solid #2563eb;
        }

        .card-label {
            font-size: 0.85rem;
            font-weight: 700;
            color: #64748b;
        }

        .card-value {
            font-size: 2.8rem;
            font-weight: 800;
            color: #0f172a;
        }

        .article-card {
            margin-top: 5rem;
            background: #1e293b;
            border-radius: 28px;
            padding: 3.5rem;
        }

        .article-title {
            font-size: 2rem;
            font-weight: 800;
            color: #60a5fa;
        }

        .article-p {
            font-size: 1.15rem;
            color: #cbd5e1;
        }
    </style>

    <div class="umkm-dashboard">

    
        <!-- CONTENT -->
        <main class="content-wrapper">
            <h1 class="headline">
                Bangun Profil UMKM Anda,<br>
                Raih Akses Pendanaan Lebih Besar
            </h1>

            <p class="sub-headline">
            Lengkapi data usaha agar sistem dapat menghitung kapasitas pendanaan
            dan menampilkan performa bisnis Anda secara profesional.
            </p>

            <a href="{{ route('umkm.input') }}" class="btn-cta-bold">
                Lengkapi Profil UMKM <i class="fas fa-arrow-right"></i>
            </a>

            <div class="stats-grid-clean">
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
                    <div class="card-value" style="color:#94a3b8;">Belum Verifikasi</div>
                </div>
            </div>

            <section class="article-card">
                <h2 class="article-title">Kenapa Data UMKM Penting?</h2>
                <p class="article-p">
                    Sistem menilai kelayakan usaha dari aset, stok, dan konsistensi data.
                    UMKM dengan pencatatan rapi memiliki peluang pendanaan lebih besar.
                </p>
            </section>
        </main>
    </div>
</x-app-layout>