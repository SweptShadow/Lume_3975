<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HMController;
use App\Http\Controllers\FashionAnalysisController;
use App\Http\Controllers\AIRecommendationController;

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

Route::post('/analyze', [FashionAnalysisController::class, 'analyze']);
