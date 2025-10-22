<template>
  <div class="store-finder">
    <!-- Header -->
    <div class="store-finder-header">
      <h2 class="text-2xl font-bold text-gray-800 mb-4">
        <i class="fas fa-map-marker-alt mr-2 text-blue-500"></i>
        Trouver un Magasin Près de Vous
      </h2>
      
      <!-- Location Permission Banner -->
      <div v-if="!geolocationStore.hasLocation" class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
        <div class="flex items-center">
          <i class="fas fa-info-circle text-blue-500 mr-3"></i>
          <div class="flex-1">
            <p class="text-blue-800 font-medium">Activez votre localisation pour trouver les magasins les plus proches</p>
            <p class="text-blue-600 text-sm mt-1">Nous utilisons votre position pour vous proposer les meilleures options</p>
          </div>
          <button 
            @click="requestLocation"
            :disabled="geolocationStore.isLocationLoading"
            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors disabled:opacity-50"
          >
            <i v-if="geolocationStore.isLocationLoading" class="fas fa-spinner fa-spin mr-2"></i>
            <i v-else class="fas fa-location-arrow mr-2"></i>
            {{ geolocationStore.isLocationLoading ? 'Localisation...' : 'Activer' }}
          </button>
        </div>
      </div>
    </div>

    <!-- Search Filters -->
    <div class="search-filters bg-white rounded-lg shadow-md p-6 mb-6">
      <h3 class="text-lg font-semibold text-gray-800 mb-4">Filtres de Recherche</h3>
      
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Search Radius -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Rayon de recherche</label>
          <select v-model="searchRadius" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <option value="5">5 km</option>
            <option value="10">10 km</option>
            <option value="15">15 km</option>
            <option value="20">20 km</option>
            <option value="30">30 km</option>
          </select>
        </div>

        <!-- Restaurant Type -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Type d'établissement</label>
          <select v-model="filters.restaurant_type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <option value="">Tous les types</option>
            <option value="restaurant">Restaurant</option>
            <option value="cafe">Café</option>
            <option value="bar">Bar</option>
            <option value="fast_food">Fast Food</option>
            <option value="bakery">Boulangerie</option>
          </select>
        </div>

        <!-- Cuisine Type -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Type de cuisine</label>
          <select v-model="filters.cuisine_type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <option value="">Toutes les cuisines</option>
            <option value="african">Africaine</option>
            <option value="european">Européenne</option>
            <option value="asian">Asiatique</option>
            <option value="american">Américaine</option>
            <option value="mediterranean">Méditerranéenne</option>
            <option value="local">Locale</option>
          </select>
        </div>

        <!-- Price Range -->
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Gamme de prix</label>
          <select v-model="filters.price_range" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <option value="">Toutes les gammes</option>
            <option value="$">€ - Économique</option>
            <option value="$$">€€ - Modéré</option>
            <option value="$$$">€€€ - Élevé</option>
            <option value="$$$$">€€€€ - Très élevé</option>
          </select>
        </div>
      </div>

      <!-- Additional Filters -->
      <div class="mt-4 flex flex-wrap gap-4">
        <label class="flex items-center">
          <input 
            type="checkbox" 
            v-model="filters.accepts_delivery"
            class="mr-2 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
          >
          <span class="text-sm text-gray-700">Livraison disponible</span>
        </label>
        
        <label class="flex items-center">
          <input 
            type="checkbox" 
            v-model="filters.accepts_pickup"
            class="mr-2 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
          >
          <span class="text-sm text-gray-700">À emporter</span>
        </label>
      </div>

      <!-- Search Button -->
      <div class="mt-6">
        <button 
          @click="searchStores"
          :disabled="!geolocationStore.hasLocation || isLoading"
          class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
        >
          <i v-if="isLoading" class="fas fa-spinner fa-spin mr-2"></i>
          <i v-else class="fas fa-search mr-2"></i>
          {{ isLoading ? 'Recherche...' : 'Rechercher' }}
        </button>
      </div>
    </div>

    <!-- Current Location Display -->
    <div v-if="geolocationStore.hasLocation" class="current-location bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
      <div class="flex items-center">
        <i class="fas fa-map-marker-alt text-green-500 mr-3"></i>
        <div class="flex-1">
          <p class="text-green-800 font-medium">Votre position actuelle</p>
          <p class="text-green-600 text-sm">{{ geolocationStore.currentLocation?.address?.address || 'Position détectée' }}</p>
        </div>
        <button 
          @click="refreshLocation"
          class="text-green-600 hover:text-green-800 transition-colors"
          title="Actualiser la position"
        >
          <i class="fas fa-sync-alt"></i>
        </button>
      </div>
    </div>

    <!-- Error Display -->
    <div v-if="geolocationStore.locationError" class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
      <div class="flex items-center">
        <i class="fas fa-exclamation-triangle text-red-500 mr-3"></i>
        <div>
          <p class="text-red-800 font-medium">Erreur de localisation</p>
          <p class="text-red-600 text-sm">{{ geolocationStore.locationError }}</p>
        </div>
      </div>
    </div>

    <!-- Results -->
    <div v-if="searchResults.length > 0" class="search-results">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-800">
          {{ searchResults.length }} magasin(s) trouvé(s)
        </h3>
        <div class="flex items-center space-x-2">
          <button 
            @click="toggleMapView"
            class="px-3 py-1 text-sm rounded-lg transition-colors"
            :class="showMapView ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'"
          >
            <i class="fas fa-map mr-1"></i>
            Carte
          </button>
          <button 
            @click="toggleMapView"
            class="px-3 py-1 text-sm rounded-lg transition-colors"
            :class="!showMapView ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'"
          >
            <i class="fas fa-list mr-1"></i>
            Liste
          </button>
        </div>
      </div>

      <!-- Map View -->
      <div v-if="showMapView" class="map-container mb-6">
        <div id="store-map" class="w-full h-96 bg-gray-200 rounded-lg flex items-center justify-center">
          <div class="text-center">
            <i class="fas fa-map-marked-alt text-4xl text-gray-400 mb-2"></i>
            <p class="text-gray-600">Carte interactive en cours de chargement...</p>
            <p class="text-sm text-gray-500 mt-1">Intégration Google Maps à venir</p>
          </div>
        </div>
      </div>

      <!-- List View -->
      <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div 
          v-for="restaurant in searchResults" 
          :key="restaurant.id"
          class="restaurant-card bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow cursor-pointer"
          @click="selectRestaurant(restaurant)"
        >
          <!-- Restaurant Image -->
          <div class="restaurant-image h-48 bg-gray-200 rounded-t-lg overflow-hidden">
            <img 
              v-if="restaurant.main_image" 
              :src="restaurant.main_image" 
              :alt="restaurant.name"
              class="w-full h-full object-cover"
            >
            <div v-else class="w-full h-full flex items-center justify-center">
              <i class="fas fa-utensils text-4xl text-gray-400"></i>
            </div>
            
            <!-- Distance Badge -->
            <div class="absolute top-2 right-2 bg-white bg-opacity-90 rounded-full px-2 py-1 text-xs font-medium">
              {{ calculateDistance(restaurant.latitude, restaurant.longitude).toFixed(1) }} km
            </div>
          </div>

          <!-- Restaurant Info -->
          <div class="p-4">
            <h4 class="font-semibold text-gray-800 mb-2">{{ restaurant.name }}</h4>
            
            <!-- Rating -->
            <div class="flex items-center mb-2">
              <div class="flex items-center">
                <i v-for="i in 5" :key="i" class="fas fa-star text-yellow-400 text-xs"></i>
              </div>
              <span class="ml-2 text-sm text-gray-600">{{ restaurant.rating }} ({{ restaurant.review_count }} avis)</span>
            </div>

            <!-- Type and Price -->
            <div class="flex items-center justify-between mb-2">
              <span class="text-sm text-gray-600 capitalize">{{ restaurant.type }}</span>
              <span class="text-sm font-medium text-gray-800">{{ restaurant.price_range }}</span>
            </div>

            <!-- Address -->
            <p class="text-sm text-gray-600 mb-3">{{ restaurant.full_address }}</p>

            <!-- Features -->
            <div class="flex flex-wrap gap-2">
              <span 
                v-if="restaurant.accepts_delivery" 
                class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full"
              >
                <i class="fas fa-truck mr-1"></i>
                Livraison
              </span>
              <span 
                v-if="restaurant.accepts_pickup" 
                class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full"
              >
                <i class="fas fa-shopping-bag mr-1"></i>
                À emporter
              </span>
              <span 
                v-if="restaurant.accepts_dine_in" 
                class="bg-purple-100 text-purple-800 text-xs px-2 py-1 rounded-full"
              >
                <i class="fas fa-chair mr-1"></i>
                Sur place
              </span>
            </div>

            <!-- Action Buttons -->
            <div class="mt-4 flex space-x-2">
              <button 
                @click.stop="viewMenu(restaurant)"
                class="flex-1 bg-blue-500 hover:bg-blue-600 text-white text-sm py-2 px-3 rounded-lg transition-colors"
              >
                <i class="fas fa-book mr-1"></i>
                Voir le menu
              </button>
              <button 
                @click.stop="getDirections(restaurant)"
                class="bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm py-2 px-3 rounded-lg transition-colors"
                title="Itinéraire"
              >
                <i class="fas fa-directions"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- No Results -->
    <div v-else-if="hasSearched && searchResults.length === 0" class="no-results text-center py-12">
      <i class="fas fa-search text-4xl text-gray-400 mb-4"></i>
      <h3 class="text-lg font-semibold text-gray-800 mb-2">Aucun magasin trouvé</h3>
      <p class="text-gray-600 mb-4">Essayez d'élargir votre recherche ou de modifier les filtres</p>
      <button 
        @click="clearFilters"
        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors"
      >
        Réinitialiser les filtres
      </button>
    </div>

    <!-- Recommendations -->
    <div v-if="geolocationStore.recommendations && !hasSearched" class="recommendations mt-8">
      <h3 class="text-lg font-semibold text-gray-800 mb-4">Recommandations pour vous</h3>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Popular Restaurants -->
        <div class="recommendation-section">
          <h4 class="font-medium text-gray-700 mb-3">Populaires près de vous</h4>
          <div class="space-y-3">
            <div 
              v-for="restaurant in geolocationStore.recommendations.popular_restaurants" 
              :key="restaurant.id"
              class="flex items-center p-3 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow cursor-pointer"
              @click="selectRestaurant(restaurant)"
            >
              <div class="w-12 h-12 bg-gray-200 rounded-lg mr-3 flex items-center justify-center">
                <i class="fas fa-utensils text-gray-400"></i>
              </div>
              <div class="flex-1">
                <p class="font-medium text-gray-800">{{ restaurant.name }}</p>
                <p class="text-sm text-gray-600">{{ calculateDistance(restaurant.latitude, restaurant.longitude).toFixed(1) }} km</p>
              </div>
              <div class="text-right">
                <div class="flex items-center">
                  <i class="fas fa-star text-yellow-400 text-xs mr-1"></i>
                  <span class="text-sm text-gray-600">{{ restaurant.rating }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Trending Restaurants -->
        <div class="recommendation-section">
          <h4 class="font-medium text-gray-700 mb-3">Tendance</h4>
          <div class="space-y-3">
            <div 
              v-for="restaurant in geolocationStore.recommendations.trending_restaurants" 
              :key="restaurant.id"
              class="flex items-center p-3 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow cursor-pointer"
              @click="selectRestaurant(restaurant)"
            >
              <div class="w-12 h-12 bg-gray-200 rounded-lg mr-3 flex items-center justify-center">
                <i class="fas fa-fire text-orange-400"></i>
              </div>
              <div class="flex-1">
                <p class="font-medium text-gray-800">{{ restaurant.name }}</p>
                <p class="text-sm text-gray-600">{{ restaurant.review_count }} avis</p>
              </div>
              <div class="text-right">
                <span class="text-xs bg-orange-100 text-orange-800 px-2 py-1 rounded-full">Tendance</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Nearby Companies -->
        <div class="recommendation-section">
          <h4 class="font-medium text-gray-700 mb-3">Entreprises locales</h4>
          <div class="space-y-3">
            <div 
              v-for="company in geolocationStore.recommendations.nearby_companies" 
              :key="company.id"
              class="flex items-center p-3 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow cursor-pointer"
              @click="viewCompany(company)"
            >
              <div class="w-12 h-12 bg-gray-200 rounded-lg mr-3 flex items-center justify-center">
                <i class="fas fa-building text-blue-400"></i>
              </div>
              <div class="flex-1">
                <p class="font-medium text-gray-800">{{ company.name }}</p>
                <p class="text-sm text-gray-600">{{ company.restaurants_count }} restaurant(s)</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue'
import { useGeolocationStore } from '@/stores/geolocation'

// Store
const geolocationStore = useGeolocationStore()

// State
const isLoading = ref(false)
const hasSearched = ref(false)
const showMapView = ref(false)
const searchResults = ref([])
const searchRadius = ref(10)

// Filters
const filters = ref({
  restaurant_type: '',
  cuisine_type: '',
  price_range: '',
  accepts_delivery: false,
  accepts_pickup: false
})

// Computed
const filteredFilters = computed(() => {
  const filtered = {}
  Object.keys(filters.value).forEach(key => {
    if (filters.value[key] !== '' && filters.value[key] !== false) {
      filtered[key] = filters.value[key]
    }
  })
  return filtered
})

// Methods
const requestLocation = async () => {
  await geolocationStore.requestLocationPermission()
  if (geolocationStore.hasLocation) {
    await loadRecommendations()
  }
}

const refreshLocation = async () => {
  await requestLocation()
}

const searchStores = async () => {
  if (!geolocationStore.hasLocation) {
    await requestLocation()
    if (!geolocationStore.hasLocation) return
  }

  try {
    isLoading.value = true
    const results = await geolocationStore.findNearbyRestaurants({
      ...filteredFilters.value,
      radius: searchRadius.value
    })
    searchResults.value = results
    hasSearched.value = true
  } catch (error) {
    console.error('Search failed:', error)
  } finally {
    isLoading.value = false
  }
}

const loadRecommendations = async () => {
  try {
    await geolocationStore.getRecommendations()
  } catch (error) {
    console.error('Failed to load recommendations:', error)
  }
}

const calculateDistance = (lat, lon) => {
  if (!geolocationStore.currentLocation) return 0
  
  return geolocationStore.calculateDistance(
    geolocationStore.currentLocation.latitude,
    geolocationStore.currentLocation.longitude,
    lat,
    lon
  )
}

const selectRestaurant = (restaurant) => {
  // Navigate to restaurant details or open menu
  console.log('Selected restaurant:', restaurant)
  // router.push(`/restaurant/${restaurant.slug}`)
}

const viewMenu = (restaurant) => {
  console.log('View menu for:', restaurant)
  // router.push(`/restaurant/${restaurant.slug}/menu`)
}

const getDirections = (restaurant) => {
  const url = `https://www.google.com/maps/dir/?api=1&destination=${restaurant.latitude},${restaurant.longitude}`
  window.open(url, '_blank')
}

const viewCompany = (company) => {
  console.log('View company:', company)
  // router.push(`/company/${company.slug}`)
}

const toggleMapView = () => {
  showMapView.value = !showMapView.value
}

const clearFilters = () => {
  filters.value = {
    restaurant_type: '',
    cuisine_type: '',
    price_range: '',
    accepts_delivery: false,
    accepts_pickup: false
  }
  searchResults.value = []
  hasSearched.value = false
}

// Lifecycle
onMounted(async () => {
  // Auto-request location on mount
  if (!geolocationStore.hasLocation) {
    await requestLocation()
  }
})

// Watch for location changes
watch(() => geolocationStore.hasLocation, (hasLocation) => {
  if (hasLocation && !hasSearched.value) {
    loadRecommendations()
  }
})
</script>

<style scoped>
.store-finder {
  max-width: 1200px;
  margin: 0 auto;
  padding: 1rem;
}

.restaurant-card {
  transition: all 0.3s ease;
}

.restaurant-card:hover {
  transform: translateY(-2px);
}

.restaurant-image {
  position: relative;
}

.recommendation-section {
  background: white;
  border-radius: 0.5rem;
  padding: 1rem;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

/* Responsive Design */
@media (max-width: 768px) {
  .store-finder {
    padding: 0.5rem;
  }
  
  .search-filters {
    padding: 1rem;
  }
  
  .grid {
    grid-template-columns: 1fr;
  }
}

/* Touch-friendly for mobile */
@media (hover: none) and (pointer: coarse) {
  .restaurant-card {
    padding: 0.5rem;
  }
  
  button {
    min-height: 44px;
  }
}

/* High DPI displays */
@media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
  .restaurant-image img {
    image-rendering: -webkit-optimize-contrast;
    image-rendering: crisp-edges;
  }
}
</style>
