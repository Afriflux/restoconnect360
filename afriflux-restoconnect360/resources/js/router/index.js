import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from '../stores/auth';

// Layouts - Keep these synchronous as they're used frequently
import MainLayout from '../layouts/MainLayout.vue';
import POSLayout from '../layouts/POSLayout.vue';
import DriverLayout from '../layouts/DriverLayout.vue';
import AdminLayout from '../layouts/AdminLayout.vue';

// Lazy load all pages for better performance
const Home = () => import('../pages/Home.vue');
const Pricing = () => import('../pages/Pricing.vue');
const Login = () => import('../pages/auth/Login.vue');
const Register = () => import('../pages/auth/Register.vue');
const RestaurantList = () => import('../pages/restaurants/RestaurantList.vue');
const RestaurantDetail = () => import('../pages/restaurants/RestaurantDetail.vue');
const FindStore = () => import('../pages/geolocation/FindStore.vue');
const Cart = () => import('../pages/cart/Cart.vue');
const Checkout = () => import('../pages/cart/Checkout.vue');
const OrderTracking = () => import('../pages/orders/OrderTracking.vue');

// Admin Dashboards - Lazy loaded
const SuperAdminDashboard = () => import('../pages/admin/SuperAdminDashboard.vue');
const AdminDashboard = () => import('../pages/admin/AdminDashboard.vue');
const RestaurantManagerDashboard = () => import('../pages/admin/RestaurantManagerDashboard.vue');
const AgentDashboard = () => import('../pages/admin/AgentDashboard.vue');

// Admin Pages - Lazy loaded
const CompaniesList = () => import('../pages/admin/companies/CompaniesList.vue');
const UsersList = () => import('../pages/admin/users/UsersList.vue');
const SubscriptionsList = () => import('../pages/admin/subscriptions/SubscriptionsList.vue');
const PaymentsList = () => import('../pages/admin/payments/PaymentsList.vue');
const ReportsList = () => import('../pages/admin/reports/ReportsList.vue');
const SettingsList = () => import('../pages/admin/settings/SettingsList.vue');
const OrdersList = () => import('../pages/admin/orders/OrdersList.vue');
const TeamList = () => import('../pages/admin/team/TeamList.vue');
const MenuList = () => import('../pages/admin/menu/MenuList.vue');
const InventoryList = () => import('../pages/admin/inventory/InventoryList.vue');
const StaffList = () => import('../pages/admin/staff/StaffList.vue');
const LeadsList = () => import('../pages/admin/leads/LeadsList.vue');
const ClientsList = () => import('../pages/admin/clients/ClientsList.vue');
const SalesList = () => import('../pages/admin/sales/SalesList.vue');
const TasksList = () => import('../pages/admin/tasks/TasksList.vue');
const CalendarList = () => import('../pages/admin/calendar/CalendarList.vue');
const PerformanceList = () => import('../pages/admin/performance/PerformanceList.vue');
const CommissionList = () => import('../pages/admin/commission/CommissionList.vue');
const RestaurantsList = () => import('../pages/admin/restaurants/RestaurantsList.vue');
const PaymentAggregatorsList = () => import('../pages/admin/payment-aggregators/PaymentAggregatorsList.vue');
const GeolocationConfig = () => import('../pages/admin/geolocation/GeolocationConfig.vue');
const EmailManagement = () => import('../pages/admin/emails/EmailManagement.vue');

// Profile & Settings - Lazy loaded
const Profile = () => import('../pages/profile/Profile.vue');
const Settings = () => import('../pages/profile/Settings.vue');

// POS - Lazy loaded
const POSDashboard = () => import('../pages/pos/POSDashboard.vue');
const POSOrders = () => import('../pages/pos/POSOrders.vue');
const POSTables = () => import('../pages/pos/POSTables.vue');

// Kiosk - Lazy loaded
const KioskHome = () => import('../pages/kiosk/KioskHome.vue');
const KioskMenu = () => import('../pages/kiosk/KioskMenu.vue');
const KioskCheckout = () => import('../pages/kiosk/KioskCheckout.vue');

// Driver - Lazy loaded
const DriverDashboard = () => import('../pages/driver/DriverDashboard.vue');
const DriverDeliveries = () => import('../pages/driver/DriverDeliveries.vue');
const DriverTracking = () => import('../pages/driver/DriverTracking.vue');

