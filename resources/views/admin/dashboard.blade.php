<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin Dashboard</h2>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white px-4 py-2 rounded text-sm font-bold transition">
                    LOGOUT
                </button>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-xl font-bold mb-4">Selamat Datang, {{ Auth::user()->name }}! 👋</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="p-4 border rounded shadow-sm hover:bg-gray-50 transition">
                        <h4 class="font-bold text-blue-600 mb-2">Verifikasi Data UMKM</h4>
                        <p class="text-gray-500 text-sm mb-4">Setujui atau tolak pendaftaran UMKM baru di sini.</p>
                        <a href="{{ route('admin.verifikasi.index') }}" class="bg-blue-600 hover:bg-blue-800 text-white px-4 py-2 rounded text-sm font-bold inline-block">
                            Buka Menu Verifikasi
                        </a>
                    </div>

                    <div class="p-4 border rounded shadow-sm hover:bg-gray-50 transition">
                        <h4 class="font-bold text-green-600 mb-2">Laporan PDF</h4>
                        <p class="text-gray-500 text-sm mb-4">Cetak laporan seluruh UMKM yang sudah aktif.</p>
                        <a href="{{ route('admin.verifikasi.cetak') }}" class="bg-green-600 hover:bg-green-800 text-white px-4 py-2 rounded text-sm font-bold inline-block">
                            Cetak Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>