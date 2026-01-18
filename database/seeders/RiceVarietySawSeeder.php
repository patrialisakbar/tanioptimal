<?php

namespace Database\Seeders;

use App\Models\RiceVariety;
use App\Models\RiceCriteria;
use App\Models\RiceVarietyScore;
use Illuminate\Database\Seeder;

class RiceVarietySawSeeder extends Seeder
{
    /**
     * Run the database seeds untuk rice varieties dengan SAW scores
     * 
     * HANYA 5 VARIETAS untuk fitur rekomendasi (SAW)
     * 41 varietas lainnya adalah untuk fitur jadwal tanam
     * 
     * Kriteria:
     * C1: Kesesuaian Jenis Tanah (bobot 4) - BENEFIT - Ultisol:3, Liat:2, Aluvial:1
     * C2: Ketahanan Curah Hujan Rendah (bobot 2) - COST - 800-1200:3, 1200-1500:2, 1500-1800:1
     * C3: Adaptasi Suhu Tinggi (bobot 3) - BENEFIT - 30-35°C:3, 27-29°C:2, 25-26°C:1
     * C4: Kesesuaian Ketinggian Lokasi (bobot 1) - COST - 0-500:3, 500-800:2, 800-1200:1
     * C5: Efisiensi Pemanfaatan Air (bobot 5) - COST - Tadah Hujan:3, Irigasi Sederhana:2, Rawa:1
     */
    public function run(): void
    {
        // Mapping hanya untuk 5 varietas dengan scores berdasarkan kriteria
        $varietiesScores = [
            'Nagina 22' => ['c1' => 3, 'c2' => 3, 'c3' => 3, 'c4' => 2, 'c5' => 3],
            'Sahbhagi Dhan' => ['c1' => 2, 'c2' => 1, 'c3' => 2, 'c4' => 1, 'c5' => 1],
            'Vandana' => ['c1' => 1, 'c2' => 1, 'c3' => 1, 'c4' => 1, 'c5' => 1],
            'DRR Dhan 42' => ['c1' => 2, 'c2' => 1, 'c3' => 2, 'c4' => 2, 'c5' => 2],
            'Inpago 8' => ['c1' => 3, 'c2' => 2, 'c3' => 3, 'c4' => 2, 'c5' => 3],
        ];

        // Get all criteria
        $criteria = RiceCriteria::all()->keyBy('code');

        // Create scores hanya untuk 5 varietas untuk fitur rekomendasi
        foreach ($varietiesScores as $varietyName => $scores) {
            $variety = RiceVariety::where('name', $varietyName)->first();
            
            if ($variety) {
                foreach ($scores as $criteriaCode => $score) {
                    if (isset($criteria[$criteriaCode])) {
                        RiceVarietyScore::create([
                            'rice_variety_id' => $variety->id,
                            'criteria_id' => $criteria[$criteriaCode]->id,
                            'score' => $score,
                        ]);
                    }
                }
            }
        }
    }
}