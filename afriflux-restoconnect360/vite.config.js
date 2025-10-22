import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import { resolve } from 'path';

export default defineConfig({
    plugins: [
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            '@': resolve(__dirname, 'resources/js'),
        },
    },
    build: {
        manifest: true,
        outDir: 'public/build',
        emptyOutDir: true,
        // Optimisation des chunks pour le lazy loading
        rollupOptions: {
            input: {
                app: 'resources/js/app-minimal.js',
                css: 'resources/css/app.css'
            },
            output: {
                manualChunks: {
                    // Chunk pour les layouts (utilisés fréquemment)
                    layouts: [
                        'resources/js/layouts/MainLayout.vue',
                        'resources/js/layouts/AdminLayout.vue',
                        'resources/js/layouts/POSLayout.vue',
                        'resources/js/layouts/DriverLayout.vue'
                    ],
                    // Chunk pour les composants UI communs
                    'ui-components': [
                        'resources/js/components/Navbar.vue',
                        'resources/js/components/Footer.vue',
                        'resources/js/components/ui/ModernButton.vue',
                        'resources/js/components/ui/ModernNotification.vue'
                    ],
                    // Chunk pour les stores Pinia
                    stores: [
                        'resources/js/stores/auth.js',
                        'resources/js/stores/restaurant.js',
                        'resources/js/stores/cart.js',
                        'resources/js/stores/order.js',
                        'resources/js/stores/delivery.js'
                    ],
                    // Chunk pour les utilitaires
                    utils: [
                        'resources/js/utils/currency.js',
                        'resources/js/utils/date.js',
                        'resources/js/utils/validators.js',
                        'resources/js/composables/useGeolocation.js',
                        'resources/js/composables/usePayment.js'
                    ],
                    // Chunk pour les pages publiques
                    'public-pages': [
                        'resources/js/pages/Home.vue',
                        'resources/js/pages/Pricing.vue',
                        'resources/js/pages/restaurants/RestaurantList.vue',
                        'resources/js/pages/restaurants/RestaurantDetail.vue'
                    ],
                    // Chunk pour les pages d'authentification
                    'auth-pages': [
                        'resources/js/pages/auth/Login.vue',
                        'resources/js/pages/auth/Register.vue'
                    ],
                    // Chunk pour les pages admin
                    'admin-pages': [
                        'resources/js/pages/admin/SuperAdminDashboard.vue',
                        'resources/js/pages/admin/AdminDashboard.vue',
                        'resources/js/pages/admin/RestaurantManagerDashboard.vue',
                        'resources/js/pages/admin/AgentDashboard.vue'
                    ],
                    // Chunk pour les pages POS
                    'pos-pages': [
                        'resources/js/pages/pos/POSDashboard.vue',
                        'resources/js/pages/pos/POSOrders.vue',
                        'resources/js/pages/pos/POSTables.vue'
                    ],
                    // Chunk pour les pages driver
                    'driver-pages': [
                        'resources/js/pages/driver/DriverDashboard.vue',
                        'resources/js/pages/driver/DriverDeliveries.vue',
                        'resources/js/pages/driver/DriverTracking.vue'
                    ],
                    // Chunk pour les pages kiosk
                    'kiosk-pages': [
                        'resources/js/pages/kiosk/KioskHome.vue',
                        'resources/js/pages/kiosk/KioskMenu.vue',
                        'resources/js/pages/kiosk/KioskCheckout.vue'
                    ]
                },
                // Optimisation des chunks
                chunkFileNames: (chunkInfo) => {
                    const facadeModuleId = chunkInfo.facadeModuleId ? chunkInfo.facadeModuleId.split('/').pop() : 'chunk';
                    return `js/[name]-[hash].js`;
                },
                entryFileNames: 'js/[name]-[hash].js',
                assetFileNames: (assetInfo) => {
                    const info = assetInfo.name.split('.');
                    const ext = info[info.length - 1];
                    if (/\.(css)$/.test(assetInfo.name)) {
                        return `css/[name]-[hash].${ext}`;
                    }
                    return `assets/[name]-[hash].${ext}`;
                }
            }
        },
        // Optimisations supplémentaires
        minify: 'terser',
        terserOptions: {
            compress: {
                drop_console: true,
                drop_debugger: true,
            },
        },
        // Source maps pour le debug
        sourcemap: false,
        // Target moderne pour de meilleures performances
        target: 'esnext',
        // CSS code splitting
        cssCodeSplit: true,
    },
    server: {
        strictPort: true,
        port: 5173,
        hmr: {
            host: 'localhost',
        },
    },
    // Optimisation des dépendances
    optimizeDeps: {
        include: [
            'vue',
            'vue-router',
            'pinia',
            'axios',
            'vue-i18n',
            '@headlessui/vue',
            '@heroicons/vue'
        ],
        exclude: ['@sentry/vue', '@sentry/tracing']
    },
});
