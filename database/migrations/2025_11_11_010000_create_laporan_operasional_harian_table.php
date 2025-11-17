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
        Schema::create('laporan_operasional_harian', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->time('waktu')->nullable();

            // Data Kendaraan
            $table->integer('jumlah_kendaraan_masuk')->default(0);
            $table->integer('jumlah_kendaraan_keluar')->default(0);
            $table->integer('manual_masuk')->default(0);
            $table->integer('jto_masuk')->default(0);
            $table->integer('manual_keluar')->default(0);
            $table->integer('jto_keluar')->default(0);
            $table->integer('jumlah_diperiksa')->default(0);
            $table->integer('jumlah_melanggar')->default(0);
            $table->integer('jumlah_tidak_melanggar')->default(0);

            // Hasil Operasional
            $table->integer('pelanggaran_daya_angkut')->default(0);
            $table->integer('pelanggaran_tcm')->default(0);
            $table->integer('pelanggaran_dokumen')->default(0);
            $table->integer('pelanggaran_dimensi')->default(0);
            $table->integer('pelanggaran_teknis')->default(0);
            $table->integer('tindakan_peringatan')->default(0);
            $table->integer('tindakan_tilang')->default(0);
            $table->integer('tindakan_transfer_muatan')->default(0);
            $table->integer('tindakan_putar_balik')->default(0);
            $table->integer('tindakan_tunda_berangkat')->default(0);
            $table->integer('tindakan_surat_tilang')->default(0);
            $table->integer('tindakan_serah_polisi')->default(0);
            $table->integer('tindakan_proses_etilang')->default(0);
            $table->decimal('denda', 12, 2)->default(0);
            $table->integer('kecelakaan_lalu_lintas')->default(0);

            // Kondisi Operasional
            $table->integer('jumlah_sdm')->default(0);
            $table->integer('sdm_ppns')->default(0);
            $table->integer('sdm_danru')->default(0);
            $table->integer('sdm_pkb')->default(0);
            $table->integer('sdm_ppkb')->default(0);
            $table->integer('sdm_pelaporan_jto')->default(0);
            $table->integer('sdm_petugas_lalin')->default(0);
            $table->string('arus_lalu_lintas', 50)->nullable();
            $table->string('cuaca', 50)->nullable();
            $table->integer('jumlah_responden_skm')->default(0);

            // Kendala & Catatan
            $table->text('kendala')->nullable();
            $table->text('catatan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_operasional_harian');
    }
};


