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
    Schema::create('kerjasamas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('mitra_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('umkm_id')->constrained('umkm')->onDelete('cascade'); // Pastikan 'umkm' atau 'umkms' sesuai tabel Anda
        $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
        $table->text('pesan')->nullable();
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('kerjasamas');
}   
};