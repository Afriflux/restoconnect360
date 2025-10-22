<?php

namespace App\Services;

use App\Models\Delivery\Delivery;
use App\Models\Delivery\Driver;
use App\Models\Restaurant\Order;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class NotificationService
{
    private WhatsAppService $whatsappService;

    public function __construct(WhatsAppService $whatsappService)
    {
        $this->whatsappService = $whatsappService;
    }

    /**
     * Notify customer of order confirmation
     */
    public function notifyOrderConfirmed(Order $order): void
    {
        try {
            $orderData = [
                'order_number' => $order->order_number,
                'total' => number_format($order->total, 0, ',', ' '),
                'address' => $order->delivery_address ?? 'Sur place',
                'estimated_time' => $order->preparation_time,
            ];

            // Send WhatsApp notification
            if ($order->customer_phone) {
                $this->whatsappService->sendOrderConfirmation(
                    $order->customer_phone,
                    $orderData
                );
            }

            // You can also send SMS, Email, or Push notifications here
        } catch (Exception $e) {
            Log::error('Notify order confirmed error: ' . $e->getMessage());
        }
    }

    /**
     * Notify customer of order status change
     */
    public function notifyOrderStatusChanged(Order $order, string $status): void
    {
        try {
            if ($order->customer_phone) {
                $this->whatsappService->sendOrderStatusUpdate(
                    $order->customer_phone,
                    $status,
                    $order->order_number
                );
            }
        } catch (Exception $e) {
            Log::error('Notify order status changed error: ' . $e->getMessage());
        }
    }

    /**
     * Notify driver of new delivery
     */
    public function notifyDriverNewDelivery(Driver $driver, Delivery $delivery): void
    {
        try {
            $message = "🚗 Nouvelle livraison!\n\n";
            $message .= "📋 #{$delivery->delivery_number}\n";
            $message .= "📍 De: {$delivery->pickup_address}\n";
            $message .= "📍 Vers: {$delivery->delivery_address}\n";
            $message .= "💰 {$delivery->delivery_fee} FCFA\n";
            $message .= "📏 {$delivery->distance_km} km\n";

            $this->whatsappService->sendMessage(
                $driver->user->phone,
                $message
            );
        } catch (Exception $e) {
            Log::error('Notify driver new delivery error: ' . $e->getMessage());
        }
    }

    /**
     * Notify customer with delivery tracking
     */
    public function notifyDeliveryTracking(Delivery $delivery): void
    {
        try {
            $trackingUrl = route('delivery.track', ['delivery' => $delivery->delivery_number]);

            $this->whatsappService->sendTrackingLink(
                $delivery->customer_phone,
                $trackingUrl
            );
        } catch (Exception $e) {
            Log::error('Notify delivery tracking error: ' . $e->getMessage());
        }
    }

    /**
     * Notify restaurant of new order
     */
    public function notifyRestaurantNewOrder(Order $order): void
    {
        try {
            // Notify restaurant staff
            $staff = $order->restaurant->users()
                ->whereHas('roles', function ($query) {
                    $query->whereIn('name', ['restaurant_manager', 'employee']);
                })
                ->get();

            foreach ($staff as $user) {
                if ($user->phone) {
                    $message = "🔔 Nouvelle commande!\n\n";
                    $message .= "📋 #{$order->order_number}\n";
                    $message .= "💰 {$order->total} FCFA\n";
                    $message .= "🕒 {$order->created_at->format('H:i')}\n";
                    $message .= "📍 {$order->order_type}\n";

                    $this->whatsappService->sendMessage($user->phone, $message);
                }
            }
        } catch (Exception $e) {
            Log::error('Notify restaurant new order error: ' . $e->getMessage());
        }
    }

    /**
     * Send push notification
     */
    public function sendPushNotification(User $user, string $title, string $body, ?array $data = null): void
    {
        try {
            // This would integrate with Firebase Cloud Messaging or similar
            // For now, we'll just log it
            Log::info('Push notification', [
                'user_id' => $user->id,
                'title' => $title,
                'body' => $body,
                'data' => $data,
            ]);

            // TODO: Implement actual push notification
        } catch (Exception $e) {
            Log::error('Send push notification error: ' . $e->getMessage());
        }
    }

    /**
     * Send SMS notification
     */
    public function sendSMS(string $phoneNumber, string $message): bool
    {
        try {
            // Integrate with Twilio or similar SMS provider
            // For now, log it
            Log::info('SMS notification', [
                'to' => $phoneNumber,
                'message' => $message,
            ]);

            // TODO: Implement actual SMS sending
            return true;
        } catch (Exception $e) {
            Log::error('Send SMS error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send email notification
     */
    public function sendEmail(string $email, string $subject, string $content): bool
    {
        try {
            // Use Laravel's built-in mail functionality
            // For now, log it
            Log::info('Email notification', [
                'to' => $email,
                'subject' => $subject,
            ]);

            // TODO: Implement actual email sending
            return true;
        } catch (Exception $e) {
            Log::error('Send email error: ' . $e->getMessage());
            return false;
        }
    }
}

