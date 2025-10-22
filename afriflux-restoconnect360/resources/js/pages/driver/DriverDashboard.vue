<template>
  <div class="p-3 sm:p-6 max-w-7xl mx-auto space-y-6">
    <!-- Welcome Header avec statut en ligne -->
    <div class="bg-gradient-to-r from-green-600 to-emerald-600 rounded-xl p-6 text-white relative overflow-hidden">
      <div class="absolute inset-0 bg-black opacity-10"></div>
      <div class="relative z-10">
        <div class="flex items-center justify-between mb-4">
          <div>
            <h1 class="text-2xl sm:text-3xl font-bold mb-2">🚗 Dashboard Livreur</h1>
            <p class="text-green-100">Gérez vos livraisons et maximisez vos gains</p>
          </div>
          <div class="flex items-center gap-3">
            <div class="flex items-center gap-2 bg-white bg-opacity-20 rounded-lg px-3 py-2">
              <div class="w-3 h-3 rounded-full" :class="isOnline ? 'bg-green-400' : 'bg-red-400'"></div>
              <span class="text-sm font-medium">{{ isOnline ? 'En ligne' : 'Hors ligne' }}</span>
            </div>
            <button
              @click="toggleOnlineStatus"
              class="px-4 py-2 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-lg transition font-semibold text-sm"
            >
              {{ isOnline ? 'Se déconnecter' : 'Se connecter' }}
            </button>
          </div>
        </div>
        
        <!-- Objectifs du jour -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-4">
          <div class="bg-white bg-opacity-20 rounded-lg p-3">
            <div class="text-sm text-green-100 mb-1">Objectif livraisons</div>
            <div class="flex items-center gap-2">
              <div class="flex-1 bg-white bg-opacity-20 rounded-full h-2">
                <div class="bg-white rounded-full h-2 transition-all duration-500" :style="{ width: `${(todayStats.deliveries / dailyGoal.deliveries) * 100}%` }"></div>
              </div>
              <span class="text-sm font-bold">{{ todayStats.deliveries }}/{{ dailyGoal.deliveries }}</span>
            </div>
          </div>
          <div class="bg-white bg-opacity-20 rounded-lg p-3">
            <div class="text-sm text-green-100 mb-1">Objectif gains</div>
            <div class="flex items-center gap-2">
              <div class="flex-1 bg-white bg-opacity-20 rounded-full h-2">
                <div class="bg-white rounded-full h-2 transition-all duration-500" :style="{ width: `${(todayStats.earnings / dailyGoal.earnings) * 100}%` }"></div>
              </div>
              <span class="text-sm font-bold">{{ formatCurrency(todayStats.earnings) }}/{{ formatCurrency(dailyGoal.earnings) }}</span>
            </div>
          </div>
          <div class="bg-white bg-opacity-20 rounded-lg p-3">
            <div class="text-sm text-green-100 mb-1">Temps de travail</div>
            <div class="text-lg font-bold">{{ formatWorkTime(workTime) }}</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Stats Cards Améliorées -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
      <div class="bg-white rounded-xl shadow-md p-4 sm:p-6 border-l-4 border-green-600 hover:shadow-lg transition">
        <div class="flex items-center justify-between mb-2">
          <div class="text-xs sm:text-sm text-gray-600 font-medium">Aujourd'hui</div>
          <div class="w-8 h-8 sm:w-10 sm:h-10 bg-green-100 rounded-lg flex items-center justify-center">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
            </svg>
          </div>
        </div>
        <div class="text-2xl sm:text-3xl font-bold text-gray-900">{{ todayStats.deliveries }}</div>
        <div class="text-xs sm:text-sm text-green-600 mt-1">livraisons</div>
        <div class="text-xs text-gray-500 mt-1">+{{ todayStats.deliveriesIncrease }}% vs hier</div>
      </div>
      
      <div class="bg-white rounded-xl shadow-md p-4 sm:p-6 border-l-4 border-blue-600 hover:shadow-lg transition">
        <div class="flex items-center justify-between mb-2">
          <div class="text-xs sm:text-sm text-gray-600 font-medium">Gains</div>
          <div class="w-8 h-8 sm:w-10 sm:h-10 bg-blue-100 rounded-lg flex items-center justify-center">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
        </div>
        <div class="text-2xl sm:text-3xl font-bold text-gray-900">{{ formatCurrency(todayStats.earnings) }}</div>
        <div class="text-xs sm:text-sm text-blue-600 mt-1">FCFA</div>
        <div class="text-xs text-gray-500 mt-1">+{{ todayStats.earningsIncrease }}% vs hier</div>
      </div>
      
      <div class="bg-white rounded-xl shadow-md p-4 sm:p-6 border-l-4 border-purple-600 hover:shadow-lg transition">
        <div class="flex items-center justify-between mb-2">
          <div class="text-xs sm:text-sm text-gray-600 font-medium">Distance</div>
          <div class="w-8 h-8 sm:w-10 sm:h-10 bg-purple-100 rounded-lg flex items-center justify-center">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
            </svg>
          </div>
        </div>
        <div class="text-2xl sm:text-3xl font-bold text-gray-900">{{ todayStats.distance }}</div>
        <div class="text-xs sm:text-sm text-purple-600 mt-1">km parcourus</div>
        <div class="text-xs text-gray-500 mt-1">Moy: {{ todayStats.avgDistancePerDelivery }}km/livraison</div>
      </div>
      
      <div class="bg-white rounded-xl shadow-md p-4 sm:p-6 border-l-4 border-yellow-600 hover:shadow-lg transition">
        <div class="flex items-center justify-between mb-2">
          <div class="text-xs sm:text-sm text-gray-600 font-medium">Note</div>
          <div class="w-8 h-8 sm:w-10 sm:h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
            </svg>
          </div>
        </div>
        <div class="text-2xl sm:text-3xl font-bold text-gray-900">⭐ {{ todayStats.rating }}</div>
        <div class="text-xs sm:text-sm text-yellow-600 mt-1">{{ todayStats.totalReviews }} avis</div>
        <div class="text-xs text-gray-500 mt-1">Top {{ todayStats.ranking }}% des livreurs</div>
      </div>
    </div>

    <!-- Graphique des gains de la semaine -->
    <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg sm:text-xl font-bold">Gains de la semaine</h2>
        <div class="flex gap-2">
          <button
            @click="selectedPeriod = 'week'"
            :class="selectedPeriod === 'week' ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700'"
            class="px-3 py-1 rounded-lg text-sm font-medium transition"
          >
            Semaine
          </button>
          <button
            @click="selectedPeriod = 'month'"
            :class="selectedPeriod === 'month' ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700'"
            class="px-3 py-1 rounded-lg text-sm font-medium transition"
          >
            Mois
          </button>
        </div>
      </div>
      
      <div class="h-64 flex items-end justify-between gap-2">
        <div
          v-for="(day, index) in weeklyEarnings"
          :key="index"
          class="flex-1 flex flex-col items-center"
        >
          <div class="text-xs text-gray-600 mb-2">{{ day.day }}</div>
          <div
            class="w-full bg-green-200 rounded-t-lg transition-all duration-500 hover:bg-green-300 cursor-pointer"
            :style="{ height: `${(day.amount / Math.max(...weeklyEarnings.map(d => d.amount))) * 200}px` }"
            :title="`${day.day}: ${formatCurrency(day.amount)}`"
          ></div>
          <div class="text-xs text-gray-500 mt-1">{{ formatCurrency(day.amount) }}</div>
        </div>
      </div>
    </div>

    <!-- Notifications et Alertes -->
    <div v-if="notifications.length" class="bg-white rounded-lg shadow-md p-4 sm:p-6">
      <h2 class="text-lg sm:text-xl font-bold mb-4 flex items-center gap-2">
        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4.828 7l2.586 2.586a2 2 0 002.828 0L12.828 7H4.828z"/>
        </svg>
        Notifications
      </h2>
      <div class="space-y-3">
        <div
          v-for="notification in notifications"
          :key="notification.id"
          class="flex items-start gap-3 p-3 rounded-lg"
          :class="notification.type === 'urgent' ? 'bg-red-50 border border-red-200' : 'bg-blue-50 border border-blue-200'"
        >
          <div class="w-2 h-2 rounded-full mt-2" :class="notification.type === 'urgent' ? 'bg-red-500' : 'bg-blue-500'"></div>
          <div class="flex-1">
            <div class="font-semibold text-sm">{{ notification.title }}</div>
            <div class="text-sm text-gray-600 mt-1">{{ notification.message }}</div>
            <div class="text-xs text-gray-500 mt-1">{{ formatTime(notification.created_at) }}</div>
          </div>
          <button @click="markAsRead(notification.id)" class="text-gray-400 hover:text-gray-600">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Livraisons disponibles avec filtres -->
    <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 mb-6">
      <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-3">
        <h2 class="text-lg sm:text-xl font-bold">Livraisons disponibles</h2>
        <div class="flex items-center gap-3">
          <!-- Filtres -->
          <select v-model="deliveryFilter" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
            <option value="all">Toutes</option>
            <option value="nearby">Proches (< 5km)</option>
            <option value="high_value">Haute valeur (> 2000 FCFA)</option>
            <option value="quick">Rapides (< 30min)</option>
          </select>
          
          <button
            @click="refreshDeliveries"
            class="p-2 hover:bg-gray-100 rounded-lg transition"
            :class="{ 'animate-spin': refreshing }"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
          </button>
        </div>
      </div>

      <div v-if="!filteredDeliveries.length" class="text-center py-8 text-gray-500">
        <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
        </svg>
        <p>Aucune livraison disponible pour le moment</p>
        <p class="text-sm text-gray-400 mt-1">Les nouvelles livraisons apparaîtront automatiquement</p>
      </div>

      <div v-else class="space-y-3">
        <div
          v-for="delivery in filteredDeliveries"
          :key="delivery.id"
          class="border-2 border-gray-200 rounded-lg p-3 sm:p-4 hover:border-green-600 transition hover:shadow-md"
        >
          <div class="flex flex-col sm:flex-row justify-between gap-3">
            <div class="flex-1">
              <div class="flex items-center gap-2 mb-2">
                <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded">
                  {{ formatCurrency(delivery.delivery_fee) }}
                </span>
                <span class="text-sm text-gray-600">• {{ delivery.distance }} km</span>
                <span class="text-sm text-gray-600">• {{ delivery.estimated_time }} min</span>
                <span v-if="delivery.is_urgent" class="px-2 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded">
                  URGENT
                </span>
              </div>
              
              <div class="space-y-2 text-sm">
                <div class="flex items-start gap-2">
                  <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                  </svg>
                  <div>
                    <div class="font-semibold">{{ delivery.restaurant.name }}</div>
                    <div class="text-gray-600">{{ delivery.pickup_address }}</div>
                  </div>
                </div>
                
                <div class="flex items-start gap-2">
                  <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                  </svg>
                  <div>
                    <div class="font-semibold">{{ delivery.customer.name }}</div>
                    <div class="text-gray-600">{{ delivery.delivery_address }}</div>
                  </div>
                </div>
                
                <div v-if="delivery.order_items" class="text-xs text-gray-500 mt-2">
                  <span class="font-medium">Commande:</span> {{ delivery.order_items.length }} article(s) • {{ formatCurrency(delivery.order_total) }}
                </div>
              </div>
            </div>

            <div class="flex sm:flex-col gap-2">
              <button
                @click="acceptDelivery(delivery)"
                class="flex-1 sm:flex-none px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold text-sm touch-manipulation"
              >
                Accepter
              </button>
              <button
                @click="viewDeliveryDetails(delivery)"
                class="flex-1 sm:flex-none px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition text-sm touch-manipulation"
              >
                Détails
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Mes livraisons en cours avec timeline -->
    <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
      <h2 class="text-lg sm:text-xl font-bold mb-4">Mes livraisons en cours</h2>

      <div v-if="!activeDeliveries.length" class="text-center py-8 text-gray-500">
        <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p>Aucune livraison en cours</p>
        <p class="text-sm text-gray-400 mt-1">Acceptez une livraison pour commencer</p>
      </div>

      <div v-else class="space-y-4">
        <div
          v-for="delivery in activeDeliveries"
          :key="delivery.id"
          class="border-2 border-green-200 bg-green-50 rounded-lg p-4"
        >
          <div class="flex justify-between items-start mb-4">
            <div>
              <div class="font-bold text-base sm:text-lg">Livraison #{{ delivery.id }}</div>
              <div class="text-sm text-gray-600">{{ delivery.order.restaurant.name }}</div>
              <div class="text-xs text-gray-500 mt-1">Acceptée à {{ formatTime(delivery.accepted_at) }}</div>
            </div>
            <span
              class="px-3 py-1 rounded-full text-xs font-semibold"
              :class="getStatusClass(delivery.status)"
            >
              {{ getStatusLabel(delivery.status) }}
            </span>
          </div>

          <!-- Timeline de progression -->
          <div class="mb-4">
            <div class="flex items-center justify-between text-xs text-gray-600 mb-2">
              <span>Assignée</span>
              <span>Récupérée</span>
              <span>En cours</span>
              <span>Livrée</span>
            </div>
            <div class="flex items-center">
              <div class="flex-1 h-2 bg-gray-200 rounded-full">
                <div class="h-2 bg-green-500 rounded-full transition-all duration-500" :style="{ width: getProgressWidth(delivery.status) }"></div>
              </div>
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
            <button
              v-if="delivery.status === 'assigned'"
              @click="updateDeliveryStatus(delivery.id, 'picked_up')"
              class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-semibold touch-manipulation"
            >
              ✅ Commande récupérée
            </button>
            <button
              v-if="delivery.status === 'picked_up'"
              @click="startTracking(delivery)"
              class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-semibold touch-manipulation"
            >
              🚗 Démarrer la livraison
            </button>
            <button
              v-if="delivery.status === 'in_transit'"
              @click="updateDeliveryStatus(delivery.id, 'delivered')"
              class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-semibold touch-manipulation"
            >
              ✅ Marquer comme livrée
            </button>
            <button
              @click="openNavigation(delivery)"
              class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition text-sm font-semibold touch-manipulation"
            >
              📍 Navigation
            </button>
            <button
              @click="contactCustomer(delivery)"
              class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition text-sm font-semibold touch-manipulation"
            >
              📞 Contacter
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { useRouter } from 'vue-router';
import { useDeliveryStore } from '../../stores/delivery';
import { formatCurrency } from '../../utils/currency';
import axios from 'axios';

