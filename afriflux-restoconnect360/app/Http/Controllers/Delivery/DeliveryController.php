<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Models\Delivery\Delivery;
use App\Models\Delivery\Driver;
use App\Services\DeliveryService;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    private DeliveryService $deliveryService;

    public function __construct(DeliveryService $deliveryService)
    {
        $this->deliveryService = $deliveryService;
    }

    /**
     * Get all deliveries
     */
    public function index(Request $request)
    {
        $query = Delivery::query();

        if ($request->has('status')) {
            $query->status($request->status);
        }

        if ($request->has('driver_id')) {
            $query->where('driver_id', $request->driver_id);
        }

        $deliveries = $query->with(['order', 'driver', 'restaurant'])
            ->latest()
            ->paginate(20);

        return response()->json([
            'success' => true,
            'deliveries' => $deliveries,
        ]);
    }

    /**
     * Get single delivery
     */
    public function show(Delivery $delivery)
    {
        return response()->json([
            'success' => true,
            'delivery' => $delivery->load(['order.items', 'driver.user', 'trackingHistory']),
        ]);
    }

    /**
     * Assign driver
     */
    public function assignDriver(Request $request, Delivery $delivery)
    {
        $request->validate([
            'driver_id' => 'required|exists:drivers,id',
        ]);

        $driver = Driver::find($request->driver_id);

        $success = $this->deliveryService->assignDriver($delivery, $driver);

        if (!$success) {
            return response()->json([
                'success' => false,
                'message' => 'Impossible d\'assigner ce livreur.',
            ], 400);
        }

        return response()->json([
            'success' => true,
            'delivery' => $delivery->load('driver'),
        ]);
    }

    /**
     * Update delivery status
     */
    public function updateStatus(Request $request, Delivery $delivery)
    {
        $request->validate([
            'status' => 'required|in:assigned,picked_up,on_delivery,delivered,cancelled',
        ]);

        switch ($request->status) {
            case 'picked_up':
                $delivery->markAsPickedUp();
                break;
            case 'on_delivery':
                $delivery->markAsOnDelivery();
                break;
            case 'delivered':
                $delivery->markAsDelivered();
                break;
            case 'cancelled':
                $delivery->cancel($request->reason);
                break;
        }

        return response()->json([
            'success' => true,
            'delivery' => $delivery,
        ]);
    }

    /**
     * Track delivery
     */
    public function track(Delivery $delivery)
    {
        $tracking = $delivery->trackingHistory()
            ->orderBy('recorded_at', 'desc')
            ->limit(50)
            ->get();

        return response()->json([
            'success' => true,
            'delivery' => $delivery->load('driver', 'order'),
            'tracking' => $tracking,
        ]);
    }
}

