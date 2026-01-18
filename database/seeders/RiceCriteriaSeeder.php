<?php

namespace Database\Seeders;

use App\Models\RiceCriteria;
use Illuminate\Database\Seeder;

class RiceCriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $criteria = [
            [
                'code' => 'c1',
                'name' => 'Jenis Tanah',
                'description' => 'Kesesuaian varietas padi dengan jenis tanah lahan',
                'weight' => 1,
                'type' => 'benefit', // Semakin sesuai, semakin baik
                'order' => 1,
            ],
            [
                'code' => 'c2',
                'name' => 'Curah Hujan',
                'description' => 'Ketahanan varietas padi terhadap curah hujan (biaya/cost)',
                'weight' => 1,
                'type' => 'cost', // Semakin mampu pada hujan rendah, semakin baik
                'order' => 2,
            ],
            [
                'code' => 'c3',
                'name' => 'Suhu Optimal',
                'description' => 'Adaptasi varietas padi dengan suhu optimal (manfaat)',
                'weight' => 1,
                'type' => 'benefit', // Semakin baik adaptasi, semakin baik
                'order' => 3,
            ],
            [
                'code' => 'c4',
                'name' => 'Ketinggian Lahan',
                'description' => 'Kesesuaian varietas padi dengan ketinggian lokasi tanam (biaya)',
                'weight' => 1,
                'type' => 'cost', // Semakin sesuai dengan ketinggian, semakin baik
                'order' => 4,
            ],
            [
                'code' => 'c5',
                'name' => 'Ketersediaan Air',
                'description' => 'Efisiensi varietas padi dalam memanfaatkan air lahan',
                'weight' => 1,
                'type' => 'cost', // Semakin efisien, semakin baik
                'order' => 5,
            ],
        ];

        foreach ($criteria as $c) {
            RiceCriteria::updateOrCreate(
                ['code' => $c['code']],
                $c
            );
        }
    }
}


// jda