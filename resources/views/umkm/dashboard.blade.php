<x-app-layout>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-4 bg-green-50 border-l-4 border-green-400 text-green-700 px-4 py-3 rounded shadow-sm">
                    <p class="text-sm font-bold">{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-50 border-l-4 border-red-400 text-red-700 px-4 py-3 rounded shadow-sm">
                    <p class="text-sm font-bold">{{ session('error') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl p-6 mb-6">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-black text-gray-900 tracking-tight">
                        {{ __("Halo, ") }} {{ Auth::user()->name }} 👋
                    </h1>
                </div>

                @php $umkm = Auth::user()->umkm; @endphp

                @if (!$umkm)
                    <div class="bg-blue-50 p-10 rounded-2xl border-2 border-dashed border-blue-200 text-center">
                        <div class="mb-4 inline-flex p-4 bg-blue-100 rounded-full text-blue-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <p class="text-blue-900 mb-6 font-medium text-lg">Profil usaha Anda belum lengkap. <br>Lengkapi data untuk mendapatkan limit pencairan modal.</p>
                        <a href="{{ route('umkm.input') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-black px-10 py-4 rounded-xl shadow-lg transition duration-200 transform hover:-translate-y-1">
                            Lengkapi Profil Sekarang
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                            <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Profil Usaha</h3>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-xs text-gray-500">Nama Usaha</p>
                                    <p class="font-bold text-gray-800">{{ $umkm->nama_usaha }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Status Akun</p>
                                    <span class="inline-block px-3 py-1 mt-1 rounded-full text-[10px] font-black uppercase {{ $umkm->status == 'aktif' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                        {{ $umkm->status }}
                                    </span>
                                </div>
                            </div>
                            <a href="{{ route('umkm.edit') }}" class="mt-6 inline-flex items-center text-blue-600 text-xs font-bold hover:underline">
                                Edit Profil Usaha 
                                <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        </div>

                        <div class="md:col-span-2 bg-gradient-to-br from-blue-600 to-blue-800 p-6 rounded-2xl shadow-xl text-white relative overflow-hidden">
                            <div class="relative z-10">
                                <h3 class="text-xs font-black text-blue-200 uppercase tracking-widest mb-6 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                    Limit Modal (Paylater)
                                </h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <div>
                                        <p class="text-blue-100 text-sm mb-1">Limit Tersedia</p>
                                        <p class="text-3xl font-black">Rp {{ number_format($umkm->limit_pinjaman - $umkm->saldo_pinjaman, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="sm:text-right">
                                        <p class="text-blue-100 text-sm mb-1">Tagihan Berjalan</p>
                                        <p class="text-2xl font-black text-orange-300">Rp {{ number_format($umkm->saldo_pinjaman, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="absolute right-0 bottom-0 opacity-10 transform translate-x-1/4 translate-y-1/4">
                                <svg class="w-64 h-64" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                            </div>
                        </div>
                    </div>

                    <div class="mb-10">
                        <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-6">Katalog Produk Unggulan</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            @forelse($umkm->portfolio_produk ?? [] as $produk)
                                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-md transition">
                                    <div class="relative">
                                        @if(isset($produk['foto']))
                                            <img src="{{ asset('storage/' . $produk['foto']) }}" class="w-full h-40 object-cover group-hover:scale-105 transition duration-500">
                                        @else
                                            <div class="w-full h-40 bg-gray-100 flex items-center justify-center text-gray-400">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-4">
                                        <h5 class="font-bold text-gray-800 truncate">{{ $produk['nama'] }}</h5>
                                        <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $produk['detail'] }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-400 italic text-sm">Belum ada produk yang ditambahkan.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">
                        <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                            <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Grafik Pencairan (6 Terakhir)</h3>
                            <canvas id="chartPinjaman" height="120"></canvas>
                        </div>
                        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col items-center">
                            <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4 w-full">Sisa Limit</h3>
                            <canvas id="chartLimit"></canvas>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-gray-50 flex justify-between items-center bg-white sticky top-0">
                            <h3 class="font-black text-gray-800 uppercase tracking-tight">Riwayat Pencairan Modal</h3>
                            @if($umkm->saldo_pinjaman < $umkm->limit_pinjaman)
                                <button onclick="document.getElementById('modalPinjam').classList.remove('hidden')" 
                                        class="bg-blue-600 text-white px-5 py-2 rounded-xl text-xs font-black shadow-lg hover:bg-blue-700 transition transform active:scale-95">
                                    + AJUKAN PENCAIRAN
                                </button>
                            @endif
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead>
                                    <tr class="bg-gray-50/50">
                                        <th class="py-4 px-6 text-[10px] font-black text-gray-400 uppercase">Nominal</th>
                                        <th class="py-4 px-6 text-[10px] font-black text-gray-400 uppercase">Tanggal</th>
                                        <th class="py-4 px-6 text-[10px] font-black text-gray-400 uppercase text-center">Status</th>
                                        <th class="py-4 px-6 text-[10px] font-black text-gray-400 uppercase text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @forelse($pinjamanModal as $pinjam)
                                        <tr class="hover:bg-blue-50/30 transition">
                                            <td class="py-4 px-6 font-black text-gray-800 text-sm">
                                                Rp {{ number_format($pinjam->jumlah_pinjaman, 0, ',', '.') }}
                                            </td>
                                            <td class="py-4 px-6 text-gray-500 text-xs">
                                                {{ $pinjam->tanggal_pinjam ? \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d/m/Y') : '-' }}
                                            </td>
                                            <td class="py-4 px-6 text-center">
                                                @if($pinjam->status_pelunasan == 'lunas')
                                                    <span class="inline-block px-2 py-1 bg-green-50 text-green-600 rounded-md text-[9px] font-black uppercase">Lunas</span>
                                                @else
                                                    <span class="inline-block px-2 py-1 bg-orange-50 text-orange-600 rounded-md text-[9px] font-black uppercase">Aktif</span>
                                                @endif
                                            </td>
                                            <td class="py-4 px-6 text-right">
                                                @if($pinjam->status_pelunasan != 'lunas')
                                                    <button onclick="bayarTagihan('{{ $pinjam->id }}')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1.5 rounded-lg text-[10px] font-black shadow-sm transition">
                                                        BAYAR
                                                    </button>
                                                @else
                                                    <a href="{{ route('umkm.cetak-bukti', $pinjam->id) }}" target="_blank" class="inline-flex items-center text-gray-400 hover:text-gray-800 transition">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-10 text-gray-400 italic text-sm text-center">Belum ada aktivitas pinjaman.</td>
                                        </tr>
                                    @endforelse 
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if(isset($umkm) && $umkm)
    <div id="modalPinjam" class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm hidden flex items-center justify-center z-50 p-4">
        <div class="bg-white p-8 rounded-3xl w-full max-w-md shadow-2xl transform transition-all">
            <h2 class="text-2xl font-black text-gray-900 mb-2">Ajukan Modal</h2>
            <p class="text-sm text-gray-500 mb-6">Dana akan dikirimkan ke rekening terdaftar dalam 1x24 jam.</p>
            
            <form action="{{ route('umkm.ajukan-pinjaman') }}" method="POST">
                @csrf
                <div class="mb-8">
                    <label class="block text-[10px] font-black text-gray-400 uppercase mb-2 tracking-widest">Nominal (Maks: Rp {{ number_format($umkm->limit_pinjaman - $umkm->saldo_pinjaman, 0, ',', '.') }})</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-5 flex items-center text-gray-400 font-bold group-focus-within:text-blue-600 transition">Rp</span>
                        <input type="number" name="jumlah_modal" max="{{ $umkm->limit_pinjaman - $umkm->saldo_pinjaman }}" 
                               class="w-full pl-12 pr-5 py-4 border-2 border-gray-100 rounded-2xl focus:border-blue-500 focus:ring-0 text-xl font-black transition" placeholder="0" required>
                    </div>
                </div>
                <div class="flex flex-col gap-3">
                    <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-2xl font-black shadow-xl shadow-blue-200 hover:bg-blue-700 transition transform active:scale-95">Konfirmasi & Cairkan</button>
                    <button type="button" onclick="document.getElementById('modalPinjam').classList.add('hidden')" class="w-full py-3 text-xs font-bold text-gray-400 hover:text-gray-600 transition">Batalkan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Charts Logic
        const ctxPinjaman = document.getElementById('chartPinjaman').getContext('2d');
        new Chart(ctxPinjaman, {
            type: 'bar',
            data: {
                labels: {!! json_encode($labels ?? []) !!},
                datasets: [{
                    label: 'Nominal Rp',
                    data: {!! json_encode($values ?? []) !!},
                    backgroundColor: '#3b82f6',
                    borderRadius: 10,
                    barThickness: 20,
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, grid: { display: false } }, x: { grid: { display: false } } }
            }
        });

        const ctxLimit = document.getElementById('chartLimit').getContext('2d');
        new Chart(ctxLimit, {
            type: 'doughnut',
            data: {
                labels: ['Terpakai', 'Sisa'],
                datasets: [{
                    data: [{{ $umkm->saldo_pinjaman }}, {{ $umkm->limit_pinjaman - $umkm->saldo_pinjaman }}],
                    backgroundColor: ['#f87171', '#3b82f6'],
                    hoverOffset: 4,
                    borderWidth: 0
                }]
            },
            options: {
                cutout: '80%',
                plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 10, weight: 'bold' } } } }
            }
        });

        // Payment Logic
        function bayarTagihan(id) {
            if (typeof window.snap === 'undefined') {
                alert("Sistem pembayaran sedang loading, silakan tunggu sebentar."); return;
            }
            fetch('/umkm/bayar/' + id, {
                method: 'GET',
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            })
            .then(response => response.json())
            .then(data => {
                if (data.snap_token) {
                    window.snap.pay(data.snap_token, {
                        onSuccess: (result) => { window.location.reload(); },
                        onPending: (result) => { alert("Menunggu pembayaran..."); },
                        onError: (result) => { alert("Pembayaran gagal!"); }
                    });
                } else { alert(data.error || "Gagal mengambil data pembayaran."); }
            })
            .catch(() => alert("Terjadi kesalahan koneksi."));
        }
    </script>
    @endif
</x-app-layout>