<?php

namespace App\Models\Restaurant;

use App\Models\Delivery\Delivery;
use App\Models\Geolocation\Location;
use App\Models\Platform\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Restaurant extends Model
{
    use HasFactory, SoftDeletes;

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
        'latitude',
        'longitude',
        'logo',
        'cover_image',
        'cuisine_type',
        'category',
        'opening_hours',
        'delivery_fee',
        'min_order_amount',
        'delivery_radius_km',
        'accepts_delivery',
        'accepts_takeaway',
        'accepts_dine_in',
        'has_pos',
        'has_kiosk',
        'has_qr_menu',
        'has_whatsapp',
        'whatsapp_number',
        'theme',
        'is_active',
        'is_featured',
        'rating',
        'total_reviews',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'opening_hours' => 'array',
        'delivery_fee' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'delivery_radius_km' => 'decimal:2',
        'accepts_delivery' => 'boolean',
        'accepts_takeaway' => 'boolean',
        'accepts_dine_in' => 'boolean',
        'has_pos' => 'boolean',
        'has_kiosk' => 'boolean',
        'has_qr_menu' => 'boolean',
        'has_whatsapp' => 'boolean',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'rating' => 'decimal:2',
    ];

    /**
     * Relations
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function zones()
    {
        return $this->hasMany(Zone::class);
    }

    public function tables()
    {
        return $this->hasMany(Table::class);
    }

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }

    public function locations()
    {
        return $this->morphMany(Location::class, 'locatable');
    }

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

    public function scopeNearby($query, $latitude, $longitude, $radius = 10)
    {
        return $query->selectRaw("
            *,
            (
                6371 * acos(
                    cos(radians(?)) *
                    cos(radians(latitude)) *
                    cos(radians(longitude) - radians(?)) +
                    sin(radians(?)) *
                    sin(radians(latitude))
                )
            ) AS distance
        ", [$latitude, $longitude, $latitude])
            ->having('distance', '<', $radius)
            ->orderBy('distance');
    }

    /**
     * Helper methods
     */
    public function isOpen(): bool
    {
        if (!$this->opening_hours) {
            return true;
        }

        $now = now($this->timezone ?? 'Africa/Dakar');
        $dayOfWeek = $now->dayOfWeek; // 0 = Sunday, 6 = Saturday
        $currentTime = $now->format('H:i');

        $todayHours = $this->opening_hours[$dayOfWeek] ?? null;

        if (!$todayHours || !isset($todayHours['open']) || !isset($todayHours['close'])) {
            return false;
        }

        return $currentTime >= $todayHours['open'] && $currentTime <= $todayHours['close'];
    }

    public function acceptsOrderType(string $type): bool
    {
        return match ($type) {
            'delivery' => $this->accepts_delivery,
            'takeaway' => $this->accepts_takeaway,
            'dine_in' => $this->accepts_dine_in,
            default => false,
        };
    }
}

