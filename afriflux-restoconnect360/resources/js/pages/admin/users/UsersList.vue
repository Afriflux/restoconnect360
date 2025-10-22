<template>
  <div class="p-6">
    <div class="mb-6">
      <h1 class="text-2xl font-bold text-gray-900">👥 Gestion des Utilisateurs</h1>
      <p class="text-gray-600 mt-2">Gérez tous les utilisateurs de la plateforme</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="p-2 bg-blue-100 rounded-lg">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Total Utilisateurs</p>
            <p class="text-2xl font-semibold text-gray-900">1,247</p>
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
            <p class="text-2xl font-semibold text-gray-900">1,156</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="p-2 bg-purple-100 rounded-lg">
            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Nouveaux (7j)</p>
            <p class="text-2xl font-semibold text-gray-900">23</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="p-2 bg-red-100 rounded-lg">
            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"/>
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Suspendus</p>
            <p class="text-2xl font-semibold text-gray-900">12</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow mb-6 p-6">
      <div class="flex flex-wrap gap-4">
        <select class="border border-gray-300 rounded-lg px-3 py-2">
          <option>Tous les rôles</option>
          <option>Super Admin</option>
          <option>Admin</option>
          <option>Restaurant Manager</option>
          <option>Agent</option>
          <option>Driver</option>
          <option>Employee</option>
        </select>
        <select class="border border-gray-300 rounded-lg px-3 py-2">
          <option>Tous les statuts</option>
          <option>Actif</option>
          <option>Inactif</option>
          <option>Suspendu</option>
        </select>
        <input type="text" placeholder="Rechercher un utilisateur..." class="border border-gray-300 rounded-lg px-3 py-2 flex-1 min-w-64">
        <ModernButton variant="primary" icon="plus" size="md">
          🔍 Rechercher
        </ModernButton>
      </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-lg shadow">
      <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex justify-between items-center">
          <h2 class="text-lg font-semibold text-gray-900">Liste des Utilisateurs</h2>
          <ModernButton variant="primary" icon="plus" size="md">
            ➕ Nouvel Utilisateur
          </ModernButton>
        </div>
      </div>

      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Utilisateur</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rôle</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Entreprise</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dernière Connexion</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="user in users" :key="user.id">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center">
                    <span class="text-white font-bold">{{ user.name.charAt(0) }}</span>
                  </div>
                  <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900">{{ user.name }}</div>
                    <div class="text-sm text-gray-500">{{ user.email }}</div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span :class="getRoleClass(user.role)" class="px-2 py-1 text-xs font-semibold rounded-full">
                  {{ user.role }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                {{ user.company }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span :class="getStatusClass(user.status)" class="px-2 py-1 text-xs font-semibold rounded-full">
                  {{ user.status }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ user.lastLogin }}
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

const users = ref([
  {
    id: 1,
    name: 'Super Admin',
    email: 'superadmin@restoconnect360.com',
    role: 'Super Admin',
    company: 'RestoConnect360',
    status: 'Actif',
    lastLogin: 'Il y a 2 heures'
  },
  {
    id: 2,
    name: 'Admin RestoConnect360',
    email: 'admin@restoconnect360.com',
    role: 'Admin',
    company: 'RestoConnect360',
    status: 'Actif',
    lastLogin: 'Il y a 1 heure'
  },
  {
    id: 3,
    name: 'Fatou Sall',
    email: 'restaurant@restoconnect360.com',
    role: 'Restaurant Manager',
    company: 'RestoConnect Group',
    status: 'Actif',
    lastLogin: 'Il y a 30 min'
  },
  {
    id: 4,
    name: 'Amadou Ndiaye',
    email: 'agent@restoconnect360.com',
    role: 'Agent',
    company: 'RestoConnect Group',
    status: 'Actif',
    lastLogin: 'Il y a 1 heure'
  },
  {
    id: 5,
    name: 'Livreur 1',
    email: 'driver1@restoconnect360.com',
    role: 'Driver',
    company: 'RestoConnect Group',
    status: 'Actif',
    lastLogin: 'Il y a 15 min'
  }
]);

const getRoleClass = (role) => {
  switch (role) {
    case 'Super Admin': return 'bg-purple-100 text-purple-800';
    case 'Admin': return 'bg-blue-100 text-blue-800';
    case 'Restaurant Manager': return 'bg-green-100 text-green-800';
    case 'Agent': return 'bg-yellow-100 text-yellow-800';
    case 'Driver': return 'bg-orange-100 text-orange-800';
    default: return 'bg-gray-100 text-gray-800';
  }
};

const getStatusClass = (status) => {
  switch (status) {
    case 'Actif': return 'bg-green-100 text-green-800';
    case 'Inactif': return 'bg-gray-100 text-gray-800';
    case 'Suspendu': return 'bg-red-100 text-red-800';
    default: return 'bg-gray-100 text-gray-800';
  }
};
</script>
