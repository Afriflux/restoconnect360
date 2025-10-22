<?php

namespace App\Models\Geolocation;

use App\Models\Restaurant\Restaurant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchHistory extends Model
{
    use HasFactory;

    protected $table = 'search_history';

    protected $fillable = [
        'user_id',
        'session_id',
        'search_query',
        'search_latitude',
        'search_longitude',
        'search_radius_km',
        'filters',
        'results_count',
        'results_ids',
        'clicked_restaurant_id',
        'click_position',
        'device_type',
        'user_agent',
        'ip_address',
        'searched_at',
    ];

    protected $casts = [
        'search_latitude' => 'decimal:8',
        'search_longitude' => 'decimal:8',
        'search_radius_km' => 'decimal:2',
        'filters' => 'array',
        'results_ids' => 'array',
        'searched_at' => 'datetime',
    ];

    /**
     * Relations
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clickedRestaurant()
    {
        return $this->belongsTo(Restaurant::class, 'clicked_restaurant_id');
    }

    /**
     * Scopes
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeBySession($query, $sessionId)
    {
        return $query->where('session_id', $sessionId);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('searched_at', '>=', now()->subDays($days));
    }

    public function scopeWithClicks($query)
    {
        return $query->whereNotNull('clicked_restaurant_id');
    }

    public function scopeByDevice($query, $deviceType)
    {
        return $query->where('device_type', $deviceType);
    }

    /**
     * Helper methods
     */
    public static function record(
        ?int $userId,
        ?string $sessionId,
        ?string $searchQuery,
        ?float $latitude,
        ?float $longitude,
        ?float $radius,
        array $filters = [],
        int $resultsCount = 0,
        array $resultsIds = []
    ): self {
        return self::create([
            'user_id' => $userId,
            'session_id' => $sessionId,
            'search_query' => $searchQuery,
            'search_latitude' => $latitude,
            'search_longitude' => $longitude,
            'search_radius_km' => $radius,
            'filters' => $filters,
            'results_count' => $resultsCount,
            'results_ids' => $resultsIds,
            'device_type' => self::detectDeviceType(),
            'user_agent' => request()->userAgent(),
            'ip_address' => request()->ip(),
            'searched_at' => now(),
        ]);
    }

    public function recordClick(int $restaurantId, int $position): void
    {
        $this->update([
            'clicked_restaurant_id' => $restaurantId,
            'click_position' => $position,
        ]);
    }

    public static function detectDeviceType(): string
    {
        $userAgent = request()->userAgent();

        if (preg_match('/mobile|android|iphone|ipod|blackberry|iemobile|opera mini/i', $userAgent)) {
            return 'mobile';
        }

        if (preg_match('/tablet|ipad/i', $userAgent)) {
            return 'tablet';
        }

        return 'desktop';
    }

    public function hasClick(): bool
    {
        return !is_null($this->clicked_restaurant_id);
    }

    public function getClickThroughRate(): float
    {
        if ($this->results_count === 0) {
            return 0;
        }

        return $this->hasClick() ? 100 : 0;
    }
}

