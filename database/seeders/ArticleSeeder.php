<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create();

        $articles = [
            [
                'title' => 'Teknik Pembajakan Optimal untuk Padi',
                'content' => 'Pembajakan adalah langkah awal yang sangat penting dalam persiapan lahan untuk menanam padi. Tujuan pembajakan adalah:

1. Menggemburkan tanah sehingga akar padi dapat penetrasi dengan mudah
2. Meningkatkan kapasitas menahan air
3. Membenamkan sisa tanaman sebelumnya sebagai bahan organik

Pembajakan yang baik harus dilakukan minimal 2-3 kali dengan interval 1-2 minggu. Kedalaman pembajakan ideal adalah 20-25 cm. Pastikan tanah basah dengan kadar air 15-20% saat dilakukan pembajakan untuk hasil optimal.',
                'category' => 'techniques',
                'views' => 245
            ],
            [
                'title' => 'Pengendalian Hama Wereng pada Padi',
                'content' => 'Wereng merupakan salah satu hama utama yang menyebabkan kerugian besar pada tanaman padi. Ada dua jenis wereng yang merugikan:

1. Wereng Coklat (Nilaparvata lugens) - menyerang dengan menghisap cairan tanaman
2. Wereng Hijau (Nephotettix virescens) - vektor penyakit tungro

Cara Pengendalian:
- Penggunaan varietas tahan wereng
- Pengendalian hayati dengan musuh alami
- Penggunaan pestisida nabati (ekstrak biji nimba)
- Penyiangan gulma karena merupakan inang alternatif
- Irigasi intermiten untuk mengurangi populasi wereng

Pantau pertanaman secara rutin, terutama pada fase vegetatif awal untuk deteksi dini.',
                'category' => 'pest_control',
                'views' => 189
            ],
            [
                'title' => 'Manajemen Pupuk Urea yang Efisien',
                'content' => 'Pupuk urea adalah sumber nitrogen yang paling penting untuk pertumbuhan vegetatif padi. Penggunaan yang efisien sangat mempengaruhi hasil panen.

Rekomendasi Pemupukan Urea:
- Dosis umum: 150-200 kg/ha
- Pemberian dibagi dalam 3-4 kali aplikasi
  
Jadwal Pemupukan:
1. Pupuk Dasar (saat pengolahan tanah): Gunakan pupuk organik dan SP-36/TSP
2. Pemupukan I (umur 2-3 minggu): 50-70 kg urea/ha + K
3. Pemupukan II (umur 5-6 minggu): 50-70 kg urea/ha
4. Pemupukan III (umur menjelang berbunga): 30-50 kg urea/ha + K

Tips Efisiensi:
- Aplikasi saat tanah lembab (setelah irigasi/hujan)
- Jangan aplikasikan pada tanah yang terlalu basah
- Gunakan pupuk organik untuk meningkatkan efisiensi nitrogen
- Hitung kebutuhan berdasarkan hasil analisis tanah',
                'category' => 'fertilizer',
                'views' => 312
            ],
            [
                'title' => 'Manajemen Air Irigasi untuk Hasil Maksimal',
                'content' => 'Pengelolaan air merupakan faktor kritis dalam budidaya padi. Air berfungsi sebagai medium tumbuh, pelarut hara, dan pengatur suhu.

Sistem Irigasi yang Baik:
1. Intermiten (Penggenangan-Pengeringan bergantian)
   - Lebih efisien menggunakan air
   - Mengurangi hama penyakit
   - Meningkatkan perakaran
   
2. Konstan (Genangan permanen)
   - Tradisional
   - Lebih mudah dalam pengelolaan

Kebutuhan Air Padi:
- Fase Vegetatif: 5-7 mm/hari
- Fase Reproduktif: 7-10 mm/hari
- Panen: kurangi air gradually

Jadwal Pemberian Air:
- Fase Awal (0-3 minggu): Genang 2-3 cm
- Fase Pertengahan (3-10 minggu): Genang 5-7 cm
- Fase Akhir (10-14 minggu): Kurangi pemberian air secara bertahap',
                'category' => 'irrigation',
                'views' => 267
            ],
            [
                'title' => 'Varietas Padi Unggul dan Karakteristiknya',
                'content' => 'Pemilihan varietas yang tepat sangat mempengaruhi produktivitas dan kualitas padi. Berikut varietas padi unggul yang direkomendasikan:

1. Ciherang
   - Potensi hasil: 7-8 ton/ha
   - Umur panen: 115-120 hari
   - Tahan wereng coklat dan blas
   - Cocok di lahan setengah matang

2. Mekongga
   - Potensi hasil: 7-8 ton/ha
   - Umur panen: 120-125 hari
   - Tahan blas dan virus tungro
   - Kualitas beras baik

3. Inpari 42
   - Potensi hasil: 8-9 ton/ha
   - Umur panen: 115 hari
   - Tahan wereng dan blas
   - Cocok untuk padi hutan raya

4. Mentik Wangi
   - Aromatis (wangi)
   - Harga jual lebih tinggi
   - Umur lebih panjang (120-130 hari)

Pertimbangkan kondisi lahan, iklim, dan target pasar saat memilih varietas.',
                'category' => 'varieties',
                'views' => 198
            ],
        ];

        foreach ($articles as $article) {
            Article::create(array_merge($article, [
                'user_id' => $user->id,
                'is_published' => true,
                'published_at' => Carbon::now(),
            ]));
        }
    }
}
