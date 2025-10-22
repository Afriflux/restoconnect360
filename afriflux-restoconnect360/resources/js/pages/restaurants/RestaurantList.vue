<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-green-600 to-emerald-600 py-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
          <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4 animate-fade-in-up">
            🍽️ Nos Commerces
          </h1>
          <p class="text-xl text-green-100 mb-8 animate-fade-in-up animation-delay-200">
            Découvrez tous nos partenaires organisés par catégorie
          </p>
          
          <!-- Search Bar -->
          <div class="max-w-md mx-auto animate-fade-in-up animation-delay-400">
            <div class="relative">
              <input 
                v-model="searchQuery"
                type="text" 
                placeholder="Rechercher un commerce..."
                class="w-full px-4 py-3 pl-12 pr-4 bg-white rounded-xl shadow-lg focus:ring-4 focus:ring-green-300 focus:outline-none transition-all duration-300"
              >
              <svg class="w-5 h-5 text-gray-400 absolute left-4 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
              </svg>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Categories Filter -->
    <div class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-10">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex flex-wrap gap-3 justify-center">
          <button 
            @click="selectedCategory = 'all'"
            :class="selectedCategory === 'all' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
            class="px-4 py-2 rounded-lg font-medium transition-all duration-300 transform hover:scale-105"
          >
            Tous ({{ totalRestaurants }})
          </button>
          <button 
            v-for="category in categories" 
            :key="category.key"
            @click="selectedCategory = category.key"
            :class="selectedCategory === category.key ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
            class="px-4 py-2 rounded-lg font-medium transition-all duration-300 transform hover:scale-105"
          >
            {{ category.icon }} {{ category.label }} ({{ category.count }})
          </button>
        </div>
      </div>
    </div>

    <!-- Loading State -->
    <div v-if="restaurantStore.loading" class="flex items-center justify-center py-16">
      <div class="text-center">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-green-600 mx-auto mb-4"></div>
        <p class="text-gray-600">Chargement des commerces...</p>
      </div>
    </div>

    <!-- Restaurants by Category -->
    <div v-else class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- All Categories View -->
      <div v-if="selectedCategory === 'all'">
        <div v-for="category in categoriesWithRestaurants" :key="category.key" class="mb-12">
          <div class="flex items-center mb-6 animate-fade-in-up">
            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center mr-4">
              <span class="text-2xl">{{ category.icon }}</span>
            </div>
            <div>
              <h2 class="text-2xl font-bold text-gray-900">{{ category.label }}</h2>
              <p class="text-gray-600">{{ category.count }} commerce{{ category.count > 1 ? 's' : '' }}</p>
            </div>
          </div>
          
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <div 
              v-for="(restaurant, index) in category.restaurants" 
              :key="restaurant.id"
              @click="viewRestaurant(restaurant.id)"
              class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 cursor-pointer overflow-hidden border border-gray-100 hover:border-green-200 transform hover:-translate-y-2 animate-stagger"
              :style="{ animationDelay: `${index * 100}ms` }"
            >
              <!-- Restaurant Image -->
              <div class="h-48 bg-gradient-to-br from-green-400 to-emerald-500 relative overflow-hidden">
                <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                <div class="absolute top-4 right-4">
                  <span class="bg-white bg-opacity-90 text-gray-800 px-2 py-1 rounded-full text-xs font-semibold">
                    {{ restaurant.category }}
                  </span>
                </div>
                <div class="absolute bottom-4 left-4 text-white">
                  <h3 class="text-xl font-bold">{{ restaurant.name }}</h3>
                  <p class="text-sm opacity-90">{{ restaurant.cuisine_type }}</p>
                </div>
              </div>
              
              <!-- Restaurant Info -->
              <div class="p-6">
                <div class="flex items-center justify-between mb-3">
                  <div class="flex items-center">
                    <svg class="w-4 h-4 text-yellow-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <span class="text-sm font-semibold text-gray-700">{{ restaurant.rating || 'Nouveau' }}</span>
                  </div>
                  <div class="text-sm text-gray-500">
                    {{ restaurant.city }}
                  </div>
                </div>
                
                <div class="flex items-center justify-between text-sm text-gray-600 mb-4">
                  <div class="flex items-center">
                    <svg class="w-4 h-4 text-green-600 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>{{ restaurant.delivery_radius_km }}km</span>
                  </div>
                  <div class="flex items-center">
                    <svg class="w-4 h-4 text-blue-600 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ restaurant.delivery_fee }} FCFA</span>
                  </div>
                </div>
                
                <!-- Services -->
                <div class="flex flex-wrap gap-2">
                  <span v-if="restaurant.accepts_delivery" class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    🚚 Livraison
                  </span>
                  <span v-if="restaurant.accepts_takeaway" class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    📦 À emporter
                  </span>
                  <span v-if="restaurant.accepts_dine_in" class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                    🍽️ Sur place
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Single Category View -->
      <div v-else>
        <div class="flex items-center mb-8 animate-fade-in-up">
          <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mr-6">
            <span class="text-3xl">{{ getCategoryIcon(selectedCategory) }}</span>
          </div>
          <div>
            <h2 class="text-3xl font-bold text-gray-900">{{ getCategoryLabel(selectedCategory) }}</h2>
            <p class="text-gray-600">{{ getFilteredRestaurants.length }} commerce{{ getFilteredRestaurants.length > 1 ? 's' : '' }}</p>
          </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
          <div 
            v-for="(restaurant, index) in getFilteredRestaurants" 
            :key="restaurant.id"
            @click="viewRestaurant(restaurant.id)"
            class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 cursor-pointer overflow-hidden border border-gray-100 hover:border-green-200 transform hover:-translate-y-2 animate-stagger"
            :style="{ animationDelay: `${index * 100}ms` }"
          >
            <!-- Restaurant Image -->
            <div class="h-48 bg-gradient-to-br from-green-400 to-emerald-500 relative overflow-hidden">
              <div class="absolute inset-0 bg-black bg-opacity-20"></div>
              <div class="absolute top-4 right-4">
                <span class="bg-white bg-opacity-90 text-gray-800 px-2 py-1 rounded-full text-xs font-semibold">
                  {{ restaurant.category }}
                </span>
              </div>
              <div class="absolute bottom-4 left-4 text-white">
                <h3 class="text-xl font-bold">{{ restaurant.name }}</h3>
                <p class="text-sm opacity-90">{{ restaurant.cuisine_type }}</p>
              </div>
            </div>
            
            <!-- Restaurant Info -->
            <div class="p-6">
              <div class="flex items-center justify-between mb-3">
                <div class="flex items-center">
                  <svg class="w-4 h-4 text-yellow-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                  </svg>
                  <span class="text-sm font-semibold text-gray-700">{{ restaurant.rating || 'Nouveau' }}</span>
                </div>
                <div class="text-sm text-gray-500">
                  {{ restaurant.city }}
                </div>
              </div>
              
              <div class="flex items-center justify-between text-sm text-gray-600 mb-4">
                <div class="flex items-center">
                  <svg class="w-4 h-4 text-green-600 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                  </svg>
                  <span>{{ restaurant.delivery_radius_km }}km</span>
                </div>
                <div class="flex items-center">
                  <svg class="w-4 h-4 text-blue-600 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                  </svg>
                  <span>{{ restaurant.delivery_fee }} FCFA</span>
                </div>
              </div>
              
              <!-- Services -->
              <div class="flex flex-wrap gap-2">
                <span v-if="restaurant.accepts_delivery" class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                  🚚 Livraison
                </span>
                <span v-if="restaurant.accepts_takeaway" class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                  📦 À emporter
                </span>
                <span v-if="restaurant.accepts_dine_in" class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                  🍽️ Sur place
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- No Results -->
      <div v-if="getFilteredRestaurants.length === 0 && !restaurantStore.loading" class="text-center py-16">
        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
          <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
          </svg>
        </div>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucun commerce trouvé</h3>
        <p class="text-gray-600 mb-6">Essayez de modifier votre recherche ou votre filtre</p>
        <button 
          @click="clearFilters"
          class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors"
        >
          Réinitialiser les filtres
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useRestaurantStore } from '../../stores/restaurant';

