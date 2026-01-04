<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Umkm;
use App\Models\Event; // Tambahkan ini
use App\Models\CicilanPembiayaan; // Pastikan nama model benar sesuai file (CicilanPembiayaan)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    public function index()
    {
    $notifBaru = \App\Models\Umkm::where('status', 'pending')->latest()->get();    $totalNotif = $notifBaru->count();
        
        $totalUmkm = \App\Models\User::where('role', 'umkm')->count();
        $totalMitra = \App\Models\User::where('role', 'mitra')->count();

        $totalUangKeluar = \App\Models\PembiayaanModal::where('status_pelunasan', 'lunas')
                            ->sum('jumlah_pinjaman');

        $totalDanaMasuk = \App\Models\PembiayaanModal::where('status_pelunasan', 'lunas')
                            ->sum('jumlah_pinjaman');

        $pinjamanList = \App\Models\PembiayaanModal::with(['umkm.pengguna'])
                            ->latest()
                            ->paginate(10);

        $umkmList = \App\Models\Umkm::latest()->take(5)->get();
        $eventList = \App\Models\Event::orderBy('tanggal', 'desc')->take(5)->get();
        $mitraList = \App\Models\User::where('role', 'mitra')->latest()->take(5)->get();
        
        $notifPinjaman = \App\Models\PembiayaanModal::where('status_pelunasan', 'pending')->count();
        $pinjamanPending = \App\Models\PembiayaanModal::where('status_pelunasan', 'belum_lunas')->latest()->get();

        return view('admin.dashboard', compact(
            'totalUmkm', 
            'totalMitra', 
            'totalUangKeluar', 
            'totalDanaMasuk', 
            'umkmList', 
            'mitraList',
            'eventList', 
            'notifBaru',
            'notifPinjaman',
            'totalNotif',
            'pinjamanList',
            'pinjamanPending'
        ));
    }

    public function verifikasiIndex()
    {
        $daftarUmkm = \App\Models\Umkm::with('user') // atau 'pengguna' sesuai model Anda
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);

        return view('admin.verifikasi.index', compact('daftarUmkm'));
    }
   
    public function verifikasiUpdate(Request $request, $id)
    {
        $umkm = \App\Models\Umkm::findOrFail($id);
        
        $umkm->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Status UMKM berhasil diperbarui menjadi ' . $request->status);
    }
    public function pembayaranIndex()
    {
        $totalUmkm = Umkm::count();
        $totalMitra = User::where('role', 'mitra')->count();
        $totalUangKeluar = Umkm::where('status', 'lunas')->sum('saldo_pinjaman');
        $totalDanaMasuk = CicilanPembiayaan::sum('jumlah_bayar');

        $notifBaru = Umkm::where('status', 'pending')->where('saldo_pinjaman', 0)->get();
        $notifPinjaman = Umkm::where('status', 'pending')->where('saldo_pinjaman', '>', 0)->get();
        $totalNotif = $notifBaru->count() + $notifPinjaman->count();

        $pembayaranList = CicilanPembiayaan::with('pembiayaanModal.umkm')
                            ->latest()
                            ->paginate(10); 

        $pinjamanList = Umkm::where('status', 'disetujui')
                            ->where('saldo_pinjaman', '>', 0)
                            ->paginate(10); 

        $totalDanaMasuk = CicilanPembiayaan::sum('jumlah_bayar');
        $totalUangKeluar = Umkm::where('status', 'disetujui')->sum('saldo_pinjaman');
        return view('admin.cicilan_pembiayaan', compact(
            'pembayaranList', 
            'pinjamanList', 
            'totalUmkm', 
            'totalMitra', 
            'totalUangKeluar', 
            'totalDanaMasuk', 
            'notifBaru', 
            'notifPinjaman', 
            'totalNotif'
        ));
    }

    public function cetakLaporan(Request $request)
    {
        try {
            $tglMulai = $request->tgl_mulai;
            $tglSelesai = $request->tgl_selesai;

            $umkmQuery = \App\Models\Umkm::whereBetween('created_at', [$tglMulai . " 00:00:00", $tglSelesai . " 23:59:59"]);
            $mitraQuery = \App\Models\User::where('role', 'mitra')->whereBetween('created_at', [$tglMulai, $tglSelesai]);
            
            $danaMasukQuery = \App\Models\CicilanPembiayaan::whereBetween('tanggal_bayar', [$tglMulai, $tglSelesai]);

            $data = [
                'periode'         => \Carbon\Carbon::parse($tglMulai)->format('d/m/Y') . ' - ' . \Carbon\Carbon::parse($tglSelesai)->format('d/m/Y'),
                'totalUmkm'       => $umkmQuery->count(),
                'totalMitra'      => $mitraQuery->count(),
                'totalUangKeluar' => $umkmQuery->where('status', 'disetujui')->sum('saldo_pinjaman'),
                'totalDanaMasuk'  => $danaMasukQuery->sum('jumlah_bayar'), // INI PERBAIKANNYA
                'umkmList'        => $umkmQuery->get(),
                'mitraList'       => $mitraQuery->get(),
            ];

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.laporan_pdf', $data);
            
            return $pdf->download('Laporan-KUMPARAN-'.$tglMulai.'-ke-'.$tglSelesai.'.pdf');

        } catch (\Exception $e) {
            return "Gagal membuat PDF: " . $e->getMessage();
        }
    }

    public function eventIndex()
    {
        $eventList = \App\Models\Event::with('user.umkm')->latest()->paginate(10);

        return view('admin.event.index', compact('eventList'));
    }

    public function pinjamanIndex() 
    {
        $pinjamanList = \App\Models\PembiayaanModal::join('umkm', 'pembiayaan_modal.umkm_id', '=', 'umkm.id')
            ->select('pembiayaan_modal.*', 'umkm.nama_usaha')
            ->where('pembiayaan_modal.status_pelunasan', 'disetujui')
            ->paginate(10);

        $totalUangKeluar = \App\Models\PembiayaanModal::where('status_pelunasan', 'disetujui')
            ->sum('jumlah_pinjaman');

        return view('admin.cicilan_pembiayaan', compact('pinjamanList', 'totalUangKeluar'));
    }

    public function update(Request $request, $id)
    {
        $umkm = Umkm::findOrFail($id);
        $umkm->status = $request->status; 
        $umkm->save(); 

        return redirect()->route('admin.dashboard')->with('success', 'UMKM berhasil diverifikasi!');
    }

    public function showEvent($id)
    {
        $event = \App\Models\Event::with('mitra')->findOrFail($id);
        
        $pendaftar = \DB::table('pendaftaran_event')
            ->join('pengguna', 'pendaftaran_event.umkm_id', '=', 'pengguna.id')
            ->where('pendaftaran_event.event_id', $id)
            ->select('pengguna.name', 'pendaftaran_event.created_at')
            ->get();

        return view('admin.event.show', compact('event', 'pendaftar'));
    }
}