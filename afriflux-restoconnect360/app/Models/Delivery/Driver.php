<?php

namespace App\Models\Delivery;

use App\Models\Platform\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'company_id',
        'license_number',
        'license_photo',
        'vehicle_type',
        'vehicle_make',
        'vehicle_model',
        'vehicle_plate_number',
        'vehicle_color',
        'vehicle_photo',
        'status',
        'current_latitude',
        'current_longitude',
        'last_location_update',
        'is_available',
        'is_verified',
        'verified_at',
        'rating',
        'total_reviews',
        'total_deliveries',
        'successful_deliveries',
        'cancelled_deliveries',
        'total_earnings',
        'commission_rate',
        'working_hours',
        'delivery_zones',
    ];

    protected $casts = [
        'current_latitude' => 'decimal:8',
        'current_longitude' => 'decimal:8',
        'last_location_update' => 'datetime',
        'is_available' => 'boolean',
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
        'rating' => 'decimal:2',
        'total_earnings' => 'decimal:2',
        'commission_rate' => 'decimal:2',
        'working_hours' => 'array',
        'delivery_zones' => 'array',
    ];

    /**
     * Relations
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }

    public function trackingHistory()
    {
        return $this->hasMany(TrackingHistory::class);
    }

    public function currentDelivery()
    {
        return $this->hasOne(Delivery::class)
            ->whereIn('status', ['assigned', 'picked_up', 'on_delivery'])
            ->latest();
    }

    /**
     * Scopes
     */
    public function scopeOnline($query)
    {
        return $query->where('status', 'online')
            ->where('is_available', true);
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'online')
            ->where('is_available', true)
            ->whereDoesntHave('currentDelivery');
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopeNearby($query, $latitude, $longitude, $radius = 10)
    {
        return $query->selectRaw("
            *,
            (
                6371 * acos(
                    cos(radians(?)) *
                    cos(radians(current_latitude)) *
                    cos(radians(current_longitude) - radians(?)) +
                    sin(radians(?)) *
                    sin(radians(current_latitude))
                )
            ) AS distance
        ", [$latitude, $longitude, $latitude])
            ->having('distance', '<', $radius)
            ->orderBy('distance');
    }

    /**
     * Helper methods
     */
    public function isOnline(): bool
    {
        return $this->status === 'online' && $this->is_available;
    }

    public function isBusy(): bool
    {
        return $this->status === 'busy';
    }

    public function updateLocation(float $latitude, float $longitude): void
    {
        $this->update([
            'current_latitude' => $latitude,
            'current_longitude' => $longitude,
            'last_location_update' => now(),
        ]);
    }

    public function goOnline(): void
    {
        $this->update([
            'status' => 'online',
            'is_available' => true,
        ]);
    }

    public function goOffline(): void
    {
        $this->update([
            'status' => 'offline',
            'is_available' => false,
        ]);
    }

    public function takeBreak(): void
    {
        $this->update([
            'status' => 'on_break',
            'is_available' => false,
        ]);
    }

    public function getSuccessRate(): float
    {
        if ($this->total_deliveries === 0) {
            return 0;
        }

        return round(($this->successful_deliveries / $this->total_deliveries) * 100, 2);
    }
}

