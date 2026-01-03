@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold"><i class="bi bi-calendar-event me-2"></i>Daftar Event</h4>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
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
                            <td class="px-4 fw-bold">{{ $item->judul }}</td> {{-- Sesuaikan kolom 'judul' di database --}}
                            <td>{{ $item->user->name ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_event)->format('d M Y') }}</td>
                            <td class="text-end px-4">
                                <a href="#" class="btn btn-outline-primary btn-sm">Detail</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">Tidak ada data event.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Navigasi Halaman (Pagination) --}}
    <div class="mt-4">
        {{ $eventList->links() }}
    </div>
</div>
@endsection