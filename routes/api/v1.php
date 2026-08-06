<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HealthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\AuthController;

Route::middleware('throttle:3,1')->group(function(){

    Route::get('/user', function (Request $request) {
    return $request->user();
    });
    Route::get('/health', [HealthController::class, 'index']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

});


Route::middleware([
    'auth:sanctum',
    'throttle:60,1'
])->group(function(){

    Route::get('/profile', [AuthController::class, 'profile']);
    
    Route::get('/products', [ProductController::class, 'index']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::get('/products/{product}', [ProductController::class, 'show']);
    Route::put('/products/{product}', [ProductController::class, 'updateProduct']);
    Route::delete('/products/{product}', [ProductController::class, 'deleteProduct']);

    Route::post('/logout', [AuthController::class, 'logout']);

});
?>