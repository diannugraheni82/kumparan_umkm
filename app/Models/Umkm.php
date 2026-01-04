<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Umkm extends Model
{
    use HasFactory;

    protected $table = 'umkm';

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

    protected $casts = [
        'portfolio_produk' => 'array',
    ];

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }

    public function pembiayaanModal()
    {
        return $this->hasMany(PembiayaanModal::class, 'umkm_id');
    }

    public function pendaftaranEvent()
    {
        return $this->hasMany(PendaftaranEvent::class, 'umkm_id');
    }

    public function mitras()
    {
        return $this->belongsToMany(User::class, 'pendaftaran_event', 'pengguna_id', 'mitra_id')
                    ->withPivot('status_kolaborasi')
                    ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'pengguna_id'); 
    }
}