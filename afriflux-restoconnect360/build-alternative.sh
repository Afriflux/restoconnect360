#!/bin/bash

# Script de build alternatif pour Node.js 18
# Ce script compile les assets sans Vite

echo "🔧 Build alternatif pour Node.js 18.20.8"
echo "=========================================="

# Vérifier la version de Node.js
echo "📋 Version Node.js: $(node --version)"
echo "📋 Version npm: $(npm --version)"
echo ""

# Créer le dossier de build
echo "📁 Création du dossier de build..."
mkdir -p public/build/assets

# Copier les fichiers CSS
echo "🎨 Copie des fichiers CSS..."
cp resources/css/app.css public/build/assets/app.css

# Créer un fichier JS minimal
echo "⚡ Création du fichier JS minimal..."
cat > public/build/assets/app.js << 'EOF'
// Application Vue.js minimale pour Node.js 18
console.log('RestoConnect360 - Application chargée');

// Import dynamique des modules Vue
import('./js/vue-app.js').catch(err => {
    console.warn('Modules Vue non disponibles:', err);
});
EOF

# Créer un fichier Vue.js de base
echo "🖼️ Création du fichier Vue.js de base..."
cat > public/build/assets/vue-app.js << 'EOF'
// Vue.js Application de base
import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import { createPinia } from 'pinia';

// Composants de base
const App = {
    template: `
        <div id="app">
            <nav class="bg-white shadow-lg sticky top-0 z-50 border-b border-gray-100">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-20">
                        <div class="flex items-center space-x-3 group">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                                <span class="text-white text-2xl font-bold">R</span>
                            </div>
                            <div class="hidden sm:block">
                                <div class="text-2xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
                                    RestoConnect360
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <a href="/" class="text-gray-700 hover:text-green-600 font-medium">Accueil</a>
                            <a href="/restaurants" class="text-gray-700 hover:text-green-600 font-medium">Restaurants</a>
                            <a href="/pricing" class="text-gray-700 hover:text-green-600 font-medium">Tarifs</a>
                        </div>
                    </div>
                </div>
            </nav>
            <main>
                <router-view />
            </main>
        </div>
    `
};

// Page d'accueil
const Home = {
    template: `
        <div class="py-8">
            <div class="max-w-7xl mx-auto px-4">
                <h1 class="text-3xl font-bold mb-6">Bienvenue sur RestoConnect360</h1>
                <p class="text-gray-600">Votre solution de gestion de restaurants</p>
            </div>
        </div>
    `
};

// Page restaurants
const Restaurants = {
    template: `
        <div class="py-8">
            <div class="max-w-7xl mx-auto px-4">
                <h1 class="text-3xl font-bold mb-6">Nos Restaurants</h1>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div v-for="restaurant in restaurants" :key="restaurant.id" class="bg-white rounded-lg shadow-md p-4">
                        <h3 class="font-bold text-xl">{{ restaurant.name }}</h3>
                        <p class="text-gray-600">{{ restaurant.cuisine_type }}</p>
                        <div class="mt-2 flex items-center justify-between">
                            <span>⭐ {{ restaurant.rating }}</span>
                            <span class="text-green-600">{{ restaurant.delivery_fee }} FCFA</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `,
    data() {
        return {
            restaurants: []
        }
    },
    async mounted() {
        try {
            const response = await fetch('/api/restaurants');
            const data = await response.json();
            this.restaurants = data.data || [];
        } catch (error) {
            console.error('Erreur lors du chargement des restaurants:', error);
            // Données de fallback
            this.restaurants = [
                { id: 1, name: 'Le Teranga', cuisine_type: 'Sénégalaise', rating: 4.5, delivery_fee: 0 },
                { id: 2, name: 'Café des Arts', cuisine_type: 'Française', rating: 4.2, delivery_fee: 0 },
                { id: 3, name: 'Fast Food Lagon', cuisine_type: 'Américaine', rating: 4.0, delivery_fee: 0 }
            ];
        }
    }
};

// Configuration des routes
const routes = [
    { path: '/', component: Home },
    { path: '/restaurants', component: Restaurants },
    { path: '/pricing', component: Home }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

// Création de l'application
const app = createApp(App);
app.use(router);
app.use(createPinia());

// Montage de l'application
app.mount('#app');

console.log('✅ Application Vue.js chargée avec succès');
EOF

# Créer un fichier de manifest
echo "📄 Création du fichier de manifest..."
cat > public/build/manifest.json << 'EOF'
{
    "resources/css/app.css": {
        "file": "assets/app.css",
        "src": "resources/css/app.css"
    },
    "resources/js/app.js": {
        "file": "assets/app.js",
        "src": "resources/js/app.js",
        "isEntry": true
    }
}
EOF

echo ""
echo "✅ Build alternatif terminé !"
echo "📁 Fichiers créés dans public/build/"
echo "🌐 Serveur Laravel disponible sur http://localhost:8001"
echo ""
echo "📋 Prochaines étapes :"
echo "1. Démarrer le serveur Laravel: php artisan serve --port=8001"
echo "2. Accéder à http://localhost:8001/restaurants"
echo "3. Pour une solution définitive, mettre à jour Node.js vers la version 20+"
echo ""
