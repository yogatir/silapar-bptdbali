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
        Schema::table('pelabuhan_records', function (Blueprint $table) {
            $table->integer('trip_kedatangan')->default(0)->after('trip');
            $table->integer('trip_keberangkatan')->default(0)->after('trip_kedatangan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pelabuhan_records', function (Blueprint $table) {
            $table->dropColumn(['trip_kedatangan', 'trip_keberangkatan']);
        });
    }
};
