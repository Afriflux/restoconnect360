<?php

namespace App\Models\Delivery;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingHistory extends Model
{
    use HasFactory;

    protected $table = 'tracking_history';

    protected $fillable = [
        'delivery_id',
        'driver_id',
        'latitude',
        'longitude',
        'accuracy',
        'speed',
        'heading',
        'status',
        'notes',
        'recorded_at',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'accuracy' => 'decimal:2',
        'speed' => 'decimal:2',
        'recorded_at' => 'datetime',
    ];

    /**
     * Relations
     */
    public function delivery()
    {
        return $this->belongsTo(Delivery::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    /**
     * Scopes
     */
    public function scopeRecent($query, $minutes = 30)
    {
        return $query->where('recorded_at', '>=', now()->subMinutes($minutes));
    }

    public function scopeForDelivery($query, $deliveryId)
    {
        return $query->where('delivery_id', $deliveryId)
            ->orderBy('recorded_at');
    }

    /**
     * Helper methods
     */
    public static function recordLocation(
        int $deliveryId,
        int $driverId,
        float $latitude,
        float $longitude,
        ?float $accuracy = null,
        ?float $speed = null,
        ?int $heading = null,
        ?string $status = null
    ): self {
        return self::create([
            'delivery_id' => $deliveryId,
            'driver_id' => $driverId,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'accuracy' => $accuracy,
            'speed' => $speed,
            'heading' => $heading,
            'status' => $status,
            'recorded_at' => now(),
        ]);
    }
}

