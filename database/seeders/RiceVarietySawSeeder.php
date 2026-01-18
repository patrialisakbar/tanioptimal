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
     * Data SAW dari Excel:
     * C1 - Jenis Tanah (BENEFIT) - Bobot: 4
     * C2 - Curah Hujan (COST) - Bobot: 2  
     * C3 - Suhu (BENEFIT) - Bobot: 3
     * C4 - Ketinggian (COST) - Bobot: 1
     * C5 - Ketersediaan Air (COST) - Bobot: 5
     * 
     * Scores (1-3):
     * A1 - Nagina 22:      C1:3, C2:1, C3:3, C4:2, C5:1
     * A2 - Sahbhagi Dhan:  C1:2, C2:3, C3:2, C4:3, C5:3
     * A3 - Vandana:        C1:1, C2:3, C3:1, C4:3, C5:3
     * A4 - DRR Dhan 42:    C1:2, C2:3, C3:2, C4:2, C5:2
     * A5 - Inpago 8:       C1:3, C2:2, C3:3, C4:2, C5:1
     */
    public function run(): void
    {
        // Mapping hanya untuk 5 varietas dengan scores berdasarkan data Excel terbaru
        $varietiesScores = [
            'Nagina 22' => ['c1' => 3, 'c2' => 1, 'c3' => 3, 'c4' => 2, 'c5' => 1],
            'Sahbhagi Dhan' => ['c1' => 2, 'c2' => 3, 'c3' => 2, 'c4' => 3, 'c5' => 3],
            'Vandana' => ['c1' => 1, 'c2' => 3, 'c3' => 1, 'c4' => 3, 'c5' => 3],
            'DRR Dhan 42' => ['c1' => 2, 'c2' => 3, 'c3' => 2, 'c4' => 2, 'c5' => 2],
            'Inpago 8' => ['c1' => 3, 'c2' => 2, 'c3' => 3, 'c4' => 2, 'c5' => 1],
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