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
        Schema::create('laporan_harian_seksis', function (Blueprint $table) {
            $table->id();
            $table->string('no_st')->unique();
            $table->string('nama_seksi');
            $table->date('tanggal');
            $table->json('petugas')->nullable();
            $table->text('kegiatan')->nullable();
            $table->string('dokumentasi_link')->nullable();
            $table->string('hasil_kegiatan_link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_harian_seksis');
    }
};


