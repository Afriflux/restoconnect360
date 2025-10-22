<?php

namespace App\Services;

use App\Models\Geolocation\GeoZone;
use App\Models\Geolocation\Location;
use App\Models\Geolocation\SearchHistory;
use App\Models\Restaurant\Restaurant;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeolocationService
{
    private string $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.google_maps.api_key');
    }

    /**
     * Find nearby restaurants
     */
    public function findNearbyRestaurants(
        float $latitude,
        float $longitude,
        float $radius = 10,
        array $filters = []
    ): array {
        try {
            $query = Restaurant::query()
                ->active()
                ->selectRaw("
                    *,
                    (
                        6371 * acos(
                            cos(radians(?)) *
                            cos(radians(latitude)) *
                            cos(radians(longitude) - radians(?)) +
                            sin(radians(?)) *
                            sin(radians(latitude))
                        )
                    ) AS distance
                ", [$latitude, $longitude, $latitude])
                ->having('distance', '<', $radius)
                ->orderBy('distance');

            // Apply filters
            if (!empty($filters['category'])) {
                $query->where('category', $filters['category']);
            }

            if (!empty($filters['cuisine_type'])) {
                $query->where('cuisine_type', $filters['cuisine_type']);
            }

            if (!empty($filters['accepts_delivery'])) {
                $query->where('accepts_delivery', true);
            }

            if (!empty($filters['is_featured'])) {
                $query->where('is_featured', true);
            }

            $restaurants = $query->get();

            // Record search history
            SearchHistory::record(
                auth()->id(),
                session()->getId(),
                $filters['search_query'] ?? null,
                $latitude,
                $longitude,
                $radius,
                $filters,
                $restaurants->count(),
                $restaurants->pluck('id')->toArray()
            );

            return [
                'success' => true,
                'restaurants' => $restaurants,
                'count' => $restaurants->count(),
            ];
        } catch (Exception $e) {
            Log::error('Geolocation find nearby error: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Failed to find nearby restaurants',
            ];
        }
    }

    /**
     * Get address from coordinates (Reverse Geocoding)
     */
    public function getAddressFromCoordinates(float $latitude, float $longitude): ?array
    {
        try {
            $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
                'latlng' => "{$latitude},{$longitude}",
                'key' => $this->apiKey,
            ]);

            $result = $response->json();

            if ($response->successful() && isset($result['results'][0])) {
                $address = $result['results'][0];

                return [
                    'formatted_address' => $address['formatted_address'],
                    'components' => $this->parseAddressComponents($address['address_components'] ?? []),
                    'place_id' => $address['place_id'] ?? null,
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                ];
            }

            return null;
        } catch (Exception $e) {
            Log::error('Reverse geocoding error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get coordinates from address (Geocoding)
     */
    public function getCoordinatesFromAddress(string $address): ?array
    {
        try {
            $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
                'address' => $address,
                'key' => $this->apiKey,
            ]);

            $result = $response->json();

            if ($response->successful() && isset($result['results'][0])) {
                $location = $result['results'][0]['geometry']['location'];

                return [
                    'latitude' => $location['lat'],
                    'longitude' => $location['lng'],
                    'formatted_address' => $result['results'][0]['formatted_address'],
                    'place_id' => $result['results'][0]['place_id'] ?? null,
                ];
            }

            return null;
        } catch (Exception $e) {
            Log::error('Geocoding error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Calculate distance between two points
     */
    public function calculateDistance(
        float $lat1,
        float $lon1,
        float $lat2,
        float $lon2
    ): float {
        $earthRadius = 6371; // km

        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        return round($angle * $earthRadius, 2);
    }

    /**
     * Calculate route and duration
     */
    public function calculateRoute(
        float $originLat,
        float $originLon,
        float $destLat,
        float $destLon
    ): ?array {
        try {
            $response = Http::get('https://maps.googleapis.com/maps/api/directions/json', [
                'origin' => "{$originLat},{$originLon}",
                'destination' => "{$destLat},{$destLon}",
                'mode' => 'driving',
                'key' => $this->apiKey,
            ]);

            $result = $response->json();

            if ($response->successful() && isset($result['routes'][0])) {
                $route = $result['routes'][0];
                $leg = $route['legs'][0];

                return [
                    'distance' => [
                        'text' => $leg['distance']['text'],
                        'value' => $leg['distance']['value'] / 1000, // Convert to km
                    ],
                    'duration' => [
                        'text' => $leg['duration']['text'],
                        'value' => $leg['duration']['value'] / 60, // Convert to minutes
                    ],
                    'polyline' => $route['overview_polyline']['points'] ?? null,
                ];
            }

            return null;
        } catch (Exception $e) {
            Log::error('Calculate route error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Parse address components
     */
    private function parseAddressComponents(array $components): array
    {
        $parsed = [];

        $types = [
            'street_number',
            'route',
            'locality',
            'administrative_area_level_1',
            'administrative_area_level_2',
            'country',
            'postal_code',
        ];

        foreach ($components as $component) {
            foreach ($types as $type) {
                if (in_array($type, $component['types'])) {
                    $parsed[$type] = $component['long_name'];
                }
            }
        }

        return [
            'street_number' => $parsed['street_number'] ?? null,
            'street' => $parsed['route'] ?? null,
            'city' => $parsed['locality'] ?? null,
            'state' => $parsed['administrative_area_level_1'] ?? null,
            'country' => $parsed['country'] ?? null,
            'postal_code' => $parsed['postal_code'] ?? null,
        ];
    }

    /**
     * Get user's current location from IP
     */
    public function getLocationFromIP(?string $ip = null): ?array
    {
        try {
            $ip = $ip ?? request()->ip();

            // For development, use a default location (Dakar)
            if (app()->environment('local') || $ip === '127.0.0.1') {
                return [
                    'latitude' => 14.7167,
                    'longitude' => -17.4677,
                    'city' => 'Dakar',
                    'country' => 'Senegal',
                ];
            }

            $response = Http::get("http://ip-api.com/json/{$ip}");
            $result = $response->json();

            if ($response->successful() && $result['status'] === 'success') {
                return [
                    'latitude' => $result['lat'],
                    'longitude' => $result['lon'],
                    'city' => $result['city'],
                    'country' => $result['country'],
                    'country_code' => $result['countryCode'],
                ];
            }

            return null;
        } catch (Exception $e) {
            Log::error('IP geolocation error: ' . $e->getMessage());
            return null;
        }
    }
}
