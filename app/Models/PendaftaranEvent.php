<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftaranEvent extends Model
{
    protected $table = 'pendaftaran_event';

    protected $fillable = [
        'event_id',
        'umkm_id',
        'status',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function umkm()
    {
        return $this->belongsTo(Umkm::class, 'umkm_id');
    }
}
