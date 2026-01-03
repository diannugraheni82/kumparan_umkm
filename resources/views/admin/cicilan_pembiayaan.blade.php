<!-- @extends('layouts.app') {{-- Sesuaikan dengan layout Anda --}}

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">Daftar Penyaluran Dana</h4>
            <p class="text-muted small">Total dana terdistribusi: <strong>Rp{{ number_format($totalUangKeluar, 0, ',', '.') }}</strong></p>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3">Nama UMKM</th>
                            <th class="py-3">Pemilik</th>
                            <th class="py-3 text-end">Dana Disalurkan</th>
                            <th class="py-3 text-center px-4">Status</th>
                        </tr>
                    </thead>
                    <tbody>
    @forelse($pinjamanList as $pinjaman)
    <tr>
        {{-- 1. Nama UMKM (diambil lewat relasi umkm) --}}
        <td class="px-4 fw-bold">
            {{ $pinjaman->umkm->nama_usaha ?? 'Nama tidak ditemukan' }}
        </td>

        {{-- 2. Nama Pemilik (diambil dari relasi umkm ke user) --}}
        <td>
            {{ $pinjaman->umkm->user->name ?? 'N/A' }}
        </td>

        {{-- 3. Dana (sesuaikan dengan kolom jumlah_pinjaman) --}}
        <td class="text-end fw-bold text-success">
            Rp{{ number_format($pinjaman->jumlah_pinjaman, 0, ',', '.') }}
        </td>

        {{-- 4. Status (diambil dari kolom status_pelunasan) --}}
        <td class="text-center px-4">
            @if($pinjaman->status_pelunasan == 'lunas')
                <span class="badge bg-success-subtle text-success rounded-pill px-3">Tersalurkan</span>
            @else
                <span class="badge bg-warning-subtle text-warning rounded-pill px-3">
                    {{ $pinjaman->status_pelunasan }}
                </span>
            @endif
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="4" class="text-center py-5 text-muted">
            Belum ada data dengan status lunas ditemukan.
        </td>
    </tr>
    @endforelse
</tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">
        {{ $pinjamanList->links() }}
    </div>
</div>
@endsection -->