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
        Schema::table('umkm', function (Blueprint $table) {
            // Tambahkan kolom-kolom baru di sini jika belum ada di tabel utama
            // Contoh:
            if (!Schema::hasColumn('umkm', 'no_whatsapp')) {
                $table->string('no_whatsapp')->nullable();
            }
            if (!Schema::hasColumn('umkm', 'npwp')) {
                $table->string('npwp')->nullable();
            }
            // Tambahkan kolom lainnya sesuai kebutuhan aplikasi KUMPARAN DIGITAL
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('umkm', function (Blueprint $table) {
            $table->dropColumn(['no_whatsapp', 'npwp']);
        });
    }
};