<?php

namespace Database\Seeders;

use App\Models\WeatherForecast;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class WeatherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            [
                'name' => 'Subang, Jawa Barat',
                'latitude' => -6.5,
                'longitude' => 107.5,
            ],
            [
                'name' => 'Indramayu, Jawa Barat',
                'latitude' => -6.3,
                'longitude' => 108.3,
            ],
            [
                'name' => 'Cirebon, Jawa Barat',
                'latitude' => -6.7,
                'longitude' => 108.5,
            ],
        ];

        foreach ($locations as $location) {
            for ($day = 0; $day < 14; $day++) {
                WeatherForecast::create([
                    'location' => $location['name'],
                    'latitude' => $location['latitude'],
                    'longitude' => $location['longitude'],
                    'forecast_date' => Carbon::now()->addDays($day)->toDateString(),
                    'temperature' => rand(24, 32),
                    'humidity' => rand(65, 85),
                    'rainfall' => rand(0, 25),
                    'weather_condition' => $this->getWeatherCondition(),
                    'wind_speed' => rand(8, 18),
                    'wind_direction' => $this->getWindDirection(),
                ]);
            }
        }
    }

    private function getWeatherCondition()
    {
        $conditions = ['Sunny', 'Cloudy', 'Rainy', 'Partly Cloudy', 'Overcast'];
        return $conditions[array_rand($conditions)];
    }

    private function getWindDirection()
    {
        $directions = ['N', 'NE', 'E', 'SE', 'S', 'SW', 'W', 'NW'];
        return $directions[array_rand($directions)];
    }
}
