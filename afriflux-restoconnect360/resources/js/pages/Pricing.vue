<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-green-50">
    <!-- Header -->
    <div class="bg-gradient-to-r from-green-600 to-emerald-600 text-white py-20">
      <div class="container mx-auto px-4 text-center">
        <h1 class="text-5xl font-extrabold mb-4">
          Tarifs Simples et Transparents
        </h1>
        <p class="text-xl text-green-100 max-w-2xl mx-auto">
          Choisissez le plan adapté à vos besoins. Sans engagement. Annulation à tout moment.
        </p>
        <div class="mt-8 flex items-center justify-center gap-4">
          <button
            @click="billingCycle = 'monthly'"
            :class="billingCycle === 'monthly' ? 'bg-white text-green-600' : 'bg-green-700 text-white'"
            class="px-6 py-3 rounded-lg font-semibold transition-all"
          >
            Mensuel
          </button>
          <button
            @click="billingCycle = 'yearly'"
            :class="billingCycle === 'yearly' ? 'bg-white text-green-600' : 'bg-green-700 text-white'"
            class="px-6 py-3 rounded-lg font-semibold transition-all"
          >
            Annuel
            <span class="ml-2 bg-yellow-400 text-gray-900 text-xs px-2 py-1 rounded-full">-20%</span>
          </button>
        </div>
      </div>
    </div>

    <!-- Pricing Cards -->
    <div class="container mx-auto px-4 -mt-12 pb-20">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
        <!-- Starter Plan -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden transform hover:scale-105 transition-transform">
          <div class="p-8">
            <div class="text-center mb-6">
              <h3 class="text-2xl font-bold text-gray-900 mb-2">Starter</h3>
              <p class="text-gray-600">Parfait pour débuter</p>
            </div>
            
            <div class="text-center mb-8">
              <div class="text-5xl font-extrabold text-gray-900">
                {{ billingCycle === 'monthly' ? '19 900' : '15 920' }}
                <span class="text-2xl text-gray-600">FCFA</span>
              </div>
              <div class="text-gray-500 mt-2">/ {{ billingCycle === 'monthly' ? 'mois' : 'mois (payé annuellement)' }}</div>
            </div>

            <ul class="space-y-4 mb-8">
              <li class="flex items-start gap-3">
                <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-gray-700"><strong>1</strong> établissement</span>
              </li>
              <li class="flex items-start gap-3">
                <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-gray-700">POS Multi-Support</span>
              </li>
              <li class="flex items-start gap-3">
                <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-gray-700">Gestion commandes</span>
              </li>
              <li class="flex items-start gap-3">
                <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-gray-700">Menu QR Code</span>
              </li>
              <li class="flex items-start gap-3">
                <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-gray-700">Paiements mobiles</span>
              </li>
              <li class="flex items-start gap-3">
                <svg class="w-6 h-6 text-gray-300 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293z" clip-rule="evenodd"/>
                </svg>
                <span class="text-gray-400 line-through">Livraison GPS</span>
              </li>
            </ul>

            <button class="w-full bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors">
              Commencer
            </button>
          </div>
        </div>

        <!-- Pro Plan (Featured) -->
        <div class="bg-gradient-to-br from-green-600 to-emerald-600 rounded-2xl shadow-2xl overflow-hidden transform scale-105 relative">
          <div class="absolute top-0 right-0 bg-yellow-400 text-gray-900 text-xs font-bold px-4 py-2 rounded-bl-lg">
            POPULAIRE
          </div>
          <div class="p-8 text-white">
            <div class="text-center mb-6">
              <h3 class="text-2xl font-bold mb-2">Pro</h3>
              <p class="text-green-100">Pour les pros ambitieux</p>
            </div>
            
            <div class="text-center mb-8">
              <div class="text-5xl font-extrabold">
                {{ billingCycle === 'monthly' ? '49 900' : '39 920' }}
                <span class="text-2xl text-green-100">FCFA</span>
              </div>
              <div class="text-green-100 mt-2">/ {{ billingCycle === 'monthly' ? 'mois' : 'mois (payé annuellement)' }}</div>
            </div>

            <ul class="space-y-4 mb-8">
              <li class="flex items-start gap-3">
                <svg class="w-6 h-6 text-yellow-300 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span><strong>3</strong> établissements</span>
              </li>
              <li class="flex items-start gap-3">
                <svg class="w-6 h-6 text-yellow-300 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>Tout du Starter +</span>
              </li>
              <li class="flex items-start gap-3">
                <svg class="w-6 h-6 text-yellow-300 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>Livraison GPS en temps réel</span>
              </li>
              <li class="flex items-start gap-3">
                <svg class="w-6 h-6 text-yellow-300 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>Analytics avancé</span>
              </li>
              <li class="flex items-start gap-3">
                <svg class="w-6 h-6 text-yellow-300 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>Rapports Excel/PDF</span>
              </li>
              <li class="flex items-start gap-3">
                <svg class="w-6 h-6 text-yellow-300 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span>Support prioritaire</span>
              </li>
            </ul>

            <button class="w-full bg-white text-green-600 py-3 rounded-lg font-semibold hover:bg-green-50 transition-colors">
              Commencer
            </button>
          </div>
        </div>

        <!-- Enterprise Plan -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden transform hover:scale-105 transition-transform">
          <div class="p-8">
            <div class="text-center mb-6">
              <h3 class="text-2xl font-bold text-gray-900 mb-2">Enterprise</h3>
              <p class="text-gray-600">Pour les grandes chaînes</p>
            </div>
            
            <div class="text-center mb-8">
              <div class="text-5xl font-extrabold text-gray-900">
                {{ billingCycle === 'monthly' ? '99 900' : '79 920' }}
                <span class="text-2xl text-gray-600">FCFA</span>
              </div>
              <div class="text-gray-500 mt-2">/ {{ billingCycle === 'monthly' ? 'mois' : 'mois (payé annuellement)' }}</div>
            </div>

            <ul class="space-y-4 mb-8">
              <li class="flex items-start gap-3">
                <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-gray-700"><strong>Illimité</strong> d'établissements</span>
              </li>
              <li class="flex items-start gap-3">
                <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-gray-700">Tout du Pro +</span>
              </li>
              <li class="flex items-start gap-3">
                <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-gray-700">WhatsApp Business API</span>
              </li>
              <li class="flex items-start gap-3">
                <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-gray-700">API personnalisée</span>
              </li>
              <li class="flex items-start gap-3">
                <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-gray-700">Support 24/7 dédié</span>
              </li>
              <li class="flex items-start gap-3">
                <svg class="w-6 h-6 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-gray-700">Formation sur mesure</span>
              </li>
            </ul>

            <button class="w-full bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors">
              Nous contacter
            </button>
          </div>
        </div>
      </div>

      <!-- FAQ Section -->
      <div class="max-w-4xl mx-auto mt-20">
        <h2 class="text-3xl font-extrabold text-center mb-12">Questions Fréquentes</h2>
        <div class="space-y-4">
          <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-2">Puis-je changer de plan à tout moment ?</h3>
            <p class="text-gray-600">Oui, vous pouvez passer à un plan supérieur ou inférieur à tout moment. Les changements sont effectifs immédiatement.</p>
          </div>
          <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-2">Y a-t-il des frais cachés ?</h3>
            <p class="text-gray-600">Non, nos tarifs sont 100% transparents. Les seuls coûts supplémentaires sont les commissions sur les paiements (2-3%).</p>
          </div>
          <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-2">Proposez-vous un essai gratuit ?</h3>
            <p class="text-gray-600">Oui ! Profitez de 14 jours d'essai gratuit sur tous nos plans, sans carte bancaire requise.</p>
          </div>
          <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-2">Quels moyens de paiement acceptez-vous ?</h3>
            <p class="text-gray-600">Nous acceptons Wave, Orange Money, MTN Money, Moov Money, cartes bancaires et virements.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const billingCycle = ref('monthly');
</script>

<style scoped>
/* Add any specific styles here */
</style>