const router = useRouter();
const deliveryStore = useDeliveryStore();

// État de base
const refreshing = ref(false);
const isOnline = ref(true);
const selectedPeriod = ref('week');
const deliveryFilter = ref('all');

// Données
const availableDeliveries = ref([]);
const activeDeliveries = ref([]);
const notifications = ref([]);
const workTime = ref(0); // en minutes

// Objectifs quotidiens
const dailyGoal = ref({
  deliveries: 15,
  earnings: 25000
});

// Statistiques améliorées
const todayStats = ref({
  deliveries: 8,
  deliveriesIncrease: 12,
  earnings: 18500,
  earningsIncrease: 8,
  distance: 45.2,
  avgDistancePerDelivery: 5.7,
  rating: 4.8,
  totalReviews: 127,
  ranking: 15
});

// Gains de la semaine
const weeklyEarnings = ref([
  { day: 'Lun', amount: 12000 },
  { day: 'Mar', amount: 15000 },
  { day: 'Mer', amount: 18000 },
  { day: 'Jeu', amount: 22000 },
  { day: 'Ven', amount: 19500 },
  { day: 'Sam', amount: 25000 },
  { day: 'Dim', amount: 18500 }
]);

// Livraisons disponibles avec données enrichies
const mockDeliveries = ref([
  {
    id: 1,
    delivery_fee: 2500,
    distance: 3.2,
    estimated_time: 25,
    is_urgent: false,
    restaurant: { name: 'Le Teranga' },
    customer: { name: 'Fatou Diallo' },
    pickup_address: 'Rue 10, Plateau, Dakar',
    delivery_address: 'Avenue Bourguiba, Dakar',
    order_items: [
      { name: 'Thieboudienne', quantity: 2 },
      { name: 'Jus de bissap', quantity: 1 }
    ],
    order_total: 8500
  },
  {
    id: 2,
    delivery_fee: 3200,
    distance: 4.8,
    estimated_time: 35,
    is_urgent: true,
    restaurant: { name: 'Café des Arts' },
    customer: { name: 'Moussa Sarr' },
    pickup_address: 'Avenue Georges Pompidou, Dakar',
    delivery_address: 'Corniche Ouest, Dakar',
    order_items: [
      { name: 'Café latte', quantity: 1 },
      { name: 'Croissant', quantity: 2 }
    ],
    order_total: 4200
  },
  {
    id: 3,
    delivery_fee: 1800,
    distance: 2.1,
    estimated_time: 18,
    is_urgent: false,
    restaurant: { name: 'Fast Food Lagon' },
    customer: { name: 'Aminata Ba' },
    pickup_address: 'Rond-point Lagon, Dakar',
    delivery_address: 'Rue de la République, Dakar',
    order_items: [
      { name: 'Burger', quantity: 1 },
      { name: 'Frites', quantity: 1 }
    ],
    order_total: 3500
  }
]);

