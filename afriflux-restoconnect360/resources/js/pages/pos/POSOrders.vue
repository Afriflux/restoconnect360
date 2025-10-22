<template>
  <div class="h-full p-2 sm:p-4 lg:p-6">
    <!-- Header -->
    <div class="mb-4 sm:mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
      <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900">Commandes</h2>
      <select
        v-model="selectedStatus"
        class="px-3 py-2 border rounded-lg text-sm text-gray-900 w-full sm:w-auto focus:ring-2 focus:ring-primary-500"
      >
        <option value="all">Toutes</option>
        <option value="pending">En attente</option>
        <option value="confirmed">Confirmées</option>
        <option value="preparing">En préparation</option>
        <option value="ready">Prêtes</option>
        <option value="delivered">Livrées</option>
      </select>
    </div>

    <!-- Orders Grid - Responsive -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-4">
      <div
        v-for="order in filteredOrders"
        :key="order.id"
        class="bg-white rounded-lg shadow-md p-3 sm:p-4 hover:shadow-lg transition"
      >
        <!-- Header -->
        <div class="flex justify-between items-start mb-3">
          <div>
            <div class="text-xs sm:text-sm text-gray-600">Commande #{{ order.id }}</div>
            <div class="font-semibold text-sm sm:text-base text-gray-900">Table {{ order.table?.number || 'N/A' }}</div>
          </div>
          <span
            class="px-2 py-1 rounded text-xs font-semibold"
            :class="getStatusBadgeClass(order.status)"
          >
            {{ getStatusLabel(order.status) }}
          </span>
        </div>

        <!-- Items -->
        <div class="space-y-1 mb-3 text-xs sm:text-sm text-gray-700">
          <div
            v-for="item in order.items.slice(0, 3)"
            :key="item.id"
            class="flex justify-between"
          >
            <span>{{ item.quantity }}x {{ item.product.name }}</span>
            <span class="font-semibold">{{ formatCurrency(item.price * item.quantity) }}</span>
          </div>
          <div v-if="order.items.length > 3" class="text-gray-500">
            +{{ order.items.length - 3 }} autres...
          </div>
        </div>

        <!-- Total -->
        <div class="flex justify-between items-center pt-3 border-t mb-3">
          <span class="font-semibold text-sm sm:text-base text-gray-900">Total</span>
          <span class="font-bold text-primary-600 text-base sm:text-lg">{{ formatCurrency(order.total) }}</span>
        </div>

        <!-- Actions -->
        <div class="grid grid-cols-2 gap-2">
          <button
            v-if="order.status === 'pending'"
            @click="updateStatus(order.id, 'confirmed')"
            class="px-3 py-2 bg-green-600 text-white rounded text-xs sm:text-sm hover:bg-green-700 transition touch-manipulation"
          >
            Confirmer
          </button>
          <button
            v-if="order.status === 'confirmed'"
            @click="updateStatus(order.id, 'preparing')"
            class="px-3 py-2 bg-blue-600 text-white rounded text-xs sm:text-sm hover:bg-blue-700 transition touch-manipulation"
          >
            En préparation
          </button>
          <button
            v-if="order.status === 'preparing'"
            @click="updateStatus(order.id, 'ready')"
            class="px-3 py-2 bg-purple-600 text-white rounded text-xs sm:text-sm hover:bg-purple-700 transition touch-manipulation"
          >
            Prête
          </button>
          <button
            v-if="order.status === 'ready'"
            @click="updateStatus(order.id, 'delivered')"
            class="px-3 py-2 bg-green-600 text-white rounded text-xs sm:text-sm hover:bg-green-700 transition touch-manipulation"
          >
            Livrée
          </button>
          <button
            @click="viewOrder(order.id)"
            class="px-3 py-2 bg-gray-600 text-white rounded text-xs sm:text-sm hover:bg-gray-700 transition touch-manipulation"
          >
            Détails
          </button>
        </div>
      </div>
    </div>

    <!-- Empty State -->
    <div
      v-if="!filteredOrders.length"
      class="text-center py-12 sm:py-16"
    >
      <svg class="w-16 h-16 sm:w-20 sm:h-20 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
      </svg>
      <p class="text-gray-600 text-sm sm:text-base">Aucune commande</p>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { formatCurrency } from '../../utils/currency';
import axios from 'axios';

const selectedStatus = ref('all');
const orders = ref([]);

const filteredOrders = computed(() => {
  if (selectedStatus.value === 'all') return orders.value;
  return orders.value.filter(o => o.status === selectedStatus.value);
});

const getStatusBadgeClass = (status) => {
  const classes = {
    pending: 'bg-yellow-100 text-yellow-800',
    confirmed: 'bg-blue-100 text-blue-800',
    preparing: 'bg-purple-100 text-purple-800',
    ready: 'bg-green-100 text-green-800',
    delivered: 'bg-gray-100 text-gray-800',
  };
  return classes[status] || 'bg-gray-100 text-gray-800';
};

const getStatusLabel = (status) => {
  const labels = {
    pending: 'En attente',
    confirmed: 'Confirmée',
    preparing: 'En préparation',
    ready: 'Prête',
    delivered: 'Livrée',
  };
  return labels[status] || status;
};

const updateStatus = async (orderId, newStatus) => {
  try {
    await axios.patch(`/api/orders/${orderId}/status`, { status: newStatus });
    
    // Mettre à jour localement
    const index = orders.value.findIndex(o => o.id === orderId);
    if (index !== -1) {
      orders.value[index].status = newStatus;
    }
  } catch (error) {
    console.error('Failed to update order status:', error);
    alert('Erreur lors de la mise à jour');
  }
};

const viewOrder = (orderId) => {
  // Ouvrir un modal avec les détails complets
  console.log('View order:', orderId);
};

onMounted(async () => {
  try {
    const response = await axios.get('/api/orders');
    orders.value = response.data.data;
  } catch (error) {
    console.error('Failed to load orders:', error);
  }
});
</script>

