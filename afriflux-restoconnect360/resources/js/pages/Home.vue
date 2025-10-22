<template>
  <div>
    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-br from-white via-green-50 to-emerald-50 pt-16 pb-32">
      <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
          <h1 class="text-5xl md:text-7xl font-extrabold text-gray-900 mb-8 leading-tight">
            La solution digitale qui
            <span class="bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
              transforme
            </span>
            <br />
            votre activité de restauration
          </h1>
          <p class="text-xl md:text-2xl text-gray-600 mb-12 max-w-3xl mx-auto leading-relaxed">
            Pour restaurants, cafés, bars, boulangeries, food-trucks et tous commerces alimentaires. POS, livraison GPS, paiements mobiles africains, kiosque digital. Tout en une plateforme.
          </p>
          <div class="flex flex-col sm:flex-row justify-center gap-4 mb-16">
            <router-link
              to="/auth/register"
              class="px-8 py-4 bg-gradient-to-r from-green-600 to-emerald-600 text-white text-lg font-semibold rounded-xl hover:from-green-700 hover:to-emerald-700 shadow-2xl shadow-green-500/30 transform hover:scale-105 transition-all duration-300"
            >
              <span class="flex items-center justify-center gap-2">
                Démarrer gratuitement
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
              </span>
            </router-link>
            <router-link
              to="/restaurants"
              class="px-8 py-4 bg-white text-gray-900 text-lg font-semibold rounded-xl hover:bg-gray-50 shadow-xl border-2 border-gray-200 hover:border-green-300 transition-all duration-300 hover:shadow-2xl"
            >
              Voir une démo
            </router-link>
          </div>
          
          <!-- Trust Badges -->
          <div class="flex flex-wrap justify-center items-center gap-8 text-sm text-gray-500">
            <div class="flex items-center gap-2">
              <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
              </svg>
              <span>Essai gratuit 14 jours</span>
            </div>
            <div class="flex items-center gap-2">
              <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
              </svg>
              <span>Sans carte bancaire</span>
            </div>
            <div class="flex items-center gap-2">
              <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
              </svg>
              <span>Configuration en 5 min</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Stats Section -->
    <section class="py-16 bg-white border-y border-gray-100">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
          <div class="text-center">
            <div class="text-4xl md:text-5xl font-extrabold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent mb-2">
              150+
            </div>
            <div class="text-gray-600 font-medium">Commerces</div>
          </div>
          <div class="text-center">
            <div class="text-4xl md:text-5xl font-extrabold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent mb-2">
              5000+
            </div>
            <div class="text-gray-600 font-medium">Commandes/mois</div>
          </div>
          <div class="text-center">
            <div class="text-4xl md:text-5xl font-extrabold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent mb-2">
              2500+
            </div>
            <div class="text-gray-600 font-medium">Utilisateurs</div>
          </div>
          <div class="text-center">
            <div class="text-4xl md:text-5xl font-extrabold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent mb-2">
              99.9%
            </div>
            <div class="text-gray-600 font-medium">Uptime</div>
          </div>
        </div>
      </div>
    </section>

    <!-- Features Grid -->
    <section class="py-24 bg-gradient-to-b from-gray-50 to-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">
            Tout ce dont vous avez besoin
          </h2>
          <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            Une solution complète pour gérer tous les aspects de votre activité de restauration
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div class="group">
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 h-full border border-gray-100 hover:border-green-200 transform hover:-translate-y-2">
              <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-all duration-300">
                <span class="text-4xl">🛒</span>
              </div>
              <h3 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-green-600 transition-colors duration-300">POS Multi-Support</h3>
              <p class="text-gray-600 leading-relaxed">Interface tactile adaptée à tous les écrans : smartphone, tablette, ordinateur, TV, terminal POS, kiosque. Gestion complète des commandes et paiements.</p>
            </div>
          </div>

          <div class="group">
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 h-full border border-gray-100 hover:border-green-200 transform hover:-translate-y-2">
              <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-all duration-300">
                <span class="text-4xl">📍</span>
              </div>
              <h3 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-green-600 transition-colors duration-300">Géolocalisation GPS</h3>
              <p class="text-gray-600 leading-relaxed">Carte interactive pour trouver les commerces à proximité. Calcul de distance en temps réel. Navigation optimisée comme les applications VTC.</p>
            </div>
          </div>

          <div class="group">
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 h-full border border-gray-100 hover:border-green-200 transform hover:-translate-y-2">
              <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-all duration-300">
                <span class="text-4xl">🚗</span>
              </div>
              <h3 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-green-600 transition-colors duration-300">Livraison GPS</h3>
              <p class="text-gray-600 leading-relaxed">Suivi en temps réel des livreurs avec position GPS. Optimisation automatique des itinéraires. Notifications clients instantanées.</p>
            </div>
          </div>

          <div class="group">
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 h-full border border-gray-100 hover:border-green-200 transform hover:-translate-y-2">
              <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-all duration-300">
                <span class="text-4xl">💳</span>
              </div>
              <h3 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-green-600 transition-colors duration-300">Paiements Africains</h3>
              <p class="text-gray-600 leading-relaxed">Wave, Orange Money, MTN Money, Moov Money via CinetPay et PayTech. Stripe et PayPal pour l'international. Paiement à la livraison.</p>
            </div>
          </div>

          <div class="group">
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 h-full border border-gray-100 hover:border-green-200 transform hover:-translate-y-2">
              <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-all duration-300">
                <span class="text-4xl">🖥️</span>
              </div>
              <h3 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-green-600 transition-colors duration-300">Kiosque Digital</h3>
              <p class="text-gray-600 leading-relaxed">Borne de commande autonome avec carte digitale interactive. Paiement intégré. Interface plein écran optimisée pour tablettes et écrans tactiles.</p>
            </div>
          </div>

          <div class="group">
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 h-full border border-gray-100 hover:border-green-200 transform hover:-translate-y-2">
              <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-all duration-300">
                <span class="text-4xl">💬</span>
              </div>
              <h3 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-green-600 transition-colors duration-300">WhatsApp Business</h3>
              <p class="text-gray-600 leading-relaxed">Commandes directement via WhatsApp. Envoi automatique de la carte. Notifications de statut. Gestion complète des conversations.</p>
            </div>
          </div>

          <div class="group">
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 h-full border border-gray-100 hover:border-green-200 transform hover:-translate-y-2">
              <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-all duration-300">
                <span class="text-4xl">📱</span>
              </div>
              <h3 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-green-600 transition-colors duration-300">PWA Mobile-First</h3>
              <p class="text-gray-600 leading-relaxed">Application web progressive installable. Mode hors-ligne. Notifications push. Performance optimale sur mobile. Expérience native.</p>
            </div>
          </div>

          <div class="group">
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 h-full border border-gray-100 hover:border-green-200 transform hover:-translate-y-2">
              <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-all duration-300">
                <span class="text-4xl">🌍</span>
              </div>
              <h3 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-green-600 transition-colors duration-300">Multi-langues</h3>
              <p class="text-gray-600 leading-relaxed">Interface disponible en Français, Anglais, Arabe et Wolof. Changement de langue instantané. Adaptée aux marchés africains.</p>
            </div>
          </div>

          <div class="group">
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 h-full border border-gray-100 hover:border-green-200 transform hover:-translate-y-2">
              <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-all duration-300">
                <span class="text-4xl">📊</span>
              </div>
              <h3 class="text-2xl font-bold text-gray-900 mb-3 group-hover:text-green-600 transition-colors duration-300">Analytics Complets</h3>
              <p class="text-gray-600 leading-relaxed">Tableaux de bord en temps réel. Rapports détaillés. Statistiques de ventes. Analyse des performances. Export Excel/PDF.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 bg-gradient-to-br from-green-600 via-emerald-600 to-green-700 relative overflow-hidden">
      <div class="relative max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl md:text-5xl font-extrabold text-white mb-6">
          Prêt à transformer votre commerce ?
        </h2>
        <p class="text-xl text-green-100 mb-10 max-w-2xl mx-auto">
          Rejoignez des centaines d'établissements qui ont choisi RestoConnect360 pour gérer leur activité.
        </p>
        <router-link
          to="/auth/register"
          class="inline-flex items-center gap-2 px-10 py-5 bg-white text-green-600 text-lg font-bold rounded-xl hover:bg-gray-50 shadow-2xl transform hover:scale-105 transition-all duration-300"
        >
          Commencer gratuitement
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
          </svg>
        </router-link>
        <p class="mt-4 text-sm text-green-100">
          Essai gratuit de 14 jours • Sans carte bancaire • Annulation à tout moment
        </p>
      </div>
    </section>
  </div>
</template>

<script setup>
// Page simple sans animations complexes - juste du contenu statique
</script>

<style scoped>
/* Transitions simples uniquement */
.transition-all {
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.group:hover {
  transform: translateY(-8px);
}
</style>