// Livraisons actives avec données enrichies
const mockActiveDeliveries = ref([
  {
    id: 101,
    status: 'assigned',
    accepted_at: '2024-01-15T10:30:00Z',
    order: { restaurant: { name: 'Le Teranga' } },
    delivery_fee: 2800,
    customer: { name: 'Ibrahima Fall', phone: '+221 77 123 45 67' },
    pickup_address: 'Rue 10, Plateau, Dakar',
    delivery_address: 'Avenue Bourguiba, Dakar'
  },
  {
    id: 102,
    status: 'picked_up',
    accepted_at: '2024-01-15T11:15:00Z',
    order: { restaurant: { name: 'Café des Arts' } },
    delivery_fee: 2100,
    customer: { name: 'Mariama Diop', phone: '+221 78 987 65 43' },
    pickup_address: 'Avenue Georges Pompidou, Dakar',
    delivery_address: 'Corniche Ouest, Dakar'
  }
]);

// Notifications
const mockNotifications = ref([
  {
    id: 1,
    type: 'urgent',
    title: 'Livraison urgente disponible',
    message: 'Une livraison urgente près de votre position avec bonus de 1000 FCFA',
    created_at: '2024-01-15T12:00:00Z'
  },
  {
    id: 2,
    type: 'info',
    title: 'Objectif quotidien atteint',
    message: 'Félicitations ! Vous avez atteint votre objectif de livraisons du jour',
    created_at: '2024-01-15T11:30:00Z'
  }
]);

