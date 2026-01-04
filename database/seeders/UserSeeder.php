<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run()
    {
        \App\Models\User::updateOrCreate(
            ['email' => 'mitra@example.com'], 
            [
                'name' => 'Mitra Utama',
                'password' => bcrypt('password'),
                'role' => 'mitra',
            ]
        );
    }  
}