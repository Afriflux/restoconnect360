<template>
  <nav class="bg-white shadow-lg sticky top-0 z-50 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-20">
        <!-- Logo -->
        <router-link to="/" class="flex items-center space-x-3 group">
          <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg transform group-hover:scale-110 transition-transform">
            <span class="text-white text-2xl font-bold">R</span>
          </div>
          <div class="hidden sm:block">
            <div class="text-2xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
              RestoConnect360
            </div>
            <div class="text-xs text-gray-500 -mt-1">Votre solution de gestion</div>
          </div>
        </router-link>

        <!-- Desktop Menu -->
        <div class="hidden lg:flex items-center space-x-8">
          <router-link to="/" class="text-gray-700 hover:text-green-600 font-medium transition-colors">
            Accueil
          </router-link>
          <router-link to="/pricing" class="text-gray-700 hover:text-green-600 font-medium transition-colors">
            Tarifs
          </router-link>
          
          <!-- Dropdown Commerces -->
          <div class="relative group">
            <button class="text-gray-700 hover:text-green-600 font-medium transition-colors flex items-center gap-1">
              Commerces
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
              </svg>
            </button>
            <div class="absolute left-0 mt-2 w-56 bg-white rounded-xl shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 border border-gray-100">
              <router-link to="/restaurants" class="block px-4 py-3 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-t-xl transition-colors">
                🏪 Commerces
              </router-link>
              <router-link to="/find-store" class="block px-4 py-3 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-b-xl transition-colors">
                🔍 Trouver un commerce
              </router-link>
            </div>
          </div>
          
          <!-- Dropdown Modules -->
          <div class="relative group">
            <button class="text-gray-700 hover:text-green-600 font-medium transition-colors flex items-center gap-1">
              Modules
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
              </svg>
            </button>
            <div class="absolute left-0 mt-2 w-48 bg-white rounded-xl shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 border border-gray-100">
              <router-link to="/pos" class="block px-4 py-3 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-t-xl transition-colors">
                🛒 POS
              </router-link>
              <router-link to="/kiosk" class="block px-4 py-3 text-gray-700 hover:bg-green-50 hover:text-green-600 transition-colors">
                🖥️ Kiosque
              </router-link>
              <router-link to="/driver" class="block px-4 py-3 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-b-xl transition-colors">
                🚗 Livreur
              </router-link>
            </div>
          </div>
        </div>

        <!-- Auth Buttons -->
        <div class="flex items-center gap-3">
          <router-link
            to="/auth/login"
            class="hidden sm:block px-6 py-2.5 text-gray-700 hover:text-green-600 font-medium transition-colors"
          >
            Connexion
          </router-link>
          <router-link
            to="/auth/register"
            class="px-6 py-2.5 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-xl hover:from-green-700 hover:to-emerald-700 font-medium shadow-lg shadow-green-500/30 transform hover:scale-105 transition-all"
          >
            Démarrer
          </router-link>

          <!-- Mobile Menu Button -->
          <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 rounded-lg hover:bg-gray-100">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path v-if="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
              <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
        </div>
      </div>

      <!-- Mobile Menu -->
      <div v-if="mobileMenuOpen" class="lg:hidden py-4 border-t border-gray-100">
        <div class="space-y-3">
          <router-link to="/" class="block px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-lg">
            Accueil
          </router-link>
          <router-link to="/pricing" class="block px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-lg">
            💰 Tarifs
          </router-link>
          
          <!-- Section Commerces -->
          <div class="pl-2 border-l-2 border-green-500 space-y-2">
            <router-link to="/restaurants" class="block px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-lg">
              🏪 Commerces
            </router-link>
            <router-link to="/find-store" class="block px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-lg">
              🔍 Trouver un commerce
            </router-link>
          </div>
          
          <!-- Section Modules -->
          <div class="pl-2 border-l-2 border-green-500 space-y-2">
            <router-link to="/pos" class="block px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-lg">
              🛒 POS
            </router-link>
            <router-link to="/kiosk" class="block px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-lg">
              🖥️ Kiosque
            </router-link>
            <router-link to="/driver" class="block px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-lg">
              🚗 Livreur
            </router-link>
          </div>
          
          <router-link to="/auth/login" class="block px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-600 rounded-lg sm:hidden">
            Connexion
          </router-link>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { ref } from 'vue';

const mobileMenuOpen = ref(false);
</script>

