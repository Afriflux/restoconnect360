<template>
  <div class="space-y-6">
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-green-600 to-emerald-600 rounded-xl p-6 text-white">
      <h1 class="text-3xl font-bold mb-2">👋 Bienvenue, Super Admin!</h1>
      <p class="text-green-100">Gestion complète de la plateforme RestoConnect360</p>
    </div>

    <!-- Global Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-600">
        <div class="flex items-center justify-between mb-2">
          <div class="text-sm text-gray-600 font-medium">Total Entreprises</div>
          <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
          </div>
        </div>
        <div class="text-3xl font-bold text-gray-900">{{ stats.totalCompanies }}</div>
        <div class="text-sm text-green-600 mt-1">+{{ stats.newCompaniesThisMonth }} ce mois</div>
      </div>

      <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-600">
        <div class="flex items-center justify-between mb-2">
          <div class="text-sm text-gray-600 font-medium">Total Commerces</div>
          <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
          </div>
        </div>
        <div class="text-3xl font-bold text-gray-900">{{ stats.totalRestaurants }}</div>
        <div class="text-sm text-blue-600 mt-1">{{ stats.activeRestaurants }} actifs</div>
      </div>

      <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-600">
        <div class="flex items-center justify-between mb-2">
          <div class="text-sm text-gray-600 font-medium">Total Utilisateurs</div>
          <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
          </div>
        </div>
        <div class="text-3xl font-bold text-gray-900">{{ stats.totalUsers }}</div>
        <div class="text-sm text-purple-600 mt-1">{{ stats.activeUsers }} actifs</div>
      </div>

      <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-600">
        <div class="flex items-center justify-between mb-2">
          <div class="text-sm text-gray-600 font-medium">Revenus Mensuels</div>
          <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
        </div>
        <div class="text-3xl font-bold text-gray-900">{{ formatCurrency(stats.monthlyRevenue) }}</div>
        <div class="text-sm text-yellow-600 mt-1">+{{ stats.revenueGrowth }}% vs mois dernier</div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <!-- Recent Activities -->
      <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-xl font-bold mb-4 flex items-center">
          <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
          </svg>
          Activités Récentes
        </h2>
        <div class="space-y-3">
          <div v-for="activity in recentActivities" :key="activity.id" class="flex items-start space-x-3 p-3 hover:bg-gray-50 rounded-lg transition">
            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0" :class="activity.colorClass">
              <span class="text-lg">{{ activity.icon }}</span>
            </div>
            <div class="flex-1 min-w-0">
              <p class="text-sm font-medium text-gray-900">{{ activity.title }}</p>
              <p class="text-sm text-gray-500">{{ activity.description }}</p>
              <p class="text-xs text-gray-400 mt-1">{{ activity.time }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- System Status -->
      <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-xl font-bold mb-4 flex items-center">
          <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          État du Système
        </h2>
        <div class="space-y-4">
          <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
            <div class="flex items-center space-x-3">
              <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
              <span class="text-sm font-medium">Serveurs API</span>
            </div>
            <span class="text-sm text-green-600 font-semibold">Opérationnel</span>
          </div>
          <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
            <div class="flex items-center space-x-3">
              <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
              <span class="text-sm font-medium">Base de données</span>
            </div>
            <span class="text-sm text-green-600 font-semibold">Opérationnel</span>
          </div>
          <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
            <div class="flex items-center space-x-3">
              <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
              <span class="text-sm font-medium">Paiements</span>
            </div>
            <span class="text-sm text-green-600 font-semibold">Opérationnel</span>
          </div>
          <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
            <div class="flex items-center space-x-3">
              <div class="w-2 h-2 bg-yellow-500 rounded-full animate-pulse"></div>
              <span class="text-sm font-medium">SMS Gateway</span>
            </div>
            <span class="text-sm text-yellow-600 font-semibold">Ralenti</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Subscriptions Overview -->
    <div class="bg-white rounded-xl shadow-md p-6">
      <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold">Abonnements par Plan</h2>
        <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-semibold">
          📊 Rapport détaillé
        </button>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="p-4 border-2 border-gray-200 rounded-lg hover:border-green-600 transition">
          <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-medium text-gray-600">Plan Starter</span>
            <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs font-semibold rounded">BASIC</span>
          </div>
          <div class="text-2xl font-bold text-gray-900">{{ subscriptions.starter }}</div>
          <div class="text-sm text-gray-500 mt-1">commerces</div>
        </div>
        <div class="p-4 border-2 border-green-200 rounded-lg hover:border-green-600 transition bg-green-50">
          <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-medium text-gray-600">Plan Professional</span>
            <span class="px-2 py-1 bg-green-600 text-white text-xs font-semibold rounded">PRO</span>
          </div>
          <div class="text-2xl font-bold text-gray-900">{{ subscriptions.professional }}</div>
          <div class="text-sm text-gray-500 mt-1">commerces</div>
        </div>
        <div class="p-4 border-2 border-purple-200 rounded-lg hover:border-purple-600 transition bg-purple-50">
          <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-medium text-gray-600">Plan Enterprise</span>
            <span class="px-2 py-1 bg-purple-600 text-white text-xs font-semibold rounded">ENTERPRISE</span>
          </div>
          <div class="text-2xl font-bold text-gray-900">{{ subscriptions.enterprise }}</div>
          <div class="text-sm text-gray-500 mt-1">commerces</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { formatCurrency } from '../../utils/currency';

const stats = ref({
  totalCompanies: 0,
  newCompaniesThisMonth: 0,
  totalRestaurants: 0,
  activeRestaurants: 0,
  totalUsers: 0,
  activeUsers: 0,
  monthlyRevenue: 0,
  revenueGrowth: 0,
});

const subscriptions = ref({
  starter: 0,
  professional: 0,
  enterprise: 0,
});

const recentActivities = ref([
  {
    id: 1,
    icon: '🏢',
    title: 'Nouvelle entreprise inscrite',
    description: 'ABC Restaurant Group a rejoint la plateforme',
    time: 'Il y a 5 minutes',
    colorClass: 'bg-green-100',
  },
  {
    id: 2,
    icon: '💳',
    title: 'Paiement reçu',
    description: 'Abonnement Pro - Restaurant Le Gourmet',
    time: 'Il y a 15 minutes',
    colorClass: 'bg-blue-100',
  },
  {
    id: 3,
    icon: '🎉',
    title: 'Upgrade compte',
    description: 'Pizza Palace est passé au plan Enterprise',
    time: 'Il y a 1 heure',
    colorClass: 'bg-purple-100',
  },
  {
    id: 4,
    icon: '🚀',
    title: 'Nouveau module activé',
    description: 'Restaurant Le Délice a activé le module Kiosque',
    time: 'Il y a 2 heures',
    colorClass: 'bg-yellow-100',
  },
]);

const loadStats = async () => {
  // Simuler le chargement des stats
  stats.value = {
    totalCompanies: 145,
    newCompaniesThisMonth: 12,
    totalRestaurants: 387,
    activeRestaurants: 356,
    totalUsers: 2456,
    activeUsers: 1876,
    monthlyRevenue: 45678900,
    revenueGrowth: 23.5,
  };

  subscriptions.value = {
    starter: 156,
    professional: 189,
    enterprise: 42,
  };
};

onMounted(() => {
  loadStats();
});
</script>

