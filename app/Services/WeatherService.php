<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\WeatherForecast;

class WeatherService
{
    private string $apiKey;
    private string $baseUrl = 'https://api.openweathermap.org/data/2.5';

    public function __construct()
    {
        $this->apiKey = config('services.openweather.key');
    }

    /**
     * Get current weather and 5-day forecast for a location
     */
    public function getWeatherByCoordinates(float $latitude, float $longitude, string $location): array
    {
        try {
            // Get current weather
            $currentResponse = Http::get("{$this->baseUrl}/weather", [
                'lat' => $latitude,
                'lon' => $longitude,
                'appid' => $this->apiKey,
                'units' => 'metric',
            ]);

            // Get 5-day forecast
            $forecastResponse = Http::get("{$this->baseUrl}/forecast", [
                'lat' => $latitude,
                'lon' => $longitude,
                'appid' => $this->apiKey,
                'units' => 'metric',
            ]);

            if ($currentResponse->failed() || $forecastResponse->failed()) {
                return $this->getCachedWeather($location);
            }

            $currentData = $currentResponse->json();
            $forecastData = $forecastResponse->json();

            // Calculate suitability score for planting
            $temperature = $currentData['main']['temp'];
            $humidity = $currentData['main']['humidity'];
            $rainfall = $currentData['rain']['1h'] ?? 0;

            $score = $this->calculateSuitabilityScore($temperature, $humidity, $rainfall);

            // Process forecast data
            $forecasts = [];
            $processedDates = [];

            foreach ($forecastData['list'] as $item) {
                $date = date('Y-m-d', $item['dt']);

                // Only store one forecast per day
                if (!in_array($date, $processedDates)) {
                    $forecasts[] = [
                        'date' => $date,
                        'temperature' => round($item['main']['temp'], 1),
                        'humidity' => $item['main']['humidity'],
                        'rainfall' => $item['rain']['3h'] ?? 0,
                        'weather' => $item['weather'][0]['main'],
                        'icon' => $this->getWeatherEmoji($item['weather'][0]['main']),
                        'wind_speed' => round($item['wind']['speed'], 1),
                    ];
                    $processedDates[] = $date;
                }
            }

            return [
                'success' => true,
                'location' => $location,
                'current' => [
                    'temperature' => round($temperature, 1),
                    'humidity' => $humidity,
                    'rainfall' => $rainfall,
                    'weather' => $currentData['weather'][0]['main'],
                    'icon' => $this->getWeatherEmoji($currentData['weather'][0]['main']),
                    'wind_speed' => round($currentData['wind']['speed'], 1),
                    'suitability_score' => $score,
                    'suitability_label' => $this->getSuitabilityLabel($score),
                ],
                'forecast' => $forecasts,
            ];
        } catch (\Exception $e) {
            return $this->getCachedWeather($location);
        }
    }

    /**
     * Calculate suitability score for rice planting (0-100)
     */
    private function calculateSuitabilityScore(float $temperature, int $humidity, float $rainfall): int
    {
        $score = 0;

        // Temperature score (optimal: 20-30°C)
        if ($temperature >= 20 && $temperature <= 30) {
            $score += 40;
        } elseif ($temperature >= 18 && $temperature <= 32) {
            $score += 25;
        } elseif ($temperature >= 15 && $temperature <= 35) {
            $score += 15;
        }

        // Humidity score (optimal: 60-80%)
        if ($humidity >= 60 && $humidity <= 80) {
            $score += 40;
        } elseif ($humidity >= 50 && $humidity <= 85) {
            $score += 25;
        } elseif ($humidity >= 40 && $humidity <= 90) {
            $score += 15;
        }

        // Rainfall score (optimal: 0-5mm for most periods)
        if ($rainfall >= 0 && $rainfall <= 5) {
            $score += 20;
        } elseif ($rainfall <= 10) {
            $score += 15;
        }

        return min($score, 100);
    }