// Computed properties
const filteredDeliveries = computed(() => {
  if (deliveryFilter.value === 'all') return availableDeliveries.value;
  
  return availableDeliveries.value.filter(delivery => {
    switch (deliveryFilter.value) {
      case 'nearby':
        return delivery.distance < 5;
      case 'high_value':
        return delivery.delivery_fee > 2000;
      case 'quick':
        return delivery.estimated_time < 30;
      default:
        return true;
    }
  });
});

// Méthodes utilitaires
const formatWorkTime = (minutes) => {
  const hours = Math.floor(minutes / 60);
  const mins = minutes % 60;
  return `${hours}h${mins.toString().padStart(2, '0')}`;
};

const formatTime = (dateString) => {
  const date = new Date(dateString);
  return date.toLocaleTimeString('fr-FR', { 
    hour: '2-digit', 
    minute: '2-digit' 
  });
};

const getProgressWidth = (status) => {
  const progress = {
    'assigned': '25%',
    'picked_up': '50%',
    'in_transit': '75%',
    'delivered': '100%'
  };
  return progress[status] || '0%';
};

// Actions principales
const toggleOnlineStatus = async () => {
  isOnline.value = !isOnline.value;
  try {
    await axios.post('/api/driver/status', { 
      is_online: isOnline.value 
    });
    
    if (isOnline.value) {
      // Se connecter - charger les livraisons disponibles
      await refreshDeliveries();
    } else {
      // Se déconnecter - vider les livraisons disponibles
      availableDeliveries.value = [];
    }
  } catch (error) {
    console.error('Failed to update status:', error);
    // Revert status on error
    isOnline.value = !isOnline.value;
  }
};

