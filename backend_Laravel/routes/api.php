<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HMController;
use App\Http\Controllers\FashionAnalysisController;

// H&M API Routes
Route::get('/hm/search', [HMController::class, 'search']);
Route::get('/hm/product-description', [HMController::class, 'productDescription']);
Route::get('/hm/new-arrivals', [HMController::class, 'newArrivals']);

// Fashion Analysis API Route - matche '/api/analyze' endpoint expected by frontend
Route::post('/analyze', [FashionAnalysisController::class, 'analyze']);

