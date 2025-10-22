<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Restaurant\Order;
use App\Services\DeliveryService;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    private DeliveryService $deliveryService;
    private NotificationService $notificationService;

    public function __construct(
        DeliveryService $deliveryService,
        NotificationService $notificationService
    ) {
        $this->deliveryService = $deliveryService;
        $this->notificationService = $notificationService;
    }

    /**
     * Get all orders
     */
    public function index(Request $request)
    {
        $query = Order::query();

        if ($request->has('restaurant_id')) {
            $query->where('restaurant_id', $request->restaurant_id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('order_type')) {
            $query->where('order_type', $request->order_type);
        }

        $orders = $query->with(['items.product', 'restaurant', 'delivery'])
            ->latest()
            ->paginate(20);

        return response()->json([
            'success' => true,
            'orders' => $orders,
        ]);
    }

    /**
     * Create order
     */
    public function store(Request $request)
    {
        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'order_type' => 'required|in:dine_in,takeaway,delivery',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'customer_name' => 'required|string',
            'customer_phone' => 'required|string',
            'delivery_address' => 'required_if:order_type,delivery',
            'delivery_latitude' => 'required_if:order_type,delivery',
            'delivery_longitude' => 'required_if:order_type,delivery',
        ]);

        DB::beginTransaction();
        try {
            $order = Order::create([
                'restaurant_id' => $request->restaurant_id,
                'user_id' => auth()->id(),
                'order_type' => $request->order_type,
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_email' => $request->customer_email,
                'delivery_address' => $request->delivery_address,
                'delivery_latitude' => $request->delivery_latitude,
                'delivery_longitude' => $request->delivery_longitude,
                'customer_notes' => $request->customer_notes,
                'status' => 'pending',
                'payment_status' => 'pending',
            ]);

            // Add items
            foreach ($request->items as $item) {
                $product = \App\Models\Restaurant\Product::find($item['product_id']);
                
                $order->items()->create([
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_sku' => $product->sku,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'special_instructions' => $item['special_instructions'] ?? null,
                ]);

                // Decrement stock if tracked
                $product->decrementStock($item['quantity']);
            }

            // Calculate totals
            $order->calculateTotals();

            // Create delivery if needed
            if ($order->order_type === 'delivery') {
                $this->deliveryService->createDelivery($order);
            }

            // Send notifications
            $this->notificationService->notifyRestaurantNewOrder($order);

            DB::commit();

            return response()->json([
                'success' => true,
                'order' => $order->load('items', 'delivery'),
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création de la commande: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get single order
     */
    public function show(Order $order)
    {
        return response()->json([
            'success' => true,
            'order' => $order->load(['items.product', 'restaurant', 'delivery.driver', 'payment']),
        ]);
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,preparing,ready,on_delivery,completed,cancelled',
        ]);

        switch ($request->status) {
            case 'confirmed':
                $order->markAsConfirmed();
                break;
            case 'preparing':
                $order->markAsPreparing();
                break;
            case 'ready':
                $order->markAsReady();
                break;
            case 'completed':
                $order->markAsCompleted();
                break;
            case 'cancelled':
                $order->markAsCancelled($request->cancellation_reason);
                break;
        }

        // Send notification
        $this->notificationService->notifyOrderStatusChanged($order, $request->status);

        return response()->json([
            'success' => true,
            'order' => $order,
        ]);
    }

    /**
     * Cancel order
     */
    public function cancel(Request $request, Order $order)
    {
        if (!$order->canBeCancelled()) {
            return response()->json([
                'success' => false,
                'message' => 'Cette commande ne peut pas être annulée.',
            ], 400);
        }

        $order->markAsCancelled($request->reason);

        return response()->json([
            'success' => true,
            'message' => 'Commande annulée avec succès.',
        ]);
    }
}

