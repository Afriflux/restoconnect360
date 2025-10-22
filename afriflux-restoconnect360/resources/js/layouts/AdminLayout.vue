<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Top Navigation -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex items-center">
            <router-link to="/" class="flex items-center space-x-3">
              <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center">
                <span class="text-white text-xl font-bold">R</span>
              </div>
              <div>
                <div class="text-lg font-bold text-gray-900">RestoConnect360</div>
                <div class="text-xs text-gray-500">{{ roleLabel }}</div>
              </div>
            </router-link>
          </div>
          
          <!-- User Menu -->
          <div class="flex items-center space-x-4">
            <!-- Notifications -->
            <button class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
              </svg>
              <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>

            <!-- User Dropdown -->
            <div class="relative group">
              <button class="flex items-center space-x-3 p-2 hover:bg-gray-100 rounded-lg">
                <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center">
                  <span class="text-white text-sm font-semibold">{{ userInitials }}</span>
                </div>
                <div class="hidden md:block text-left">
                  <div class="text-sm font-semibold text-gray-900">{{ userName }}</div>
                  <div class="text-xs text-gray-500">{{ userEmail }}</div>
                </div>
                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
              </button>
              
              <!-- Dropdown Menu -->
              <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 border border-gray-100 z-50">
                <router-link to="/profile" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 rounded-t-xl">
                  👤 Mon profil
                </router-link>
                <router-link to="/settings" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50">
                  ⚙️ Paramètres
                </router-link>
                <hr class="my-1">
                <button @click="logout" class="w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 rounded-b-xl">
                  🚪 Déconnexion
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <div class="flex">
      <!-- Sidebar -->
      <aside class="w-64 bg-white min-h-screen shadow-sm border-r border-gray-200">
        <nav class="p-4 space-y-2">
          <component :is="currentSidebar" />
        </nav>
      </aside>

      <!-- Main Content -->
      <main class="flex-1 p-6">
        <router-view />
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../stores/auth';

// Import des sidebars
import SuperAdminSidebar from '../components/admin/SuperAdminSidebar.vue';
import AdminSidebar from '../components/admin/AdminSidebar.vue';
import RestaurantManagerSidebar from '../components/admin/RestaurantManagerSidebar.vue';
import AgentSidebar from '../components/admin/AgentSidebar.vue';

const router = useRouter();
const authStore = useAuthStore();

const userName = computed(() => authStore.user?.name || 'Utilisateur');
const userEmail = computed(() => authStore.user?.email || '');
const userInitials = computed(() => {
  const name = userName.value;
  return name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);
});

const roleLabel = computed(() => {
  const role = authStore.user?.role;
  const labels = {
    'super_admin': 'Super Administrateur',
    'admin': 'Administrateur',
    'restaurant_manager': 'Gestionnaire Restaurant',
    'agent': 'Agent Commercial',
    'employee': 'Employé',
    'driver': 'Livreur',
  };
  return labels[role] || 'Dashboard';
});

// Déterminer quelle sidebar utiliser selon le rôle
const currentSidebar = computed(() => {
  const role = authStore.user?.role;
  switch (role) {
    case 'super_admin':
      return SuperAdminSidebar;
    case 'admin':
      return AdminSidebar;
    case 'restaurant_manager':
      return RestaurantManagerSidebar;
    case 'agent':
      return AgentSidebar;
    default:
      return AdminSidebar; // Fallback
  }
});

const logout = async () => {
  await authStore.logout();
  router.push({ name: 'login' });
};
</script>

