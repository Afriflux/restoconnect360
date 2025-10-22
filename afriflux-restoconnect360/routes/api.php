<?php

use App\Http\Controllers\Api\GeolocationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Delivery\DeliveryController;
use App\Http\Controllers\Delivery\DriverController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\Restaurant\OrderController;
use App\Http\Controllers\Restaurant\RestaurantController;
use App\Http\Controllers\TwoFactorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Restaurants (public)
Route::get('/restaurants', [RestaurantController::class, 'index']);
Route::get('/restaurants/nearby', [RestaurantController::class, 'nearby']);
Route::get('/restaurants/{restaurant}', [RestaurantController::class, 'show']);
Route::get('/restaurants/{restaurant}/menu', [RestaurantController::class, 'menu']);

// Payment webhooks (public)
Route::post('/payments/cinetpay/webhook', [PaymentController::class, 'cinetpayWebhook']);
Route::post('/payments/paytech/webhook', [PaymentController::class, 'paytechWebhook']);

// Geolocation (public)
Route::post('/geolocation/current', [GeolocationController::class, 'getCurrentLocation']);
Route::get('/geolocation/restaurants/nearby', [GeolocationController::class, 'findNearbyRestaurants']);
Route::get('/geolocation/companies/nearby', [GeolocationController::class, 'findNearbyCompanies']);
Route::post('/geolocation/reverse', [GeolocationController::class, 'reverseGeocode']);
Route::post('/geolocation/distance', [GeolocationController::class, 'calculateDistance']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    
    // Auth
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);

    // Two-Factor Authentication
    Route::prefix('2fa')->group(function () {
        Route::get('/status', [TwoFactorController::class, 'status']);
        Route::post('/generate', [TwoFactorController::class, 'generate']);
        Route::post('/verify', [TwoFactorController::class, 'verify']);
        Route::post('/verify-login', [TwoFactorController::class, 'verifyLogin']);
        Route::post('/disable', [TwoFactorController::class, 'disable']);
        Route::post('/regenerate-recovery-codes', [TwoFactorController::class, 'regenerateRecoveryCodes']);
        Route::get('/recovery-codes', [TwoFactorController::class, 'recoveryCodes']);
        Route::get('/lock-status', [TwoFactorController::class, 'lockStatus']);
    });

    // Restaurants (authenticated)
    Route::post('/restaurants', [RestaurantController::class, 'store']);
    Route::put('/restaurants/{restaurant}', [RestaurantController::class, 'update']);
    Route::delete('/restaurants/{restaurant}', [RestaurantController::class, 'destroy']);

    // Orders
    Route::get('/orders', [OrderController::class, 'index']);
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders/{order}', [OrderController::class, 'show']);
    Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus']);
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel']);

    // Payments
    Route::post('/payments/initialize', [PaymentController::class, 'initialize']);
    Route::get('/payments/{payment}/status', [PaymentController::class, 'status']);

    // Deliveries
    Route::get('/deliveries', [DeliveryController::class, 'index']);
    Route::get('/deliveries/{delivery}', [DeliveryController::class, 'show']);
    Route::post('/deliveries/{delivery}/assign', [DeliveryController::class, 'assignDriver']);
    Route::put('/deliveries/{delivery}/status', [DeliveryController::class, 'updateStatus']);
    Route::get('/deliveries/{delivery}/track', [DeliveryController::class, 'track']);

    // Drivers
    Route::get('/drivers', [DriverController::class, 'index']);
    Route::get('/drivers/{driver}', [DriverController::class, 'show']);
    Route::post('/driver/location', [DriverController::class, 'updateLocation']);
    Route::put('/driver/status', [DriverController::class, 'updateStatus']);
    Route::get('/driver/deliveries', [DriverController::class, 'deliveries']);
    Route::get('/driver/stats', [DriverController::class, 'stats']);

    // Geolocation (authenticated)
    Route::get('/geolocation/recommendations', [GeolocationController::class, 'getRecommendations']);
    Route::get('/geolocation/geosensing', [GeolocationController::class, 'getGeosensingData']);
});

// Admin routes with enhanced security
Route::middleware(['auth:sanctum', 'security'])->prefix('admin')->group(function () {
    // Ces routes nécessitent 2FA et ont des vérifications de permissions renforcées
    Route::get('/users', function () {
        return response()->json(['message' => 'Admin users endpoint']);
    });
    
    Route::get('/companies', function () {
        return response()->json(['message' => 'Admin companies endpoint']);
    });
    
    Route::get('/payments', function () {
        return response()->json(['message' => 'Admin payments endpoint']);
    });
    
    Route::get('/subscriptions', function () {
        return response()->json(['message' => 'Admin subscriptions endpoint']);
    });
});
