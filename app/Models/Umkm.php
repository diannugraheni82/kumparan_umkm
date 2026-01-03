<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'umkm';

    // Kolom yang boleh diisi (Mass Assignment)
    protected $fillable = [
        'pengguna_id', 
        'nama_usaha', 
        'no_whatsapp', 
        'npwp', 
        'alamat_usaha', 
        'status_tempat', 
        'luas_lahan', 
        'kbli', 
        'jumlah_karyawan', 
        'kategori', 
        'modal_usaha', 
        'omzet_tahunan',
        'limit_pinjaman', 
        'saldo_pinjaman',
        'kapasitas_produksi', 
        'sistem_penjualan', 
        'deskripsi', 
        'status',
        'nama_bank',
        'nomor_rekening',
        'portfolio_produk',
    ];

    // Mengubah data JSON/Array otomatis
    protected $casts = [
        'portfolio_produk' => 'array',
    ];
}