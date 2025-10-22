<?php

namespace App\Services;

use App\Models\Payment\Payment;
use App\Models\Restaurant\Order;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PayTechService
{
    private string $apiKey;
    private string $merchantId;
    private string $baseUrl;
    private bool $isSandbox;

    public function __construct()
    {
        $this->apiKey = config('services.paytech.api_key');
        $this->merchantId = config('services.paytech.merchant_id');
        $this->isSandbox = config('services.paytech.environment') === 'sandbox';
        $this->baseUrl = $this->isSandbox
            ? 'https://paytech.sn/api/payment/request'
            : 'https://paytech.sn/api/payment/request';
    }

    /**
     * Initialize a payment
     */
    public function initializePayment(Order $order, array $customerData): array
    {
        try {
            $payment = Payment::create([
                'order_id' => $order->id,
                'user_id' => $order->user_id,
                'payment_method' => 'paytech',
                'amount' => $order->total,
                'currency' => 'XOF',
                'status' => 'pending',
            ]);

            $requestData = [
                'item_name' => "Commande #{$order->order_number}",
                'item_price' => (int) $order->total,
                'currency' => 'XOF',
                'ref_command' => $payment->payment_number,
                'command_name' => "Commande RestoConnect360 #{$order->order_number}",
                'env' => $this->isSandbox ? 'test' : 'prod',
                'ipn_url' => config('services.paytech.notify_url'),
                'success_url' => config('services.paytech.success_url'),
                'cancel_url' => config('services.paytech.cancel_url'),
                'custom_field' => json_encode([
                    'order_id' => $order->id,
                    'restaurant_id' => $order->restaurant_id,
                    'customer_name' => $customerData['name'] ?? $order->customer_name,
                    'customer_phone' => $customerData['phone'] ?? $order->customer_phone,
                ]),
            ];

            $response = Http::withHeaders([
                'API_KEY' => $this->apiKey,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl, $requestData);

            $result = $response->json();

            if ($response->successful() && isset($result['success']) && $result['success']) {
                $payment->update([
                    'payment_url' => $result['redirect_url'] ?? null,
                    'reference' => $result['token'] ?? null,
                    'metadata' => $result,
                ]);

                return [
                    'success' => true,
                    'payment_url' => $result['redirect_url'],
                    'payment' => $payment,
                ];
            }

            $payment->markAsFailed($result['message'] ?? 'Payment initialization failed');

            return [
                'success' => false,
                'message' => $result['message'] ?? 'Payment initialization failed',
            ];
        } catch (Exception $e) {
            Log::error('PayTech initialization error: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Payment initialization failed: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Handle IPN (Instant Payment Notification)
     */
    public function handleIPN(array $data): bool
    {
        try {
            if (!isset($data['type_event']) || !isset($data['ref_command'])) {
                Log::error('PayTech IPN: Invalid data', $data);
                return false;
            }

            $payment = Payment::where('payment_number', $data['ref_command'])->first();

            if (!$payment) {
                Log::error('PayTech IPN: Payment not found', $data);
                return false;
            }

            switch ($data['type_event']) {
                case 'sale_complete':
                    $payment->markAsCompleted($data['transaction_id'] ?? null);
                    break;

                case 'sale_cancelled':
                    $payment->markAsFailed('Payment cancelled by user');
                    break;

                case 'sale_failed':
                    $payment->markAsFailed($data['payment_message'] ?? 'Payment failed');
                    break;

                default:
                    Log::info("PayTech IPN: Unknown event {$data['type_event']}", $data);
            }

            return true;
        } catch (Exception $e) {
            Log::error('PayTech IPN error: ' . $e->getMessage(), $data);
            return false;
        }
    }

    /**
     * Get payment methods
     */
    public function getPaymentMethods(): array
    {
        return [
            'ORANGE_MONEY_CI' => 'Orange Money Côte d\'Ivoire',
            'MTN_MONEY_CI' => 'MTN Money Côte d\'Ivoire',
            'MOOV_MONEY_CI' => 'Moov Money Côte d\'Ivoire',
            'YAS' => 'YAS',
            'CARD' => 'Carte bancaire',
        ];
    }
}