const router = useRouter();
const restaurantStore = useRestaurantStore();
const restaurants = ref([]);
const searchQuery = ref('');
const selectedCategory = ref('all');

const categories = [
  { key: 'restaurant', label: 'Restaurants', icon: '🍽️' },
  { key: 'cafe', label: 'Cafés', icon: '☕' },
  { key: 'bar', label: 'Bars', icon: '🍺' },
  { key: 'fast_food', label: 'Fast Food', icon: '🍔' },
  { key: 'boulangerie', label: 'Boulangeries', icon: '🥖' },
  { key: 'patisserie', label: 'Pâtisseries', icon: '🧁' },
  { key: 'food_truck', label: 'Food Trucks', icon: '🚚' },
];

const totalRestaurants = computed(() => restaurants.value.length);

const categoriesWithRestaurants = computed(() => {
  return categories.map(category => ({
    ...category,
    restaurants: restaurants.value.filter(r => r.category === category.key),
    count: restaurants.value.filter(r => r.category === category.key).length
  })).filter(category => category.count > 0);
});

const getFilteredRestaurants = computed(() => {
  let filtered = restaurants.value;
  
  // Filter by category
  if (selectedCategory.value !== 'all') {
    filtered = filtered.filter(r => r.category === selectedCategory.value);
  }
  
  // Filter by search query
  if (searchQuery.value) {
    const query = searchQuery.value.toLowerCase();
    filtered = filtered.filter(r => 
      r.name.toLowerCase().includes(query) ||
      r.cuisine_type.toLowerCase().includes(query) ||
      r.city.toLowerCase().includes(query) ||
      r.description?.toLowerCase().includes(query)
    );
  }
  
  return filtered;
});

const getCategoryIcon = (categoryKey) => {
  const category = categories.find(c => c.key === categoryKey);
  return category ? category.icon : '🍽️';
};

const getCategoryLabel = (categoryKey) => {
  const category = categories.find(c => c.key === categoryKey);
  return category ? category.label : 'Commerces';
};

const clearFilters = () => {
  searchQuery.value = '';
  selectedCategory.value = 'all';
};

const viewRestaurant = (id) => router.push({ name: 'restaurant-detail', params: { id } });

onMounted(async () => {
  await restaurantStore.fetchRestaurants();
  restaurants.value = restaurantStore.restaurants;
});
</script>

<style scoped>
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes stagger {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fade-in-up {
  animation: fadeInUp 0.8s ease-out forwards;
  opacity: 0;
}

.animate-stagger {
  animation: stagger 0.6s ease-out forwards;
  opacity: 0;
}

.animation-delay-200 {
  animation-delay: 0.2s;
}

.animation-delay-400 {
  animation-delay: 0.4s;
}

/* Responsive animations */
@media (prefers-reduced-motion: reduce) {
  .animate-fade-in-up,
  .animate-stagger {
    animation: none;
  }
}

/* Hover effects */
.group:hover {
  transform: translateY(-8px);
}

/* Smooth transitions */
.transition-all {
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
</style>

