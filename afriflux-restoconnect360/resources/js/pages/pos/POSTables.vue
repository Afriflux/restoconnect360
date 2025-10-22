<template>
  <div class="h-full p-2 sm:p-4 lg:p-6">
    <!-- Header -->
    <div class="mb-4 sm:mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
      <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900">Gestion des Tables</h2>
      <div class="flex gap-2 w-full sm:w-auto">
        <select
          v-model="selectedZone"
          class="px-3 py-2 border rounded-lg text-sm text-gray-900 flex-1 sm:flex-none focus:ring-2 focus:ring-primary-500"
        >
          <option :value="null">Toutes les zones</option>
          <option v-for="zone in zones" :key="zone.id" :value="zone.id">
            {{ zone.name }}
          </option>
        </select>
      </div>
    </div>

    <!-- Tables Grid - Responsive -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3 sm:gap-4 lg:gap-6">
      <button
        v-for="table in filteredTables"
        :key="table.id"
        @click="selectTable(table)"
        class="aspect-square rounded-lg p-3 sm:p-4 flex flex-col items-center justify-center transition touch-manipulation active:scale-95"
        :class="getTableClass(table.status)"
      >
        <!-- Icon -->
        <svg class="w-8 h-8 sm:w-12 sm:h-12 lg:w-16 lg:h-16 mb-2" fill="currentColor" viewBox="0 0 20 20">
          <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
        </svg>
        
        <!-- Table Number -->
        <div class="text-lg sm:text-xl lg:text-2xl font-bold">{{ table.number }}</div>
        
        <!-- Capacity -->
        <div class="text-xs sm:text-sm opacity-75 mt-1">{{ table.capacity }} pers.</div>
        
        <!-- Status -->
        <div class="mt-2 text-[10px] sm:text-xs font-semibold uppercase">
          {{ getTableStatusLabel(table.status) }}
        </div>
      </button>
    </div>

    <!-- Table Modal -->
    <teleport to="body">
      <div
        v-if="selectedTableData"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
        @click.self="selectedTableData = null"
      >
        <div class="bg-white rounded-lg p-4 sm:p-6 w-full max-w-lg max-h-[90vh] overflow-y-auto">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl sm:text-2xl font-bold text-gray-900">Table {{ selectedTableData.number }}</h3>
            <button
              @click="selectedTableData = null"
              class="text-gray-500 hover:text-gray-700"
            >
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>

          <div class="space-y-3 sm:space-y-4">
            <div>
              <label class="block text-sm font-semibold mb-1 text-gray-900">Statut</label>
              <div class="text-lg" :class="getStatusColor(selectedTableData.status)">
                {{ getTableStatusLabel(selectedTableData.status) }}
              </div>
            </div>

            <div>
              <label class="block text-sm font-semibold mb-1 text-gray-900">Capacité</label>
              <div class="text-gray-900">{{ selectedTableData.capacity }} personnes</div>
            </div>

            <div>
              <label class="block text-sm font-semibold mb-1 text-gray-900">Zone</label>
              <div class="text-gray-900">{{ getZoneName(selectedTableData.zone_id) }}</div>
            </div>

            <div class="pt-4 space-y-2">
              <button
                v-if="selectedTableData.status === 'available'"
                @click="updateTableStatus('occupied')"
                class="w-full p-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition touch-manipulation"
              >
                Marquer comme Occupée
              </button>
              
              <button
                v-if="selectedTableData.status === 'occupied'"
                @click="updateTableStatus('available')"
                class="w-full p-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition touch-manipulation"
              >
                Libérer la Table
              </button>
              
              <button
                v-if="selectedTableData.status === 'available'"
                @click="updateTableStatus('reserved')"
                class="w-full p-3 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition touch-manipulation"
              >
                Réserver
              </button>
              
              <button
                @click="createOrderForTable"
                class="w-full p-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition touch-manipulation"
              >
                Nouvelle Commande
              </button>
            </div>
          </div>
        </div>
      </div>
    </teleport>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

const router = useRouter();
const selectedZone = ref(null);
const zones = ref([]);
const tables = ref([]);
const selectedTableData = ref(null);

const filteredTables = computed(() => {
  if (!selectedZone.value) return tables.value;
  return tables.value.filter(t => t.zone_id === selectedZone.value);
});

const getTableClass = (status) => {
  switch (status) {
    case 'available':
      return 'bg-green-100 text-green-800 hover:bg-green-200 border-2 border-green-300';
    case 'occupied':
      return 'bg-red-100 text-red-800 hover:bg-red-200 border-2 border-red-300';
    case 'reserved':
      return 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200 border-2 border-yellow-300';
    default:
      return 'bg-gray-100 text-gray-800 hover:bg-gray-200 border-2 border-gray-300';
  }
};

const getStatusColor = (status) => {
  switch (status) {
    case 'available':
      return 'text-green-600 font-semibold';
    case 'occupied':
      return 'text-red-600 font-semibold';
    case 'reserved':
      return 'text-yellow-600 font-semibold';
    default:
      return 'text-gray-600';
  }
};

const getTableStatusLabel = (status) => {
  const labels = {
    available: 'Disponible',
    occupied: 'Occupée',
    reserved: 'Réservée',
  };
  return labels[status] || status;
};

const getZoneName = (zoneId) => {
  const zone = zones.value.find(z => z.id === zoneId);
  return zone?.name || 'N/A';
};

const selectTable = (table) => {
  selectedTableData.value = table;
};

const updateTableStatus = async (newStatus) => {
  try {
    await axios.patch(`/api/tables/${selectedTableData.value.id}/status`, {
      status: newStatus,
    });
    
    // Mettre à jour localement
    const index = tables.value.findIndex(t => t.id === selectedTableData.value.id);
    if (index !== -1) {
      tables.value[index].status = newStatus;
      selectedTableData.value.status = newStatus;
    }
  } catch (error) {
    console.error('Failed to update table status:', error);
    alert('Erreur lors de la mise à jour');
  }
};

const createOrderForTable = () => {
  // Rediriger vers POS Dashboard avec la table sélectionnée
  router.push({
    name: 'pos-dashboard',
    query: { table_id: selectedTableData.value.id },
  });
  selectedTableData.value = null;
};

onMounted(async () => {
  try {
    const [zonesRes, tablesRes] = await Promise.all([
      axios.get('/api/zones'),
      axios.get('/api/tables'),
    ]);
    zones.value = zonesRes.data.data;
    tables.value = tablesRes.data.data;
  } catch (error) {
    console.error('Failed to load data:', error);
  }
});
</script>

