<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PendaftaranEvent;

class PendaftaranEventSeeder extends Seeder
{
    public function run(): void
{
    $event = \DB::table('event')->first();
    $umkm = \DB::table('pengguna')->where('role', 'umkm')->first();

    if ($event && $umkm) {
        \DB::table('pendaftaran_event')->insert([
            [
                'event_id'   => $event->id,
                'umkm_id'    => $umkm->id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
}