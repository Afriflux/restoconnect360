<template>
  <div class="space-y-6">
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl p-6 text-white">
      <h1 class="text-3xl font-bold mb-2">📊 Dashboard Administrateur</h1>
      <p class="text-blue-100">Gérez vos commerces et votre équipe</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-600">
        <div class="flex items-center justify-between mb-2">
          <div class="text-sm text-gray-600 font-medium">Mes Commerces</div>
          <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
          </div>
        </div>
        <div class="text-3xl font-bold text-gray-900">{{ stats.totalRestaurants }}</div>
        <div class="text-sm text-green-600 mt-1">{{ stats.activeRestaurants }} ouverts</div>
      </div>

      <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-600">
        <div class="flex items-center justify-between mb-2">
          <div class="text-sm text-gray-600 font-medium">Commandes Aujourd'hui</div>
          <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
          </div>
        </div>
        <div class="text-3xl font-bold text-gray-900">{{ stats.todayOrders }}</div>
        <div class="text-sm text-blue-600 mt-1">{{ stats.pendingOrders }} en attente</div>
      </div>

      <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-600">
        <div class="flex items-center justify-between mb-2">
          <div class="text-sm text-gray-600 font-medium">Revenus du Jour</div>
          <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
        </div>
        <div class="text-3xl font-bold text-gray-900">{{ formatCurrency(stats.todayRevenue) }}</div>
        <div class="text-sm text-purple-600 mt-1">+{{ stats.revenueGrowth }}% vs hier</div>
      </div>

      <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-600">
        <div class="flex items-center justify-between mb-2">
          <div class="text-sm text-gray-600 font-medium">Équipe</div>
          <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
          </div>
        </div>
        <div class="text-3xl font-bold text-gray-900">{{ stats.totalEmployees }}</div>
        <div class="text-sm text-yellow-600 mt-1">{{ stats.activeEmployees }} en service</div>
      </div>
    </div>

    <!-- Restaurant Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <div class="lg:col-span-2 bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between mb-6">
          <h2 class="text-xl font-bold flex items-center">
            <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
            Mes Commerces
          </h2>
          <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-semibold">
            + Ajouter un commerce
          </button>
        </div>

        <div class="space-y-3">
          <div v-for="restaurant in restaurants" :key="restaurant.id" class="border-2 border-gray-200 rounded-lg p-4 hover:border-green-600 transition">
            <div class="flex items-center justify-between">
              <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg flex items-center justify-center">
                  <span class="text-white text-xl">{{ restaurant.icon }}</span>
                </div>
                <div>
                  <h3 class="font-bold text-gray-900">{{ restaurant.name }}</h3>
                  <div class="flex items-center space-x-3 text-sm text-gray-600 mt-1">
                    <span class="flex items-center">
                      📍 {{ restaurant.address }}
                    </span>
                    <span v-if="restaurant.isOpen" class="flex items-center text-green-600">
                      <span class="w-2 h-2 bg-green-500 rounded-full mr-1"></span>
                      Ouvert
                    </span>
                    <span v-else class="flex items-center text-red-600">
                      <span class="w-2 h-2 bg-red-500 rounded-full mr-1"></span>
                      Fermé
                    </span>
                  </div>
                </div>
              </div>
              <div class="flex items-center space-x-2">
                <button class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm">
                  Gérer
                </button>
                <button class="px-3 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition text-sm">
                  Stats
                </button>
              </div>
            </div>
            <div class="grid grid-cols-3 gap-4 mt-4 pt-4 border-t border-gray-200">
              <div class="text-center">
                <div class="text-xl font-bold text-gray-900">{{ restaurant.todayOrders }}</div>
                <div class="text-xs text-gray-500">Commandes</div>
              </div>
              <div class="text-center">
                <div class="text-xl font-bold text-green-600">{{ formatCurrency(restaurant.todayRevenue) }}</div>
                <div class="text-xs text-gray-500">Revenus</div>
              </div>
              <div class="text-center">
                <div class="text-xl font-bold text-yellow-600">⭐ {{ restaurant.rating }}</div>
                <div class="text-xs text-gray-500">Note moyenne</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Quick Actions & Notifications -->
      <div class="space-y-6">
        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-md p-6">
          <h2 class="text-lg font-bold mb-4">Actions Rapides</h2>
          <div class="space-y-2">
            <button class="w-full px-4 py-3 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition text-left font-medium flex items-center">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
              </svg>
              Nouvelle commande
            </button>
            <button class="w-full px-4 py-3 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition text-left font-medium flex items-center">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
              </svg>
              Gérer l'équipe
            </button>
            <button class="w-full px-4 py-3 bg-purple-50 text-purple-700 rounded-lg hover:bg-purple-100 transition text-left font-medium flex items-center">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
              </svg>
              Rapports
            </button>
            <button class="w-full px-4 py-3 bg-yellow-50 text-yellow-700 rounded-lg hover:bg-yellow-100 transition text-left font-medium flex items-center">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
              </svg>
              Paramètres
            </button>
          </div>
        </div>

        <!-- Recent Notifications -->
        <div class="bg-white rounded-xl shadow-md p-6">
          <h2 class="text-lg font-bold mb-4">Notifications</h2>
          <div class="space-y-3">
            <div v-for="notification in notifications" :key="notification.id" class="p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
              <div class="flex items-start space-x-2">
                <span class="text-lg">{{ notification.icon }}</span>
                <div class="flex-1 min-w-0">
                  <p class="text-sm font-medium text-gray-900">{{ notification.title }}</p>
                  <p class="text-xs text-gray-500 mt-1">{{ notification.time }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { formatCurrency } from '../../utils/currency';

const stats = ref({
  totalRestaurants: 0,
  activeRestaurants: 0,
  todayOrders: 0,
  pendingOrders: 0,
  todayRevenue: 0,
  revenueGrowth: 0,
  totalEmployees: 0,
  activeEmployees: 0,
});

const restaurants = ref([]);

const notifications = ref([
  {
    id: 1,
    icon: '🔔',
    title: 'Nouvelle commande chez Pizza Paradise',
    time: 'Il y a 2 minutes',
  },
  {
    id: 2,
    icon: '👤',
    title: 'Nouveau membre de l\'équipe ajouté',
    time: 'Il y a 15 minutes',
  },
  {
    id: 3,
    icon: '⭐',
    title: 'Nouvelle évaluation 5 étoiles reçue',
    time: 'Il y a 1 heure',
  },
]);

const loadStats = async () => {
  // Simuler le chargement des stats
  stats.value = {
    totalRestaurants: 5,
    activeRestaurants: 4,
    todayOrders: 87,
    pendingOrders: 12,
    todayRevenue: 2345600,
    revenueGrowth: 15.3,
    totalEmployees: 45,
    activeEmployees: 32,
  };

  restaurants.value = [
    {
      id: 1,
      name: 'Pizza Paradise',
      icon: '🍕',
      address: 'Dakar, Sénégal',
      isOpen: true,
      todayOrders: 34,
      todayRevenue: 856700,
      rating: 4.8,
    },
    {
      id: 2,
      name: 'Le Gourmet',
      icon: '🍽️',
      address: 'Dakar Plateau',
      isOpen: true,
      todayOrders: 28,
      todayRevenue: 765400,
      rating: 4.6,
    },
    {
      id: 3,
      name: 'Burger King DKR',
      icon: '🍔',
      address: 'Almadies',
      isOpen: false,
      todayOrders: 25,
      todayRevenue: 723500,
      rating: 4.7,
    },
  ];
};

onMounted(() => {
  loadStats();
});
</script>

