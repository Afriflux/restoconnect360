<?php

use App\Http\Controllers\RealtimeExampleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Real-time Testing Routes
|--------------------------------------------------------------------------
|
| These routes are for testing Soketi WebSocket broadcasting.
| In production, these events would be triggered by actual business logic.
|
*/

Route::prefix('test/realtime')->group(function () {
    // Test Soketi connection
    Route::get('/connection', [RealtimeExampleController::class, 'testSoketiConnection'])
        ->name('test.soketi.connection');

    // Test broadcasting events
    Route::post('/order-created', [RealtimeExampleController::class, 'testOrderCreated'])
        ->name('test.order.created');

    Route::post('/order-status', [RealtimeExampleController::class, 'testOrderStatusUpdated'])
        ->name('test.order.status');

    Route::post('/delivery-location', [RealtimeExampleController::class, 'testDeliveryLocation'])
        ->name('test.delivery.location');
});
