<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use App\Models\Payment\Payment;
use App\Models\Restaurant\Order;
use App\Models\Restaurant\Restaurant;
use App\Models\User;
use App\Models\Delivery\Delivery;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_restaurants' => Restaurant::count(),
            'total_orders' => Order::count(),
            'total_payments' => Payment::count(),
            'total_deliveries' => Delivery::count(),
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'completed_orders' => Order::where('status', 'completed')->count(),
            'active_deliveries' => Delivery::whereIn('status', ['pending', 'in_progress'])->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    /**
     * Show payments management page
     */
    public function payments(Request $request)
    {
        $query = Payment::with(['order', 'user']);

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filter by payment method
        if ($request->has('method') && $request->method !== '') {
            $query->where('payment_method', $request->method);
        }

        // Filter by date range
        if ($request->has('from_date') && $request->from_date) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->has('to_date') && $request->to_date) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $payments = $query->orderBy('created_at', 'desc')->paginate(20);

        $paymentStats = [
            'total_amount' => Payment::sum('amount'),
            'successful_payments' => Payment::where('status', 'success')->count(),
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'failed_payments' => Payment::where('status', 'failed')->count(),
        ];

        return view('admin.payments', compact('payments', 'paymentStats'));
    }

    /**
     * Show orders management page
     */
    public function orders(Request $request)
    {
        $query = Order::with(['user', 'restaurant', 'items']);

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filter by restaurant
        if ($request->has('restaurant_id') && $request->restaurant_id !== '') {
            $query->where('restaurant_id', $request->restaurant_id);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(20);

        $restaurants = Restaurant::select('id', 'name')->get();

        return view('admin.orders', compact('orders', 'restaurants'));
    }

    /**
     * Show restaurants management page
     */
    public function restaurants(Request $request)
    {
        $query = Restaurant::withCount(['orders', 'tables']);

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        $restaurants = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.restaurants', compact('restaurants'));
    }

    /**
     * Show users management page
     */
    public function users(Request $request)
    {
        $query = User::withCount(['orders', 'restaurants']);

        // Filter by role
        if ($request->has('role') && $request->role !== '') {
            $query->where('role', $request->role);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.users', compact('users'));
    }

    /**
     * Show deliveries management page
     */
    public function deliveries(Request $request)
    {
        $query = Delivery::with(['order', 'driver']);

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        $deliveries = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.deliveries', compact('deliveries'));
    }

    /**
     * Show subscriptions management page
     */
    public function subscriptions(Request $request)
    {
        // Données simulées pour la démonstration
        // En production, ces données viendraient de votre base de données
        $totalSubscriptions = 1247;
        $monthlyRevenue = 89247;
        $lastMonthRevenue = 85432;
        $yearlyRevenue = 1067234;
        
        $activeSubscriptions = 1089;
        $trialSubscriptions = 45;
        $cancelledSubscriptions = 23;
        $newThisMonth = 67;
        
        $premiumCount = 756;
        $starterCount = 312;
        $enterpriseCount = 179;
        
        $failedPayments = 12;
        $trialsEnding = 8;
        $cancellations = 3;

        // Données pour les options promotionnelles
        $giftCards = [
            'total_issued' => 234,
            'total_value' => 45680,
            'active_cards' => 189,
            'used_cards' => 45,
            'expired_cards' => 12,
            'pending_cards' => 8
        ];

        $coupons = [
            'total_created' => 156,
            'active_coupons' => 89,
            'used_coupons' => 67,
            'expired_coupons' => 23,
            'total_discount' => 12340,
            'pending_approval' => 5
        ];

        $specialOffers = [
            'total_offers' => 34,
            'active_offers' => 12,
            'expired_offers' => 18,
            'draft_offers' => 4,
            'total_revenue' => 23450,
            'pending_offers' => 3
        ];

        $promotions = [
            'total_promos' => 67,
            'active_promos' => 23,
            'scheduled_promos' => 8,
            'expired_promos' => 36,
            'total_savings' => 45670,
            'pending_promos' => 6
        ];

        // Données pour les nouveaux widgets
        $liveStats = [
            'orders_per_minute' => 12,
            'active_users' => 247,
            'revenue_per_hour' => 1234
        ];

        $monthlyGoals = [
            'revenue_percentage' => 78,
            'revenue_current' => 156000,
            'revenue_target' => 200000,
            'customers_percentage' => 65,
            'customers_current' => 130,
            'customers_target' => 200
        ];

        $geographicStats = [
            'dakar' => 45,
            'thies' => 23,
            'saint_louis' => 18,
            'others' => 14
        ];

        return view('admin.subscriptions', compact(
            'totalSubscriptions',
            'monthlyRevenue',
            'lastMonthRevenue',
            'yearlyRevenue',
            'activeSubscriptions',
            'trialSubscriptions',
            'cancelledSubscriptions',
            'newThisMonth',
            'premiumCount',
            'starterCount',
            'enterpriseCount',
            'failedPayments',
            'trialsEnding',
            'cancellations',
            'giftCards',
            'coupons',
            'specialOffers',
            'promotions',
            'liveStats',
            'monthlyGoals',
            'geographicStats'
        ));
    }

    /**
     * Show gift cards management page
     */
    public function giftCards(Request $request)
    {
        // Données simulées pour les cartes cadeaux
        $giftCards = [
            [
                'id' => 1,
                'code' => 'GIFT2024-001',
                'value' => 50,
                'status' => 'active',
                'recipient' => 'john@example.com',
                'purchaser' => 'mary@example.com',
                'created_at' => '2024-01-15',
                'expires_at' => '2024-12-31',
                'used_at' => null
            ],
            [
                'id' => 2,
                'code' => 'GIFT2024-002',
                'value' => 100,
                'status' => 'used',
                'recipient' => 'sarah@example.com',
                'purchaser' => 'bob@example.com',
                'created_at' => '2024-01-10',
                'expires_at' => '2024-12-31',
                'used_at' => '2024-02-15'
            ]
        ];

        return view('admin.promotional.gift-cards', compact('giftCards'));
    }

    /**
     * Show coupons management page
     */
    public function coupons(Request $request)
    {
        // Données simulées pour les coupons
        $coupons = [
            [
                'id' => 1,
                'code' => 'WELCOME20',
                'type' => 'percentage',
                'value' => 20,
                'status' => 'active',
                'usage_limit' => 100,
                'used_count' => 45,
                'created_at' => '2024-01-01',
                'expires_at' => '2024-12-31'
            ],
            [
                'id' => 2,
                'code' => 'SAVE50',
                'type' => 'fixed',
                'value' => 50,
                'status' => 'active',
                'usage_limit' => 50,
                'used_count' => 23,
                'created_at' => '2024-01-05',
                'expires_at' => '2024-06-30'
            ]
        ];

        return view('admin.promotional.coupons', compact('coupons'));
    }

    /**
     * Show special offers management page
     */
    public function specialOffers(Request $request)
    {
        // Données simulées pour les offres spéciales
        $specialOffers = [
            [
                'id' => 1,
                'title' => 'Offre Premium - 30% de réduction',
                'description' => 'Réduction spéciale pour les nouveaux utilisateurs Premium',
                'discount_percentage' => 30,
                'status' => 'active',
                'start_date' => '2024-01-01',
                'end_date' => '2024-03-31',
                'usage_count' => 156,
                'revenue_generated' => 12500
            ],
            [
                'id' => 2,
                'title' => 'Pack Enterprise - 3 mois gratuits',
                'description' => 'Offre spéciale pour les grandes entreprises',
                'discount_percentage' => 100,
                'status' => 'active',
                'start_date' => '2024-02-01',
                'end_date' => '2024-05-01',
                'usage_count' => 23,
                'revenue_generated' => 8750
            ]
        ];

        return view('admin.promotional.special-offers', compact('specialOffers'));
    }

    /**
     * Show promotions management page
     */
    public function promotions(Request $request)
    {
        // Données simulées pour les promotions
        $promotions = [
            [
                'id' => 1,
                'name' => 'Black Friday 2024',
                'description' => 'Promotion Black Friday avec réductions exceptionnelles',
                'type' => 'seasonal',
                'status' => 'scheduled',
                'start_date' => '2024-11-24',
                'end_date' => '2024-11-30',
                'discount_value' => 40,
                'expected_revenue' => 50000
            ],
            [
                'id' => 2,
                'name' => 'Nouvel An 2024',
                'description' => 'Offre de Nouvel An avec 25% de réduction',
                'type' => 'seasonal',
                'status' => 'active',
                'start_date' => '2024-01-01',
                'end_date' => '2024-01-31',
                'discount_value' => 25,
                'expected_revenue' => 25000
            ]
        ];

        return view('admin.promotional.promotions', compact('promotions'));
    }
}
