<main class="container py-5">
    <header class="mb-5">
        <h4 class="fw-bold text-dark m-0">Partner Bisnis Saya</h4>
        <p class="text-muted">Daftar UMKM yang telah menyetujui kolaborasi dengan Anda</p>
    </header>

    <div class="row g-4">
        @forelse($umkmsJoined as $umkm)
        <div class="col-md-6 col-lg-4">
            <div class="card card-umkm h-100 shadow-sm border-0" style="border-radius: 20px; background: white;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-success bg-opacity-10 p-2 rounded-circle me-3">
                            <i class="bi bi-handshake text-success fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold m-0 text-dark">{{ $umkm->nama_umkm }}</h6>
                            <span class="badge bg-success small" style="font-size: 0.6rem;">AKTIF</span>
                        </div>
                    </div>

                    <p class="text-muted small mb-4">
                        <i class="bi bi-calendar-check me-1"></i>
                        Terjalin sejak: {{ \Carbon\Carbon::parse($umkm->pivot->created_at)->format('d M Y') }}
                    </p>

                    <div class="d-grid gap-2">
                        <a href="{{ route('mitra.umkm.show', $umkm->id) }}" class="btn btn-outline-primary btn-sm rounded-3 fw-600">
                            Lihat Progress
                        </a>
                        <button class="btn btn-primary btn-sm rounded-3 fw-600">
                            <i class="bi bi-chat-left-text me-1"></i> Kirim Pesan
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <img src="https://illustrations.popsy.co/amber/no-messages-found.svg" style="width: 200px;" alt="Empty State">
            <h5 class="mt-4 fw-bold text-dark">Belum Ada Partner</h5>
            <p class="text-muted">Anda belum memiliki kerjasama yang disetujui oleh UMKM.</p>
            <a href="{{ route('mitra.dashboard') }}" class="btn btn-primary rounded-pill px-4 mt-2">
                <i class="bi bi-search me-1"></i> Cari UMKM Sekarang
            </a>
        </div>
        @endforelse
    </div>
</main>