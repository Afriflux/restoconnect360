<template>
  <div class="h-screen bg-gray-100 flex flex-col overflow-hidden">
    <!-- POS Header - Compact sur mobile, complet sur desktop -->
    <header class="bg-primary-600 text-white shadow-lg flex-shrink-0">
      <div class="px-2 sm:px-4 lg:px-6 py-2 sm:py-3">
        <div class="flex items-center justify-between">
          <!-- Logo + Restaurant -->
          <div class="flex items-center space-x-2 sm:space-x-4 text-white">
            <h1 class="text-lg sm:text-xl lg:text-2xl font-bold truncate text-white">
              POS
            </h1>
            <span class="hidden sm:inline text-xs sm:text-sm opacity-80 truncate text-white">
              {{ currentRestaurant?.name || 'RestoConnect360' }}
            </span>
          </div>

          <!-- Navigation - Responsive -->
          <nav class="flex items-center space-x-1 sm:space-x-2 lg:space-x-4">
            <router-link
              to="/pos"
              class="px-2 sm:px-3 lg:px-4 py-1 sm:py-2 rounded text-xs sm:text-sm lg:text-base text-white hover:bg-primary-700 transition nav-link"
              :class="{ 'bg-primary-700': $route.name === 'pos-dashboard' }"
            >
              <span class="hidden sm:inline text-white">{{ $t('pos.dashboard') || 'Tableau de bord' }}</span>
              <svg class="w-5 h-5 sm:hidden text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
              </svg>
            </router-link>
            <router-link
              to="/pos/tables"
              class="px-2 sm:px-3 lg:px-4 py-1 sm:py-2 rounded text-xs sm:text-sm lg:text-base text-white hover:bg-primary-700 transition nav-link"
              :class="{ 'bg-primary-700': $route.name === 'pos-tables' }"
            >
              <span class="hidden sm:inline text-white">{{ $t('pos.tables') || 'Tables' }}</span>
              <svg class="w-5 h-5 sm:hidden text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
              </svg>
            </router-link>
            <router-link
              to="/pos/orders"
              class="px-2 sm:px-3 lg:px-4 py-1 sm:py-2 rounded text-xs sm:text-sm lg:text-base text-white hover:bg-primary-700 transition nav-link"
              :class="{ 'bg-primary-700': $route.name === 'pos-orders' }"
            >
              <span class="hidden sm:inline text-white">{{ $t('pos.orders') || 'Commandes' }}</span>
              <svg class="w-5 h-5 sm:hidden text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
              </svg>
            </router-link>
          </nav>

          <!-- User + Actions -->
          <div class="flex items-center space-x-2 sm:space-x-4 text-white">
            <span class="hidden lg:inline text-xs sm:text-sm text-white">{{ authStore.user?.name }}</span>
            <button @click="logout" class="p-1 sm:p-2 hover:bg-primary-700 rounded text-white">
              <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
              </svg>
            </button>
          </div>
        </div>
      </div>
    </header>

    <!-- Main Content - Flexible height -->
    <main class="flex-1 overflow-auto">
      <router-view></router-view>
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../stores/auth';

const router = useRouter();
const authStore = useAuthStore();
const currentRestaurant = ref(null);

onMounted(() => {
  // Charger les infos du restaurant
  if (authStore.user?.restaurant_id) {
    // Fetch restaurant info
  }
});

const logout = async () => {
  await authStore.logout();
  router.push({ name: 'login' });
};
</script>

<style scoped>
/* Empêcher le scroll sur mobile pour une expérience app */
@media (max-width: 640px) {
  body {
    overflow: hidden;
  }
}

/* S'assurer que le texte de l'en-tête est toujours blanc et lisible */
header {
  background-color: #5568d3 !important; /* primary-600 */
  color: #ffffff !important;
}

header *,
header h1,
header span,
header a,
header button,
header div {
  color: #ffffff !important;
}

header svg,
header svg * {
  stroke: #ffffff !important;
  fill: none !important;
}

/* Styles spécifiques pour les liens de navigation */
header .nav-link,
header .nav-link *,
header .nav-link span {
  color: #ffffff !important;
  text-decoration: none !important;
}

header a:hover,
header button:hover,
header .nav-link:hover {
  background-color: #4453b8 !important; /* primary-700 */
  color: #ffffff !important;
}

/* Forcer les liens actifs à être visibles */
header .router-link-active,
header .router-link-exact-active {
  background-color: #4453b8 !important;
  color: #ffffff !important;
}

/* S'assurer que le texte est toujours lisible dans le main content */
main {
  color: #111827; /* text-gray-900 */
}
</style>

