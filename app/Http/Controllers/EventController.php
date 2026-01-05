<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event; 
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $events = Event::where('mitra_id', $user->id)
                    ->withCount('umkms') 
                    ->latest() 
                    ->get();

        return view('mitra.events.index', compact('events'));
    }

    public function create()
    {
        return view('mitra.events.create');
    }

    public function store(Request $request) 
    {
        $validated = $request->validate([
            'nama_event' => 'required',
            'tanggal'    => 'required',
            'kuota'      => 'required|integer',
            'lokasi'     => 'required',
        ]);

        \App\Models\Event::create([
            'nama_event' => $validated['nama_event'],
            'tanggal'    => $validated['tanggal'],
            'kuota'      => $validated['kuota'],
            'lokasi'     => $validated['lokasi'],
            'deskripsi'  => '-', 
        ]);

        return redirect()->route('mitra.events.index')->with('success', 'Event berhasil dibuat');
    }

    public function daftarEvent(Request $request)
    {
        $umkm = \App\Models\Umkm::where('pengguna_id', auth()->id())->first();

        if (!$umkm) {
            return back()->with('error', 'Data UMKM tidak ditemukan.');
        }

        \App\Models\PendaftaranEvent::create([
            'event_id' => $request->event_id,
            'umkm_id'  => $umkm->id, 
            'status'   => 'pending',
        ]);
    }
}