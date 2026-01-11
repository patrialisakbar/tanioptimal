<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PlantingScheduleController;
use App\Http\Controllers\RiceRecommendationController;
use App\Http\Controllers\Api\AuthController;

Route::get('/health', function () {
    return response()->json(['status' => 'ok']);
});

// Public API Authentication Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected API Authentication Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
});

// Public routes for articles (everyone can view)
Route::get('/articles', [ArticleController::class, 'index']);
Route::get('/articles/{article}', [ArticleController::class, 'show']);

// Test POST Article (temporarily public for debugging)
Route::post('/articles', [ArticleController::class, 'store']);

// Public routes for categories
Route::get('/categories', function () {
    return response()->json(\App\Models\Category::all());
});
Route::get('/categories/{category}', function (\App\Models\Category $category) {
    return response()->json($category->load('articles'));
});

// Rice Recommendation SAW Routes (Public)
Route::get('/rice-saw/criteria', [RiceRecommendationController::class, 'getCriteria']);
Route::get('/rice-saw/varieties', [RiceRecommendationController::class, 'getVarieties']);
Route::get('/rice-saw/scores', [RiceRecommendationController::class, 'getSawScores']);

// Public routes for rice varieties (for dropdown/selection)
Route::get('/rice-varieties', function () {
    return response()->json([
        'success' => true,
        'message' => 'Rice varieties retrieved successfully',
        'data' => \App\Models\RiceVariety::select('id', 'name', 'maturity_days', 'description')
            ->orderBy('name')
            ->get(),
        'total' => \App\Models\RiceVariety::count(),
    ]);
});

// Protected routes - require authentication
Route::middleware(['auth:sanctum'])->group(function () {
    // Article management
    Route::put('/articles/{article}', [ArticleController::class, 'update']);
    Route::delete('/articles/{article}', [ArticleController::class, 'destroy']);

    // Planting schedules
    Route::get('/planting-schedules', [PlantingScheduleController::class, 'index']);
    Route::post('/planting-schedules', [PlantingScheduleController::class, 'store']);
    Route::get('/planting-schedules/{plantingSchedule}', [PlantingScheduleController::class, 'show']);
    Route::put('/planting-schedules/{plantingSchedule}', [PlantingScheduleController::class, 'update']);
    Route::delete('/planting-schedules/{plantingSchedule}', [PlantingScheduleController::class, 'destroy']);
    Route::get('/planting-schedules/{plantingSchedule}/recommendations', [PlantingScheduleController::class, 'getRecommendations']);

    // Rice Recommendation SAW Routes (Protected)
    Route::post('/rice-saw/generate/{plantingSchedule}', [RiceRecommendationController::class, 'generateRecommendations']);
    Route::get('/rice-saw/recommendations/{plantingSchedule}', [RiceRecommendationController::class, 'getRecommendations']);
    Route::get('/rice-saw/top-recommendations/{plantingSchedule}', [RiceRecommendationController::class, 'getTopRecommendations']);

    // User info
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });
});
