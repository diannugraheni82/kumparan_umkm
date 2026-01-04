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
        Schema::create('umkm', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengguna_id')->constrained('pengguna')->onDelete('cascade');
            $table->string('nama_usaha');
            $table->string('no_whatsapp')->nullable();
            $table->string('npwp')->nullable();
            $table->text('alamat_usaha')->nullable();
            $table->string('status_tempat')->nullable();
            $table->decimal('luas_lahan', 12, 2)->nullable(); 
            $table->string('kbli', 10)->nullable(); 
            $table->integer('jumlah_karyawan')->default(0);
            $table->bigInteger('modal_usaha')->default(0);
            $table->enum('kategori', ['mikro', 'kecil', 'menengah'])->default('mikro');
            $table->bigInteger('omzet_tahunan')->default(0);
            $table->string('kapasitas_produksi')->nullable(); 
            $table->enum('sistem_penjualan', ['luring', 'daring', 'keduanya'])->default('luring');
            $table->bigInteger('limit_pinjaman')->default(0);
            $table->bigInteger('saldo_pinjaman')->default(0);
            $table->string('nama_bank')->nullable();
            $table->string('nomor_rekening')->nullable();
            $table->text('deskripsi');
            $table->json('portfolio_produk')->nullable();
            $table->enum('status', ['pending', 'aktif', 'ditolak'])->default('pending');
            $table->timestamps();
        });

        Schema::create('pinjaman_modal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('umkm_id')->constrained('umkm')->onDelete('cascade');
            $table->bigInteger('jumlah_pinjam');
            $table->date('tanggal_pinjam');
            $table->date('tenggat_waktu');
            $table->enum('status_pembayaran', ['belum_lunas', 'lunas', 'telat'])->default('belum_lunas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pinjaman_modal'); 
        Schema::dropIfExists('umkm'); 
    }
};