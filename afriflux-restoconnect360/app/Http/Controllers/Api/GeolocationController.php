<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\GeolocationService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class GeolocationController extends Controller
{
    protected GeolocationService $geolocationService;

    public function __construct(GeolocationService $geolocationService)
    {
        $this->geolocationService = $geolocationService;
    }

    /**
     * Get user's current location and create session.
     */
    public function getCurrentLocation(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'accuracy' => 'nullable|numeric|min:0',
            'altitude' => 'nullable|numeric',
            'speed' => 'nullable|numeric|min:0',
            'device_type' => 'nullable|string|in:mobile,tablet,desktop,pos,kiosk,tpe',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid location data',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $locationData = array_merge($request->all(), [
                'user_agent' => $request->userAgent(),
                'metadata' => [
                    'ip' => $request->ip(),
                    'timestamp' => now()->toISOString(),
                ]
            ]);

            $session = $this->geolocationService->getCurrentLocation($locationData);

            return response()->json([
                'success' => true,
                'message' => 'Location captured successfully',
                'data' => [
                    'session_id' => $session->session_id,
                    'location' => [
                        'latitude' => $session->latitude,
                        'longitude' => $session->longitude,
                        'accuracy' => $session->accuracy,
                        'address' => $session->address,
                        'city' => $session->city,
                        'country' => $session->country,
                    ],
                    'expires_at' => $session->expires_at,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to capture location',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Find restaurants near a location.
     */
    public function findNearbyRestaurants(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'radius' => 'nullable|integer|min:1|max:50',
            'cuisine_type' => 'nullable|string',
            'restaurant_type' => 'nullable|string|in:restaurant,cafe,bar,fast_food,bakery',
            'price_range' => 'nullable|string|in:$,$$,$$$,$$$$',
            'accepts_delivery' => 'nullable|boolean',
            'accepts_pickup' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid search parameters',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $latitude = $request->latitude;
            $longitude = $request->longitude;
            $radius = $request->radius ?? 10;

            $filters = $request->only([
                'cuisine_type',
                'restaurant_type',
                'price_range',
                'accepts_delivery',
                'accepts_pickup'
            ]);

            $restaurants = $this->geolocationService->findRestaurantsNearLocation(
                $latitude,
                $longitude,
                $radius,
                array_filter($filters)
            );

            return response()->json([
                'success' => true,
                'message' => 'Restaurants found successfully',
                'data' => [
                    'restaurants' => $restaurants,
                    'search_params' => [
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                        'radius_km' => $radius,
                        'filters' => $filters,
                        'total_found' => $restaurants->count(),
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to find nearby restaurants',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Find companies near a location.
     */
    public function findNearbyCompanies(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'radius' => 'nullable|integer|min:1|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid search parameters',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $latitude = $request->latitude;
            $longitude = $request->longitude;
            $radius = $request->radius ?? 10;

            $companies = $this->geolocationService->findCompaniesNearLocation(
                $latitude,
                $longitude,
                $radius
            );

            return response()->json([
                'success' => true,
                'message' => 'Companies found successfully',
                'data' => [
                    'companies' => $companies,
                    'search_params' => [
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                        'radius_km' => $radius,
                        'total_found' => $companies->count(),
                    ]
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to find nearby companies',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get reverse geocoding.
     */
    public function reverseGeocode(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid coordinates',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $address = $this->geolocationService->reverseGeocode(
                $request->latitude,
                $request->longitude
            );

            return response()->json([
                'success' => true,
                'message' => 'Address found successfully',
                'data' => [
                    'coordinates' => [
                        'latitude' => $request->latitude,
                        'longitude' => $request->longitude,
                    ],
                    'address' => $address
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get address',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get location-based recommendations.
     */
    public function getRecommendations(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid coordinates',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $recommendations = $this->geolocationService->getLocationRecommendations(
                $request->latitude,
                $request->longitude,
                $request->user()?->id
            );

            return response()->json([
                'success' => true,
                'message' => 'Recommendations generated successfully',
                'data' => $recommendations
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get recommendations',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Calculate distance between two points.
     */
    public function calculateDistance(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'from_latitude' => 'required|numeric|between:-90,90',
            'from_longitude' => 'required|numeric|between:-180,180',
            'to_latitude' => 'required|numeric|between:-90,90',
            'to_longitude' => 'required|numeric|between:-180,180',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid coordinates',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $distance = $this->geolocationService->calculateDistance(
                $request->from_latitude,
                $request->from_longitude,
                $request->to_latitude,
                $request->to_longitude
            );

            return response()->json([
                'success' => true,
                'message' => 'Distance calculated successfully',
                'data' => [
                    'from' => [
                        'latitude' => $request->from_latitude,
                        'longitude' => $request->from_longitude,
                    ],
                    'to' => [
                        'latitude' => $request->to_latitude,
                        'longitude' => $request->to_longitude,
                    ],
                    'distance_km' => round($distance, 2),
                    'distance_miles' => round($distance * 0.621371, 2),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to calculate distance',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get geosensing analytics data.
     */
    public function getGeosensingData(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
            'city' => 'nullable|string',
            'country' => 'nullable|string',
            'device_type' => 'nullable|string|in:mobile,tablet,desktop,pos,kiosk,tpe',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid filter parameters',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = $this->geolocationService->getGeosensingData($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Geosensing data retrieved successfully',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get geosensing data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}