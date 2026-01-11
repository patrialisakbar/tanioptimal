<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create([
            'name' => 'Hama',
            'slug' => 'hama',
            'description' => 'Informasi tentang hama tanaman padi dan cara penanggulangannya',
        ]);

        Category::create([
            'name' => 'Teknologi Pertanian',
            'slug' => 'teknologi-pertanian',
            'description' => 'Inovasi dan teknologi terbaru dalam industri pertanian',
        ]);

        Category::create([
            'name' => 'Informasi Perkembangan Pertanian',
            'slug' => 'informasi-perkembangan-pertanian',
            'description' => 'Update dan berita terkini tentang perkembangan sektor pertanian',
        ]);
    }
}
