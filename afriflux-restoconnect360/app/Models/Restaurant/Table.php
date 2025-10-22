<?php

namespace App\Models\Restaurant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Table extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'restaurant_id',
        'zone_id',
        'name',
        'number',
        'capacity',
        'shape',
        'qr_code',
        'status',
        'position_x',
        'position_y',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Relations
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function currentOrder()
    {
        return $this->hasOne(Order::class)
            ->whereIn('status', ['pending', 'confirmed', 'preparing'])
            ->latest();
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeOccupied($query)
    {
        return $query->where('status', 'occupied');
    }

    /**
     * Helper methods
     */
    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    public function markAsOccupied(): void
    {
        $this->update(['status' => 'occupied']);
    }

    public function markAsAvailable(): void
    {
        $this->update(['status' => 'available']);
    }

    public function generateQRCode(): string
    {
        $url = route('menu.qr', [
            'restaurant' => $this->restaurant->slug,
            'table' => $this->id,
        ]);

        // In a real implementation, use a QR code library
        return $url;
    }
}

