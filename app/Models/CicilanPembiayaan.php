<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CicilanPembiayaan extends Model
{
    protected $table = 'cicilan_pembiayaan';

    protected $fillable = [
        'pembiayaan_modal_id', // Pastikan nama kolom di sini SAMA dengan di relasi bawah
        'jumlah_bayar',
        'tanggal_bayar',
        'status',        
    ];

    /**
     * Relasi ke PembiayaanModal
     */
    public function pembiayaanModal()
    {
        // Pastikan foreign key 'pembiayaan_modal_id' memang ada di tabel cicilan_pembiayaan
        return $this->belongsTo(PembiayaanModal::class, 'pembiayaan_modal_id');
    }

    /**
     * Accessor untuk mengambil nama UMKM secara praktis
     * Cara panggil di Blade: {{ $item->nama_umkm }}
     */
    public function getNamaUmkmAttribute()
    {
        // Menelusuri: Cicilan -> PembiayaanModal -> Umkm -> nama_usaha
        return $this->pembiayaanModal->umkm->nama_usaha ?? 'N/A';
    }    
}