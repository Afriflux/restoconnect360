<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'name',
        'slug',
        'description',
        'phone',
        'email',
        'address',
        'city',
        'country',
        'postal_code',
        'latitude',
        'longitude',
        'logo',
        'images',
        'cuisine_types',
        'rating',
        'review_count',
        'type',
        'price_range',
        'opening_hours',
        'delivery_zones',
        'delivery_fee',
        'delivery_time_min',
        'delivery_time_max',
        'accepts_orders',
        'accepts_delivery',
        'accepts_pickup',
        'accepts_dine_in',
        'payment_methods',
        'features',
        'settings',
        'status',
    ];

    protected $casts = [
        'images' => 'array',
        'cuisine_types' => 'array',
        'opening_hours' => 'array',
        'delivery_zones' => 'array',
        'payment_methods' => 'array',
        'features' => 'array',
        'settings' => 'array',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'rating' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'accepts_orders' => 'boolean',
        'accepts_delivery' => 'boolean',
        'accepts_pickup' => 'boolean',
        'accepts_dine_in' => 'boolean',
    ];

    /**
     * Get the company that owns the restaurant.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the delivery zones for the restaurant.
     */
    public function deliveryZones(): HasMany
    {
        return $this->hasMany(DeliveryZone::class);
    }

    /**
     * Get the orders for the restaurant.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Scope a query to only include active restaurants.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include restaurants that accept orders.
     */
    public function scopeAcceptingOrders($query)
    {
        return $query->where('accepts_orders', true)->where('status', 'active');
    }

    /**
     * Scope a query to find restaurants near a location.
     */
    public function scopeNearLocation($query, $latitude, $longitude, $radiusKm = 10)
    {
        $earthRadius = 6371; // Earth's radius in kilometers
        
        return $query->selectRaw("*, 
            ({$earthRadius} * acos(cos(radians(?)) * cos(radians(latitude)) * 
            cos(radians(longitude) - radians(?)) + sin(radians(?)) * 
            sin(radians(latitude)))) AS distance", [$latitude, $longitude, $latitude])
            ->having('distance', '<', $radiusKm)
            ->orderBy('distance');
    }

    /**
     * Scope a query to filter by cuisine type.
     */
    public function scopeByCuisineType($query, $cuisineType)
    {
        return $query->whereJsonContains('cuisine_types', $cuisineType);
    }

    /**
     * Scope a query to filter by restaurant type.
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Check if restaurant is open at a specific time.
     */
    public function isOpenAt($time = null): bool
    {
        $time = $time ?: now();
        $dayOfWeek = strtolower($time->format('l'));
        
        $openingHours = $this->opening_hours[$dayOfWeek] ?? null;
        
        if (!$openingHours || !$openingHours['open']) {
            return false;
        }

        $currentTime = $time->format('H:i');
        $openTime = $openingHours['open_time'];
        $closeTime = $openingHours['close_time'];

        return $currentTime >= $openTime && $currentTime <= $closeTime;
    }

    /**
     * Get restaurant's full address.
     */
    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([
            $this->address,
            $this->city,
            $this->postal_code,
            $this->country
        ]);

        return implode(', ', $parts);
    }

    /**
     * Get restaurant's main image.
     */
    public function getMainImageAttribute(): ?string
    {
        $images = $this->images ?? [];
        return $images[0] ?? $this->logo;
    }

    /**
     * Check if restaurant delivers to a location.
     */
    public function deliversTo($latitude, $longitude): bool
    {
        // Check if coordinates are within any delivery zone
        foreach ($this->deliveryZones as $zone) {
            if ($this->isPointInPolygon($latitude, $longitude, $zone->coordinates)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if a point is inside a polygon.
     */
    private function isPointInPolygon($latitude, $longitude, $coordinates): bool
    {
        $inside = false;
        $x = $longitude;
        $y = $latitude;

        for ($i = 0, $j = count($coordinates) - 1; $i < count($coordinates); $j = $i++) {
            $xi = $coordinates[$i]['longitude'];
            $yi = $coordinates[$i]['latitude'];
            $xj = $coordinates[$j]['longitude'];
            $yj = $coordinates[$j]['latitude'];

            if ((($yi > $y) !== ($yj > $y)) && ($x < ($xj - $xi) * ($y - $yi) / ($yj - $yi) + $xi)) {
                $inside = !$inside;
            }
        }

        return $inside;
    }
}