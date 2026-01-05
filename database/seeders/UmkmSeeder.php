<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Pengguna; // Tambahkan ini

class UmkmSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua ID pengguna yang tersedia di database
        $penggunaIds = Pengguna::pluck('id')->toArray();

        // Cek jika tidak ada pengguna sama sekali, hentikan seeder agar tidak error
        if (empty($penggunaIds)) {
            return;
        }

        DB::table('umkm')->insert([
            [
                'pengguna_id' => $penggunaIds[0], // Ambil ID pertama yang tersedia
                'nama_usaha' => 'Maju Kuliner',
                'deskripsi' => 'UMKM makanan ringan',
                'kategori' => 'mikro',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'pengguna_id' => $penggunaIds[1] ?? $penggunaIds[0], // Pakai ID kedua, jika tidak ada balik ke ID pertama
                'nama_usaha' => 'Kreatif Fashion',
                'deskripsi' => 'UMKM pakaian dan aksesoris',
                'kategori' => 'kecil',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'pengguna_id' => $penggunaIds[0],
                'nama_usaha' => 'Kerajinan Tangan',
                'deskripsi' => 'UMKM kerajinan lokal',
                'kategori' => 'mikro',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'pengguna_id' => $penggunaIds[1] ?? $penggunaIds[0],
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