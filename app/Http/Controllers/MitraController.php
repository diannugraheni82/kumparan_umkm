<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Umkm;
use App\Models\Event;
use App\Models\Lokasi; // Tambahkan ini
use Illuminate\Support\Facades\Auth;

class MitraController extends Controller
{
    public function index()
{
    $user = auth()->user();
    
    $events = \App\Models\Event::where('mitra_id', $user->id)
                ->withCount('umkms') 
                ->orderBy('created_at', 'desc')
                ->get();

    return view('mitra.events.index', compact('events'));
}

    public function storeEvent(Request $request)
    {
        $request->validate([
            'nama_event' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'kuota' => 'required|integer',
            'lokasi_id' => 'required|exists:lokasi,id',
        ]);

        Event::create([
            'mitra_id' => Auth::id(), // Sesuai kolom di image_c57967.png
            'lokasi_id' => $request->lokasi_id,
            'nama_event' => $request->nama_event,
            'tanggal' => $request->tanggal,
            'kuota' => $request->kuota,
        ]);

        return redirect()->back()->with('success', 'Event berhasil dipublikasikan!');
    }

    public function show($id)
{
    // Mencari data UMKM berdasarkan ID, jika tidak ada akan muncul error 404
    $umkm = Umkm::findOrFail($id);
    
    // Mengembalikan view detail (pastikan file view-nya sudah ada)
    return view('mitra.show', compact('umkm'));
}

public function ajukanKolaborasi(Request $request, Umkm $umkm)
{
    // 1. Ambil User ID pemilik UMKM (Pelaku UMKM)
    $pelakuUmkm = $umkm->user; 

    // 2. Simpan notifikasi ke tabel 'notifications'
    // Jika menggunakan sistem Notifikasi Laravel (Database Notification)
    $pelakuUmkm->notify(new \App\Notifications\UndanganKolaborasi(auth()->user(), $umkm));

    // 3. Siapkan Link WhatsApp
    $pesanWa = urlencode("Halo " . $umkm->nama_usaha . ", saya " . auth()->user()->name . " dari perusahaan Mitra tertarik untuk berkolaborasi.");
    $waUrl = "https://wa.me/" . $umkm->no_whatsapp . "?text=" . $pesanWa;

    return redirect($waUrl);
}

public function kirimKolaborasi(Request $request, $umkm_id)
{
    $umkm = Umkm::findOrFail($umkm_id);
    $mitra = auth()->user();

    // AKTIVITAS 1: Simpan Notifikasi ke Database untuk Pelaku UMKM
    Notifikasi::create([
        'pengguna_id' => $umkm->user_id, // Pemilik UMKM
        'pengirim_id' => $mitra->id,
        'judul'       => 'Ajakan Kolaborasi Baru',
        'pesan'       => "Mitra {$mitra->name} ingin berkolaborasi dengan usaha {$umkm->nama_usaha}.",
        'kategori'    => 'kolaborasi',
        'data_id'     => $mitra->id,
        'status'      => 'pending',
    ]);

    // AKTIVITAS 2: Siapkan Link WhatsApp
    $pesanWa = "Halo {$umkm->nama_usaha}, saya {$mitra->name} tertarik berkolaborasi. Saya sudah mengirim undangan resmi di dashboard Anda.";
    $urlWa = "https://wa.me/{$umkm->no_whatsapp}?text=" . urlencode($pesanWa);

    // Redirect ke WhatsApp (Gunakan target _blank di View)
    return redirect($urlWa);
}

public function dashboard()
{
    // 1. Dashboard menampilkan UMKM yang sudah diverifikasi admin
    // (Bukan berdasarkan relasi kerjasama, tapi status akun UMKM itu sendiri)
    $umkms = \App\Models\Umkm::where('status', 'verified')->get();

    return view('mitra.dashboard', compact('umkms'));
}

// app/Http/Controllers/MitraController.php

public function eksplorasi()
{
    $user = auth()->user();

    // Mengambil UMKM yang terhubung dengan Mitra ini dan statusnya 'disetujui'
    $umkmsJoined = $user->umkms()
                        ->wherePivot('status_kolaborasi', 'disetujui')
                        ->orderBy('pendaftaran_event.created_at', 'desc')
                        ->get();

    return view('mitra.eksplorasi', compact('umkmsJoined'));
}
}
