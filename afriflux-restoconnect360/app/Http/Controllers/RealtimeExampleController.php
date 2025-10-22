<?php

namespace App\Http\Controllers;

use App\Events\OrderCreated;
use App\Events\OrderStatusUpdated;
use App\Events\DeliveryLocationUpdated;
use App\Models\Order;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RealtimeExampleController extends Controller
{
    /**
     * Example: Trigger OrderCreated event
     */
    public function testOrderCreated(Request $request): JsonResponse
    {
        // Simulate order creation
        $order = Order::first(); // Get first order for testing
        
        if (!$order) {
            return response()->json(['error' => 'No order found in database'], 404);
        }

        // Broadcast the event
        broadcast(new OrderCreated($order))->toOthers();

        return response()->json([
            'success' => true,
            'message' => 'OrderCreated event broadcasted',
            'order_id' => $order->id,
            'channels' => [
                'commerce.' . $order->commerce_id,
                'order.' . $order->id,
            ]
        ]);
    }

    /**
     * Example: Trigger OrderStatusUpdated event
     */
    public function testOrderStatusUpdated(Request $request): JsonResponse
    {
        $order = Order::first();
        
        if (!$order) {
            return response()->json(['error' => 'No order found in database'], 404);
        }

        $oldStatus = $order->status;
        $newStatus = 'preparing'; // Example new status

        // Update the order status
        $order->update(['status' => $newStatus]);

        // Broadcast the event
        broadcast(new OrderStatusUpdated($order, $oldStatus, $newStatus))->toOthers();

        return response()->json([
            'success' => true,
            'message' => 'OrderStatusUpdated event broadcasted',
            'order_id' => $order->id,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
        ]);
    }

    /**
     * Example: Trigger DeliveryLocationUpdated event
     */
    public function testDeliveryLocation(Request $request): JsonResponse
    {
        $delivery = Delivery::with('order')->first();
        
        if (!$delivery) {
            // Create a mock delivery for testing
            $order = Order::first();
            if (!$order) {
                return response()->json(['error' => 'No order found to create delivery'], 404);
            }

            $delivery = new Delivery();
            $delivery->order_id = $order->id;
            $delivery->id = 1; // Mock ID for testing
            $delivery->order = $order;
        }

        // Example coordinates (Dakar, Senegal)
        $latitude = 14.7167 + (rand(-100, 100) / 10000); // Add some variance
        $longitude = -17.4677 + (rand(-100, 100) / 10000);

        // Broadcast the event
        broadcast(new DeliveryLocationUpdated($delivery, $latitude, $longitude))->toOthers();

        return response()->json([
            'success' => true,
            'message' => 'DeliveryLocationUpdated event broadcasted',
            'delivery_id' => $delivery->id,
            'coordinates' => [
                'latitude' => $latitude,
                'longitude' => $longitude,
            ]
        ]);
    }

    /**
     * Test Soketi connection
     */
    public function testSoketiConnection(): JsonResponse
    {
        try {
            $pusher = app('pusher');
            $info = $pusher->get('/channels');
            
            return response()->json([
                'success' => true,
                'message' => 'Soketi is connected and working',
                'channels_info' => $info,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Soketi connection failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
