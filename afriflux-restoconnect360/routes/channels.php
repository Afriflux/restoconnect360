<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

// Canal privé pour un commerce spécifique
Broadcast::channel('commerce.{commerceId}', function ($user, $commerceId) {
    return $user->commerce_id === (int) $commerceId;
});

// Canal privé pour une commande spécifique
Broadcast::channel('order.{orderId}', function ($user, $orderId) {
    return $user->orders()->where('id', $orderId)->exists();
});

// Canal privé pour un utilisateur spécifique
Broadcast::channel('user.{userId}', function ($user, $userId) {
    return $user->id === (int) $userId;
});

// Canal privé pour les livreurs
Broadcast::channel('delivery.{deliveryId}', function ($user, $deliveryId) {
    return $user->hasRole('delivery') && $user->deliveries()->where('id', $deliveryId)->exists();
});

// Canal public pour les notifications générales
Broadcast::channel('notifications', function () {
    return true;
});
