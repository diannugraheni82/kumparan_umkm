<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    protected $table = 'umkm';
protected $fillable = [
    'pengguna_id', 'nama_usaha', 'no_whatsapp', 'npwp', 'alamat_usaha', 
    'status_tempat', 'luas_lahan', 'kbli', 'jumlah_karyawan', 'modal_usaha', 
    'kategori', 'omzet_tahunan', 'kapasitas_produksi', 'sistem_penjualan', 
    'limit_pinjaman', 'saldo_pinjaman', 'nama_bank', 'nomor_rekening', 
    'deskripsi', 'portfolio_produk', 'status'
];

// Sangat Penting: Cast portfolio_produk agar JSON terbaca sebagai Array
protected $casts = [
    'portfolio_produk' => 'array',
];
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriUmkm::class, 'kategori_id');
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id');
    }

    public function legalitas()
    {
        return $this->hasOne(LegalitasUmkm::class, 'umkm_id');
    }

    public function PembiayaanModal()
    {
        return $this->hasMany(PembiayaanModal::class, 'umkm_id');
    }

    public function pendaftaranEvent()
    {
        return $this->hasMany(PendaftaranEvent::class, 'umkm_id');
    }
}
