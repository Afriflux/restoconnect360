<template>
  <div class="p-3 sm:p-6 max-w-7xl mx-auto">
    <h2 class="text-xl sm:text-2xl font-bold mb-4 sm:mb-6">Toutes mes livraisons</h2>

    <!-- Filters -->
    <div class="flex gap-2 mb-4 overflow-x-auto pb-2">
      <button
        @click="filterStatus = 'all'"
        class="px-4 py-2 rounded-lg text-sm font-semibold whitespace-nowrap transition"
        :class="filterStatus === 'all' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
      >
        Toutes
      </button>
      <button
        @click="filterStatus = 'assigned'"
        class="px-4 py-2 rounded-lg text-sm font-semibold whitespace-nowrap transition"
        :class="filterStatus === 'assigned' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
      >
        Assignées
      </button>
      <button
        @click="filterStatus = 'in_transit'"
        class="px-4 py-2 rounded-lg text-sm font-semibold whitespace-nowrap transition"
        :class="filterStatus === 'in_transit' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
      >
        En cours
      </button>
      <button
        @click="filterStatus = 'delivered'"
        class="px-4 py-2 rounded-lg text-sm font-semibold whitespace-nowrap transition"
        :class="filterStatus === 'delivered' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
      >
        Livrées
      </button>
    </div>

    <!-- Deliveries List -->
    <div class="space-y-3">
      <div
        v-for="delivery in filteredDeliveries"
        :key="delivery.id"
        class="bg-white rounded-lg shadow-md p-4"
      >
        <div class="flex justify-between items-start mb-3">
          <div>
            <div class="font-bold text-lg">Livraison #{{ delivery.id }}</div>
            <div class="text-sm text-gray-600">{{ formatDateTime(delivery.created_at) }}</div>
          </div>
          <span
            class="px-3 py-1 rounded-full text-xs font-semibold"
            :class="getStatusClass(delivery.status)"
          >
            {{ getStatusLabel(delivery.status) }}
          </span>
        </div>

        <div class="space-y-2 text-sm mb-3">
          <div>
            <span class="text-gray-600">Restaurant:</span>
            <span class="font-semibold ml-2">{{ delivery.order.restaurant.name }}</span>
          </div>
          <div>
            <span class="text-gray-600">Client:</span>
            <span class="font-semibold ml-2">{{ delivery.order.customer_name }}</span>
          </div>
          <div>
            <span class="text-gray-600">Distance:</span>
            <span class="font-semibold ml-2">{{ delivery.distance }} km</span>
          </div>
          <div>
            <span class="text-gray-600">Frais:</span>
            <span class="font-semibold ml-2 text-green-600">{{ formatCurrency(delivery.delivery_fee) }}</span>
          </div>
        </div>

        <div class="flex gap-2">
          <router-link
            :to="{ name: 'driver-tracking', params: { id: delivery.id } }"
            class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-center font-semibold text-sm"
          >
            Voir détails
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useDeliveryStore } from '../../stores/delivery';
import { formatCurrency } from '../../utils/currency';
import { formatDateTime } from '../../utils/date';

const deliveryStore = useDeliveryStore();
const filterStatus = ref('all');

const filteredDeliveries = computed(() => {
  if (filterStatus.value === 'all') {
    return deliveryStore.deliveries;
  }
  return deliveryStore.deliveries.filter(d => d.status === filterStatus.value);
});

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
    in_transit: 'En livraison',
    delivered: 'Livrée',
  };
  return labels[status] || status;
};

onMounted(() => {
  deliveryStore.fetchDeliveries();
});
</script>

