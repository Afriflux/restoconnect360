<?php

namespace App\Services;

use App\Models\Payment\Payment;
use App\Models\Restaurant\Order;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CinetPayService
{
    private string $apiKey;
    private string $siteId;
    private string $baseUrl;
    private bool $isSandbox;

    public function __construct()
    {
        $this->apiKey = config('services.cinetpay.api_key');
        $this->siteId = config('services.cinetpay.site_id');
        $this->isSandbox = config('services.cinetpay.environment') === 'sandbox';
        $this->baseUrl = $this->isSandbox
            ? 'https://api-checkout.cinetpay.com/v2'
            : 'https://api-checkout.cinetpay.com/v2';
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
                'payment_method' => 'cinetpay',
                'amount' => $order->total,
                'currency' => 'XOF',
                'status' => 'pending',
            ]);

            $response = Http::post("{$this->baseUrl}/payment", [
                'apikey' => $this->apiKey,
                'site_id' => $this->siteId,
                'transaction_id' => $payment->payment_number,
                'amount' => (int) $order->total,
                'currency' => 'XOF',
                'description' => "Commande #{$order->order_number}",
                'customer_name' => $customerData['name'] ?? $order->customer_name,
                'customer_surname' => $customerData['surname'] ?? '',
                'customer_email' => $customerData['email'] ?? $order->customer_email,
                'customer_phone_number' => $customerData['phone'] ?? $order->customer_phone,
                'customer_address' => $customerData['address'] ?? $order->delivery_address,
                'customer_city' => $customerData['city'] ?? 'Dakar',
                'customer_country' => $customerData['country'] ?? 'SN',
                'customer_state' => $customerData['state'] ?? 'Dakar',
                'customer_zip_code' => $customerData['zip_code'] ?? '00000',
                'notify_url' => config('services.cinetpay.notify_url'),
                'return_url' => config('services.cinetpay.return_url'),
                'channels' => 'ALL',
                'metadata' => json_encode([
                    'order_id' => $order->id,
                    'restaurant_id' => $order->restaurant_id,
                ]),
            ]);

            $result = $response->json();

            if ($response->successful() && isset($result['data']['payment_url'])) {
                $payment->update([
                    'payment_url' => $result['data']['payment_url'],
                    'reference' => $result['data']['payment_token'] ?? null,
                    'metadata' => $result,
                ]);

                return [
                    'success' => true,
                    'payment_url' => $result['data']['payment_url'],
                    'payment' => $payment,
                ];
            }

            $payment->markAsFailed($result['message'] ?? 'Payment initialization failed');

            return [
                'success' => false,
                'message' => $result['message'] ?? 'Payment initialization failed',
            ];
        } catch (Exception $e) {
            Log::error('CinetPay initialization error: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Payment initialization failed: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Check payment status
     */
    public function checkPaymentStatus(string $transactionId): array
    {
        try {
            $response = Http::post("{$this->baseUrl}/payment/check", [
                'apikey' => $this->apiKey,
                'site_id' => $this->siteId,
                'transaction_id' => $transactionId,
            ]);

            $result = $response->json();

            if ($response->successful()) {
                return [
                    'success' => true,
                    'status' => $result['data']['status'] ?? 'unknown',
                    'data' => $result['data'] ?? [],
                ];
            }

            return [
                'success' => false,
                'message' => $result['message'] ?? 'Status check failed',
            ];
        } catch (Exception $e) {
            Log::error('CinetPay status check error: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Status check failed: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Handle webhook notification
     */
    public function handleWebhook(array $data): bool
    {
        try {
            if (!isset($data['cpm_trans_id']) || !isset($data['cpm_trans_status'])) {
                Log::error('CinetPay webhook: Invalid data', $data);
                return false;
            }

            $payment = Payment::where('payment_number', $data['cpm_trans_id'])->first();

            if (!$payment) {
                Log::error('CinetPay webhook: Payment not found', $data);
                return false;
            }

            // Verify the payment status with CinetPay API
            $statusCheck = $this->checkPaymentStatus($data['cpm_trans_id']);

            if (!$statusCheck['success']) {
                return false;
            }

            $status = $statusCheck['data']['status'] ?? 'unknown';

            switch ($status) {
                case 'ACCEPTED':
                case 'SUCCESS':
                    $payment->markAsCompleted($data['cpm_payment_id'] ?? null);
                    break;

                case 'REFUSED':
                case 'FAILED':
                    $payment->markAsFailed($data['cpm_error_message'] ?? 'Payment failed');
                    break;

                default:
                    Log::info("CinetPay webhook: Unknown status {$status}", $data);
            }

            return true;
        } catch (Exception $e) {
            Log::error('CinetPay webhook error: ' . $e->getMessage(), $data);
            return false;
        }
    }

    /**
     * Get payment methods
     */
    public function getPaymentMethods(): array
    {
        return [
            'WAVE' => 'Wave',
            'ORANGE_MONEY_SN' => 'Orange Money Sénégal',
            'FREE_MONEY' => 'Free Money',
            'E_MONEY' => 'E-Money',
            'YUP' => 'Yup',
            'WIZALL' => 'Wizall',
            'CARD' => 'Carte bancaire',
        ];
    }

    /**
     * Refund a payment
     */
    public function refundPayment(Payment $payment, float $amount): array
    {
        try {
            $response = Http::post("{$this->baseUrl}/payment/refund", [
                'apikey' => $this->apiKey,
                'site_id' => $this->siteId,
                'transaction_id' => $payment->payment_number,
                'amount' => (int) $amount,
                'description' => "Remboursement de la commande #{$payment->order->order_number}",
            ]);

            $result = $response->json();

            if ($response->successful() && ($result['code'] ?? '') === '00') {
                return [
                    'success' => true,
                    'data' => $result['data'] ?? [],
                ];
            }

            return [
                'success' => false,
                'message' => $result['message'] ?? 'Refund failed',
            ];
        } catch (Exception $e) {
            Log::error('CinetPay refund error: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Refund failed: ' . $e->getMessage(),
            ];
        }
    }
}

