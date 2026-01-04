<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use App\Models\Berita;
use App\Models\Event;
use App\Models\PembiayaanModal;
use App\Models\Notifikasi;
use App\Models\PendaftaranEvent;
use App\Models\User;
use App\Models\Pinjaman;
use App\Models\Kerjasama;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Midtrans\Config;
use Midtrans\Snap;
use Carbon\Carbon;

class UmkmController extends Controller
{
   
    public function index()
    {
        $user = Auth::user();
        $umkm = Umkm::where('pengguna_id', $user->id)->first();

        $notifikasi = Notifikasi::where('pengguna_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->get();

        $unreadCount = $notifikasi->where('dibaca', false)->count();
            if (!$umkm) {
                return view('umkm.dashboard-empty', compact('notifikasi', 'unreadCount'));
            }

        $events = Event::where('tanggal', '>=', now())
            ->orderBy('tanggal', 'asc')
            ->take(3)
            ->get();

        $riwayatPinjaman = PembiayaanModal::where('umkm_id', $umkm->id)->get();
        $labels = ['Jan', 'Feb', 'Mar']; // Sesuaikan dengan logika Anda
        $values = [0, 0, 0]; // Sesuaikan dengan logika Anda
        $maxPinjaman = $umkm->limit_pinjaman - $umkm->saldo_pinjaman;
        $sisaLimit = $umkm->limit_pinjaman - $umkm->saldo_pinjaman;
        $maxPinjaman = max(0, $sisaLimit);

        $listNotifikasi = [];
        if ($umkm->status == 'aktif') {
            $listNotifikasi[] = [
                'judul' => 'Akun Terverifikasi',
                'pesan' => 'Selamat! Usaha ' . $umkm->nama_usaha . ' telah aktif.',
                'icon'  => 'bi-patch-check-fill',
                'warna' => 'text-success'
            ];
        }

        return view('umkm.dashboard', compact(
            'umkm', 'riwayatPinjaman', 'labels', 'values', 
            'maxPinjaman', 'notifikasi', 'unreadCount', 
            'listNotifikasi', 'events', 'maxPinjaman'
        ));
    }

    public function create()
    {
        return view('umkm.input_data');
    }

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

        // $portfolio = [];
        // if ($request->has('produk_nama')) {
        //     foreach ($request->produk_nama as $key => $namaProduk) {
        //         $path = $request->hasFile("produk_foto.$key") 
        //             ? $request->file("produk_foto.$key")->store('produk', 'public') 
        //             : null;
        //         $portfolio[] = [
        //             'nama' => $namaProduk,
        //             'detail' => $request->produk_detail[$key] ?? '',
        //             'foto' => $path
        //         ];
        //     }
        // }

        $modal = $request->modal_usaha;
        if ($modal <= 50000000) {
            $kategori = 'mikro'; $limit = 2000000;
        } elseif ($modal <= 500000000) {
            $kategori = 'kecil'; $limit = 10000000;
        } else {
            $kategori = 'menengah'; $limit = 50000000;
        }

        Umkm::create(array_merge($validatedData, [
            'pengguna_id'    => Auth::id(),
            'kategori'       => $kategori,
            'limit_pinjaman' => $limit,
            'saldo_pinjaman' => 0,
            'portfolio_produk' => $portfolio,
            'status'         => 'pending'
        ]));

        return redirect()->route('umkm.dashboard')->with('success', "Pendaftaran berhasil!");
    }

