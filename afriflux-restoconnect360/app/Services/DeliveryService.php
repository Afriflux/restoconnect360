<?php

namespace App\Services;

use App\Models\Delivery\Delivery;
use App\Models\Delivery\Driver;
use App\Models\Restaurant\Order;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeliveryService
{
    private GeolocationService $geolocationService;

    public function __construct(GeolocationService $geolocationService)
    {
        $this->geolocationService = $geolocationService;
    }

    /**
     * Create a delivery for an order
     */
    public function createDelivery(Order $order): ?Delivery
    {
        try {
            if ($order->order_type !== 'delivery') {
                return null;
            }

            $restaurant = $order->restaurant;

            // Calculate distance and duration
            $route = $this->geolocationService->calculateRoute(
                $restaurant->latitude,
                $restaurant->longitude,
                $order->delivery_latitude,
                $order->delivery_longitude
            );

            $delivery = Delivery::create([
                'order_id' => $order->id,
                'restaurant_id' => $restaurant->id,
                'pickup_address' => $restaurant->address,
                'pickup_latitude' => $restaurant->latitude,
                'pickup_longitude' => $restaurant->longitude,
                'delivery_address' => $order->delivery_address,
                'delivery_latitude' => $order->delivery_latitude,
                'delivery_longitude' => $order->delivery_longitude,
                'distance_km' => $route['distance']['value'] ?? null,
                'estimated_duration_minutes' => $route['duration']['value'] ?? 30,
                'delivery_fee' => $order->delivery_fee,
                'customer_name' => $order->customer_name,
                'customer_phone' => $order->customer_phone,
                'status' => 'pending',
            ]);

            return $delivery;
        } catch (Exception $e) {
            Log::error('Create delivery error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Find and assign the nearest available driver
     */
    public function assignNearestDriver(Delivery $delivery): bool
    {
        try {
            $driver = Driver::online()
                ->available()
                ->verified()
                ->nearby(
                    $delivery->pickup_latitude,
                    $delivery->pickup_longitude,
                    20 // Search within 20km
                )
                ->first();

            if (!$driver) {
                Log::warning("No available driver found for delivery {$delivery->id}");
                return false;
            }

            $delivery->assignDriver($driver);

            // Send notification to driver
            app(NotificationService::class)->notifyDriverNewDelivery($driver, $delivery);

            return true;
        } catch (Exception $e) {
            Log::error('Assign driver error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Manually assign a driver
     */
    public function assignDriver(Delivery $delivery, Driver $driver): bool
    {
        try {
            if (!$driver->isOnline()) {
                return false;
            }

            $delivery->assignDriver($driver);

            // Send notification
            app(NotificationService::class)->notifyDriverNewDelivery($driver, $delivery);

            return true;
        } catch (Exception $e) {
            Log::error('Manual assign driver error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Update driver location
     */
    public function updateDriverLocation(Driver $driver, float $latitude, float $longitude): bool
    {
        try {
            $driver->updateLocation($latitude, $longitude);

            // If driver has an active delivery, record tracking
            $activeDelivery = $driver->currentDelivery;

            if ($activeDelivery) {
                $activeDelivery->trackingHistory()->create([
                    'driver_id' => $driver->id,
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'status' => $activeDelivery->status,
                    'recorded_at' => now(),
                ]);
            }

            return true;
        } catch (Exception $e) {
            Log::error('Update driver location error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Optimize delivery route
     */
    public function optimizeRoute(array $deliveryIds): array
    {
        try {
            // This is a simplified version
            // In production, you would use Google Maps Directions API with waypoints
            // or a dedicated route optimization service

            $deliveries = Delivery::whereIn('id', $deliveryIds)
                ->where('status', 'assigned')
                ->get();

            $optimized = $deliveries->sortBy(function ($delivery) {
                // Sort by distance from pickup point
                return $delivery->distance_km;
            });

            return $optimized->pluck('id')->toArray();
        } catch (Exception $e) {
            Log::error('Optimize route error: ' . $e->getMessage());
            return $deliveryIds;
        }
    }

    /**
     * Calculate delivery fee based on distance
     */
    public function calculateDeliveryFee(float $distanceKm, ?int $restaurantId = null): float
    {
        try {
            $baseFee = config('services.delivery.base_price', 1000);
            $pricePerKm = config('services.delivery.price_per_km', 500);

            // Check if restaurant has custom delivery zone pricing
            if ($restaurantId) {
                $restaurant = \App\Models\Restaurant\Restaurant::find($restaurantId);

                if ($restaurant && $restaurant->delivery_fee > 0) {
                    return $restaurant->delivery_fee;
                }
            }

            return $baseFee + ($distanceKm * $pricePerKm);
        } catch (Exception $e) {
            Log::error('Calculate delivery fee error: ' . $e->getMessage());
            return 1000; // Default fee
        }
    }

    /**
     * Get delivery statistics
     */
    public function getDeliveryStats(?int $driverId = null, ?string $period = 'today'): array
    {
        try {
            $query = Delivery::query();

            if ($driverId) {
                $query->where('driver_id', $driverId);
            }

            switch ($period) {
                case 'today':
                    $query->whereDate('created_at', today());
                    break;
                case 'week':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('created_at', now()->month);
                    break;
            }

            return [
                'total' => $query->count(),
                'completed' => $query->clone()->where('status', 'delivered')->count(),
                'in_progress' => $query->clone()->whereIn('status', ['assigned', 'picked_up', 'on_delivery'])->count(),
                'cancelled' => $query->clone()->where('status', 'cancelled')->count(),
                'total_distance' => $query->clone()->sum('distance_km'),
                'total_earnings' => $query->clone()->where('status', 'delivered')->sum('delivery_fee'),
            ];
        } catch (Exception $e) {
            Log::error('Get delivery stats error: ' . $e->getMessage());
            return [];
        }
    }
}

