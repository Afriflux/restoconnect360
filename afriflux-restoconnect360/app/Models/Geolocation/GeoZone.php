<?php

namespace App\Models\Geolocation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GeoZone extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'type',
        'description',
        'center_latitude',
        'center_longitude',
        'radius_km',
        'polygon_coordinates',
        'bounds',
        'country',
        'state',
        'city',
        'restaurant_count',
        'active_drivers',
        'is_active',
        'is_featured',
        'timezone',
        'color',
    ];

    protected $casts = [
        'center_latitude' => 'decimal:8',
        'center_longitude' => 'decimal:8',
        'radius_km' => 'decimal:2',
        'polygon_coordinates' => 'array',
        'bounds' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeNearby($query, $latitude, $longitude, $radius = 50)
    {
        return $query->selectRaw("
            *,
            (
                6371 * acos(
                    cos(radians(?)) *
                    cos(radians(center_latitude)) *
                    cos(radians(center_longitude) - radians(?)) +
                    sin(radians(?)) *
                    sin(radians(center_latitude))
                )
            ) AS distance
        ", [$latitude, $longitude, $latitude])
            ->having('distance', '<', $radius)
            ->orderBy('distance');
    }

    /**
     * Helper methods
     */
    public function containsLocation(float $latitude, float $longitude): bool
    {
        if ($this->radius_km) {
            $distance = $this->calculateDistance($latitude, $longitude);
            return $distance <= $this->radius_km;
        }

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

    public function isPointInPolygon(float $latitude, float $longitude): bool
    {
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

    public function updateRestaurantCount(): void
    {
        // This would typically query the restaurants table
        // For now, we'll just increment/decrement
        $this->update([
            'restaurant_count' => \App\Models\Restaurant\Restaurant::query()
                ->where('is_active', true)
                ->where(function ($query) {
                    $query->where('city', $this->city)
                        ->orWhereRaw("ST_Distance_Sphere(
                            point(longitude, latitude),
                            point(?, ?)
                        ) / 1000 <= ?", [
                            $this->center_longitude,
                            $this->center_latitude,
                            $this->radius_km,
                        ]);
                })
                ->count(),
        ]);
    }
}

