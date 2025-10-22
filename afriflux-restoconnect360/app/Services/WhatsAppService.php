<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    private string $token;
    private string $phoneNumberId;
    private string $baseUrl = 'https://graph.facebook.com/v17.0';

    public function __construct()
    {
        $this->token = config('services.whatsapp.token');
        $this->phoneNumberId = config('services.whatsapp.phone_number_id');
    }

    /**
     * Send a text message
     */
    public function sendMessage(string $to, string $message): bool
    {
        try {
            $response = Http::withToken($this->token)
                ->post("{$this->baseUrl}/{$this->phoneNumberId}/messages", [
                    'messaging_product' => 'whatsapp',
                    'to' => $this->formatPhoneNumber($to),
                    'type' => 'text',
                    'text' => [
                        'body' => $message,
                    ],
                ]);

            if ($response->successful()) {
                Log::info('WhatsApp message sent successfully', [
                    'to' => $to,
                    'response' => $response->json(),
                ]);
                return true;
            }

            Log::error('WhatsApp message failed', [
                'to' => $to,
                'response' => $response->json(),
            ]);

            return false;
        } catch (Exception $e) {
            Log::error('WhatsApp send message error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send menu as template
     */
    public function sendMenu(string $to, array $menuData): bool
    {
        try {
            $message = "🍽️ *Notre Menu*\n\n";

            foreach ($menuData as $category => $products) {
                $message .= "*{$category}*\n";
                foreach ($products as $product) {
                    $message .= "• {$product['name']} - {$product['price']} FCFA\n";
                    if (!empty($product['description'])) {
                        $message .= "  _{$product['description']}_\n";
                    }
                }
                $message .= "\n";
            }

            $message .= "Pour commander, répondez avec le numéro de votre choix.";

            return $this->sendMessage($to, $message);
        } catch (Exception $e) {
            Log::error('WhatsApp send menu error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send order confirmation
     */
    public function sendOrderConfirmation(string $to, array $orderData): bool
    {
        $message = "✅ *Commande Confirmée*\n\n";
        $message .= "📋 Numéro: {$orderData['order_number']}\n";
        $message .= "💰 Total: {$orderData['total']} FCFA\n";
        $message .= "📍 Adresse: {$orderData['address']}\n";
        $message .= "⏱️ Temps estimé: {$orderData['estimated_time']} min\n\n";
        $message .= "Merci pour votre commande! 🙏";

        return $this->sendMessage($to, $message);
    }

    /**
     * Send order status update
     */
    public function sendOrderStatusUpdate(string $to, string $status, string $orderNumber): bool
    {
        $statusMessages = [
            'confirmed' => "✅ Votre commande #{$orderNumber} a été confirmée!",
            'preparing' => "👨‍🍳 Votre commande #{$orderNumber} est en préparation...",
            'ready' => "✅ Votre commande #{$orderNumber} est prête!",
            'on_delivery' => "🚗 Votre commande #{$orderNumber} est en cours de livraison!",
            'delivered' => "✅ Votre commande #{$orderNumber} a été livrée! Merci! 🙏",
            'cancelled' => "❌ Votre commande #{$orderNumber} a été annulée.",
        ];

        $message = $statusMessages[$status] ?? "Mise à jour de votre commande #{$orderNumber}";

        return $this->sendMessage($to, $message);
    }

    /**
     * Send delivery tracking link
     */
    public function sendTrackingLink(string $to, string $trackingUrl): bool
    {
        $message = "📍 Suivez votre livraison en temps réel:\n{$trackingUrl}";
        return $this->sendMessage($to, $message);
    }

    /**
     * Format phone number for WhatsApp API
     */
    private function formatPhoneNumber(string $phone): string
    {
        // Remove all non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // Add country code if not present (default to Senegal +221)
        if (strlen($phone) === 9) {
            $phone = '221' . $phone;
        }

        return $phone;
    }

    /**
     * Verify webhook
     */
    public function verifyWebhook(string $mode, string $token, string $challenge): ?string
    {
        $verifyToken = config('services.whatsapp.verify_token');

        if ($mode === 'subscribe' && $token === $verifyToken) {
            return $challenge;
        }

        return null;
    }

    /**
     * Handle incoming message
     */
    public function handleIncomingMessage(array $data): bool
    {
        try {
            if (!isset($data['entry'][0]['changes'][0]['value']['messages'][0])) {
                return false;
            }

            $message = $data['entry'][0]['changes'][0]['value']['messages'][0];
            $from = $message['from'];
            $text = $message['text']['body'] ?? '';

            Log::info('WhatsApp incoming message', [
                'from' => $from,
                'message' => $text,
            ]);

            // Here you would process the message and create an order
            // For now, just send an acknowledgment
            $this->sendMessage($from, "Merci pour votre message! Notre équipe va vous répondre rapidement. 🙏");

            return true;
        } catch (Exception $e) {
            Log::error('WhatsApp handle message error: ' . $e->getMessage());
            return false;
        }
    }
}

