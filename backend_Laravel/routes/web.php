<?php

use App\Http\Controllers\api\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HMController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\ArticleController;
use App\Http\Controllers\AIRecommendationController;
use App\Http\Controllers\api\AdminController;
use App\Http\Controllers\api\UsersController;

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
require __DIR__.'/auth.php';


Route::middleware('auth')->group(function () {

    Route::get('/logout', [UsersController::class, 'logout'])->name('logout');


    //! Route for creating post page functionality for posting as well.
    Route::get('/createPost', function () {
        return view('common/createPost');
    })->name('createPost');
    Route::get('/posts/create', [ArticleController::class, 'create'])->name('post_create');
    Route::post('/posts', [ArticleController::class, 'store'])->name('posts_store');
    
    //! Route for pending page
    Route::get('/pending', function () {
        return view('common/pendingPage');
    })->name('pending');
    
    
    
        //! Route for admin page
    Route::get('/admin/users', [AdminController::class, 'userManagement'])->name('admin_users');
    Route::patch('/admin/users/{id}/toggle-approval', [AdminController::class, 'toggleApproval'])
        ->name('admin.users.toggle-approval');
    
    
    //! Route for profile page
    Route::get('/profile', [UsersController::class, 'getAllUserPosts'])->name('profile');
   
});










Route::middleware('guest')->group(function () {
//! Route for Login and signup page
Route::get('/login', function () {
    return view('common.login_signup');
})->name('login');
Route::get('/signup', function () {
    return view('common.login_signup');
})->name('signup');
Route::post('/login', [UsersController::class, 'login'])->name('login.submit');
Route::post('/signup', [UsersController::class, 'register'])->name('signup.submit');


});






//! Route for landing Page (Including react redirect routes).
Route::get('/', function () {
    return view('welcome');
}) ->name('welcome');
Route::get('/discover', function() {
    return redirect(config('app.react_url') . '/discover');
}) -> name('discover');
Route::get('/ootd', function() {
    return redirect(config('app.react_url') . '/ootd');
}) -> name('ootd');

Route::get('/main', function() {
    return redirect(config('app.react_url'));
}) -> name('mainFrontEnd');





Route::post('/posts/{id}/like', [ArticleController::class, 'like']);





//! Route for sending post data to react
Route::prefix('ootd')->group(function () {
    Route::get('/posts', [ArticleController::class, 'index']);
    Route::get('/post/{id}', [ArticleController::class, 'show']);
    Route::post('/posts', [ArticleController::class, 'store']);
    Route::post('/post/{id}/like', [ArticleController::class, 'like']);
});
Route::get('/articles', [ArticleController::class, 'index']);










// AI Recommendation page
Route::get('/ai-recommendation/{id}', [AIRecommendationController::class, 'show'])->name('ai.recommendation');

//! Commented out cuz it's causing error


// Placeholder image route for development
// Route::get('/api/placeholder/{width}/{height}', function ($width, $height) {
//     $img = imagecreatetruecolor($width, $height);
    
//     // Background color - light gray
//     $bgColor = imagecolorallocate($img, 240, 240, 240);
//     imagefill($img, 0, 0, $bgColor);
    
//     // Border color - darker gray
//     $borderColor = imagecolorallocate($img, 200, 200, 200);
//     imagerectangle($img, 0, 0, $width-1, $height-1, $borderColor);
    
//     // Text color - dark gray
//     $textColor = imagecolorallocate($img, 120, 120, 120);
    
//     // Add text with dimensions
//     $text = "{$width}x{$height}";
//     $font = 4; // Built-in font size
//     $textWidth = imagefontwidth($font) * strlen($text);
//     $textHeight = imagefontheight($font);
    
//     // Center the text
//     $x = ($width - $textWidth) / 2;
//     $y = ($height - $textHeight) / 2;
    
//     // Draw the text
//     imagestring($img, $font, $x, $y, $text, $textColor);
    
//     // Output image
//     header('Content-Type: image/png');
//     imagepng($img);
//     imagedestroy($img);
//     exit;
// })->where(['width' => '[0-9]+', 'height' => '[0-9]+']);

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// // why isnt it detecting...
// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//     Route::get('/hm-products', [HMController::class, 'fetchProducts']);
//     // Route::post('/gpt-recommendations', [GPTController::class, 'generateRecommendations']);
//     // Route::post('/azure-image-analysis', [AzureImageController::class, 'analyzeImage']);
// });



// Route::post('/image', [ItemController::class, 'store'])->name("items.store");

// Route::get('/image/{id}', [ItemController::class, 'showImage'])->name("image");

// Route::get('/test', function(){
//     return view('test-image');
// });

Route::get('/debug', function () {
    return [
        'database_exists' => file_exists(env('DB_DATABASE')),
        'storage_writable' => is_writable(storage_path()),
        'sessions_table_exists' => \Illuminate\Support\Facades\Schema::hasTable('sessions'),
        'php_version' => phpversion(),
        'laravel_version' => app()->version()
    ];
});

// Debug route to check routing
Route::get('/route-debug', function () {
    return response()->json([
        'route' => request()->path(),
        'url' => request()->url(),
        'full_url' => request()->fullUrl(),
        'method' => request()->method(),
        'server_protocol' => $_SERVER['SERVER_PROTOCOL'] ?? 'unknown',
        'script_name' => $_SERVER['SCRIPT_NAME'] ?? 'unknown',
        'request_uri' => $_SERVER['REQUEST_URI'] ?? 'unknown',
    ]);
});








