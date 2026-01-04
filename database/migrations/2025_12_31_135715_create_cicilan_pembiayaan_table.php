<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cicilan_pembiayaan', function (Blueprint $user) {
            $user->id();
            $user->foreignId('pembiayaan_modal_id')->constrained('pembiayaan_modal')->onDelete('cascade');
            $user->integer('jumlah_bayar');
            $user->date('tanggal_bayar');
            $user->string('status')->default('pending'); 
            $user->string('snap_token')->nullable();
            $user->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cicilan_pembiayaan');
    }
};