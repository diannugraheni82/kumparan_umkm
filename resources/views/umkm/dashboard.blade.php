@extends('layouts.app')

@section('content')

<style>
    body {
        background: #f4f8ff;
    }

    .dashboard-title {
        font-weight: 700;
        color: #0d6efd;
    }

    .card {
        border-radius: 1.25rem;
        transition: all .25s ease;
    }

    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 30px rgba(13,110,253,.15);
    }

    .stat-gradient {
        background: linear-gradient(135deg, #0d6efd, #4f9bff);
        color: white;
    }

    .stat-gradient small {
        color: rgba(255,255,255,.8);
    }

    .badge-soft {
        background: rgba(13,110,253,.15);
        color: #0d6efd;
        font-weight: 600;
    }

    table thead th {
        font-size: 13px;
        text-transform: uppercase;
        color: #6c757d;
    }
</style>

<div class="container py-4">

@if(!$umkm)
    {{-- JIKA BELUM ISI DATA --}}
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card shadow-sm border-0 text-center p-5">
                <h5 class="fw-bold mb-2">Data UMKM Belum Lengkap</h5>
                <p class="text-muted mb-4">
                    Lengkapi data UMKM untuk mengakses pendanaan dan fitur dashboard.
                </p>
                <a href="{{ route('umkm.input') }}" class="btn btn-primary px-4 rounded-pill">
                    Lengkapi Data
                </a>
            </div>
        </div>
    </div>

@else

{{-- HEADER --}}
<div class="mb-4">
    <h3 class="dashboard-title mb-1">Dashboard UMKM</h3>
    <p class="text-muted">
        Halo, {{ Auth::user()->name }} · <strong>{{ $umkm->nama_usaha }}</strong>
    </p>
</div>

{{-- STATISTIK --}}
<div class="row g-3 mb-4">

    <div class="col-md-4">
        <div class="card stat-gradient shadow-sm h-100">
            <div class="card-body">
                <small>Limit Pinjaman</small>
                <h4 class="fw-bold mt-1">
                    Rp {{ number_format($umkm->limit_pinjaman,0,',','.') }}
                </h4>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <small class="text-muted">Saldo Pinjaman</small>
                <h5 class="fw-bold text-primary mt-1">
                    Rp {{ number_format($umkm->saldo_pinjaman,0,',','.') }}
                </h5>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <small class="text-muted">Status UMKM</small>
                <div class="mt-2">
                    <span class="badge badge-soft px-3 py-2">
                        {{ ucfirst($umkm->status) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- GRAFIK --}}
<div class="row g-3 mb-4">

    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Grafik Pencairan Modal</h6>
                <canvas id="chartPinjaman" height="120"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0 text-center">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Sisa Limit</h6>
                <canvas id="chartLimit"></canvas>
            </div>
        </div>
    </div>

</div>

{{-- AJUKAN PINJAMAN --}}
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h6 class="fw-bold mb-2">Ajukan Pinjaman Modal</h6>
                <p class="text-muted small">
                    Maksimal:
                    Rp {{ number_format($umkm->limit_pinjaman - $umkm->saldo_pinjaman,0,',','.') }}
                </p>

                <form action="{{ route('umkm.ajukan-pinjaman') }}" method="POST">
                    @csrf
                    <input type="number" name="jumlah_modal" class="form-control mb-3" required>
                    <button class="btn btn-primary w-100 rounded-pill">
                        Ajukan Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- RIWAYAT --}}
<div class="card shadow-sm border-0">
    <div class="card-body">
        <h6 class="fw-bold mb-3">Riwayat Pinjaman</h6>

        @if($pinjamanModal->isEmpty())
            <p class="text-muted">Belum ada riwayat pinjaman.</p>
        @else
        <div class="table-responsive">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nominal</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pinjamanModal as $item)
                    <tr>
                        <td>Rp {{ number_format($item->jumlah_pinjaman,0,',','.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}</td>
                        <td>
                            <span class="badge {{ $item->status_pelunasan == 'lunas' ? 'bg-primary' : 'bg-warning text-dark' }}">
                                {{ ucfirst(str_replace('_',' ',$item->status_pelunasan)) }}
                            </span>
                        </td>
                        <td class="text-end">
                            @if($item->status_pelunasan == 'belum_lunas')
                                <a href="{{ route('umkm.bayar',$item->id) }}" class="btn btn-sm btn-primary">Bayar</a>
                            @else
                                <a href="{{ route('umkm.cetak-bukti',$item->id) }}" class="btn btn-sm btn-secondary">Bukti</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>

@endif
</div>

{{-- SCRIPT GRAFIK --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const pinjamanCtx = document.getElementById('chartPinjaman');
    if (pinjamanCtx) {
        new Chart(pinjamanCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($pinjamanModal->pluck('tanggal_pinjam')->map(fn($d)=>\Carbon\Carbon::parse($d)->format('d M'))) !!},
                datasets: [{
                    data: {!! json_encode($pinjamanModal->pluck('jumlah_pinjaman')) !!},
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13,110,253,.2)',
                    tension: .4,
                    fill: true
                }]
            },
            options: {
                plugins: { legend: { display: false } }
            }
        });
    }

    const limitCtx = document.getElementById('chartLimit');
    if (limitCtx) {
        new Chart(limitCtx, {
            type: 'doughnut',
            data: {
                labels: ['Terpakai','Sisa'],
                datasets: [{
                    data: [{{ $umkm->saldo_pinjaman }}, {{ $umkm->limit_pinjaman - $umkm->saldo_pinjaman }}],
                    backgroundColor: ['#0d6efd','#cfe2ff']
                }]
            },
            options: {
                cutout: '70%',
                plugins: { legend: { position: 'bottom' } }
            }
        });
    }

});
</script>

@endsection
