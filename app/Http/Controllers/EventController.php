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

// Di dalam EventController.php fungsi store
public function store(Request $request) 
{
    $validated = $request->validate([
        'nama_event' => 'required',
        'tanggal'    => 'required',
        'kuota'      => 'required|integer',
        'lokasi'     => 'required',
        // Jangan tambahkan deskripsi required di sini jika di form blade sudah dihapus
    ]);

    \App\Models\Event::create([
        'nama_event' => $validated['nama_event'],
        'tanggal'    => $validated['tanggal'],
        'kuota'      => $validated['kuota'],
        'lokasi'     => $validated['lokasi'],
        'deskripsi'  => '-', // WAJIB ADA BARIS INI agar database tidak menolak
        'mitra_id'   => auth()->id(), 
    ]);

    return redirect()->route('mitra.events.index')->with('success', 'Event berhasil dibuat');
}}