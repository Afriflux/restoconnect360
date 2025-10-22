<template>
  <div class="space-y-6">
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-emerald-600 to-green-600 rounded-xl p-6 text-white">
      <h1 class="text-3xl font-bold mb-2">🏪 Gestion de {{ restaurantName }}</h1>
      <p class="text-green-100">Tableau de bord du gestionnaire de restaurant</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-600">
        <div class="flex items-center justify-between mb-2">
          <div class="text-sm text-gray-600 font-medium">Commandes Aujourd'hui</div>
          <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
          </div>
        </div>
        <div class="text-3xl font-bold text-gray-900">{{ stats.todayOrders }}</div>
        <div class="text-sm text-green-600 mt-1">+{{ stats.orderGrowth }}% vs hier</div>
      </div>

      <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-600">
        <div class="flex items-center justify-between mb-2">
          <div class="text-sm text-gray-600 font-medium">Revenus du Jour</div>
          <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
        </div>
        <div class="text-3xl font-bold text-gray-900">{{ formatCurrency(stats.todayRevenue) }}</div>
        <div class="text-sm text-blue-600 mt-1">{{ formatCurrency(stats.avgOrderValue) }} moyen/commande</div>
      </div>

      <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-600">
        <div class="flex items-center justify-between mb-2">
          <div class="text-sm text-gray-600 font-medium">Tables Actives</div>
          <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
            </svg>
          </div>
        </div>
        <div class="text-3xl font-bold text-gray-900">{{ stats.activeTables }}</div>
        <div class="text-sm text-purple-600 mt-1">sur {{ stats.totalTables }} tables</div>
      </div>

      <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-600">
        <div class="flex items-center justify-between mb-2">
          <div class="text-sm text-gray-600 font-medium">Note Moyenne</div>
          <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
            </svg>
          </div>
        </div>
        <div class="text-3xl font-bold text-gray-900">⭐ {{ stats.rating }}</div>
        <div class="text-sm text-yellow-600 mt-1">{{ stats.totalReviews }} avis</div>
      </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Orders in Progress -->
      <div class="lg:col-span-2 bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between mb-6">
          <h2 class="text-xl font-bold flex items-center">
            <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            Commandes en Cours
          </h2>
          <div class="flex space-x-2">
            <button class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 rounded-lg transition">
              Toutes
            </button>
            <button class="px-3 py-1 text-sm bg-green-100 text-green-700 rounded-lg">
              En cours
            </button>
          </div>
        </div>

        <div class="space-y-3">
          <div v-for="order in activeOrders" :key="order.id" class="border-2 border-gray-200 rounded-lg p-4 hover:border-green-600 transition">
            <div class="flex items-start justify-between mb-3">
              <div>
                <div class="flex items-center space-x-2">
                  <span class="font-bold text-lg">Commande #{{ order.id }}</span>
                  <span class="px-2 py-1 text-xs font-semibold rounded-full" :class="getStatusClass(order.status)">
                    {{ order.status }}
                  </span>
                </div>
                <div class="text-sm text-gray-600 mt-1">
                  <span v-if="order.tableNumber">Table {{ order.tableNumber }}</span>
                  <span v-else-if="order.customerName">{{ order.customerName }}</span>
                  • {{ order.time }}
                </div>
              </div>
              <div class="text-right">
                <div class="text-xl font-bold text-green-600">{{ formatCurrency(order.total) }}</div>
              </div>
            </div>

            <div class="space-y-2 mb-3">
              <div v-for="item in order.items" :key="item.id" class="flex justify-between text-sm">
                <span class="text-gray-700">{{ item.quantity }}x {{ item.name }}</span>
                <span class="text-gray-600">{{ formatCurrency(item.price * item.quantity) }}</span>
              </div>
            </div>

            <div class="flex space-x-2 pt-3 border-t border-gray-200">
              <button 
                v-if="order.status === 'pending'"
                @click="updateOrderStatus(order.id, 'preparing')"
                class="flex-1 px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-semibold"
              >
                Préparer
              </button>
              <button 
                v-if="order.status === 'preparing'"
                @click="updateOrderStatus(order.id, 'ready')"
                class="flex-1 px-3 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-semibold"
              >
                ✓ Prêt
              </button>
              <button 
                v-if="order.status === 'ready'"
                @click="updateOrderStatus(order.id, 'completed')"
                class="flex-1 px-3 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition text-sm font-semibold"
              >
                ✓ Livré
              </button>
              <button class="px-3 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition text-sm font-semibold">
                Détails
              </button>
            </div>
          </div>

          <div v-if="!activeOrders.length" class="text-center py-12 text-gray-500">
            <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <p>Aucune commande en cours</p>
          </div>
        </div>
      </div>

      <!-- Sidebar -->
      <div class="space-y-6">
        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-md p-6">
          <h2 class="text-lg font-bold mb-4">Actions Rapides</h2>
          <div class="space-y-2">
            <router-link 
              to="/pos"
              class="w-full px-4 py-3 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition text-left font-medium flex items-center"
            >
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
              </svg>
              Ouvrir POS
            </router-link>
            <button class="w-full px-4 py-3 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition text-left font-medium flex items-center">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
              </svg>
              Gérer les tables
            </button>
            <button class="w-full px-4 py-3 bg-purple-50 text-purple-700 rounded-lg hover:bg-purple-100 transition text-left font-medium flex items-center">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
              </svg>
              Ajouter un plat
            </button>
            <button class="w-full px-4 py-3 bg-yellow-50 text-yellow-700 rounded-lg hover:bg-yellow-100 transition text-left font-medium flex items-center">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
              </svg>
              Voir les stats
            </button>
          </div>
        </div>

        <!-- Menu Popular Items -->
        <div class="bg-white rounded-xl shadow-md p-6">
          <h2 class="text-lg font-bold mb-4">Plats Populaires</h2>
          <div class="space-y-3">
            <div v-for="item in popularItems" :key="item.id" class="flex items-center justify-between p-2 hover:bg-gray-50 rounded-lg">
              <div class="flex items-center space-x-3">
                <span class="text-2xl">{{ item.icon }}</span>
                <div>
                  <div class="text-sm font-semibold text-gray-900">{{ item.name }}</div>
                  <div class="text-xs text-gray-500">{{ item.orders }} commandes</div>
                </div>
              </div>
              <div class="text-sm font-bold text-green-600">{{ formatCurrency(item.price) }}</div>
            </div>
          </div>
        </div>

        <!-- Staff on Duty -->
        <div class="bg-white rounded-xl shadow-md p-6">
          <h2 class="text-lg font-bold mb-4">Équipe en Service</h2>
          <div class="space-y-2">
            <div v-for="staff in onDutyStaff" :key="staff.id" class="flex items-center space-x-3 p-2 hover:bg-gray-50 rounded-lg">
              <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center">
                <span class="text-white text-xs font-semibold">{{ staff.initials }}</span>
              </div>
              <div class="flex-1">
                <div class="text-sm font-semibold text-gray-900">{{ staff.name }}</div>
                <div class="text-xs text-gray-500">{{ staff.role }}</div>
              </div>
              <span class="w-2 h-2 bg-green-500 rounded-full"></span>
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

