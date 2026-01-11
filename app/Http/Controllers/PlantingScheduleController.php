<?php

namespace App\Http\Controllers;

use App\Models\PlantingSchedule;
use App\Models\WeatherForecast;
use App\Models\RiceVariety;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class PlantingScheduleController extends Controller
{
    /**
     * Get user's planting schedules
     */
    public function index(Request $request): JsonResponse
    {
        $query = PlantingSchedule::where('user_id', auth()->id());

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $schedules = $query->with('riceVariety')
                          ->orderBy('planned_planting_date', 'desc')
                          ->paginate(10);

        return response()->json($schedules);
    }

    /**
     * Create new planting schedule
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'location' => 'required|string|max:100',
            'rice_variety_id' => 'required|exists:rice_varieties,id',
            'planned_planting_date' => 'required|date|after:today',
            'field_size_hectares' => 'nullable|numeric|min:0.1',
            'notes' => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'planned';

        // Get rice variety data to calculate harvest date
        $riceVariety = RiceVariety::find($validated['rice_variety_id']);
        $validated['rice_variety'] = $riceVariety->name; // Keep for backward compatibility
        
        // Calculate harvest date based on maturity_days from variety
        $plantingDate = Carbon::parse($validated['planned_planting_date']);
        $harvestDays = $riceVariety->maturity_days ?? 135; // default 135 if not set
        $validated['planned_harvest_date'] = $plantingDate->addDays($harvestDays);

        $schedule = PlantingSchedule::create($validated);

        return response()->json([
            'message' => 'Planting schedule created successfully',
            'data' => $schedule->load('riceVariety'),
        ], 201);
    }

    /**
     * Get single schedule details
     */
    public function show(PlantingSchedule $plantingSchedule): JsonResponse
    {
        $this->authorize('view', $plantingSchedule);
        return response()->json($plantingSchedule->load('riceVariety'));
    }

    /**
     * Update planting schedule
     */
    public function update(Request $request, PlantingSchedule $plantingSchedule): JsonResponse
    {
        $this->authorize('update', $plantingSchedule);

        $validated = $request->validate([
            'location' => 'string|max:100',
            'rice_variety_id' => 'exists:rice_varieties,id',
            'planned_planting_date' => 'date',
            'field_size_hectares' => 'nullable|numeric|min:0.1',
            'notes' => 'nullable|string',
            'status' => 'in:planned,in_progress,completed,failed',
        ]);

        if (isset($validated['rice_variety_id']) || isset($validated['planned_planting_date'])) {
            $riceVarietyId = $validated['rice_variety_id'] ?? $plantingSchedule->rice_variety_id;
            $plantingDate = isset($validated['planned_planting_date']) 
                ? Carbon::parse($validated['planned_planting_date']) 
                : $plantingSchedule->planned_planting_date;
            
            $riceVariety = RiceVariety::find($riceVarietyId);
            $harvestDays = $riceVariety->maturity_days ?? 135;
            $validated['planned_harvest_date'] = $plantingDate->addDays($harvestDays);
            
            if (isset($validated['rice_variety_id'])) {
                $validated['rice_variety'] = $riceVariety->name;
            }
        }

        $plantingSchedule->update($validated);

        return response()->json([
            'message' => 'Planting schedule updated successfully',
            'data' => $plantingSchedule->load('riceVariety'),
        ]);
    }

    /**
     * Delete planting schedule
     */
    public function destroy(PlantingSchedule $plantingSchedule): JsonResponse
    {
        $this->authorize('delete', $plantingSchedule);

        $plantingSchedule->delete();

        return response()->json(null, 204);
    }

    /**
     * Get planting recommendations based on weather and schedule
     */
    public function getRecommendations(PlantingSchedule $schedule): JsonResponse
    {
        $this->authorize('view', $schedule);

        // Get weather forecast for the location
        $weatherData = WeatherForecast::where('location', $schedule->location)
                                     ->where('forecast_date', '>=', now()->toDateString())
                                     ->orderBy('forecast_date', 'asc')
                                     ->take(14)
                                     ->get();

        $recommendations = [
            'schedule' => $schedule,
            'weather_outlook' => $this->analyzeWeatherOutlook($weatherData),
            'planting_tips' => $this->getPlantingTips($schedule),
            'pre_planting_tasks' => $this->getPrePlantingTasks($schedule),
            'monitoring_tasks' => $this->getMonitoringTasks($schedule),
        ];

        return response()->json($recommendations);
    }

    private function analyzeWeatherOutlook($weatherData): array
    {
        if ($weatherData->isEmpty()) {
            return ['message' => 'Data cuaca tidak tersedia. Silakan update data cuaca terlebih dahulu.'];
        }

        $avgTemp = $weatherData->avg('temperature');
        $totalRain = $weatherData->sum('rainfall');
        $avgHumidity = $weatherData->avg('humidity');

        return [
            'average_temperature' => round($avgTemp, 2),
            'total_rainfall_forecast' => round($totalRain, 2),
            'average_humidity' => round($avgHumidity, 2),
            'suitability' => $this->assessSuitability($avgTemp, $totalRain, $avgHumidity),
        ];
    }

    private function assessSuitability($temp, $rain, $humidity): array
    {
        $score = 0;
        $issues = [];

        // Temperature assessment
        if ($temp >= 20 && $temp <= 30) {
            $score += 30;
        } else {
            $issues[] = "Suhu ({$temp}°C) di luar range optimal (20-30°C)";
        }

        // Rainfall assessment
        if ($rain >= 20) {
            $score += 35;
        } else {
            $issues[] = "Curah hujan ({$rain}mm) mungkin perlu irigasi tambahan";
        }

        // Humidity assessment
        if ($humidity >= 60 && $humidity <= 90) {
            $score += 35;
        } else {
            $issues[] = "Kelembaban ({$humidity}%) kurang optimal";
        }

        $assessment = '';
        if ($score >= 90) {
            $assessment = 'Sangat Baik - Kondisi ideal untuk menanam';
        } elseif ($score >= 70) {
            $assessment = 'Baik - Cocok untuk menanam dengan persiapan';
        } elseif ($score >= 50) {
            $assessment = 'Cukup - Lakukan persiapan ekstra (irigasi, naungan)';
        } else {
            $assessment = 'Kurang - Sebaiknya tunda sampai kondisi lebih baik';
        }

        return [
            'score' => $score,
            'assessment' => $assessment,
            'issues' => $issues,
        ];
    }

    private function getPlantingTips($schedule): array
    {
        return [
            'Siapkan benih unggul berkualitas tinggi 2-3 minggu sebelumnya',
            'Lakukan pengayakan air dan pembajakan optimal untuk hasil terbaik',
            'Pastikan sistem drainase baik untuk pengaturan air yang tepat',
            'Gunakan pupuk dasar (fosfor dan kalium) sebelum tanam',
            'Tanam dengan jarak yang teratur (25x25 cm atau sesuai varietas)',
            'Lakukan penyulaman untuk tanaman yang mati pada hari ke 7-14',
            'Persiapkan sumber air irigasi yang stabil',
        ];
    }

    private function getPrePlantingTasks($schedule): array
    {
        $plantingDate = Carbon::parse($schedule->planned_planting_date);
        $today = now();
        $daysUntilPlanting = $today->diffInDays($plantingDate);

        $tasks = [];

        if ($daysUntilPlanting >= 21) {
            $tasks[] = ['day' => -21, 'task' => 'Persiapkan dan pilih lahan yang baik'];
            $tasks[] = ['day' => -21, 'task' => 'Mulai penyemaian benih'];
        }

        if ($daysUntilPlanting >= 14) {
            $tasks[] = ['day' => -14, 'task' => 'Mulai pengolahan tanah (bajak)'];
            $tasks[] = ['day' => -14, 'task' => 'Aplikasi pupuk organik'];
        }

        if ($daysUntilPlanting >= 7) {
            $tasks[] = ['day' => -7, 'task' => 'Ratakan dan persiapkan untuk tanam final'];
            $tasks[] = ['day' => -7, 'task' => 'Pastikan sistem irigasi berfungsi'];
        }

        $tasks[] = ['day' => 0, 'task' => 'Hari tanam - mulai penanaman padi'];

        return $tasks;
    }

    private function getMonitoringTasks($schedule): array
    {
        return [
            ['umur' => '1-2 minggu', 'tugas' => 'Penyulaman tanaman yang mati'],
            ['umur' => '2-4 minggu', 'tugas' => 'Pemupukan pertama dengan urea'],
            ['umur' => '4-6 minggu', 'tugas' => 'Penyiangan dan pemupukan kedua'],
            ['umur' => '8-10 minggu', 'tugas' => 'Pengaturan air untuk pembentukan malai'],
            ['umur' => '12-14 minggu', 'tugas' => 'Monitoring hama dan penyakit'],
            ['umur' => '15-17 minggu', 'tugas' => 'Panen (saat gabah 80% kuning emas)'],
        ];
    }
}
