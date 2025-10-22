<?php

namespace App\Events;

use App\Models\Delivery;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeliveryLocationUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $delivery;
    public $latitude;
    public $longitude;

    /**
     * Create a new event instance.
     *
     * @param Delivery $delivery
     * @param float $latitude
     * @param float $longitude
     */
    public function __construct(Delivery $delivery, float $latitude, float $longitude)
    {
        $this->delivery = $delivery;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('commerce.' . $this->delivery->order->commerce_id),
            new PrivateChannel('order.' . $this->delivery->order_id),
            new PrivateChannel('delivery.' . $this->delivery->id),
            new PrivateChannel('user.' . $this->delivery->order->customer_id),
        ];
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'delivery.location.updated';
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'delivery_id' => $this->delivery->id,
            'order_id' => $this->delivery->order_id,
            'driver_name' => $this->delivery->driver->name ?? 'Livreur',
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'estimated_time' => $this->delivery->estimated_arrival_time,
            'distance_remaining' => $this->calculateDistance(),
            'updated_at' => now()->toISOString(),
        ];
    }

    /**
     * Calculate distance remaining to destination
     *
     * @return float
     */
    private function calculateDistance(): float
    {
        // Simple calculation for demo - in production use proper geo calculation
        $customerLat = $this->delivery->order->delivery_latitude ?? 0;
        $customerLng = $this->delivery->order->delivery_longitude ?? 0;
        
        $earthRadius = 6371; // km
        $deltaLat = deg2rad($customerLat - $this->latitude);
        $deltaLng = deg2rad($customerLng - $this->longitude);
        
        $a = sin($deltaLat/2) * sin($deltaLat/2) +
            cos(deg2rad($this->latitude)) * cos(deg2rad($customerLat)) *
            sin($deltaLng/2) * sin($deltaLng/2);
        
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        
        return round($earthRadius * $c, 2); // Distance in km
    }
}
