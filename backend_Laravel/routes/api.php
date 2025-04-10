<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HMController;
use App\Http\Controllers\FashionAnalysisController;
use App\Http\Controllers\AIRecommendationController;
use App\Http\Controllers\api\UsersController; // Fixed path

// Basic test endpoint that should always work
Route::get('/test', function() {
    return response()->json(['status' => 'API is working', 'message' => 'Connection successful']);
});

// H&M API Routes
Route::get('/hm/search', [HMController::class, 'search']);
Route::get('/hm/product-description', [HMController::class, 'productDescription']);
Route::get('/hm/new-arrivals', [HMController::class, 'newArrivals']);

// Fashion Analysis API Route - matches '/api/analyze' endpoint expected by frontend
Route::post('/analyze', [FashionAnalysisController::class, 'analyze']);

// AI Recommendation Routes
Route::post('/ai-recommend', [AIRecommendationController::class, 'getRecommendations']);
Route::get('/ai-recommend/{id}', [AIRecommendationController::class, 'getRecommendationById']);

// Debug endpoint
Route::get('/ai-debug', function() {
    return response()->json(['status' => 'API is working']);
});

// Authentication endpoints
Route::post('/auth/login', [UsersController::class, 'apiLogin']);
Route::post('/auth/register', [UsersController::class, 'apiRegister']);

// Debug route
Route::get('/debug', function() {
    return response()->json([
        'database_path' => config('database.connections.sqlite.database'),
        'database_exists' => file_exists(config('database.connections.sqlite.database')),
        'database_writable' => is_writable(config('database.connections.sqlite.database')),
        'storage_writable' => is_writable(storage_path()),
        'cache_writable' => is_writable(storage_path('framework/cache')),
        'app_url' => config('app.url'),
        'cors_origin' => config('cors.allowed_origins'),
        'php_version' => PHP_VERSION,
    ]);
});

// Simple health check route
Route::get('/health', function() {
    return response()->json(['status' => 'healthy', 'timestamp' => now()->toDateTimeString()]);
});
