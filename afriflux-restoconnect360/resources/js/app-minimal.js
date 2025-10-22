// Version minimale de l'app pour test
import { createApp } from 'vue';
import { createPinia } from 'pinia';

// Composant minimal
const App = {
    template: `
        <div class="min-h-screen bg-gradient-to-br from-green-50 to-emerald-50 p-8">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-12">
                    <h1 class="text-6xl font-bold text-gray-900 mb-4">
                        RestoConnect360
                    </h1>
                    <p class="text-2xl text-gray-600">
                        La plateforme fonctionne ! 🎉
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <div class="text-4xl mb-4">🍽️</div>
                        <h3 class="text-xl font-bold mb-2">Restaurants</h3>
                        <p class="text-gray-600">Découvrez nos restaurants partenaires</p>
                    </div>
                    
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <div class="text-4xl mb-4">🚚</div>
                        <h3 class="text-xl font-bold mb-2">Livraison</h3>
                        <p class="text-gray-600">Livraison rapide à votre porte</p>
                    </div>
                    
                    <div class="bg-white p-6 rounded-lg shadow-lg">
                        <div class="text-4xl mb-4">💳</div>
                        <h3 class="text-xl font-bold mb-2">Paiements</h3>
                        <p class="text-gray-600">Paiements sécurisés et faciles</p>
                    </div>
                </div>
            </div>
        </div>
    `
};

// Création et montage de l'app
try {
    const app = createApp(App);
    const pinia = createPinia();
    app.use(pinia);
    app.mount('#app');
    console.log('✅ App montée avec succès !');
} catch (error) {
    console.error('❌ Erreur lors du montage:', error);
    document.getElementById('app').innerHTML = `
        <div style="padding: 20px; background: #fee; color: #c00; font-family: monospace;">
            <h1>Erreur de chargement</h1>
            <pre>${error.message}</pre>
            <pre>${error.stack}</pre>
        </div>
    `;
}

