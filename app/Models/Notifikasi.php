<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';
    protected $casts = [
    'created_at' => 'datetime',
];

    protected $fillable = [
        'pengguna_id', 
        'pengirim_id', 
        'judul',
        'pesan',
        'kategori',    
        'data_id',  
        'status',    
        'dibaca'
    ];

    
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }
}
