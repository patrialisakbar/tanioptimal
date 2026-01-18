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
     * Kriteria dari tabel attachment:
     * C1: Jenis Tanah (bobot 1) - Score 1-3 (BENEFIT)
     * C2: Curah Hujan (bobot 1) - Score 1-3 (COST) - 1500-1800:3, 1200-1500:2, 800-1200:1
     * C3: Suhu Optimal (bobot 1) - Score 1-3 (BENEFIT)
     * C4: Ketinggian Lahan (bobot 1) - Score 1-3 (COST) - 1200-800:3, 800-500:2, 500-0:1
     * C5: Ketersediaan Air (bobot 1) - Score 1-3 (COST) - Rawa:3, Irigasi Sederhana:2, Tadah Hujan:1
     * 
     * Data dari tabel:
     * A1 - Nagina 22: C1=3, C2=1, C3=3, C4=2, C5=1 → V_i = 16.0
     * A2 - Sahbhagi Dhan: C1=2, C2=3, C3=2, C4=3, C5=3 → V_i = 7.7
     * A3 - Vandana: C1=1, C2=3, C3=1, C4=3, C5=3 → V_i = 6.3
     * A4 - DRR Dhan 42: C1=2, C2=3, C3=2, C4=2, C5=2 → V_i = 8.8
     * A5 - Inpago 8: C1=3, C2=2, C3=3, C4=2, C5=1 → V_i = 14.0
     */
    public function run(): void
    {
        // Mapping untuk 5 varietas dengan scores berdasarkan tabel attachment
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
