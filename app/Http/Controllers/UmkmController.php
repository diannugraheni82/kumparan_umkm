<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use App\Models\Berita;
use App\Models\PembiayaanModal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Midtrans\Config;
use Midtrans\Snap;

class UmkmController extends Controller
{
    /**
     * Menampilkan form input data UMKM
     */
    public function create()
    {
        // Jika user sudah punya UMKM, langsung arahkan ke dashboard
        if (Auth::user()->umkm) {
            return redirect()->route('umkm.dashboard');
        }
        return view('umkm.input_data');
    }

    /**
     * Menyimpan data UMKM baru
     */
public function store(Request $request)
{
    $validatedData = $request->validate([
        'nama_usaha'         => 'required|string|max:255',
        'no_whatsapp'        => 'nullable|numeric',
        'npwp'               => 'nullable|string|max:20',
        'alamat_usaha'       => 'nullable|string',
        'status_tempat'      => 'nullable|string',
        'luas_lahan'         => 'nullable|numeric',
        'kbli'               => 'nullable|string|size:5',
        'jumlah_karyawan'    => 'nullable|integer',
        'modal_usaha'        => 'required|numeric',
        'omzet_tahunan'      => 'nullable|numeric',
        'kapasitas_produksi' => 'nullable|string',
        'sistem_penjualan'   => 'nullable|in:luring,daring,keduanya',
        'deskripsi'          => 'required|string',
        'nama_bank'          => 'required|string',
        'nomor_rekening'     => 'required|numeric',
        'produk_nama.*'      => 'required|string',
        'produk_detail.*'    => 'required|string',
        'produk_foto.*'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048', 
        // Hapus 'kategori' dari validasi request karena kita akan menentukannya secara otomatis
    ]);

    // 1. Olah Portfolio (Tetap sama)
    $portfolio = [];
    if ($request->has('produk_nama')) {
        foreach ($request->produk_nama as $key => $namaProduk) {
            $path = null;
            if ($request->hasFile("produk_foto.$key")) {
                $path = $request->file("produk_foto.$key")->store('produk', 'public');
            }
            $portfolio[] = [
                'nama' => $namaProduk,
                'detail' => $request->produk_detail[$key] ?? '',
                'foto' => $path
            ];
        }
    }

    // 2. Logika Penentuan Kategori & Limit (PASTIKAN STRING INI SAMA DENGAN DI DATABASE)
    $modal = $request->modal_usaha;
    if ($modal <= 50000000) {
        $kategori = 'mikro'; // Harus huruf kecil jika di DB 'mikro'
        $limit    = 2000000;
    } elseif ($modal <= 500000000) {
        $kategori = 'kecil';
        $limit    = 10000000;
    } else {
        $kategori = 'menengah';
        $limit    = 50000000;
    }

    // 3. Simpan Data
    Umkm::create([
        'pengguna_id'        => Auth::id(),
        'nama_usaha'         => $validatedData['nama_usaha'],
        'no_whatsapp'        => $validatedData['no_whatsapp'],
        'npwp'               => $validatedData['npwp'],
        'alamat_usaha'       => $validatedData['alamat_usaha'],
        'status_tempat'      => $validatedData['status_tempat'],
        'luas_lahan'         => $validatedData['luas_lahan'],
        'kbli'               => $validatedData['kbli'],
        'jumlah_karyawan'    => $validatedData['jumlah_karyawan'] ?? 0,
        'modal_usaha'        => $modal,
        'kategori'           => $kategori, // Menggunakan variabel hasil logika, bukan request
        'limit_pinjaman'     => $limit,
        'saldo_pinjaman'     => 0,
        'omzet_tahunan'      => $validatedData['omzet_tahunan'] ?? 0,
        'kapasitas_produksi' => $validatedData['kapasitas_produksi'],
        'sistem_penjualan'   => $validatedData['sistem_penjualan'] ?? 'luring',
        'deskripsi'          => $validatedData['deskripsi'],
        'nama_bank'          => $validatedData['nama_bank'],
        'nomor_rekening'     => $validatedData['nomor_rekening'],
        'portfolio_produk'   => $portfolio, 
        'status'             => 'pending',
    ]);

    return redirect()->route('umkm.dashboard')->with('success', "Pendaftaran berhasil!");
}
    /**
     * Dashboard UMKM
     */
    public function index()
    {
        $user = Auth::user();
        $umkm = Umkm::where('pengguna_id', $user->id)->first();
        
        $labels = collect();
        $values = collect();
        $pinjamanModal = collect();

        if ($umkm) {
            $riwayatGrafik = PembiayaanModal::where('umkm_id', $umkm->id)
                                ->orderBy('created_at', 'asc')
                                ->take(6)
                                ->get();

            $labels = $riwayatGrafik->map(fn($q) => $q->created_at ? $q->created_at->format('d M') : 'N/A');
            $values = $riwayatGrafik->pluck('jumlah_pinjaman');
            $pinjamanModal = $umkm->PembiayaanModal; // Pastikan relasi di model Umkm sudah ada
        }

        $beritaHot = Berita::where('status_publish', 1)
                        ->orderBy('tanggal_publish', 'desc')
                        ->take(3)
                        ->get();

        return view('umkm.dashboard', compact('umkm', 'beritaHot', 'pinjamanModal', 'labels', 'values'));
    }

