<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CicilanPembiayaan extends Model
{
    protected $table = 'cicilan_pembiayaan';

    protected $fillable = [
        'pembiayaan_modal_id', 
        'jumlah_bayar',
        'tanggal_bayar',
        'status',        
    ];

    public function pembiayaanModal()
    {
        return $this->belongsTo(PembiayaanModal::class, 'pembiayaan_modal_id');
    }

    public function getNamaUmkmAttribute()
    {
        return $this->pembiayaanModal->umkm->nama_usaha ?? 'N/A';
    }    
}