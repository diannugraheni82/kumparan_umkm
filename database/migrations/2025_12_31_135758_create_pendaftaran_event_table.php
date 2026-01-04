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
        $table->foreignId('event_id')->constrained('event')->onDelete('cascade');
        $table->foreignId('umkm_id')->constrained('pengguna')->onDelete('cascade');
        $table->string('status')->default('menunggu'); 
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_event');
    }
};