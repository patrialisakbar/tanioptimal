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
                'name' => 'Kesesuaian Jenis Tanah',
                'description' => 'Seberapa sesuai varietas padi dengan jenis tanah lahan',
                'weight' => 4,
                'type' => 'benefit', // Semakin sesuai, semakin baik
                'order' => 1,
            ],
            [
                'code' => 'c2',
                'name' => 'Ketahanan Curah Hujan Rendah',
                'description' => 'Seberapa tahan varietas padi terhadap curah hujan rendah',
                'weight' => 2,
                'type' => 'cost', // Semakin mampu pada hujan rendah, semakin baik
                'order' => 2,
            ],
            [
                'code' => 'c3',
                'name' => 'Adaptasi Suhu Tinggi',
                'description' => 'Seberapa baik varietas padi beradaptasi dengan suhu tinggi',
                'weight' => 3,
                'type' => 'benefit', // Semakin baik adaptasi, semakin baik
                'order' => 3,
            ],
            [
                'code' => 'c4',
                'name' => 'Kesesuaian Ketinggian Lokasi',
                'description' => 'Seberapa sesuai varietas padi dengan ketinggian lokasi tanam',
                'weight' => 1,
                'type' => 'cost', // Semakin sesuai dengan ketinggian, semakin baik
                'order' => 4,
            ],
            [
                'code' => 'c5',
                'name' => 'Efisiensi Pemanfaatan Air',
                'description' => 'Seberapa efisien varietas padi dalam memanfaatkan air lahan',
                'weight' => 5,
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