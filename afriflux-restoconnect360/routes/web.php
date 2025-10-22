<?php

use App\Http\Controllers\Platform\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('app');
});

// Admin routes - Protected by Vue.js authentication
Route::prefix('admin')->name('admin.')->middleware('vue.auth')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/payments', [AdminController::class, 'payments'])->name('payments');
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::get('/restaurants', [AdminController::class, 'restaurants'])->name('restaurants');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/deliveries', [AdminController::class, 'deliveries'])->name('deliveries');
    Route::get('/subscriptions', [AdminController::class, 'subscriptions'])->name('subscriptions');
    
    // Routes pour les options promotionnelles
    Route::prefix('promotional')->name('promotional.')->group(function () {
        Route::get('/gift-cards', [AdminController::class, 'giftCards'])->name('gift-cards');
        Route::get('/coupons', [AdminController::class, 'coupons'])->name('coupons');
        Route::get('/special-offers', [AdminController::class, 'specialOffers'])->name('special-offers');
        Route::get('/promotions', [AdminController::class, 'promotions'])->name('promotions');
    });
});

// Catch-all route for Vue.js SPA - must be last
Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');
