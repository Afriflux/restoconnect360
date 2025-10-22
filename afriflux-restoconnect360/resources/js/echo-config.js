import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

// Make Pusher available globally
window.Pusher = Pusher;

// Configure Laravel Echo with Soketi
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'restoconnect360key', // Same as in .env PUSHER_APP_KEY
    cluster: 'mt1',
    wsHost: window.location.hostname,
    wsPort: 6001,
    wssPort: 6001,
    forceTLS: false,
    encrypted: true,
    disableStats: true,
    enabledTransports: ['ws', 'wss'],
    authEndpoint: '/broadcasting/auth',
});

// Export for use in other modules
export default window.Echo;

/**
 * Example usage in Vue/React components:
 * 
 * // Listen for new orders (commerce-specific)
 * Echo.private(`commerce.${commerceId}`)
 *     .listen('.order.created', (e) => {
 *         console.log('New order received!', e);
 *         // Play notification sound
 *         playNotificationSound();
 *         // Update orders list
 *         addOrderToList(e);
 *         // Show notification
 *         showNotification(`New order #${e.order_number}`, e.message);
 *     });
 * 
 * // Listen for order status updates
 * Echo.private(`order.${orderId}`)
 *     .listen('.order.status.updated', (e) => {
 *         console.log('Order status updated!', e);
 *         updateOrderStatus(e.order_id, e.new_status);
 *         showNotification('Status Update', e.message);
 *     });
 * 
 * // Listen for delivery location updates
 * Echo.private(`delivery.${deliveryId}`)
 *     .listen('.delivery.location.updated', (e) => {
 *         console.log('Delivery location updated!', e);
 *         updateMapMarker(e.latitude, e.longitude);
 *         updateEstimatedTime(e.estimated_time);
 *         updateDistanceRemaining(e.distance_remaining);
 *     });
 * 
 * // Leave channel when component unmounts
 * Echo.leave(`commerce.${commerceId}`);
 */

// Helper functions
window.playNotificationSound = function() {
    const audio = new Audio('/sounds/notification.mp3');
    audio.play().catch(e => console.log('Could not play sound:', e));
};

window.showNotification = function(title, message) {
    // Check if browser supports notifications
    if (!("Notification" in window)) {
        console.log("This browser does not support notifications");
        return;
    }

    // Check permission
    if (Notification.permission === "granted") {
        new Notification(title, {
            body: message,
            icon: '/images/logo.png',
            badge: '/images/badge.png',
            vibrate: [200, 100, 200],
            tag: 'restoconnect360',
        });
    } else if (Notification.permission !== "denied") {
        Notification.requestPermission().then(function (permission) {
            if (permission === "granted") {
                new Notification(title, {
                    body: message,
                    icon: '/images/logo.png',
                });
            }
        });
    }
};

// Auto-request notification permission on load
if ("Notification" in window && Notification.permission === "default") {
    Notification.requestPermission();
}

console.log('🚀 Laravel Echo configured with Soketi WebSocket server');
