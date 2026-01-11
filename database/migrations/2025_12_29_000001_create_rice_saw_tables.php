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
        // Create criteria table
        Schema::create('rice_criteria', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // c1, c2, c3, c4, c5
            $table->string('name'); // Nama kriteria
            $table->text('description'); // Deskripsi lengkap
            $table->decimal('weight', 8, 2); // Bobot/weight
            $table->string('type'); // 'benefit' or 'cost'
            $table->integer('order'); // Urutan display
            $table->timestamps();
        });

        // Create rice_variety_scores table untuk SAW calculation
        Schema::create('rice_variety_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rice_variety_id')->constrained('rice_varieties')->onDelete('cascade');
            $table->foreignId('criteria_id')->constrained('rice_criteria')->onDelete('cascade');
            $table->decimal('score', 8, 2); // Raw score (1-5)
            $table->timestamps();
            
            $table->unique(['rice_variety_id', 'criteria_id']);
        });

        // Create rice_variety_recommendations table untuk hasil rekomendasi
        Schema::create('rice_variety_recommendations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('planting_schedule_id')->constrained('planting_schedules')->onDelete('cascade');
            $table->foreignId('rice_variety_id')->constrained('rice_varieties')->onDelete('cascade');
            $table->decimal('suitability_score', 8, 3); // Skor kesesuaian akhir
            $table->decimal('normalized_score', 8, 3); // Skor ternormalisasi
            $table->integer('rank'); // Peringkat (1, 2, 3, dst)
            $table->string('suitability_level'); // 'Sangat cocok', 'Cukup cocok', 'Kurang cocok', 'Tidak cocok'
            $table->text('reasons')->nullable(); // Alasan rekomendasi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rice_variety_recommendations');
        Schema::dropIfExists('rice_variety_scores');
        Schema::dropIfExists('rice_criteria');
    }
};