    public function edit()
    {
        $user = Auth::user();
        $umkm = Umkm::where('pengguna_id', $user->id)->firstOrFail();
        
        $notifikasi = Notifikasi::where('pengguna_id', $user->id)->latest()->get();
        $unreadCount = $notifikasi->where('dibaca', false)->count();

        return view('umkm.edit_data', compact('umkm', 'notifikasi', 'unreadCount'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $umkm = Umkm::where('pengguna_id', $user->id)->firstOrFail();

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
            'produk_nama.*'      => 'nullable|string',
            'produk_detail.*'    => 'nullable|string',
            'produk_foto.*'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->has('produk_nama')) {
            $portfolio = [];
            foreach ($request->produk_nama as $key => $namaProduk) {
                if ($request->hasFile("produk_foto.$key")) {
                    $path = $request->file("produk_foto.$key")->store('produk', 'public');
                } else {
                    $oldPortfolio = $umkm->portfolio_produk ?? [];
                    $path = $oldPortfolio[$key]['foto'] ?? null;
                }
                $portfolio[] = ['nama' => $namaProduk, 'detail' => $request->produk_detail[$key] ?? '', 'foto' => $path];
            }
            $validatedData['portfolio_produk'] = $portfolio;
        }

        $modal = $request->modal_usaha;
        if ($modal <= 50000000) {
            $validatedData['kategori'] = 'mikro'; $validatedData['limit_pinjaman'] = 2000000;
        } elseif ($modal <= 500000000) {
            $validatedData['kategori'] = 'kecil'; $validatedData['limit_pinjaman'] = 10000000;
        } else {
            $validatedData['kategori'] = 'menengah'; $validatedData['limit_pinjaman'] = 50000000;
        }

        $umkm->update($validatedData);
        return redirect()->route('umkm.dashboard')->with('success', 'Data berhasil diperbarui!');
    }

    public function semuaEvent()
    {
        $user = Auth::user();
        $umkm = Umkm::where('pengguna_id', $user->id)->first();

        // 1. Ambil data event dari database
        $events = Event::where('tanggal', '>=', now())
                    ->orderBy('tanggal', 'asc')
                    ->get();

        // 2. Tambahkan logika pendukung (sisa kuota & status daftar)
        foreach ($events as $event) {
            $event->sisa_kuota = $event->kuota - $event->pendaftars()->count();
            $event->sudah_daftar = PendaftaranEvent::where('event_id', $event->id)
                                                ->where('umkm_id', $umkm->id)
                                                ->exists();
            $event->tersedia = ($event->sisa_kuota > 0);
        }

        // 3. WAJIB: masukkan 'events' ke dalam compact
        return view('umkm.semua_event', compact('events', 'umkm'));
    }

    public function daftarEvent($event_id)
    {
        $umkm = Umkm::where('pengguna_id', Auth::id())->firstOrFail();
        $event = Event::findOrFail($event_id);

        $jumlahPendaftar = PendaftaranEvent::where('event_id', $event_id)->count();
            if ($jumlahPendaftar >= $event->kuota) {
                return back()->with('error', 'Maaf, kuota event ini sudah penuh.');
            }

            if (PendaftaranEvent::where('event_id', $event_id)->where('umkm_id', $umkm->id)->exists()) {
                return back()->with('error', 'Anda sudah terdaftar di event ini.');
            }

            DB::transaction(function () use ($event, $umkm) {
                PendaftaranEvent::create([
                    'event_id' => $event->id,
                    'umkm_id' => $umkm->id,
                    'mitra_id' => $event->mitra_id,
                    'status' => 'pending',
                ]);

            Notifikasi::create([
                'pengguna_id' => $event->mitra_id,
                'pengirim_id' => Auth::id(),
                'judul' => 'Pendaftaran Event Baru',
                'pesan' => "UMKM {$umkm->nama_usaha} mendaftar ke event '{$event->nama_event}'.",
                'kategori' => 'event',
                'status' => 'pending'
            ]);
        });

        return back()->with('success', 'Pendaftaran event berhasil!');
    }

    public function ajukanPinjaman(Request $request)
    {
        $umkm = Umkm::where('pengguna_id', Auth::id())->firstOrFail();
        $maxPinjaman = $umkm->limit_pinjaman - $umkm->saldo_pinjaman;

        $request->validate(['jumlah_modal' => "required|numeric|min:10000|max:$maxPinjaman"]);

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

        return back()->with('success', 'Pencairan diproses ke rekening ' . $umkm->nama_bank);
    }

    public function bayar($id_pinjaman)
    {
        $umkm = Umkm::where('pengguna_id', Auth::id())->firstOrFail();
        $pinjaman = PembiayaanModal::where('id', $id_pinjaman)->where('umkm_id', $umkm->id)->firstOrFail();

        if ($pinjaman->status_pelunasan === 'lunas') return back()->with('error', 'Sudah lunas.');
        
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');

        $params = [
            'transaction_details' => ['order_id' => 'PAY-'.$pinjaman->id.'-'.time(), 'gross_amount' => (int)$pinjaman->jumlah_pinjaman],
            'customer_details' => ['first_name' => Auth::user()->name, 'email' => Auth::user()->email],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return view('umkm.pembayaran', compact('snapToken', 'pinjaman'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function pembayaranSukses($id)
    {
        $pinjaman = PembiayaanModal::findOrFail($id);
        if ($pinjaman->status_pelunasan !== 'lunas') {
            DB::transaction(function () use ($pinjaman) {
                $pinjaman->update(['status_pelunasan' => 'lunas', 'tanggal_lunas' => now()]);
                $pinjaman->umkm->decrement('saldo_pinjaman', $pinjaman->jumlah_pinjaman);
            });
        }
        return redirect()->route('umkm.dashboard')->with('success', 'Pembayaran berhasil!');
    }

    public function cetakBukti($id)
    {
        $pinjam = PembiayaanModal::with('umkm')->findOrFail($id);
        if ($pinjam->umkm->pengguna_id !== Auth::id()) abort(403);

        return Pdf::loadView('umkm.cetak_bukti', compact('pinjam'))->download('Struk-'.$pinjam->id.'.pdf');
    }

    public function accKerjasama($id)
    {
        $notifLama = Notifikasi::findOrFail($id);
        $umkm = Umkm::where('pengguna_id', Auth::id())->firstOrFail();

        DB::transaction(function () use ($notifLama, $umkm) {
            $notifLama->update(['status' => 'disetujui', 'dibaca' => true]);

            PendaftaranEvent::where('umkm_id', $umkm->id)
                ->where('event_id', $notifLama->event_id) 
                ->update(['status' => 'disetujui']);

            Notifikasi::create([
                'pengguna_id' => $notifLama->pengirim_id, 
                'pengirim_id' => Auth::id(),             
                'judul'       => 'Kerjasama Disetujui',
                'pesan'       => 'UMKM ' . $umkm->nama_usaha . ' telah menyetujui ajakan kerjasama Anda.',
                'kategori'    => 'event',
                'status'      => 'disetujui',
                'dibaca'      => false
            ]);
        });

        return redirect()->back()->with('success', 'Kerjasama telah disetujui!');
    }


    public function tolakKerjasama($id) 
    {
        $notifLama = Notifikasi::findOrFail($id);
        $umkm = Umkm::where('pengguna_id', Auth::id())->firstOrFail();
        
        DB::transaction(function () use ($notifLama, $umkm) {
            $notifLama->update(['status' => 'ditolak', 'dibaca' => true]);

            PendaftaranEvent::where('umkm_id', $umkm->id)
                ->where('event_id', $notifLama->event_id) 
                ->update(['status' => 'ditolak']);

            Notifikasi::create([
                'pengguna_id' => $notifLama->pengirim_id, 
                'pengirim_id' => Auth::id(),             
                'judul'       => 'Kolaborasi Ditolak',
                'pesan'       => "UMKM {$umkm->nama_usaha} belum bisa menerima kolaborasi.",
                'kategori'    => 'event',
                'status'      => 'ditolak',
                'dibaca'      => false
            ]);
        });
        return back()->with('info', 'Kerjasama ditolak.');
    }
}