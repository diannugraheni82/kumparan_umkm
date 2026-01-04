<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Umkm;
use App\Models\Event;
use App\Models\Lokasi; 
use Illuminate\Support\Facades\Auth;

class MitraController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $events = Event::where('mitra_id', auth()->id())
            ->with('umkms') 
            ->withCount('umkms') 
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
            'deskripsi'     => 'required|string|min:20',
        ]);

        Event::create([
            'mitra_id' => auth()->user()->id,
            'nama_event' => $request->nama_event,
            'lokasi_id' => $request->lokasi_id, 
            'tanggal' => $request->tanggal,
            'kuota' => $request->kuota,
            'deskripsi'     => $request->deskripsi,
        ]);

        return redirect()->back()->with('success', 'Event berhasil dipublikasikan!');
    }

    public function show($id)
    {
        $umkm = Umkm::findOrFail($id);
        return view('mitra.show', compact('umkm'));
    }

    public function ajukanKerjasama($id)
    {
        $umkm = \App\Models\Umkm::findOrFail($id);
        $mitra = auth()->user();

        \App\Models\Notifikasi::create([
            'pengguna_id' => $umkm->pengguna_id, 
            'pengirim_id' => $mitra->id,         
            'judul'       => 'Ajakan Kerjasama Baru',
            'pesan'       => "Mitra {$mitra->name} ingin bekerjasama dengan {$umkm->nama_usaha}.",
            'kategori'    => 'kolaborasi',       
            'status'      => 'pending',        
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

        Notifikasi::create([
            'pengirim_id' => $mitra->id,
            'judul'       => 'Ajakan Kolaborasi Baru',
            'pesan'       => "Mitra {$mitra->name} ingin berkolaborasi dengan usaha {$umkm->nama_usaha}.",
            'kategori'    => 'kolaborasi',
            'data_id'     => $mitra->id,
            'status'      => 'pending',
        ]);

        $pesanWa = "Halo {$umkm->nama_usaha}, saya {$mitra->name} tertarik berkolaborasi. Saya sudah mengirim undangan resmi di dashboard Anda.";
        $urlWa = "https://wa.me/{$umkm->no_whatsapp}?text=" . urlencode($pesanWa);

        return redirect($urlWa);
    }

    public function dashboard(Request $request)
    {
        $userId = auth()->id();
        $search = $request->query('search');

        $umkms = \App\Models\Umkm::where('status', 'aktif')
            ->when($search, function($query) use ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('nama_usaha', 'like', "%{$search}%")
                    ->orWhere('kategori', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        $notifikasi = \App\Models\Notifikasi::where('pengguna_id', $userId)
                        ->latest()
                        ->take(5)
                        ->get();
        $unreadCount = \App\Models\Notifikasi::where('pengguna_id', $userId)
                        ->where('dibaca', false)
                        ->count();

        return view('mitra.dashboard', compact('umkms', 'notifikasi', 'unreadCount'));
    }

    public function eksplorasi()
    {
        $user = auth()->user();

        $umkmsJoined = auth()->user()->umkms()
                        ->wherePivot('status', 'disetujui')
                        ->get();

        return view('mitra.eksplorasi', compact('umkmsJoined'));
    }

    public function partnerSaya()
    {
        $userId = auth()->id();

        $eventIds = \App\Models\Event::where('mitra_id', $userId)->pluck('id');

        $umkmsJoined = \App\Models\Umkm::whereHas('events', function($query) use ($eventIds) {
            $query->whereIn('event_id', $eventIds)
                ->where('status_kolaborasi', 'disetujui');
        })
        ->with(['events' => function($query) use ($eventIds) {
            $query->whereIn('event_id', $eventIds);
        }])
        ->get();

        return view('mitra.partner', compact('umkmsJoined'));
    }
}