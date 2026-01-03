<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembiayaanModal extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table = 'pembiayaan_modal';
    protected $casts = [
        'tanggal_pinjam' => 'datetime',
    ];

    protected $fillable = [
        'umkm_id',
        'mitra_id',
        'jumlah_pinjaman',
        'tanggal_pinjam', 
        'tenggat_waktu', 
        'status_pelunasan'
    ];

    
    public function umkm()
    {
        return $this->belongsTo(Umkm::class, 'umkm_id');
    }

  
    public function mitra()
    {
        return $this->belongsTo(Pengguna::class, 'mitra_id');
    }

    
    public function cicilan()
    {
        return $this->hasMany(CicilanPembiayaan::class, 'pembiayaan_id');
    }
}
