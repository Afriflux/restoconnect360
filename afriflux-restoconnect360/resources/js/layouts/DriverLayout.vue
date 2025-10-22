<template>
  <div class="h-screen bg-gray-100 flex flex-col overflow-hidden">
    <!-- Driver Header - Mobile First -->
    <header class="bg-green-600 text-white shadow-lg flex-shrink-0">
      <div class="px-3 sm:px-6 py-3 sm:py-4">
        <div class="flex items-center justify-between">
          <!-- Status -->
          <div class="flex items-center gap-2 sm:gap-3">
            <div
              class="w-3 h-3 rounded-full animate-pulse"
              :class="isOnline ? 'bg-green-300' : 'bg-red-300'"
            ></div>
            <div>
              <div class="text-xs opacity-75">Statut</div>
              <div class="font-bold text-sm sm:text-base">{{ isOnline ? 'En ligne' : 'Hors ligne' }}</div>
            </div>
          </div>

          <!-- Toggle Online/Offline -->
          <button
            @click="toggleOnlineStatus"
            class="px-4 sm:px-6 py-2 sm:py-3 rounded-lg font-semibold transition text-sm sm:text-base"
            :class="isOnline ? 'bg-red-600 hover:bg-red-700' : 'bg-green-700 hover:bg-green-800'"
          >
            {{ isOnline ? 'Se mettre hors ligne' : 'Se mettre en ligne' }}
          </button>

          <!-- User Menu -->
          <div class="flex items-center gap-2 sm:gap-4">
            <div class="hidden sm:block text-right">
              <div class="text-xs opacity-75">Livreur</div>
              <div class="font-semibold text-sm">{{ authStore.user?.name }}</div>
            </div>
            <button
              @click="logout"
              class="p-2 hover:bg-green-700 rounded-lg transition"
            >
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
              </svg>
            </button>
          </div>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 overflow-auto">
      <router-view></router-view>
    </main>

    <!-- Bottom Navigation - Mobile -->
    <nav class="sm:hidden bg-white border-t border-gray-200 flex-shrink-0">
      <div class="flex justify-around">
        <router-link
          to="/driver"
          class="flex-1 py-3 flex flex-col items-center gap-1 transition"
          :class="$route.name === 'driver-dashboard' ? 'text-green-600' : 'text-gray-600'"
        >
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
          </svg>
          <span class="text-xs font-semibold">Accueil</span>
        </router-link>
        <router-link
          to="/driver/deliveries"
          class="flex-1 py-3 flex flex-col items-center gap-1 transition"
          :class="$route.name === 'driver-deliveries' ? 'text-green-600' : 'text-gray-600'"
        >
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
          </svg>
          <span class="text-xs font-semibold">Livraisons</span>
        </router-link>
      </div>
    </nav>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../stores/auth';

const router = useRouter();
const authStore = useAuthStore();
const isOnline = ref(true);

const toggleOnlineStatus = () => {
  isOnline.value = !isOnline.value;
  // TODO: Envoyer le statut au backend
};

const logout = async () => {
  await authStore.logout();
  router.push({ name: 'login' });
};
</script>

