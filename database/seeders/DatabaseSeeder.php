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
        KategoriUmkmSeeder::class,
        LokasiSeeder::class,
        PenggunaSeeder::class, 
        UmkmSeeder::class,
        LegalitasUmkmSeeder::class,
        PembayaranPendaftaranSeeder::class,
        EventSeeder::class,             
        PendaftaranEventSeeder::class,  
        NotifikasiSeeder::class,
        BeritaSeeder::class,
    ]);
}
}