const restaurantName = ref('Pizza Paradise');

const stats = ref({
  todayOrders: 0,
  orderGrowth: 0,
  todayRevenue: 0,
  avgOrderValue: 0,
  activeTables: 0,
  totalTables: 0,
  rating: 0,
  totalReviews: 0,
});

const activeOrders = ref([]);
const popularItems = ref([]);
const onDutyStaff = ref([]);

const getStatusClass = (status) => {
  const classes = {
    'pending': 'bg-yellow-100 text-yellow-800',
    'preparing': 'bg-blue-100 text-blue-800',
    'ready': 'bg-green-100 text-green-800',
    'completed': 'bg-gray-100 text-gray-800',
  };
  return classes[status] || 'bg-gray-100 text-gray-800';
};

const updateOrderStatus = async (orderId, newStatus) => {
  // Mettre à jour le statut de la commande
  console.log(`Update order ${orderId} to ${newStatus}`);
  await loadActiveOrders();
};

const loadStats = async () => {
  stats.value = {
    todayOrders: 47,
    orderGrowth: 12.5,
    todayRevenue: 1245800,
    avgOrderValue: 26500,
    activeTables: 8,
    totalTables: 15,
    rating: 4.7,
    totalReviews: 234,
  };
};

const loadActiveOrders = async () => {
  activeOrders.value = [
    {
      id: 1234,
      status: 'pending',
      tableNumber: 5,
      time: 'Il y a 3 min',
      total: 45000,
      items: [
        { id: 1, name: 'Pizza Margherita', quantity: 2, price: 15000 },
        { id: 2, name: 'Salade César', quantity: 1, price: 8000 },
        { id: 3, name: 'Coca-Cola', quantity: 2, price: 3500 },
      ],
    },
    {
      id: 1235,
      status: 'preparing',
      customerName: 'Moussa Diop',
      time: 'Il y a 8 min',
      total: 32000,
      items: [
        { id: 1, name: 'Burger Classic', quantity: 1, price: 12000 },
        { id: 2, name: 'Frites', quantity: 2, price: 5000 },
        { id: 3, name: 'Jus Orange', quantity: 2, price: 5000 },
      ],
    },
    {
      id: 1236,
      status: 'ready',
      tableNumber: 12,
      time: 'Il y a 15 min',
      total: 67000,
      items: [
        { id: 1, name: 'Poulet Yassa', quantity: 2, price: 18000 },
        { id: 2, name: 'Riz Cantonnais', quantity: 1, price: 12000 },
        { id: 3, name: 'Thiéboudienne', quantity: 1, price: 19000 },
      ],
    },
  ];
};

const loadPopularItems = async () => {
  popularItems.value = [
    { id: 1, icon: '🍕', name: 'Pizza Margherita', orders: 23, price: 15000 },
    { id: 2, icon: '🍔', name: 'Burger Classic', orders: 18, price: 12000 },
    { id: 3, icon: '🍗', name: 'Poulet Yassa', orders: 16, price: 18000 },
    { id: 4, icon: '🍝', name: 'Spaghetti', orders: 12, price: 13000 },
  ];
};

const loadOnDutyStaff = async () => {
  onDutyStaff.value = [
    { id: 1, name: 'Amadou Seck', initials: 'AS', role: 'Chef' },
    { id: 2, name: 'Fatou Diallo', initials: 'FD', role: 'Serveuse' },
    { id: 3, name: 'Omar Kane', initials: 'OK', role: 'Serveur' },
    { id: 4, name: 'Aïssa Ndiaye', initials: 'AN', role: 'Caissière' },
  ];
};

onMounted(() => {
  loadStats();
  loadActiveOrders();
  loadPopularItems();
  loadOnDutyStaff();

  // Auto-refresh orders every 30 seconds
  setInterval(() => {
    loadActiveOrders();
  }, 30000);
});
</script>

