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
        //Schema::table('umkm', function (Blueprint $table) {
            // Menambahkan kolom portfolio (json) setelah kolom nama_usaha
            //$table->json('portfolio_produk')->nullable()->after('nama_usaha');
        //});
    }

    public function down(): void
    {
        //Schema::table('umkm', function (Blueprint $table) {
            //$table->dropColumn('portfolio_produk');
        //});
    }
};
