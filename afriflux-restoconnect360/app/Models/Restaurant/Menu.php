<?php

namespace App\Models\Restaurant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'restaurant_id',
        'name',
        'slug',
        'description',
        'type',
        'availability_times',
        'availability_days',
        'is_active',
        'is_featured',
        'display_order',
    ];

    protected $casts = [
        'availability_times' => 'array',
        'availability_days' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    /**
     * Relations
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
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

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order');
    }

    /**
     * Helper methods
     */
    public function isAvailableNow(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $now = now();
        $dayOfWeek = $now->dayOfWeek;

        // Check if menu is available today
        if ($this->availability_days && !in_array($dayOfWeek, $this->availability_days)) {
            return false;
        }

        // Check if menu is available at this time
        if ($this->availability_times) {
            $currentTime = $now->format('H:i');
            return $currentTime >= $this->availability_times['start'] 
                && $currentTime <= $this->availability_times['end'];
        }

        return true;
    }
}

