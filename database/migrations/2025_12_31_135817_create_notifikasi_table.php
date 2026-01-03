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
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengguna_id')->constrained('users')->onDelete('cascade');
            $table->unsignedBigInteger('pengirim_id')->nullable(); // Siapa yang ngajak
            $table->string('judul');
            $table->text('pesan');
            $table->string('kategori')->default('info'); // 'kolaborasi' atau 'umum'
            $table->unsignedBigInteger('data_id')->nullable(); // ID Mitra pencatat
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->boolean('dibaca')->default(false);
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};
