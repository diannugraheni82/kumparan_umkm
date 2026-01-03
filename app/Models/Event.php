<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // Tambahkan nama tabel secara eksplisit jika nama tabel Anda 'event' (bukan 'events')
    protected $table = 'event';

    // Daftarkan kolom yang boleh diisi melalui form
    protected $fillable = [
        'mitra_id',
        'nama_event',
        'lokasi', // TAMBAHKAN INI
        'tanggal',
        'kuota',
    ];

    // Relasi ke User/Mitra
    public function mitra()
    {
        return $this->belongsTo(User::class, 'mitra_id');
    }

    public function umkms()
{
    // Sesuaikan dengan nama tabel pivot Anda (pendaftaran_event)
    return $this->belongsToMany(Umkm::class, 'pendaftaran_event', 'event_id', 'umkm_id');
}}