<?php

namespace App\Models\Payment;

use App\Models\Restaurant\Restaurant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethod extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'restaurant_id',
        'name',
        'slug',
        'type',
        'provider',
        'description',
        'logo',
        'configuration',
        'is_active',
        'is_default',
        'transaction_fee_percentage',
        'transaction_fee_fixed',
        'display_order',
        'supported_currencies',
        'supported_countries',
    ];

    protected $casts = [
        'configuration' => 'encrypted:array',
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'transaction_fee_percentage' => 'decimal:2',
        'transaction_fee_fixed' => 'decimal:2',
        'supported_currencies' => 'array',
        'supported_countries' => 'array',
    ];

    /**
     * Relations
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Helper methods
     */
    public function calculateFee(float $amount): float
    {
        $percentageFee = ($amount * $this->transaction_fee_percentage) / 100;
        return $percentageFee + $this->transaction_fee_fixed;
    }

    public function supportsCurrency(string $currency): bool
    {
        if (!$this->supported_currencies) {
            return true; // If not specified, assume all currencies are supported
        }

        return in_array(strtoupper($currency), array_map('strtoupper', $this->supported_currencies));
    }

    public function supportsCountry(string $country): bool
    {
        if (!$this->supported_countries) {
            return true; // If not specified, assume all countries are supported
        }

        return in_array(strtoupper($country), array_map('strtoupper', $this->supported_countries));
    }
}

