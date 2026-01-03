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
            'mitra_id' => auth()->user()->id,
            'nama_event' => $request->nama_event,
            'lokasi_id' => $request->lokasi_id, // Tambahkan baris ini
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

public function ajukanKerjasama($id)
{
    $umkm = \App\Models\Umkm::findOrFail($id);
    $mitra = auth()->user();

    // Simpan Notifikasi ke Database
    \App\Models\Notifikasi::create([
        'pengguna_id' => $umkm->pengguna_id, // Penerima (Pelaku UMKM)
        'pengirim_id' => $mitra->id,         // Pengirim (Mitra)
        'judul'       => 'Ajakan Kerjasama Baru',
        'pesan'       => "Mitra {$mitra->name} ingin bekerjasama dengan {$umkm->nama_usaha}.",
        'kategori'    => 'kolaborasi',       // Kategori khusus kerjasama
        'status'      => 'pending',          // Status awal
        'dibaca'      => false
    ]);

    return response()->json([
        'success'    => true,
        'no_wa'      => $umkm->no_whatsapp, 
        'nama_umkm'  => $umkm->nama_usaha,
        'nama_mitra' => $mitra->name
    ]);
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

// MitraController.php

public function dashboard(Request $request)
{
    $userId = auth()->id();
    $search = $request->query('search');

    // 1. Mengambil data UMKM yang sudah diverifikasi (Status: aktif)
    $umkms = \App\Models\Umkm::where('status', 'aktif')
        ->when($search, function($query) use ($search) {
            $query->where(function($q) use ($search) {
                // Mencari berdasarkan nama usaha atau kategori
                $q->where('nama_usaha', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%");
            });
        })
        ->latest()
        ->get();

    // 2. Mengambil data Notifikasi asli dari database untuk Mitra
    // Kita ambil 5 notifikasi terbaru
    $notifikasi = \App\Models\Notifikasi::where('pengguna_id', $userId)
                    ->latest()
                    ->take(5)
                    ->get();

    // 3. Menghitung jumlah notifikasi yang belum dibaca (untuk badge merah di lonceng)
    $unreadCount = \App\Models\Notifikasi::where('pengguna_id', $userId)
                    ->where('dibaca', false)
                    ->count();

    // 4. Mengirim semua variabel ke view mitra.dashboard
    return view('mitra.dashboard', compact('umkms', 'notifikasi', 'unreadCount'));
}
// app/Http/Controllers/MitraController.php

public function eksplorasi()
{
    $user = auth()->user();

    // Mengambil UMKM yang terhubung dengan Mitra ini dan statusnya 'disetujui'
// Mengambil UMKM yang sudah ACC kolaborasi
$umkmsJoined = auth()->user()->umkms()
                    ->wherePivot('status_kolaborasi', 'disetujui')
                    ->get();

    return view('mitra.eksplorasi', compact('umkmsJoined'));
}
}
