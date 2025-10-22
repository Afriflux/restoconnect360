<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Models\Delivery\Driver;
use App\Services\DeliveryService;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    private DeliveryService $deliveryService;

    public function __construct(DeliveryService $deliveryService)
    {
        $this->deliveryService = $deliveryService;
    }

    /**
     * Get all drivers
     */
    public function index(Request $request)
    {
        $query = Driver::query();

        if ($request->boolean('online')) {
            $query->online();
        }

        if ($request->boolean('available')) {
            $query->available();
        }

        if ($request->boolean('verified')) {
            $query->verified();
        }

        $drivers = $query->with('user')->paginate(20);

        return response()->json([
            'success' => true,
            'drivers' => $drivers,
        ]);
    }

    /**
     * Get driver details
     */
    public function show(Driver $driver)
    {
        return response()->json([
            'success' => true,
            'driver' => $driver->load(['user', 'currentDelivery']),
            'stats' => $this->deliveryService->getDeliveryStats($driver->id, 'month'),
        ]);
    }

    /**
     * Update driver location
     */
    public function updateLocation(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $driver = $request->user()->driver;

        if (!$driver) {
            return response()->json([
                'success' => false,
                'message' => 'Vous n\'êtes pas un livreur.',
            ], 403);
        }

        $this->deliveryService->updateDriverLocation(
            $driver,
            $request->latitude,
            $request->longitude
        );

        return response()->json([
            'success' => true,
            'message' => 'Position mise à jour.',
        ]);
    }

    /**
     * Update driver status
     */
    public function updateStatus(Request $request)
    {
        $request->validate([
            'status' => 'required|in:online,offline,on_break',
        ]);

        $driver = $request->user()->driver;

        match ($request->status) {
            'online' => $driver->goOnline(),
            'offline' => $driver->goOffline(),
            'on_break' => $driver->takeBreak(),
        };

        return response()->json([
            'success' => true,
            'driver' => $driver,
        ]);
    }

    /**
     * Get driver deliveries
     */
    public function deliveries(Request $request)
    {
        $driver = $request->user()->driver;

        $deliveries = $driver->deliveries()
            ->with(['order', 'restaurant'])
            ->latest()
            ->paginate(20);

        return response()->json([
            'success' => true,
            'deliveries' => $deliveries,
        ]);
    }

    /**
     * Get driver stats
     */
    public function stats(Request $request)
    {
        $driver = $request->user()->driver;
        $period = $request->get('period', 'today');

        $stats = $this->deliveryService->getDeliveryStats($driver->id, $period);

        return response()->json([
            'success' => true,
            'stats' => $stats,
        ]);
    }
}

