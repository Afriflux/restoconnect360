<?php

namespace App\Models\Delivery;

use App\Models\Restaurant\Restaurant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryZone extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'restaurant_id',
        'name',
        'description',
        'center_latitude',
        'center_longitude',
        'radius_km',
        'polygon_coordinates',
        'base_delivery_fee',
        'price_per_km',
        'min_order_amount',
        'estimated_delivery_time',
        'is_active',
        'color',
    ];

    protected $casts = [
        'center_latitude' => 'decimal:8',
        'center_longitude' => 'decimal:8',
        'radius_km' => 'decimal:2',
        'polygon_coordinates' => 'array',
        'base_delivery_fee' => 'decimal:2',
        'price_per_km' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Relations
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Helper methods
     */
    public function isLocationInZone(float $latitude, float $longitude): bool
    {
        // Simple radius-based check
        if ($this->radius_km) {
            $distance = $this->calculateDistance($latitude, $longitude);
            return $distance <= $this->radius_km;
        }

        // Polygon-based check (if implemented)
        if ($this->polygon_coordinates) {
            return $this->isPointInPolygon($latitude, $longitude);
        }

        return false;
    }

    public function calculateDistance(float $latitude, float $longitude): float
    {
        $earthRadius = 6371; // km

        $latFrom = deg2rad($this->center_latitude);
        $lonFrom = deg2rad($this->center_longitude);
        $latTo = deg2rad($latitude);
        $lonTo = deg2rad($longitude);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        return round($angle * $earthRadius, 2);
    }

    public function calculateDeliveryFee(float $distance): float
    {
        return $this->base_delivery_fee + ($distance * $this->price_per_km);
    }

    private function isPointInPolygon(float $latitude, float $longitude): bool
    {
        // Ray-casting algorithm to determine if point is in polygon
        // This is a simplified version - you may want to use a more robust library
        if (!$this->polygon_coordinates || count($this->polygon_coordinates) < 3) {
            return false;
        }

        $inside = false;
        $count = count($this->polygon_coordinates);

        for ($i = 0, $j = $count - 1; $i < $count; $j = $i++) {
            $xi = $this->polygon_coordinates[$i]['lat'];
            $yi = $this->polygon_coordinates[$i]['lng'];
            $xj = $this->polygon_coordinates[$j]['lat'];
            $yj = $this->polygon_coordinates[$j]['lng'];

            $intersect = (($yi > $longitude) != ($yj > $longitude))
                && ($latitude < ($xj - $xi) * ($longitude - $yi) / ($yj - $yi) + $xi);

            if ($intersect) {
                $inside = !$inside;
            }
        }

        return $inside;
    }
}

