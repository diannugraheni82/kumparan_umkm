<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Verifikasi UMKM</h2>
            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline text-sm font-bold">
                &larr; Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                
                <div class="mb-6 flex justify-between items-center">
                    <p class="text-gray-600">Kelola pendaftaran UMKM di bawah ini.</p>
                    <a href="{{ route('admin.verifikasi.cetak') }}" class="bg-red-600 text-white px-4 py-2 rounded shadow hover:bg-red-700 font-bold text-sm">
                        DOWNLOAD LAPORAN (PDF)
                    </a>
                </div>

                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded border border-green-200">{{ session('success') }}</div>
                @endif

                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-left">
                            <th class="p-3 border">Nama Usaha</th>
                            <th class="p-3 border">Status</th>
                            <th class="p-3 border text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($daftarUmkm as $umkm)
                        <tr>
                            <td class="p-3 border">{{ $umkm->nama_usaha }}</td>
                            <td class="p-3 border text-center">
                                <span class="px-2 py-1 rounded text-xs text-white {{ $umkm->status == 'aktif' ? 'bg-green-500' : ($umkm->status == 'ditolak' ? 'bg-red-500' : 'bg-yellow-500') }}">
                                    {{ strtoupper($umkm->status) }}
                                </span>
                            </td>
                            <td class="p-3 border text-center">
                                <form action="{{ route('admin.verifikasi.update', $umkm->id) }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="status" value="aktif">
                                    <button class="bg-green-600 text-white px-3 py-1 rounded text-sm mr-1 {{ $umkm->status == 'aktif' ? 'opacity-50' : '' }}" {{ $umkm->status == 'aktif' ? 'disabled' : '' }}>Terima</button>
                                </form>
                                <form action="{{ route('admin.verifikasi.update', $umkm->id) }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="status" value="ditolak">
                                    <button class="bg-red-600 text-white px-3 py-1 rounded text-sm {{ $umkm->status == 'ditolak' ? 'opacity-50' : '' }}" {{ $umkm->status == 'ditolak' ? 'disabled' : '' }}>Tolak</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>