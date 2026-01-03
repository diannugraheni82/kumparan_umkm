<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
       $user = auth()->user();
    $events = \App\Models\Event::where('mitra_id', $user->id)
                ->withCount('umkms') 
                ->get();

    // Pastikan ini merujuk ke folder 'events', bukan 'create'
    return view('mitra.events.index', compact('events'));
}

    public function create()
    {
        return view('mitra.events.create'); // Buat file create.blade.php nanti
    }

    public function store(Request $request)
{
    $request->validate([
        'nama_event' => 'required|string|max:255',
        'tanggal' => 'required|date',
        'kuota' => 'required|integer|min:1',
        'lokasi' => 'required|string|max:255', // Validasi sebagai teks
    ]);

    \App\Models\Event::create([
        'mitra_id' => auth()->id(),
        'nama_event' => $request->nama_event,
        'tanggal' => $request->tanggal,
        'kuota' => $request->kuota,
        'lokasi' => $request->lokasi, // Simpan teks langsung
    ]);

    return redirect()->route('mitra.dashboard')->with('success', 'Event berhasil dipublikasikan!');
}
}