    /**
     * Get suitability label
     */
    private function getSuitabilityLabel(int $score): string
    {
        if ($score >= 80) {
            return 'Excellent';
        } elseif ($score >= 60) {
            return 'Good';
        } elseif ($score >= 40) {
            return 'Fair';
        } else {
            return 'Poor';
        }
    }

    /**
     * Get weather emoji based on condition
     */
    private function getWeatherEmoji(string $condition): string
    {
        return match (strtolower($condition)) {
            'clear' => '☀️',
            'clouds' => '☁️',
            'rain', 'drizzle' => '🌧️',
            'thunderstorm' => '⛈️',
            'snow' => '❄️',
            'mist', 'smoke', 'haze', 'dust', 'fog', 'sand', 'ash', 'squall', 'tornado' => '🌫️',
            default => '🌤️',
        };
    }

    /**
     * Get cached weather from database if API fails
     */
    private function getCachedWeather(string $location): array
    {
        $forecasts = WeatherForecast::where('location', $location)
                                    ->orderBy('forecast_date', 'asc')
                                    ->take(5)
                                    ->get()
                                    ->map(function ($item) {
                                        return [
                                            'date' => $item->forecast_date->toDateString(),
                                            'temperature' => $item->temperature,
                                            'humidity' => $item->humidity,
                                            'rainfall' => $item->rainfall,
                                            'weather' => $item->weather_condition,
                                            'icon' => $this->getWeatherEmoji($item->weather_condition),
                                            'wind_speed' => $item->wind_speed,
                                        ];
                                    })
                                    ->toArray();

        // If no cached data, return mock data for testing
        if (empty($forecasts)) {
            return $this->getMockWeather($location);
        }

        return [
            'success' => true,
            'location' => $location,
            'cached' => true,
            'current' => [
                'temperature' => $forecasts[0]['temperature'] ?? 0,
                'humidity' => $forecasts[0]['humidity'] ?? 0,
                'rainfall' => $forecasts[0]['rainfall'] ?? 0,
                'weather' => $forecasts[0]['weather'] ?? 'Unknown',
                'icon' => $forecasts[0]['icon'] ?? '🌤️',
                'wind_speed' => $forecasts[0]['wind_speed'] ?? 0,
                'suitability_score' => 70,
                'suitability_label' => 'Good (Cached)',
            ],
            'forecast' => $forecasts,
        ];
    }

    /**
     * Get mock weather data for testing when API unavailable
     */
    private function getMockWeather(string $location): array
    {
        $today = date('Y-m-d');
        $forecasts = [];
        
        for ($i = 0; $i < 5; $i++) {
            $date = date('Y-m-d', strtotime("+$i days"));
            $temp = rand(25, 32);
            $humidity = rand(60, 85);
            $condition = ['Cloudy', 'Rainy', 'Sunny', 'Partly Cloudy', 'Overcast'][array_rand(['Cloudy', 'Rainy', 'Sunny', 'Partly Cloudy', 'Overcast'])];
            
            $forecasts[] = [
                'date' => $date,
                'temperature' => $temp,
                'humidity' => $humidity,
                'rainfall' => rand(0, 50) / 10,
                'weather' => $condition,
                'icon' => $this->getWeatherEmoji($condition),
                'wind_speed' => rand(5, 15),
            ];
        }

        $score = rand(60, 85);

        return [
            'success' => true,
            'location' => $location,
            'mock' => true,
            'current' => [
                'temperature' => $forecasts[0]['temperature'],
                'humidity' => $forecasts[0]['humidity'],
                'rainfall' => $forecasts[0]['rainfall'],
                'weather' => $forecasts[0]['weather'],
                'icon' => $forecasts[0]['icon'],
                'wind_speed' => $forecasts[0]['wind_speed'],
                'suitability_score' => $score,
                'suitability_label' => $this->getSuitabilityLabel($score),
            ],
            'forecast' => $forecasts,
        ];
    }
}