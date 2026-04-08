<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/products', [\App\Http\Controllers\Api\ProductController::class, 'index']);
Route::get('/products/{slug}', [\App\Http\Controllers\Api\ProductController::class, 'show']);
Route::post('/checkout', [\App\Http\Controllers\Api\OrderController::class, 'store']);

Route::post('/payment/initiate', [\App\Http\Controllers\Api\PaymentController::class, 'initiate']);
Route::post('/payment/verify', [\App\Http\Controllers\Api\PaymentController::class, 'verify']);

// Auth
Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
    Route::get('/user', [\App\Http\Controllers\Api\AuthController::class, 'user']);
    Route::get('/my-orders', [\App\Http\Controllers\Api\OrderController::class, 'index']);
});

// Settings
Route::get('/settings', [\App\Http\Controllers\Api\SettingsController::class, 'index']);

// CMS Pages
Route::get('/home-page', [\App\Http\Controllers\Api\PageController::class, 'home']);
Route::get('/pages/{slug}', [\App\Http\Controllers\Api\PageController::class, 'show']);

// Coupons
Route::get('/coupons/public', [\App\Http\Controllers\Api\CouponApiController::class, 'getActivePublicCoupons']);
Route::post('/coupons/apply', [\App\Http\Controllers\Api\CouponApiController::class, 'applyCoupon']);
