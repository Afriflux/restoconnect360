<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Restaurant\Restaurant;
use App\Services\GeolocationService;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    private GeolocationService $geolocationService;

    public function __construct(GeolocationService $geolocationService)
    {
        $this->geolocationService = $geolocationService;
    }

    /**
     * Get all restaurants
     */
    public function index(Request $request)
    {
        $query = Restaurant::query()->active();

        // Filters
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        if ($request->has('cuisine_type')) {
            $query->where('cuisine_type', $request->cuisine_type);
        }

        if ($request->boolean('featured')) {
            $query->featured();
        }

        $restaurants = $query->with('company')->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $restaurants->items(),
            'total' => $restaurants->total(),
            'per_page' => $restaurants->perPage(),
            'current_page' => $restaurants->currentPage(),
            'last_page' => $restaurants->lastPage(),
        ]);
    }

    /**
     * Search nearby restaurants
     */
    public function nearby(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'nullable|numeric|min:1|max:50',
        ]);

        $result = $this->geolocationService->findNearbyRestaurants(
            $request->latitude,
            $request->longitude,
            $request->radius ?? 10,
            $request->only(['category', 'cuisine_type', 'accepts_delivery'])
        );

        return response()->json($result);
    }

    /**
     * Get single restaurant
     */
    public function show(Restaurant $restaurant)
    {
        return response()->json([
            'success' => true,
            'data' => $restaurant->load(['menus', 'categories', 'zones']),
        ]);
    }

    /**
     * Create restaurant
     */
    public function store(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:restaurants',
            'address' => 'required|string',
            'city' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'category' => 'required|in:restaurant,cafe,bar,fast_food',
        ]);

        $restaurant = Restaurant::create($request->all());

        return response()->json([
            'success' => true,
            'restaurant' => $restaurant,
        ], 201);
    }

    /**
     * Update restaurant
     */
    public function update(Request $request, Restaurant $restaurant)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'address' => 'sometimes|string',
            'phone' => 'sometimes|string',
        ]);

        $restaurant->update($request->all());

        return response()->json([
            'success' => true,
            'restaurant' => $restaurant,
        ]);
    }

    /**
     * Delete restaurant
     */
    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();

        return response()->json([
            'success' => true,
            'message' => 'Restaurant supprimé avec succès.',
        ]);
    }

    /**
     * Get restaurant menu
     */
    public function menu(Restaurant $restaurant)
    {
        $menus = $restaurant->menus()
            ->active()
            ->with(['categories.products' => function ($query) {
                $query->active()->orderBy('display_order');
            }])
            ->get();

        return response()->json([
            'success' => true,
            'menus' => $menus,
        ]);
    }
}

