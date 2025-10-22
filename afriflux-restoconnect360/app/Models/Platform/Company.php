<?php

namespace App\Models\Platform;

use App\Models\Restaurant\Restaurant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'email',
        'phone',
        'address',
        'city',
        'country',
        'logo',
        'description',
        'website',
        'tax_number',
        'business_type',
        'is_active',
        'verified_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'verified_at' => 'datetime',
    ];

    /**
     * Relations
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function restaurants()
    {
        return $this->hasMany(Restaurant::class);
    }

    public function subscription()
    {
        return $this->hasOne(Subscription::class)->latestOfMany();
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeVerified($query)
    {
        return $query->whereNotNull('verified_at');
    }

    /**
     * Accessors & Mutators
     */
    public function getActiveSubscriptionAttribute()
    {
        return $this->subscriptions()->where('status', 'active')->first();
    }

    public function hasActiveSubscription(): bool
    {
        return $this->activeSubscription !== null;
    }
}

