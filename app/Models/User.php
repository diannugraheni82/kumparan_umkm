<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use App\Models\Umkm;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'pengguna';
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nik',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    // app/Models/User.php

// app/Models/User.php

public function umkms()
{
    // 'pendaftaran_event' adalah nama tabel pivot Anda
    // 'status_kolaborasi' adalah kolom untuk membedakan mana yang sudah ACC
    return $this->belongsToMany(Umkm::class, 'pendaftaran_event', 'mitra_id', 'umkm_id')
                ->withPivot('status_kolaborasi', 'created_at')
                ->withTimestamps();
}

// app/Models/User.php

public function events()
{
    // Mengacu ke tabel 'event' yang Anda buat tadi
    return $this->hasMany(Event::class, 'mitra_id');
}

// app/Models/User.php
public function umkm()
{
    return $this->hasOne(Umkm::class, 'pengguna_id');
}
}