const refreshDeliveries = async () => {
  if (!isOnline.value) return;
  
  refreshing.value = true;
  try {
    // Simulation d'appel API
    await new Promise(resolve => setTimeout(resolve, 1000));
    availableDeliveries.value = [...mockDeliveries.value];
  } catch (error) {
    console.error('Failed to refresh:', error);
  } finally {
    setTimeout(() => {
      refreshing.value = false;
    }, 500);
  }
};

const acceptDelivery = async (delivery) => {
  try {
    await axios.post(`/api/deliveries/${delivery.id}/accept`);
    
    // Ajouter à la liste des livraisons actives
    const newActiveDelivery = {
      ...delivery,
      status: 'assigned',
      accepted_at: new Date().toISOString()
    };
    activeDeliveries.value.push(newActiveDelivery);
    
    // Retirer de la liste des livraisons disponibles
    availableDeliveries.value = availableDeliveries.value.filter(d => d.id !== delivery.id);
    
    // Mettre à jour les statistiques
    todayStats.value.deliveries++;
    todayStats.value.earnings += delivery.delivery_fee;
    
  } catch (error) {
    console.error('Failed to accept:', error);
    alert('Erreur lors de l\'acceptation');
  }
};

const updateDeliveryStatus = async (id, status) => {
  try {
    await deliveryStore.updateDeliveryStatus(id, status);
    
    // Mettre à jour localement
    const delivery = activeDeliveries.value.find(d => d.id === id);
    if (delivery) {
      delivery.status = status;
      
      if (status === 'delivered') {
        // Retirer de la liste des livraisons actives après livraison
        setTimeout(() => {
          activeDeliveries.value = activeDeliveries.value.filter(d => d.id !== id);
        }, 2000);
      }
    }
  } catch (error) {
    console.error('Failed to update status:', error);
    alert('Erreur lors de la mise à jour');
  }
};

