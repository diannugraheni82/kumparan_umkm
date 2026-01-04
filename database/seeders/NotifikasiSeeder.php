<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notifikasi;

class NotifikasiSeeder extends Seeder
{
    public function run(): void
{
    $users = \DB::table('pengguna')->pluck('id')->toArray();

    if (count($users) > 0) {
        \DB::table('notifikasi')->insert([
            [
                'pengguna_id' => $users[0], 
                'judul' => 'Selamat Datang',
                'pesan' => 'UMKM Anda berhasil terdaftar',
                'dibaca' => 0,
            ],
            [
                'pengguna_id' => $users[array_rand($users)], 
                'judul' => 'Update Event',
                'pesan' => 'Event Workshop Kreatif telah dibuka',
                'dibaca' => 0,
            ],
        ]);
    }
}}