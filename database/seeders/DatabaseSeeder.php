<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

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