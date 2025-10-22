<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'avatar',
        'company_id',
        'restaurant_id',
        'language',
        'timezone',
        'is_active',
        'last_login_at',
        'last_login_ip',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Relations
     */
    public function company()
    {
        return $this->belongsTo(Platform\Company::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant\Restaurant::class);
    }

    public function orders()
    {
        return $this->hasMany(Restaurant\Order::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment\Payment::class);
    }

    public function driver()
    {
        return $this->hasOne(Delivery\Driver::class);
    }

    public function locations()
    {
        return $this->morphMany(Geolocation\Location::class, 'locatable');
    }

    public function searchHistory()
    {
        return $this->hasMany(Geolocation\SearchHistory::class);
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * Check if user is company manager
     */
    public function isCompanyManager(): bool
    {
        return $this->hasRole('company_manager');
    }

    /**
     * Check if user is restaurant manager
     */
    public function isRestaurantManager(): bool
    {
        return $this->hasRole('restaurant_manager');
    }

    /**
     * Check if user is employee
     */
    public function isEmployee(): bool
    {
        return $this->hasRole('employee');
    }

    /**
     * Check if user is driver
     */
    public function isDriver(): bool
    {
        return $this->hasRole('driver');
    }
}
