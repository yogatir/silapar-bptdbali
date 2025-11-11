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
        Schema::create('pelabuhan_records', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->time('waktu');
            $table->string('pelabuhan');
            $table->integer('kapal_operasi')->default(0);
            $table->integer('trip')->default(0);
            $table->integer('penumpang')->default(0);
            $table->integer('roda_2')->default(0);
            $table->integer('roda_4_penumpang')->default(0);
            $table->integer('roda_4_barang')->default(0);
            $table->json('dermaga')->nullable(); // Stores all dermaga data as JSON array
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelabuhan_records');
    }
};
