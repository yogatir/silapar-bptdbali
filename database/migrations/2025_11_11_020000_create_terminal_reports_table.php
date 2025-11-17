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
        Schema::create('terminal_reports', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->time('waktu');
            $table->string('terminal');
            $table->integer('kedatangan_armada')->default(0);
            $table->integer('kedatangan_penumpang')->default(0);
            $table->integer('keberangkatan_armada')->default(0);
            $table->integer('keberangkatan_penumpang')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terminal_reports');
    }
};


