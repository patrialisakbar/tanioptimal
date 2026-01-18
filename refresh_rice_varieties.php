#!/usr/bin/env php
<?php
/**
 * Script untuk refresh dan reseed database dengan data varietas padi yang benar
 * Jalankan dari root project dengan: php refresh_rice_varieties.php
 */

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

// Refresh database dan seed
echo "🔄 Refreshing database...\n";
$kernel->call('migrate:refresh', ['--seed' => true]);

echo "\n✅ Database refreshed dan di-seed dengan data varietas padi yang benar!\n";

// Tampilkan ringkasan data
$kernel->call('tinker', [
    '--execute' => <<<'PHP'
        $varieties = \App\Models\RiceVariety::all();
        echo "\n📊 Total Varietas Padi: " . $varieties->count() . "\n\n";
        
        $sawVarieties = \App\Models\RiceVarietyScore::distinct('rice_variety_id')->count();
        echo "🔬 Varietas dengan SAW Scores: " . $sawVarieties . "\n\n";
        
        $criteria = \App\Models\RiceCriteria::orderBy('order')->get();
        echo "📋 Kriteria SAW:\n";
        foreach ($criteria as $c) {
            echo "  - C{$c->order}: {$c->name} (bobot: {$c->weight}, tipe: {$c->type})\n";
        }
        echo "\n";
PHP
]);

echo "\n🎉 Setup lengkap! Database siap digunakan.\n";
