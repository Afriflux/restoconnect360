<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class CacheService
{
    /**
     * Cache des restaurants avec TTL optimisé
     */
    public static function getRestaurants($forceRefresh = false)
    {
        $key = 'restaurants:list';
        
        if ($forceRefresh) {
            Cache::forget($key);
        }
        
        return Cache::remember($key, 3600, function () {
            return \App\Models\Restaurant\Restaurant::with(['company', 'menus', 'products'])
                ->where('is_active', true)
                ->orderBy('name')
                ->get();
        });
    }
    
    /**
     * Cache des menus par restaurant
     */
    public static function getRestaurantMenus($restaurantId, $forceRefresh = false)
    {
        $key = "restaurant:{$restaurantId}:menus";
        
        if ($forceRefresh) {
            Cache::forget($key);
        }
        
        return Cache::remember($key, 1800, function () use ($restaurantId) {
            return \App\Models\Restaurant\Menu::with(['products', 'categories'])
                ->where('restaurant_id', $restaurantId)
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get();
        });
    }
    
    /**
     * Cache des statistiques globales
     */
    public static function getPlatformStats($forceRefresh = false)
    {
        $key = 'platform:stats';
        
        if ($forceRefresh) {
            Cache::forget($key);
        }
        
        return Cache::remember($key, 300, function () {
            return [
                'total_restaurants' => \App\Models\Restaurant\Restaurant::count(),
                'active_restaurants' => \App\Models\Restaurant\Restaurant::where('is_active', true)->count(),
                'total_orders' => \App\Models\Restaurant\Order::count(),
                'total_users' => \App\Models\User::count(),
                'total_companies' => \App\Models\Company::count(),
                'revenue_today' => \App\Models\Payment\Payment::whereDate('created_at', today())->sum('amount'),
                'revenue_month' => \App\Models\Payment\Payment::whereMonth('created_at', now()->month)->sum('amount'),
            ];
        });
    }
    
    /**
     * Cache des zones de livraison
     */
    public static function getDeliveryZones($forceRefresh = false)
    {
        $key = 'delivery:zones';
        
        if ($forceRefresh) {
            Cache::forget($key);
        }
        
        return Cache::remember($key, 7200, function () {
            return \App\Models\Delivery\DeliveryZone::with(['restaurant'])
                ->where('is_active', true)
                ->get();
        });
    }
    
    /**
     * Cache des livreurs disponibles
     */
    public static function getAvailableDrivers($forceRefresh = false)
    {
        $key = 'drivers:available';
        
        if ($forceRefresh) {
            Cache::forget($key);
        }
        
        return Cache::remember($key, 60, function () {
            return \App\Models\Delivery\Driver::where('is_online', true)
                ->where('is_available', true)
                ->with(['currentLocation'])
                ->get();
        });
    }
    
    /**
     * Cache des paiements par méthode
     */
    public static function getPaymentMethods($forceRefresh = false)
    {
        $key = 'payment:methods';
        
        if ($forceRefresh) {
            Cache::forget($key);
        }
        
        return Cache::remember($key, 3600, function () {
            return \App\Models\Payment\PaymentMethod::where('is_active', true)
                ->orderBy('sort_order')
                ->get();
        });
    }
    
    /**
     * Cache des catégories de produits
     */
    public static function getProductCategories($restaurantId = null, $forceRefresh = false)
    {
        $key = $restaurantId ? "categories:restaurant:{$restaurantId}" : 'categories:global';
        
        if ($forceRefresh) {
            Cache::forget($key);
        }
        
        return Cache::remember($key, 1800, function () use ($restaurantId) {
            $query = \App\Models\Restaurant\Category::where('is_active', true);
            
            if ($restaurantId) {
                $query->where('restaurant_id', $restaurantId);
            }
            
            return $query->orderBy('sort_order')->get();
        });
    }
    
    /**
     * Invalidation intelligente du cache
     */
    public static function invalidateRestaurantCache($restaurantId)
    {
        $keys = [
            "restaurant:{$restaurantId}:menus",
            "categories:restaurant:{$restaurantId}",
            'restaurants:list',
            'platform:stats'
        ];
        
        foreach ($keys as $key) {
            Cache::forget($key);
        }
        
        // Invalidation Redis avec pattern
        Redis::del(Redis::keys("restaurant:{$restaurantId}:*"));
    }
    
    /**
     * Invalidation du cache des commandes
     */
    public static function invalidateOrderCache($orderId = null)
    {
        Cache::forget('platform:stats');
        
        if ($orderId) {
            Cache::forget("order:{$orderId}:details");
        }
    }
    
    /**
     * Invalidation du cache des paiements
     */
    public static function invalidatePaymentCache()
    {
        Cache::forget('platform:stats');
        Cache::forget('payment:methods');
    }
    
    /**
     * Cache des données géolocalisation
     */
    public static function getNearbyRestaurants($latitude, $longitude, $radius = 10, $forceRefresh = false)
    {
        $key = "restaurants:nearby:{$latitude}:{$longitude}:{$radius}";
        
        if ($forceRefresh) {
            Cache::forget($key);
        }
        
        return Cache::remember($key, 300, function () use ($latitude, $longitude, $radius) {
            return \App\Models\Restaurant\Restaurant::selectRaw("
                *, 
                (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance
            ", [$latitude, $longitude, $latitude])
                ->having('distance', '<', $radius)
                ->where('is_active', true)
                ->orderBy('distance')
                ->limit(20)
                ->get();
        });
    }
    
    /**
     * Warm up du cache (préchargement)
     */
    public static function warmUpCache()
    {
        // Précharger les données les plus utilisées
        self::getRestaurants();
        self::getPlatformStats();
        self::getPaymentMethods();
        self::getDeliveryZones();
        
        // Précharger les restaurants populaires
        $popularRestaurants = \App\Models\Restaurant\Restaurant::where('is_active', true)
            ->orderBy('order_count', 'desc')
            ->limit(10)
            ->get();
            
        foreach ($popularRestaurants as $restaurant) {
            self::getRestaurantMenus($restaurant->id);
            self::getProductCategories($restaurant->id);
        }
    }
    
    /**
     * Nettoyage du cache expiré
     */
    public static function cleanExpiredCache()
    {
        // Redis nettoie automatiquement les clés expirées
        // Mais on peut forcer un nettoyage manuel si nécessaire
        Redis::command('FLUSHDB');
    }
    
    /**
     * Statistiques du cache
     */
    public static function getCacheStats()
    {
        $info = Redis::info();
        
        return [
            'memory_used' => $info['used_memory_human'] ?? 'N/A',
            'keys_count' => Redis::dbsize(),
            'hit_rate' => isset($info['keyspace_hits'], $info['keyspace_misses']) 
                ? round($info['keyspace_hits'] / ($info['keyspace_hits'] + $info['keyspace_misses']) * 100, 2)
                : 'N/A',
            'connected_clients' => $info['connected_clients'] ?? 'N/A',
        ];
    }
}
