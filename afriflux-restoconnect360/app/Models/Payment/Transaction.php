<?php

namespace App\Models\Payment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'transaction_type',
        'amount',
        'currency',
        'status',
        'provider_transaction_id',
        'request_data',
        'response_data',
        'description',
        'processed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'request_data' => 'array',
        'response_data' => 'array',
        'processed_at' => 'datetime',
    ];

    /**
     * Relations
     */
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    /**
     * Scopes
     */
    public function scopeType($query, $type)
    {
        return $query->where('transaction_type', $type);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    /**
     * Helper methods
     */
    public static function log(
        int $paymentId,
        string $type,
        float $amount,
        string $currency,
        string $status,
        ?array $requestData = null,
        ?array $responseData = null,
        ?string $description = null
    ): self {
        return self::create([
            'payment_id' => $paymentId,
            'transaction_type' => $type,
            'amount' => $amount,
            'currency' => $currency,
            'status' => $status,
            'request_data' => $requestData,
            'response_data' => $responseData,
            'description' => $description,
            'processed_at' => now(),
        ]);
    }
}

