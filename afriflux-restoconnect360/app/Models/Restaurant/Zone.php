<?php

namespace App\Models\Restaurant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Zone extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'restaurant_id',
        'name',
        'slug',
        'description',
        'color',
        'capacity',
        'table_count',
        'is_smoking_allowed',
        'is_outdoor',
        'is_vip',
        'is_active',
        'display_order',
    ];

    protected $casts = [
        'is_smoking_allowed' => 'boolean',
        'is_outdoor' => 'boolean',
        'is_vip' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Relations
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function tables()
    {
        return $this->hasMany(Table::class);
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order');
    }
}

