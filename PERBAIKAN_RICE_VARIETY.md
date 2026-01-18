# Perbaikan Fitur Varietas Padi (Rice Variety Feature)

## 📋 Ringkasan Perbaikan

Fitur varietas padi telah diperbaiki dengan implementasi metode SAW (Simple Additive Weighting) yang sesuai dengan data yang disediakan dalam tabel attachment.

## 🔧 Perubahan yang Dilakukan

### 1. **Buat Model RiceVarietyRecommendation** ✅
   - **File**: [app/Models/RiceVarietyRecommendation.php](app/Models/RiceVarietyRecommendation.php)
   - Menghubungkan PlantingSchedule dengan RiceVariety melalui rekomendasi SAW
   - Menyimpan hasil rekomendasi termasuk suitability score dan ranking

### 2. **Perbaiki Kriteria dan Weight** ✅
   - **File**: [database/seeders/RiceCriteriaSeeder.php](database/seeders/RiceCriteriaSeeder.php)
   - Sesuaikan weight semua kriteria menjadi 1 (equal weight)
   - Kriteria tetap 5:
     - **C1**: Jenis Tanah (benefit)
     - **C2**: Curah Hujan (cost) 
     - **C3**: Suhu Optimal (benefit)
     - **C4**: Ketinggian Lahan (cost)
     - **C5**: Ketersediaan Air (cost)

### 3. **Perbaiki SAW Service** ✅
   - **File**: [app/Services/RiceRecommendationSawService.php](app/Services/RiceRecommendationSawService.php)
   - Perbaiki normalisasi score dengan formula yang benar:
     - **Benefit**: normalized = score / max_score
     - **Cost**: normalized = min_score / score
   - Perbaiki perhitungan final score: `final_score = sum(weight * normalized_score) / sum(weight)`
   - Tambahkan validasi score antara 0-1

### 4. **Update Data Seeder** ✅
   - **File**: [database/seeders/RiceVarietySawSeeder.php](database/seeders/RiceVarietySawSeeder.php)
   - Sesuaikan data score untuk 5 varietas berdasarkan tabel:
     - **Nagina 22**: C1=3, C2=1, C3=3, C4=2, C5=1
     - **Sahbhagi Dhan**: C1=2, C2=3, C3=2, C4=3, C5=3
     - **Vandana**: C1=1, C2=3, C3=1, C4=3, C5=3
     - **DRR Dhan 42**: C1=2, C2=3, C3=2, C4=2, C5=2
     - **Inpago 8**: C1=3, C2=2, C3=3, C4=2, C5=1

## 📊 Data Struktur

### RiceCriteria (Kriteria Evaluasi)
```
- id: integer
- code: string (c1, c2, c3, c4, c5)
- name: string
- description: text
- weight: decimal (bobot)
- type: string (benefit/cost)
- order: integer
```

### RiceVarietyScore (Score Mentah)
```
- id: integer
- rice_variety_id: foreign key
- criteria_id: foreign key
- score: decimal (1-5)
- unique: [rice_variety_id, criteria_id]
```

### RiceVarietyRecommendation (Hasil Rekomendasi)
```
- id: integer
- planting_schedule_id: foreign key
- rice_variety_id: foreign key
- suitability_score: decimal (0-1)
- normalized_score: decimal (percentage)
- rank: integer
- suitability_level: string
- reasons: text
```

## 🧮 Formula SAW

Untuk setiap varietas padi:

1. **Normalisasi Score** untuk setiap kriteria:
   ```
   Jika type = 'benefit':
     normalized = score / max_score
   
   Jika type = 'cost':
     normalized = min_score / score
   ```

2. **Hitung Final Score**:
   ```
   final_score = Σ(weight_i × normalized_score_i) / Σ(weight_i)
   ```

3. **Tentukan Tingkat Kesesuaian**:
   - ≥ 0.8: Sangat cocok
   - ≥ 0.6: Cukup cocok
   - ≥ 0.4: Kurang cocok
   - < 0.4: Tidak cocok

## 🚀 Cara Menggunakan

### Reset Database dengan Data Baru
```bash
php artisan migrate:refresh --seed
```

Atau gunakan script helper:
```bash
php refresh_rice_varieties.php
```

### API Endpoints

#### Dapatkan Semua Kriteria
```
GET /api/rice-saw/criteria
```

#### Dapatkan Semua Varietas dengan Scores
```
GET /api/rice-saw/varieties
```

#### Dapatkan SAW Scores untuk Semua Varietas
```
GET /api/rice-saw/scores
```

Response menampilkan ranking dengan final score sudah dinormalisasi.

#### Generate Rekomendasi untuk Planting Schedule
```
POST /api/planting-schedules/{id}/recommendations
```

## ✅ Testing

Untuk memverifikasi implementasi SAW:

```php
$sawService = app(\App\Services\RiceRecommendationSawService::class);
$results = $sawService->calculateAllVarietiesScore();

foreach ($results as $varietyId => $result) {
    echo "Variety: " . $result['variety']->name . "\n";
    echo "Final Score: " . round($result['final_score'] * 100, 2) . "%\n";
}
```

Expected ranking berdasarkan tabel:
1. **Nagina 22**: ~16.0 (tertinggi)
2. **Inpago 8**: ~14.0
3. **DRR Dhan 42**: ~8.8
4. **Sahbhagi Dhan**: ~7.7
5. **Vandana**: ~6.3 (terendah)

## 📝 Notes

- Semua 5 kriteria memiliki bobot yang sama (1) untuk fleksibilitas
- Score input adalah 1-5 untuk setiap kriteria
- Hasil akhir dinormalisasi menjadi 0-1 (atau 0-100%)
- Sistem dapat dengan mudah dikonfigurasi dengan mengubah weight di seeder
