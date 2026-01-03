<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event; // Import model agar kode lebih bersih
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $events = Event::where('mitra_id', $user->id)
                    ->withCount('umkms') 
                    ->latest() // Menampilkan event terbaru di atas
                    ->get();

        return view('mitra.events.index', compact('events'));
    }

    public function create()
    {
        return view('mitra.events.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi input
        $validated = $request->validate([
            'nama_event' => 'required|string|max:255',
            'tanggal'    => 'required|date|after_or_equal:today', // Minimal tanggal hari ini
            'kuota'      => 'required|integer|min:1',
            'lokasi'     => 'required|string|max:255', 
        ]);

        // 2. Simpan ke Database
        Event::create([
            'mitra_id'   => Auth::id(),
            'nama_event' => $validated['nama_event'],
            'tanggal'    => $validated['tanggal'],
            'kuota'      => $validated['kuota'],
            // Karena nama kolom di database Anda 'lokasi_id' tapi berisi string,
            // kita masukkan data dari input 'lokasi'
            'lokasi_id'  => $validated['lokasi'], 
        ]);

        // 3. Redirect dengan pesan sukses
        return redirect()->route('mitra.events.index') // Sebaiknya kembali ke list event
                        ->with('success', 'Event berhasil dipublikasikan!');
    }
}