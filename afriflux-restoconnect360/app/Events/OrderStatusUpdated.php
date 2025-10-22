<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    public $oldStatus;
    public $newStatus;

    /**
     * Create a new event instance.
     *
     * @param Order $order
     * @param string $oldStatus
     * @param string $newStatus
     */
    public function __construct(Order $order, string $oldStatus, string $newStatus)
    {
        $this->order = $order;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('commerce.' . $this->order->commerce_id),
            new PrivateChannel('order.' . $this->order->id),
            new PrivateChannel('user.' . $this->order->customer_id),
        ];
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'order.status.updated';
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        $messages = [
            'preparing' => 'Votre commande est en préparation',
            'ready' => 'Votre commande est prête !',
            'delivering' => 'Votre commande est en livraison',
            'delivered' => 'Commande livrée avec succès',
            'cancelled' => 'Commande annulée',
        ];

        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'message' => $messages[$this->newStatus] ?? 'Statut mis à jour',
            'updated_at' => now()->toISOString(),
        ];
    }
}