const startTracking = (delivery) => {
  router.push({ name: 'driver-tracking', params: { id: delivery.id } });
};

const openNavigation = (delivery) => {
  const destination = `${delivery.delivery_latitude || '14.7167'},${delivery.delivery_longitude || '-17.4677'}`;
  const url = `https://www.google.com/maps/dir/?api=1&destination=${destination}&travelmode=driving`;
  window.open(url, '_blank');
};

const contactCustomer = (delivery) => {
  if (delivery.customer?.phone) {
    window.open(`tel:${delivery.customer.phone}`, '_self');
  } else {
    alert('Numéro de téléphone non disponible');
  }
};

const viewDeliveryDetails = (delivery) => {
  // Modal avec tous les détails
  const details = `
Livraison #${delivery.id}
Restaurant: ${delivery.restaurant.name}
Client: ${delivery.customer.name}
Adresse: ${delivery.delivery_address}
Frais: ${formatCurrency(delivery.delivery_fee)}
Distance: ${delivery.distance} km
Temps estimé: ${delivery.estimated_time} min
${delivery.is_urgent ? 'URGENT' : ''}
  `;
  alert(details);
};

const markAsRead = (notificationId) => {
  notifications.value = notifications.value.filter(n => n.id !== notificationId);
};

const getStatusClass = (status) => {
  const classes = {
    assigned: 'bg-blue-100 text-blue-800',
    picked_up: 'bg-yellow-100 text-yellow-800',
    in_transit: 'bg-green-100 text-green-800',
    delivered: 'bg-gray-100 text-gray-800',
  };
  return classes[status] || 'bg-gray-100 text-gray-800';
};

const getStatusLabel = (status) => {
  const labels = {
    assigned: 'Assignée',
    picked_up: 'Récupérée',
    in_transit: 'En cours',
    delivered: 'Livrée',
  };
  return labels[status] || status;
};

const loadActiveDeliveries = async () => {
  try {
    // Simulation d'appel API
    await new Promise(resolve => setTimeout(resolve, 500));
    activeDeliveries.value = [...mockActiveDeliveries.value];
  } catch (error) {
    console.error('Failed to load active deliveries:', error);
  }
};

const loadStats = async () => {
  try {
    // Simulation d'appel API
    await new Promise(resolve => setTimeout(resolve, 300));
    // Les stats sont déjà définies dans todayStats
  } catch (error) {
    console.error('Failed to load stats:', error);
  }
};

const loadNotifications = async () => {
  try {
    // Simulation d'appel API
    await new Promise(resolve => setTimeout(resolve, 200));
    notifications.value = [...mockNotifications.value];
  } catch (error) {
    console.error('Failed to load notifications:', error);
  }
};

const startWorkTimer = () => {
  setInterval(() => {
    workTime.value++;
  }, 60000); // Incrémenter chaque minute
};

// Lifecycle
onMounted(() => {
  refreshDeliveries();
  loadActiveDeliveries();
  loadStats();
  loadNotifications();
  startWorkTimer();
  
  // Auto-refresh toutes les 30 secondes
  setInterval(() => {
    if (isOnline.value) {
      refreshDeliveries();
      loadActiveDeliveries();
    }
  }, 30000);
});
</script>