    /**
     * Pengajuan Pinjaman Baru
     */
    public function ajukanPinjaman(Request $request)
    {
        $umkm = Auth::user()->umkm;
        $maxPinjaman = $umkm->limit_pinjaman - $umkm->saldo_pinjaman;

        $request->validate([
            'jumlah_modal' => "required|numeric|min:10000|max:$maxPinjaman",
        ]);

        DB::transaction(function () use ($request, $umkm) {
            PembiayaanModal::create([
                'umkm_id'          => $umkm->id,
                'jumlah_pinjaman'  => $request->jumlah_modal,
                'tanggal_pinjam'   => now(),
                'tenggat_waktu'    => now()->addMonths(1),
                'status_pelunasan' => 'belum_lunas',
            ]);

            $umkm->increment('saldo_pinjaman', $request->jumlah_modal);
        });

        return redirect()->back()->with('success', 'Pencairan diproses! Dana akan dikirim ke rekening ' . $umkm->nama_bank);
    }

    /**
     * Integrasi Pembayaran Midtrans
     */
    public function bayar($id_pinjaman)
    {
        $umkm = Auth::user()->umkm;
        $pinjaman = PembiayaanModal::where('id', $id_pinjaman)
                        ->where('umkm_id', $umkm->id)
                        ->firstOrFail();

        if ($pinjaman->status_pelunasan === 'lunas') {
            return response()->json(['error' => 'Tagihan ini sudah lunas.'], 400);
        }
        
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id'     => 'PAY-' . $pinjaman->id . '-' . time(), 
                'gross_amount' => (int) $pinjaman->jumlah_pinjaman,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email'      => Auth::user()->email,
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Midtrans Callback
     */
    public function callback(Request $request)
    {
        $serverKey = config('services.midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {
            if (in_array($request->transaction_status, ['capture', 'settlement'])) {
                $id_pinjaman = explode('-', $request->order_id)[1];
                $pinjaman = PembiayaanModal::find($id_pinjaman);
                
                if ($pinjaman && $pinjaman->status_pelunasan !== 'lunas') {
                    DB::transaction(function () use ($pinjaman) {
                        $pinjaman->update(['status_pelunasan' => 'lunas']);
                        $pinjaman->umkm->decrement('saldo_pinjaman', $pinjaman->jumlah_pinjaman);
                    });
                }
            }
        }
        return response()->json(['status' => 'success']);
    }

    /**
     * Cetak PDF Bukti
     */
    public function cetakBukti($id)
    {
        $pinjam = PembiayaanModal::with('umkm')->findOrFail($id);
        if ($pinjam->umkm_id !== Auth::user()->umkm->id) {
            abort(403);
        }
        $pdf = Pdf::loadView('umkm.cetak_bukti', compact('pinjam'));
        return $pdf->download('Bukti_Transfer_'.$pinjam->id.'.pdf');
    }
}