<?php

namespace App\Models\Delivery;

use App\Models\Restaurant\Order;
use App\Models\Restaurant\Restaurant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Delivery extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_id',
        'driver_id',
        'restaurant_id',
        'delivery_number',
        'pickup_address',
        'pickup_latitude',
        'pickup_longitude',
        'delivery_address',
        'delivery_latitude',
        'delivery_longitude',
        'distance_km',
        'estimated_duration_minutes',
        'delivery_fee',
        'status',
        'delivery_notes',
        'customer_name',
        'customer_phone',
        'delivery_proof',
        'signature',
        'assigned_at',
        'picked_up_at',
        'on_delivery_at',
        'delivered_at',
        'cancelled_at',
        'cancellation_reason',
        'driver_rating',
        'driver_review',
    ];

    protected $casts = [
        'pickup_latitude' => 'decimal:8',
        'pickup_longitude' => 'decimal:8',
        'delivery_latitude' => 'decimal:8',
        'delivery_longitude' => 'decimal:8',
        'distance_km' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'driver_rating' => 'decimal:2',
        'assigned_at' => 'datetime',
        'picked_up_at' => 'datetime',
        'on_delivery_at' => 'datetime',
        'delivered_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    /**
     * Relations
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function trackingHistory()
    {
        return $this->hasMany(TrackingHistory::class);
    }

    /**
     * Scopes
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeAssigned($query)
    {
        return $query->where('status', 'assigned');
    }

    public function scopeInProgress($query)
    {
        return $query->whereIn('status', ['picked_up', 'on_delivery']);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'delivered');
    }

    /**
     * Helper methods
     */
    public function assignDriver(Driver $driver): void
    {
        $this->update([
            'driver_id' => $driver->id,
            'status' => 'assigned',
            'assigned_at' => now(),
        ]);

        $driver->update(['status' => 'busy']);
    }

    public function markAsPickedUp(): void
    {
        $this->update([
            'status' => 'picked_up',
            'picked_up_at' => now(),
        ]);
    }

    public function markAsOnDelivery(): void
    {
        $this->update([
            'status' => 'on_delivery',
            'on_delivery_at' => now(),
        ]);
    }

    public function markAsDelivered(): void
    {
        $this->update([
            'status' => 'delivered',
            'delivered_at' => now(),
        ]);

        $this->driver?->update(['status' => 'online']);
        $this->driver?->increment('successful_deliveries');
        $this->driver?->increment('total_deliveries');
        $this->order?->markAsCompleted();
    }

    public function cancel(string $reason = null): void
    {
        $this->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'cancellation_reason' => $reason,
        ]);

        $this->driver?->update(['status' => 'online']);
        $this->driver?->increment('cancelled_deliveries');
    }

    public function calculateDistance(): float
    {
        // Haversine formula to calculate distance
        $earthRadius = 6371; // km

        $latFrom = deg2rad($this->pickup_latitude);
        $lonFrom = deg2rad($this->pickup_longitude);
        $latTo = deg2rad($this->delivery_latitude);
        $lonTo = deg2rad($this->delivery_longitude);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        return round($angle * $earthRadius, 2);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($delivery) {
            if (!$delivery->delivery_number) {
                $delivery->delivery_number = 'DEL-' . strtoupper(uniqid());
            }

            if (!$delivery->distance_km && $delivery->pickup_latitude && $delivery->delivery_latitude) {
                $delivery->distance_km = $delivery->calculateDistance();
            }
        });
    }
}

