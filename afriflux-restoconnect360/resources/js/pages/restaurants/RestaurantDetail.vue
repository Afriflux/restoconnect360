<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Loading State -->
    <div v-if="restaurantStore.loading" class="flex items-center justify-center min-h-screen">
      <div class="text-center">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-green-600 mx-auto"></div>
        <p class="mt-4 text-gray-600">Chargement du restaurant...</p>
      </div>
    </div>

    <!-- Error State -->
    <div v-else-if="restaurantStore.error" class="flex items-center justify-center min-h-screen">
      <div class="text-center">
        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
          </svg>
        </div>
        <h2 class="text-xl font-semibold text-gray-900 mb-2">Erreur de chargement</h2>
        <p class="text-gray-600 mb-4">{{ restaurantStore.error }}</p>
        <button @click="loadRestaurant" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
          Réessayer
        </button>
      </div>
    </div>

    <!-- Restaurant Content -->
    <div v-else-if="restaurant" class="max-w-7xl mx-auto px-4 py-8">
      <!-- Header Section -->
      <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
        <!-- Cover Image -->
        <div class="h-64 bg-gradient-to-r from-green-500 to-emerald-600 relative">
          <div class="absolute inset-0 bg-black bg-opacity-20"></div>
          <div class="absolute bottom-6 left-6 text-white">
            <h1 class="text-4xl font-bold mb-2">{{ restaurant.name }}</h1>
            <p class="text-lg opacity-90">{{ restaurant.description }}</p>
          </div>
        </div>

        <!-- Restaurant Info -->
        <div class="p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Address -->
            <div class="flex items-start space-x-3">
              <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
              </div>
              <div>
                <h3 class="font-semibold text-gray-900">Adresse</h3>
                <p class="text-sm text-gray-600">{{ restaurant.address }}</p>
                <p class="text-sm text-gray-500">{{ restaurant.city }}, {{ restaurant.country }}</p>
              </div>
            </div>

            <!-- Phone -->
            <div class="flex items-start space-x-3">
              <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
              </div>
              <div>
                <h3 class="font-semibold text-gray-900">Téléphone</h3>
                <p class="text-sm text-gray-600">{{ restaurant.phone }}</p>
                <p class="text-sm text-gray-500">{{ restaurant.email }}</p>
              </div>
            </div>

            <!-- Cuisine Type -->
            <div class="flex items-start space-x-3">
              <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
              </div>
              <div>
                <h3 class="font-semibold text-gray-900">Cuisine</h3>
                <p class="text-sm text-gray-600 capitalize">{{ restaurant.cuisine_type }}</p>
                <p class="text-sm text-gray-500 capitalize">{{ restaurant.category }}</p>
              </div>
            </div>

            <!-- Services -->
            <div class="flex items-start space-x-3">
              <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
              </div>
              <div>
                <h3 class="font-semibold text-gray-900">Services</h3>
                <div class="text-sm text-gray-600 space-y-1">
                  <div v-if="restaurant.accepts_delivery" class="flex items-center space-x-1">
                    <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                    <span>Livraison</span>
                  </div>
                  <div v-if="restaurant.accepts_takeaway" class="flex items-center space-x-1">
                    <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                    <span>À emporter</span>
                  </div>
                  <div v-if="restaurant.accepts_dine_in" class="flex items-center space-x-1">
                    <span class="w-2 h-2 bg-purple-500 rounded-full"></span>
                    <span>Sur place</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="flex flex-wrap gap-4 mb-8">
        <button class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors flex items-center space-x-2">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"/>
          </svg>
          <span>Commander</span>
        </button>
        
        <button class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
          </svg>
          <span>Appeler</span>
        </button>
        
        <button v-if="restaurant.has_whatsapp" class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 transition-colors flex items-center space-x-2">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
          </svg>
          <span>WhatsApp</span>
        </button>
      </div>

      <!-- Menu Section -->
      <div v-if="restaurant.menus && restaurant.menus.length > 0" class="bg-white rounded-2xl shadow-lg p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">🍽️ Menu</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div v-for="menu in restaurant.menus" :key="menu.id" class="border border-gray-200 rounded-lg p-4">
            <h3 class="font-semibold text-gray-900 mb-2">{{ menu.name }}</h3>
            <p class="text-sm text-gray-600 mb-3">{{ menu.description }}</p>
            <div class="text-sm text-gray-500">
              <span v-if="menu.is_active" class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                Actif
              </span>
              <span v-else class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                Inactif
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Categories Section -->
      <div v-if="restaurant.categories && restaurant.categories.length > 0" class="bg-white rounded-2xl shadow-lg p-6 mt-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">📂 Catégories</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
          <div v-for="category in restaurant.categories" :key="category.id" class="border border-gray-200 rounded-lg p-4">
            <h3 class="font-semibold text-gray-900 mb-2">{{ category.name }}</h3>
            <p class="text-sm text-gray-600">{{ category.description }}</p>
          </div>
        </div>
      </div>

      <!-- Delivery Zones -->
      <div v-if="restaurant.zones && restaurant.zones.length > 0" class="bg-white rounded-2xl shadow-lg p-6 mt-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">🚚 Zones de Livraison</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
          <div v-for="zone in restaurant.zones" :key="zone.id" class="border border-gray-200 rounded-lg p-4">
            <h3 class="font-semibold text-gray-900 mb-2">{{ zone.name }}</h3>
            <p class="text-sm text-gray-600 mb-2">{{ zone.description }}</p>
            <div class="text-sm text-gray-500">
              <p>Rayon: {{ zone.radius_km }}km</p>
              <p>Frais: {{ zone.delivery_fee }} FCFA</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- No Restaurant Found -->
    <div v-else class="flex items-center justify-center min-h-screen">
      <div class="text-center">
        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
          </svg>
        </div>
        <h2 class="text-xl font-semibold text-gray-900 mb-2">Restaurant introuvable</h2>
        <p class="text-gray-600 mb-4">Le restaurant demandé n'existe pas ou a été supprimé.</p>
        <router-link to="/restaurants" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
          Voir tous les restaurants
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import { useRestaurantStore } from '../../stores/restaurant';

const route = useRoute();
const restaurantStore = useRestaurantStore();
const restaurant = ref(null);

const loadRestaurant = async () => {
  try {
    restaurant.value = await restaurantStore.fetchRestaurant(route.params.id);
  } catch (error) {
    console.error('Error loading restaurant:', error);
  }
};

onMounted(() => {
  loadRestaurant();
});
</script>

