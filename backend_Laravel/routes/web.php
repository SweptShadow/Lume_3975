<?php

use App\Http\Controllers\api\ItemController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes???
|--------------------------------------------------------------------------
|
| try to register web routes for application
| routes are loaded by RouteServiceProvider & all of them will
| be assigned to the "web" middleware group?
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Placeholder image route for development
Route::get('/api/placeholder/{width}/{height}', function ($width, $height) {
    $img = imagecreatetruecolor($width, $height);
    
    // Background color - light gray
    $bgColor = imagecolorallocate($img, 240, 240, 240);
    imagefill($img, 0, 0, $bgColor);
    
    // Border color - darker gray
    $borderColor = imagecolorallocate($img, 200, 200, 200);
    imagerectangle($img, 0, 0, $width-1, $height-1, $borderColor);
    
    // Text color - dark gray
    $textColor = imagecolorallocate($img, 120, 120, 120);
    
    // Add text with dimensions
    $text = "{$width}x{$height}";
    $font = 4; // Built-in font size
    $textWidth = imagefontwidth($font) * strlen($text);
    $textHeight = imagefontheight($font);
    
    // Center the text
    $x = ($width - $textWidth) / 2;
    $y = ($height - $textHeight) / 2;
    
    // Draw the text
    imagestring($img, $font, $x, $y, $text, $textColor);
    
    // Output image
    header('Content-Type: image/png');
    imagepng($img);
    imagedestroy($img);
    exit;
})->where(['width' => '[0-9]+', 'height' => '[0-9]+']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// why isnt it detecting...
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/hm-products', [HMController::class, 'fetchProducts']);
    // Route::post('/gpt-recommendations', [GPTController::class, 'generateRecommendations']);
    Route::post('/azure-image-analysis', [AzureImageController::class, 'analyzeImage']);
});

require __DIR__.'/auth.php';

Route::post('/image', [ItemController::class, 'store'])->name("items.store");

Route::get('/image/{id}', [ItemController::class, 'showImage'])->name("image");

Route::get('/test', function(){
    return view('test-image');
});








