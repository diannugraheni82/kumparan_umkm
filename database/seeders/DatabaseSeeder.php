<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            PenggunaSeeder::class,
            KategoriUmkmSeeder::class,
            LokasiSeeder::class,
            UmkmSeeder::class,
            LegalitasUmkmSeeder::class,
            PembayaranPendaftaranSeeder::class,
            // PembiayaanModalSeeder::class,  <-- Dimatikan karena error kolom 'status'
            // CicilanPembiayaanSeeder::class, <-- Dimatikan karena bergantung pada PembiayaanModal
            EventSeeder::class,
            PendaftaranEventSeeder::class,
            NotifikasiSeeder::class,
            BeritaSeeder::class,
        ]);
        
    }
}