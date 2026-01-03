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
    /**
     * Menampilkan Halaman Dashboard Utama Admin
     */
public function index()
{
    // 1. Ambil Notifikasi (UMKM Pending)
$notifBaru = \App\Models\Umkm::where('status', 'pending')->latest()->get();    $totalNotif = $notifBaru->count();
    
    // 2. Statistik Pengguna
    $totalUmkm = \App\Models\User::where('role', 'umkm')->count();
    $totalMitra = \App\Models\User::where('role', 'mitra')->count();

    // 3. Keuangan (Berdasarkan status 'lunas' sesuai database Anda)
    // Dana Keluar: Total pinjaman yang sudah diberikan/lunas
    $totalUangKeluar = \App\Models\PembiayaanModal::where('status_pelunasan', 'lunas')
                        ->sum('jumlah_pinjaman');

    // Dana Masuk: (Jika Anda menggunakan tabel yang sama, sesuaikan logikanya)
    $totalDanaMasuk = \App\Models\PembiayaanModal::where('status_pelunasan', 'lunas')
                        ->sum('jumlah_pinjaman');

    // 4. Daftar Pinjaman untuk Tabel (Pastikan Relasi Eager Loading)
    $pinjamanList = \App\Models\PembiayaanModal::with(['umkm.pengguna'])
                        ->latest()
                        ->paginate(10);

    // 5. Data Pendukung Dashboard lainnya
    $umkmList = \App\Models\Umkm::latest()->take(5)->get();
    $eventList = \App\Models\Event::latest()->take(5)->get();
    $mitraList = \App\Models\User::where('role', 'mitra')->latest()->take(5)->get();
    
    // Menghitung pengajuan yang masih menunggu (pending)
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
    /**
     * Menampilkan daftar semua UMKM untuk Verifikasi
     */
public function verifikasiIndex()
{
    // Mengambil UMKM dengan status pending
    $daftarUmkm = \App\Models\Umkm::with('user') // atau 'pengguna' sesuai model Anda
        ->where('status', 'pending')
        ->latest()
        ->paginate(10);

    // Kirim variabel 'daftarUmkm' ke view
    return view('admin.verifikasi.index', compact('daftarUmkm'));
}
    /**
     * Menyetujui atau Menolak UMKM
     */
public function verifikasiUpdate(Request $request, $id)
{
    $umkm = \App\Models\Umkm::findOrFail($id);
    
    // Update status berdasarkan tombol yang diklik (disetujui/ditolak)
    $umkm->update([
        'status' => $request->status
    ]);

    return redirect()->back()->with('success', 'Status UMKM berhasil diperbarui menjadi ' . $request->status);
}
public function pembayaranIndex()
{
    // 1. Data Statistik (untuk angka di atas)
    $totalUmkm = Umkm::count();
    $totalMitra = User::where('role', 'mitra')->count();
    $totalUangKeluar = Umkm::where('status', 'lunas')->sum('saldo_pinjaman');
    $totalDanaMasuk = CicilanPembiayaan::sum('jumlah_bayar');

    // 2. Notifikasi
    $notifBaru = Umkm::where('status', 'pending')->where('saldo_pinjaman', 0)->get();
    $notifPinjaman = Umkm::where('status', 'pending')->where('saldo_pinjaman', '>', 0)->get();
    $totalNotif = $notifBaru->count() + $notifPinjaman->count();

    // 3. Data Riwayat Pembayaran (Ini yang ditampilkan di tabel utama)
$pembayaranList = CicilanPembiayaan::with('pembiayaanModal.umkm')
                        ->latest()
                        ->paginate(10); 

    // 2. Ambil daftar pinjaman aktif
    // Jika di Blade Anda juga menggunakan {{ $pinjamanList->links() }}, maka gunakan paginate juga di sini:
    $pinjamanList = Umkm::where('status', 'disetujui')
                        ->where('saldo_pinjaman', '>', 0)
                        ->paginate(10); // Ubah dari get() menjadi paginate()

    // 3. Statistik (Opsional, pastikan variabel ini ada)
    $totalDanaMasuk = CicilanPembiayaan::sum('jumlah_bayar');
    $totalUangKeluar = Umkm::where('status', 'disetujui')->sum('saldo_pinjaman');
    return view('admin.cicilan_pembiayaan', compact(
        'pembayaranList', 
        'pinjamanList', // Pastikan variabel ini dikirim!
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

        // 1. Query UMKM & Mitra
        $umkmQuery = \App\Models\Umkm::whereBetween('created_at', [$tglMulai . " 00:00:00", $tglSelesai . " 23:59:59"]);
        $mitraQuery = \App\Models\User::where('role', 'mitra')->whereBetween('created_at', [$tglMulai, $tglSelesai]);
        
        // 2. Query Dana Masuk (Cicilan) - Pastikan nama model & kolom tanggal sesuai
        $danaMasukQuery = \App\Models\CicilanPembiayaan::whereBetween('tanggal_bayar', [$tglMulai, $tglSelesai]);

        // 3. Siapkan semua variabel yang dipanggil di laporan_pdf.blade.php
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
        // Jika masih error, pesan ini akan memberitahu variabel apa lagi yang kurang
        return "Gagal membuat PDF: " . $e->getMessage();
    }
}

public function eventIndex()
{
    // 1. Ambil data event dari database
    // Pastikan Model Event sudah ada dan relasi 'user' sudah didefinisikan
    $eventList = \App\Models\Event::with('user.umkm')->latest()->paginate(10);

    // 2. Kirim variabel ke view
    // Pastikan nama variabel di compact('eventList') sama dengan di Blade $eventList
    return view('admin.event.index', compact('eventList'));
}
/**
 * Menampilkan Daftar Pinjaman/Pembiayaan UMKM
 */
public function pinjamanIndex() // atau pembayaranIndex tergantung route Anda
{
    $pinjamanList = \App\Models\PembiayaanModal::join('umkm', 'pembiayaan_modal.umkm_id', '=', 'umkm.id')
        ->select('pembiayaan_modal.*', 'umkm.nama_usaha')
        ->where('pembiayaan_modal.status_pelunasan', 'disetujui')
        ->paginate(10);

    // Hitung total uang keluar
    $totalUangKeluar = \App\Models\PembiayaanModal::where('status_pelunasan', 'disetujui')
        ->sum('jumlah_pinjaman');

    return view('admin.cicilan_pembiayaan', compact('pinjamanList', 'totalUangKeluar'));
}

public function update(Request $request, $id)
{
    $umkm = Umkm::findOrFail($id);
    $umkm->status = $request->status; // Mengambil nilai 'aktif' dari form
    $umkm->save(); // JANGAN LUPA BARIS INI

    return redirect()->route('admin.dashboard')->with('success', 'UMKM berhasil diverifikasi!');
}



}