<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UmkmSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('umkm')->insert([
            [
                'pengguna_id' => 2,
                'nama_usaha' => 'Maju Kuliner',
                'deskripsi' => 'UMKM makanan ringan',
                'kategori' => 'mikro',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'pengguna_id' => 4,
                'nama_usaha' => 'Kreatif Fashion',
                'deskripsi' => 'UMKM pakaian dan aksesoris',
                'kategori' => 'kecil',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'pengguna_id' => 2,
                'nama_usaha' => 'Kerajinan Tangan',
                'deskripsi' => 'UMKM kerajinan lokal',
                'kategori' => 'mikro',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'pengguna_id' => 4,
                'nama_usaha' => 'Digital Kreatif',
                'deskripsi' => 'UMKM pengembangan aplikasi',
                'kategori' => 'menengah',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}