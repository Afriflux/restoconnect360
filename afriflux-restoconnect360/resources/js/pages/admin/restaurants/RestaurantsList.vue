<template>
  <div class="p-6">
    <div class="mb-6">
      <h1 class="text-2xl font-bold text-gray-900">🏪 Gestion des Commerces</h1>
      <p class="text-gray-600 mt-2">Gérez tous les commerces de la plateforme</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="p-2 bg-blue-100 rounded-lg">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Total Commerces</p>
            <p class="text-2xl font-semibold text-gray-900">4</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="p-2 bg-green-100 rounded-lg">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Actifs</p>
            <p class="text-2xl font-semibold text-gray-900">2</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="p-2 bg-yellow-100 rounded-lg">
            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">En Attente</p>
            <p class="text-2xl font-semibold text-gray-900">1</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="p-2 bg-red-100 rounded-lg">
            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Suspendus</p>
            <p class="text-2xl font-semibold text-gray-900">1</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow mb-6 p-6">
      <div class="flex flex-wrap gap-4">
        <select class="border border-gray-300 rounded-lg px-3 py-2">
          <option>Tous les types</option>
          <option>Restaurant</option>
          <option>Fast Food</option>
          <option>Café</option>
          <option>Boulangerie</option>
        </select>
        <select class="border border-gray-300 rounded-lg px-3 py-2">
          <option>Tous les statuts</option>
          <option>Actif</option>
          <option>En Attente</option>
          <option>Suspendu</option>
        </select>
        <input type="text" placeholder="Rechercher un commerce..." class="border border-gray-300 rounded-lg px-3 py-2 flex-1 min-w-64">
        <ModernButton variant="primary" icon="plus" size="md">
          🔍 Rechercher
        </ModernButton>
      </div>
    </div>

    <!-- Restaurants Table -->
    <div class="bg-white rounded-lg shadow">
      <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex justify-between items-center">
          <h2 class="text-lg font-semibold text-gray-900">Liste des Commerces</h2>
          <ModernButton variant="primary" icon="plus" size="md">
            ➕ Nouveau Commerce
          </ModernButton>
        </div>
      </div>

      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Commerce</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Adresse</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Commandes</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="restaurant in restaurants" :key="restaurant.id">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg flex items-center justify-center">
                    <span class="text-white font-bold text-lg">{{ restaurant.name.charAt(0) }}</span>
                  </div>
                  <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900">{{ restaurant.name }}</div>
                    <div class="text-sm text-gray-500">{{ restaurant.manager }}</div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                  {{ restaurant.type }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">{{ restaurant.address }}</div>
                <div class="text-sm text-gray-500">{{ restaurant.city }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span :class="getStatusClass(restaurant.status)" class="px-2 py-1 text-xs font-semibold rounded-full">
                  {{ restaurant.status }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                {{ restaurant.orders }} commandes
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <ModernButton variant="success" icon="edit" size="sm">Modifier</ModernButton>
                <ModernButton variant="info" icon="view" size="sm">Voir</ModernButton>
                <ModernButton variant="danger" icon="delete" size="sm">Suspendre</ModernButton>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import ModernButton from '@/components/ui/ModernButton.vue';

const restaurants = ref([
  {
    id: 1,
    name: 'Le Teranga',
    type: 'Restaurant',
    manager: 'Fatou Sall',
    address: 'Rue 10, Plateau, Dakar',
    city: 'Dakar',
    status: 'Actif',
    orders: 156
  },
  {
    id: 2,
    name: 'Café des Arts',
    type: 'Café',
    manager: 'Fatou Sall',
    address: 'Avenue Georges Pompidou, Dakar',
    city: 'Dakar',
    status: 'Actif',
    orders: 89
  },
  {
    id: 3,
    name: 'Fast Food Lagon',
    type: 'Fast Food',
    manager: 'Fatou Sall',
    address: 'Rond-point Lagon, Dakar',
    city: 'Dakar',
    status: 'En Attente',
    orders: 23
  },
  {
    id: 4,
    name: 'Le Dakarois Gourmand',
    type: 'Restaurant',
    manager: 'Fatou Sall',
    address: 'Corniche Ouest, Dakar',
    city: 'Dakar',
    status: 'Suspendu',
    orders: 12
  }
]);

const getStatusClass = (status) => {
  switch (status) {
    case 'Actif': return 'bg-green-100 text-green-800';
    case 'En Attente': return 'bg-yellow-100 text-yellow-800';
    case 'Suspendu': return 'bg-red-100 text-red-800';
    default: return 'bg-gray-100 text-gray-800';
  }
};
</script>
