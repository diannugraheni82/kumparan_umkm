<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pendaftaran_event', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel event (Pastikan nama tabelnya 'event' bukan 'events')
            $table->foreignId('event_id')->nullable()->constrained('event')->onDelete('cascade');
            
            // Relasi ke tabel mitra (Sesuaikan 'users' atau 'pengguna')
            $table->foreignId('mitra_id')->nullable()->constrained('users')->onDelete('cascade');
            
            // Relasi ke tabel umkm
            $table->foreignId('umkm_id')->constrained('umkm')->onDelete('cascade');
            
            // Kolom status untuk filter dashboard
            $table->string('status_kolaborasi')->default('pending'); 
            
            $table->timestamps();
        });
    } // <-- Tanda kurung ini sebelumnya hilang/salah letak

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_event');
    }
};