// Style Guide - Lazy loaded
const StyleGuide = () => import('../pages/StyleGuide.vue');

// Subscriptions - Lazy loaded
const Subscriptions = () => import('../pages/Subscriptions.vue');

const routes = [
    {
        path: '/',
        component: MainLayout,
        children: [
            {
                path: '',
                name: 'home',
                component: Home,
            },
            {
                path: 'pricing',
                name: 'pricing',
                component: Pricing,
            },
            {
                path: 'restaurants',
                name: 'restaurants',
                component: RestaurantList,
            },
            {
                path: 'restaurants/:id',
                name: 'restaurant-detail',
                component: RestaurantDetail,
            },
            {
                path: 'find-store',
                name: 'find-store',
                component: FindStore,
            },
            {
                path: 'cart',
                name: 'cart',
                component: Cart,
            },
            {
                path: 'checkout',
                name: 'checkout',
                component: Checkout,
                meta: { requiresAuth: true },
            },
            {
                path: 'orders/:id/tracking',
                name: 'order-tracking',
                component: OrderTracking,
            },
            {
                path: 'style-guide',
                name: 'style-guide',
                component: StyleGuide,
            },
            {
                path: 'subscriptions',
                name: 'subscriptions',
                component: Subscriptions,
                meta: { requiresAuth: true },
            },
            {
                path: 'profile',
                name: 'profile',
                component: Profile,
                meta: { requiresAuth: true },
            },
            {
                path: 'settings',
                name: 'settings',
                component: Settings,
                meta: { requiresAuth: true },
            },
        ],
    },
    {
        path: '/auth',
        component: MainLayout,
        children: [
            {
                path: 'login',
                name: 'login',
                component: Login,
            },
            {
                path: 'register',
                name: 'register',
                component: Register,
            },
        ],
    },
    {
        path: '/pos',
        component: POSLayout,
        meta: { requiresAuth: true, requiresRole: ['employee', 'restaurant_manager', 'admin'] },
        children: [
            {
                path: '',
                name: 'pos-dashboard',
                component: POSDashboard,
            },
            {
                path: 'orders',
                name: 'pos-orders',
                component: POSOrders,
            },
            {
                path: 'tables',
                name: 'pos-tables',
                component: POSTables,
            },
        ],
    },
    {
        path: '/kiosk',
        children: [
            {
                path: '',
                name: 'kiosk-home',
                component: KioskHome,
            },
            {
                path: 'menu',
                name: 'kiosk-menu',
                component: KioskMenu,
            },
            {
                path: 'checkout',
                name: 'kiosk-checkout',
                component: KioskCheckout,
            },
        ],
    },
    {
        path: '/driver',
        component: DriverLayout,
        meta: { requiresAuth: true, requiresRole: ['driver', 'admin'] },
        children: [
            {
                path: '',
                name: 'driver-dashboard',
                component: DriverDashboard,
            },
            {
                path: 'deliveries',
                name: 'driver-deliveries',
                component: DriverDeliveries,
            },
            {
                path: 'tracking/:id',
                name: 'driver-tracking',
                component: DriverTracking,
            },
        ],
    },
    {
        path: '/admin',
        component: AdminLayout,
        meta: { requiresAuth: true },
        children: [
            // Dashboards
            {
                path: 'super-admin',
                name: 'super-admin-dashboard',
                component: SuperAdminDashboard,
                meta: { requiresRole: ['super_admin'] },
            },
            {
                path: 'dashboard',
                name: 'admin-dashboard',
                component: AdminDashboard,
                meta: { requiresRole: ['admin', 'super_admin'] },
            },
            {
                path: 'restaurant',
                name: 'restaurant-manager-dashboard',
                component: RestaurantManagerDashboard,
                meta: { requiresRole: ['restaurant_manager', 'admin', 'super_admin'] },
            },
            {
                path: 'agent',
                name: 'agent-dashboard',
                component: AgentDashboard,
                meta: { requiresRole: ['agent', 'admin', 'super_admin'] },
            },
            
            // Super Admin Routes
            {
                path: 'companies',
                name: 'admin-companies',
                component: CompaniesList,
                meta: { requiresRole: ['super_admin'] },
            },
            {
                path: 'users',
                name: 'admin-users',
                component: UsersList,
                meta: { requiresRole: ['super_admin'] },
            },
            {
                path: 'subscriptions',
                name: 'admin-subscriptions',
                component: SubscriptionsList,
                meta: { requiresRole: ['super_admin'] },
            },
            {
                path: 'payments',
                name: 'admin-payments',
                component: PaymentsList,
                meta: { requiresRole: ['super_admin'] },
            },
            
            // Restaurants Route (Super Admin & Admin)
            {
                path: 'restaurants',
                name: 'admin-restaurants',
                component: RestaurantsList,
                meta: { requiresRole: ['super_admin', 'admin'] },
            },
            
            // Payment Aggregators Route (Super Admin & Admin)
            {
                path: 'payment-aggregators',
                name: 'admin-payment-aggregators',
                component: PaymentAggregatorsList,
                meta: { requiresRole: ['super_admin', 'admin'] },
            },
            {
                path: 'geolocation',
                name: 'admin-geolocation',
                component: GeolocationConfig,
                meta: { requiresRole: ['super_admin', 'admin'] },
            },
            {
                path: 'emails',
                name: 'admin-emails',
                component: EmailManagement,
                meta: { requiresRole: ['super_admin', 'admin'] },
            },
            
            // Common Admin Routes
            {
                path: 'orders',
                name: 'admin-orders',
                component: OrdersList,
                meta: { requiresRole: ['admin', 'restaurant_manager', 'super_admin'] },
            },
            {
                path: 'team',
                name: 'admin-team',
                component: TeamList,
                meta: { requiresRole: ['admin', 'super_admin'] },
            },
            {
                path: 'menu',
                name: 'admin-menu',
                component: MenuList,
                meta: { requiresRole: ['restaurant_manager', 'admin', 'super_admin'] },
            },
            {
                path: 'inventory',
                name: 'admin-inventory',
                component: InventoryList,
                meta: { requiresRole: ['restaurant_manager', 'admin', 'super_admin'] },
            },
            {
                path: 'staff',
                name: 'admin-staff',
                component: StaffList,
                meta: { requiresRole: ['restaurant_manager', 'admin', 'super_admin'] },
            },
            
            // Agent Routes
            {
                path: 'leads',
                name: 'admin-leads',
                component: LeadsList,
                meta: { requiresRole: ['agent', 'admin', 'super_admin'] },
            },
            {
                path: 'clients',
                name: 'admin-clients',
                component: ClientsList,
                meta: { requiresRole: ['agent', 'admin', 'super_admin'] },
            },
            {
                path: 'sales',
                name: 'admin-sales',
                component: SalesList,
                meta: { requiresRole: ['agent', 'admin', 'super_admin'] },
            },
            {
                path: 'tasks',
                name: 'admin-tasks',
                component: TasksList,
                meta: { requiresRole: ['agent', 'admin', 'super_admin'] },
            },
            {
                path: 'calendar',
                name: 'admin-calendar',
                component: CalendarList,
                meta: { requiresRole: ['agent', 'admin', 'super_admin'] },
            },
            {
                path: 'performance',
                name: 'admin-performance',
                component: PerformanceList,
                meta: { requiresRole: ['agent', 'admin', 'super_admin'] },
            },
            {
                path: 'commission',
                name: 'admin-commission',
                component: CommissionList,
                meta: { requiresRole: ['agent', 'admin', 'super_admin'] },
            },
            
            // Common Routes
            {
                path: 'reports',
                name: 'admin-reports',
                component: ReportsList,
                meta: { requiresRole: ['admin', 'restaurant_manager', 'agent', 'super_admin'] },
            },
            {
                path: 'settings',
                name: 'admin-settings',
                component: SettingsList,
                meta: { requiresRole: ['admin', 'restaurant_manager', 'agent', 'super_admin'] },
            },
        ],
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

// Navigation guards
router.beforeEach((to, from, next) => {
    const authStore = useAuthStore();
    
    if (to.meta.requiresAuth && !authStore.isAuthenticated) {
        next({ name: 'login', query: { redirect: to.fullPath } });
    } else if (to.meta.requiresRole) {
        const userRole = authStore.user?.role;
        if (!to.meta.requiresRole.includes(userRole)) {
            next({ name: 'home' });
        } else {
            next();
        }
    } else {
        next();
    }
});

export default router;