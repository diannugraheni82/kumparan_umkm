<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'event';

    protected $fillable = [
    'nama_event',
    'tanggal',
    'kuota',
    'lokasi', 
    'mitra_id',
    ];

    public function mitra()
    {
        return $this->belongsTo(User::class, 'mitra_id');
    }

    public function umkms()
    {
        return $this->belongsToMany(User::class, 'pendaftaran_event', 'event_id', 'umkm_id')
                    ->withPivot('created_at') 
                    ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getSisaKuotaAttribute() {
        return $this->kuota - $this->jumlah_pendaftar;
    }

    public function getTersediaAttribute() {
        return $this->sisa_kuota > 0;
    }

    public function pendaftars()
    {
        return $this->hasMany(PendaftaranEvent::class, 'event_id');
    }

}