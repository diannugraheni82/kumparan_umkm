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

    /**
     * Casting data otomatis.
     * Mengubah format JSON dari database menjadi Array di Laravel secara otomatis.
     */
    protected $casts = [
        'portfolio_produk' => 'array',
        'modal_usaha' => 'integer',
        'limit_pinjaman' => 'integer',
        'saldo_pinjaman' => 'integer',
    ];

    // --- RELASI DATABASE ---

    /**
     * Relasi ke User (Pemilik UMKM)
     */
    public function pengguna()
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }

    /**
     * Relasi ke Pembiayaan Modal
     * Menggunakan camelCase (pembiayaanModal) adalah standar Laravel.
     */
    public function pembiayaanModal()
    {
        return $this->hasMany(PembiayaanModal::class, 'umkm_id');
    }

    /**
     * Relasi ke Pendaftaran Event (Tabel Pivot)
     */
    public function pendaftaranEvent()
    {
        return $this->hasMany(PendaftaranEvent::class, 'umkm_id');
    }

    /**
     * Relasi Many-to-Many ke Mitra melalui tabel pivot 'pendaftaran_event'
     * Ini krusial agar Mitra bisa melihat UMKM yang berkolaborasi dengannya.
     */
    public function mitras()
    {
        return $this->belongsToMany(User::class, 'pendaftaran_event', 'umkm_id', 'mitra_id')
                    ->withPivot('status_kolaborasi')
                    ->withTimestamps();
    }
}