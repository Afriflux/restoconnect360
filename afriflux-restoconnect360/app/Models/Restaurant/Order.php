<?php

namespace App\Models\Restaurant;

use App\Models\Delivery\Delivery;
use App\Models\Payment\Payment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_number',
        'restaurant_id',
        'user_id',
        'table_id',
        'order_type',
        'customer_name',
        'customer_phone',
        'customer_email',
        'delivery_address',
        'delivery_latitude',
        'delivery_longitude',
        'subtotal',
        'delivery_fee',
        'tax_amount',
        'discount_amount',
        'service_fee',
        'total',
        'coupon_code',
        'payment_method',
        'payment_status',
        'status',
        'customer_notes',
        'kitchen_notes',
        'cancellation_reason',
        'confirmed_at',
        'preparing_at',
        'ready_at',
        'delivered_at',
        'completed_at',
        'cancelled_at',
        'preparation_time',
        'is_scheduled',
        'scheduled_for',
    ];

    protected $casts = [
        'delivery_latitude' => 'decimal:8',
        'delivery_longitude' => 'decimal:8',
        'subtotal' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'service_fee' => 'decimal:2',
        'total' => 'decimal:2',
        'confirmed_at' => 'datetime',
        'preparing_at' => 'datetime',
        'ready_at' => 'datetime',
        'delivered_at' => 'datetime',
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'is_scheduled' => 'boolean',
        'scheduled_for' => 'datetime',
    ];

    /**
     * Relations
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function delivery()
    {
        return $this->hasOne(Delivery::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Scopes
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopePreparing($query)
    {
        return $query->where('status', 'preparing');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeDelivery($query)
    {
        return $query->where('order_type', 'delivery');
    }

    public function scopeTakeaway($query)
    {
        return $query->where('order_type', 'takeaway');
    }

    public function scopeDineIn($query)
    {
        return $query->where('order_type', 'dine_in');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    /**
     * Helper methods
     */
    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'confirmed']);
    }

    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    public function isDelivery(): bool
    {
        return $this->order_type === 'delivery';
    }

    public function calculateTotals(): void
    {
        $this->subtotal = $this->items->sum(fn ($item) => $item->total_price);
        
        // Calculate tax (18% in Senegal)
        $this->tax_amount = $this->subtotal * 0.18;
        
        // Calculate total
        $this->total = $this->subtotal + $this->tax_amount + $this->delivery_fee + $this->service_fee - $this->discount_amount;
        
        $this->save();
    }

    public function markAsConfirmed(): void
    {
        $this->update([
            'status' => 'confirmed',
            'confirmed_at' => now(),
        ]);
    }

    public function markAsPreparing(): void
    {
        $this->update([
            'status' => 'preparing',
            'preparing_at' => now(),
        ]);
    }

    public function markAsReady(): void
    {
        $this->update([
            'status' => 'ready',
            'ready_at' => now(),
        ]);
    }

    public function markAsCompleted(): void
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }

    public function markAsCancelled(string $reason = null): void
    {
        $this->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'cancellation_reason' => $reason,
        ]);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (!$order->order_number) {
                $order->order_number = 'ORD-' . strtoupper(uniqid());
            }
        });
    }
}

