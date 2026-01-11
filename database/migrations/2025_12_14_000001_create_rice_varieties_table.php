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
        Schema::create('rice_varieties', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('soil_type')->nullable(); // aluvial, liat, ultisol, gambut, rawa
            $table->string('rainfall_category')->nullable(); // rawan_kekeringan, sedang, rawan_banjir
            $table->string('temperature_optimal')->nullable(); // dingin, sedang, panas
            $table->string('elevation_category')->nullable(); // dataran_rendah, dataran_menengah, dataran_tinggi
            $table->string('water_availability')->nullable(); // irigasi_teknis, tadah_hujan, lahan_kering, rawa
            $table->string('salinity_category')->nullable(); // normal, air_payau, tinggi
            $table->json('threats')->nullable(); // array of threats
            $table->float('yield_potential')->nullable(); // ton/ha
            $table->integer('maturity_days')->nullable(); // days
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rice_varieties');
    }
};
