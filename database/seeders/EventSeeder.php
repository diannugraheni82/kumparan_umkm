<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    public function run()
    {
        \DB::table('event')->insert([
            [
                'nama_event' => 'Pelatihan UMKM',
                'tanggal'    => '2026-01-14 15:26:41',
                'kuota'      => 50,
                'lokasi'     => 'Gedung Pusat Niaga', 
                'mitra_id'   => 1, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_event' => 'Workshop Digital Marketing',
                'tanggal'    => '2026-01-19 15:26:41',
                'kuota'      => 30,
                'lokasi'     => 'Online (Zoom Meeting)', 
                'mitra_id'   => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }    
}
