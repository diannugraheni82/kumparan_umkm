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
     * Menampilkan Form Pendaftaran UMKM
     */
    public function create()
    {
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
        ]);

        // Olah Portfolio
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

        // Logika Penentuan Kategori & Limit
        $modal = $request->modal_usaha;
        if ($modal <= 50000000) {
            $kategori = 'mikro';
            $limit    = 2000000;
        } elseif ($modal <= 500000000) {
            $kategori = 'kecil';
            $limit    = 10000000;
        } else {
            $kategori = 'menengah';
            $limit    = 50000000;
        }

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
            'kategori'           => $kategori,
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
     * Dashboard UMKM (Dengan Logika Notifikasi Tetap)
     */
    public function index()
    {
        $user = Auth::user();
        $umkm = Umkm::where('pengguna_id', $user->id)->first();

        if (!$umkm) {
            return view('umkm.dashboard-empty'); 
        }

        // Ambil riwayat pinjaman dari database
        $riwayatPinjaman = PembiayaanModal::where('umkm_id', $umkm->id)
            ->orderBy('tanggal_pinjam', 'desc')
            ->get();

        // LOGIKA NOTIFIKASI LONCENG
        $listNotifikasi = [];

        // 1. Cek Status Verifikasi Akun
        if ($umkm->status == 'aktif') {
            $listNotifikasi[] = [
                'judul' => 'Akun Terverifikasi',
                'pesan' => 'Selamat! Usaha ' . $umkm->nama_usaha . ' telah aktif.',
                'icon'  => 'bi-patch-check-fill',
                'warna' => 'text-success'
            ];
        }

        // 2. Cek Status Pembayaran (Lunas)
        foreach ($riwayatPinjaman as $p) {
            if ($p->status_pelunasan == 'lunas') {
                $listNotifikasi[] = [
                    'judul' => 'Tagihan Lunas',
                    'pesan' => 'Pembayaran Rp' . number_format($p->jumlah_pinjaman) . ' berhasil.',
                    'icon'  => 'bi-cash-coin',
                    'warna' => 'text-primary'
                ];
            }
        }

        // Persiapan Data Chart
        $labels = $riwayatPinjaman->map(function($item) {
            return $item->tanggal_pinjam ? \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M') : '';
        })->filter()->toArray();
        $values = $riwayatPinjaman->pluck('jumlah_pinjaman')->toArray();

        $sisaLimit = $umkm->limit_pinjaman - $umkm->saldo_pinjaman;
        $maxPinjaman = max(0, $sisaLimit);

        return view('umkm.dashboard', compact(
            'umkm', 
            'riwayatPinjaman', 
            'labels', 
            'values', 
            'maxPinjaman', 
            'listNotifikasi'
        ));
    }

    /**
     * Proses Pengajuan Pinjaman
     */
    public function ajukanPinjaman(Request $request)
    {
        $umkm = Umkm::where('pengguna_id', Auth::id())->firstOrFail();
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
        $umkm = Umkm::where('pengguna_id', Auth::id())->firstOrFail();
        $pinjaman = PembiayaanModal::where('id', $id_pinjaman)
                        ->where('umkm_id', $umkm->id)
                        ->firstOrFail();

        if ($pinjaman->status_pelunasan === 'lunas') {
            return back()->with('error', 'Tagihan ini sudah lunas.');
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
            return view('umkm.pembayaran', compact('snapToken', 'pinjaman'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Handle Konfirmasi Pembayaran Sukses (Manual/Redirect)
     */
    public function pembayaranSukses($id)
    {
        $pinjaman = PembiayaanModal::findOrFail($id);
        
        if ($pinjaman->status_pelunasan !== 'lunas') {
            DB::transaction(function () use ($pinjaman) {
                $pinjaman->update([
                    'status_pelunasan' => 'lunas',
                    'tanggal_lunas' => now()
                ]);
                $pinjaman->umkm->decrement('saldo_pinjaman', $pinjaman->jumlah_pinjaman);
            });
        }

        return redirect()->route('umkm.dashboard')->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }

    /**
     * Cetak PDF Bukti Pembayaran
     */
    public function cetakBukti($id)
    {
        $pinjam = PembiayaanModal::with('umkm')->findOrFail($id);
        $umkm = Umkm::where('pengguna_id', Auth::id())->first();

        if ($pinjam->umkm_id !== $umkm->id) {
            abort(403);
        }

        $pdf = Pdf::loadView('umkm.cetak_bukti', compact('pinjam'));
        return $pdf->download('Struk-Pembayaran-'.$pinjam->id.'.pdf');
    }

    public function accKerjasama($id) {
    $notif = \App\Models\Notifikasi::findOrFail($id);
    $notif->update(['status' => 'disetujui', 'dibaca' => true]); //
    return back()->with('success', 'Kerjasama diterima!');
}

public function tolakKerjasama($id) {
    $notif = \App\Models\Notifikasi::findOrFail($id);
    $notif->update(['status' => 'ditolak', 'dibaca' => true]); //
    return back()->with('info', 'Kerjasama ditolak.');
}
}