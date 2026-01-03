<x-app-layout>
    <div class="container py-5">
        <div class="card p-4">
            <h3>Detail Profil: {{ $umkm->nama_usaha }}</h3>
            <hr>
            <p><strong>Deskripsi:</strong> {{ $umkm->deskripsi_usaha }}</p>
            <p><strong>Alamat:</strong> {{ $umkm->alamat_usaha }}</p>
            <a href="{{ route('mitra.dashboard') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</x-app-layout>