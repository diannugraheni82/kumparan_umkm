<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pengguna')->insert([
            [
                'nik' => '1234567890123456',
                'name' => 'Admin Dinas',
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'status_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nik' => '2345678901234567',
                'name' => 'UMKM Maju',
                'email' => 'umkm1@example.com',
                'password' => Hash::make('password123'),
                'role' => 'umkm',
                'status_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nik' => '3456789012345678',
                'name' => 'Mitra Cerdas',
                'email' => 'mitra@example.com',
                'password' => Hash::make('password123'),
                'role' => 'mitra',
                'status_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nik' => '4567890123456789',
                'name' => 'UMKM Kreatif',
                'email' => 'umkm2@example.com',
                'password' => Hash::make('password123'),
                'role' => 'umkm',
                'status_aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
