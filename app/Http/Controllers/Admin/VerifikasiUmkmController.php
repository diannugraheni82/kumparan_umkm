<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class VerifikasiUmkmController extends Controller
{
    public function index()
    {
        // Ambil data UMKM untuk ditampilkan di halaman verifikasi
        $daftarUmkm = DB::table('umkm')->get();
        return view('admin.verifikasi.index', compact('daftarUmkm'));
    }

    public function updateStatus(Request $request, $id)
    {
        // Update status UMKM (Aktif/Ditolak)
        DB::table('umkm')->where('id', $id)->update([
            'status' => $request->status,
            'updated_at' => now()
        ]);

        return back()->with('success', 'Status UMKM berhasil diperbarui!');
    }

    public function cetakPdf()
    {
        // Ambil data yang aktif saja untuk laporan PDF
        $dataUmkm = DB::table('umkm')->where('status', 'aktif')->get();
        
        // Memanggil view PDF
        $pdf = Pdf::loadView('admin.verifikasi.pdf', compact('dataUmkm'));
        
        return $pdf->download('laporan-umkm-aktif.pdf');
    }

    
}