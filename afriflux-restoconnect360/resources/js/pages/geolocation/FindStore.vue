<template>
  <div class="h-screen flex flex-col">
    <!-- Search Header -->
    <div class="bg-white shadow-md z-10 flex-shrink-0">
      <div class="max-w-7xl mx-auto px-4 py-4">
        <!-- Search Bar -->
        <div class="relative">
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Rechercher une adresse, un restaurant..."
            class="w-full px-12 py-4 border-2 border-gray-300 rounded-lg focus:border-primary-500 focus:ring-2 focus:ring-primary-200 text-lg"
            @focus="showSuggestions = true"
          />
          <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
          </svg>
          <button
            @click="useMyLocation"
            class="absolute right-4 top-1/2 transform -translate-y-1/2 px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition flex items-center gap-2"
            :disabled="loadingLocation"
          >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
            </svg>
            <span class="hidden sm:inline">{{ loadingLocation ? 'Localisation...' : 'Ma position' }}</span>
          </button>
        </div>

        <!-- Filters -->
        <div class="mt-4 flex flex-wrap gap-2">
          <button
            @click="radiusFilter = 5"
            class="px-4 py-2 rounded-lg text-sm font-semibold transition"
            :class="radiusFilter === 5 ? 'bg-primary-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
          >
            À 5 km
          </button>
          <button
            @click="radiusFilter = 10"
            class="px-4 py-2 rounded-lg text-sm font-semibold transition"
            :class="radiusFilter === 10 ? 'bg-primary-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
          >
            À 10 km
          </button>
          <button
            @click="radiusFilter = 20"
            class="px-4 py-2 rounded-lg text-sm font-semibold transition"
            :class="radiusFilter === 20 ? 'bg-primary-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
          >
            À 20 km
          </button>
          <button
            @click="sortBy = 'distance'"
            class="px-4 py-2 rounded-lg text-sm font-semibold transition"
            :class="sortBy === 'distance' ? 'bg-primary-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
          >
            Plus proche
          </button>
          <button
            @click="sortBy = 'rating'"
            class="px-4 py-2 rounded-lg text-sm font-semibold transition"
            :class="sortBy === 'rating' ? 'bg-primary-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
          >
            Mieux notés
          </button>
        </div>
      </div>
    </div>

    <!-- Map + List Container -->
    <div class="flex-1 flex flex-col lg:flex-row overflow-hidden">
      <!-- Google Map -->
      <div class="h-1/2 lg:h-full lg:flex-1 relative">
        <div id="map" class="w-full h-full"></div>
        
        <!-- Loading overlay -->
        <div
          v-if="loadingRestaurants"
          class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center"
        >
          <div class="text-center">
            <svg class="animate-spin h-12 w-12 text-primary-600 mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p class="text-gray-600">Recherche en cours...</p>
          </div>
        </div>

        <!-- User location marker info -->
        <div
          v-if="userLocation"
          class="absolute top-4 left-4 bg-white rounded-lg shadow-lg px-4 py-2 flex items-center gap-2"
        >
          <div class="w-3 h-3 bg-blue-600 rounded-full animate-pulse"></div>
          <span class="text-sm font-semibold">Votre position</span>
        </div>
      </div>

      <!-- Results List -->
      <div class="h-1/2 lg:h-full lg:w-96 xl:w-[28rem] bg-white overflow-y-auto shadow-lg">
        <div class="p-4">
          <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">
              {{ nearbyRestaurants.length }} restaurant(s) trouvé(s)
            </h2>
          </div>

          <!-- Restaurant Cards -->
          <div class="space-y-3">
            <div
              v-for="restaurant in sortedRestaurants"
              :key="restaurant.id"
              class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition cursor-pointer border-2"
              :class="selectedRestaurant?.id === restaurant.id ? 'border-primary-600' : 'border-transparent'"
              @click="selectRestaurant(restaurant)"
              @mouseenter="highlightMarker(restaurant)"
              @mouseleave="unhighlightMarker()"
            >
              <div class="flex gap-3">
                <img
                  :src="restaurant.logo || '/images/placeholder-restaurant.jpg'"
                  :alt="restaurant.name"
                  class="w-20 h-20 object-cover rounded-lg"
                />
                <div class="flex-1 min-w-0">
                  <h3 class="font-bold text-lg truncate">{{ restaurant.name }}</h3>
                  <p class="text-sm text-gray-600 truncate">{{ restaurant.cuisine_type }}</p>
                  
                  <div class="flex items-center gap-3 mt-2 text-sm">
                    <div class="flex items-center gap-1">
                      <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                      </svg>
                      <span class="font-semibold">{{ restaurant.rating }}</span>
                    </div>
                    
                    <div class="flex items-center gap-1 text-primary-600 font-semibold">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                      </svg>
                      <span>{{ restaurant.distance?.toFixed(1) }} km</span>
                    </div>
                  </div>

                  <div class="mt-2 flex gap-2">
                    <span
                      v-if="restaurant.accepts_delivery"
                      class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded font-semibold"
                    >
                      Livraison
                    </span>
                    <span
                      v-if="restaurant.accepts_takeaway"
                      class="px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded font-semibold"
                    >
                      À emporter
                    </span>
                  </div>
                </div>
              </div>

              <!-- Action Buttons -->
              <div class="mt-3 grid grid-cols-2 gap-2">
                <button
                  @click.stop="getDirections(restaurant)"
                  class="px-3 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition text-sm font-semibold flex items-center justify-center gap-2"
                >
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                  </svg>
                  Itinéraire
                </button>
                <button
                  @click.stop="viewRestaurant(restaurant)"
                  class="px-3 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition text-sm font-semibold"
                >
                  Voir menu
                </button>
              </div>
            </div>
          </div>

          <!-- Empty State -->
          <div
            v-if="!nearbyRestaurants.length && !loadingRestaurants"
            class="text-center py-12"
          >
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-gray-600">Aucun restaurant trouvé dans cette zone</p>
            <button
              @click="radiusFilter = radiusFilter < 20 ? radiusFilter + 5 : 5"
              class="mt-4 px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition"
            >
              Élargir la recherche
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import { useRouter } from 'vue-router';
import { useGeolocation } from '../../composables/useGeolocation';
import axios from 'axios';

const router = useRouter();
const { latitude, longitude, getCurrentPosition, calculateDistance } = useGeolocation();

const searchQuery = ref('');
const showSuggestions = ref(false);
const radiusFilter = ref(10);
const sortBy = ref('distance');
const loadingLocation = ref(false);
const loadingRestaurants = ref(false);
const nearbyRestaurants = ref([]);
const selectedRestaurant = ref(null);
const userLocation = ref(null);
const map = ref(null);
const markers = ref([]);
const userMarker = ref(null);

const sortedRestaurants = computed(() => {
  const sorted = [...nearbyRestaurants.value];
  
  if (sortBy.value === 'distance') {
    sorted.sort((a, b) => (a.distance || 0) - (b.distance || 0));
  } else if (sortBy.value === 'rating') {
    sorted.sort((a, b) => (b.rating || 0) - (a.rating || 0));
  }
  
  return sorted;
});

const useMyLocation = async () => {
  loadingLocation.value = true;
  try {
    getCurrentPosition();
    
    // Attendre que la position soit obtenue
    await new Promise((resolve) => {
      const checkInterval = setInterval(() => {
        if (latitude.value && longitude.value) {
          clearInterval(checkInterval);
          resolve();
        }
      }, 100);
      
      setTimeout(() => {
        clearInterval(checkInterval);
        resolve();
      }, 5000);
    });
    
    if (latitude.value && longitude.value) {
      userLocation.value = {
        lat: latitude.value,
        lng: longitude.value,
      };
      
      // Centrer la carte
      if (map.value) {
        map.value.setCenter(userLocation.value);
        map.value.setZoom(14);
      }
      
      // Ajouter le marker utilisateur
      updateUserMarker();
      
      // Rechercher les restaurants
      await searchNearbyRestaurants();
    }
  } catch (error) {
    console.error('Geolocation error:', error);
    alert('Impossible de récupérer votre position');
  } finally {
    loadingLocation.value = false;
  }
};

const searchNearbyRestaurants = async () => {
  if (!userLocation.value) return;
  
  loadingRestaurants.value = true;
  try {
    const response = await axios.get('/api/geolocation/nearby', {
      params: {
        latitude: userLocation.value.lat,
        longitude: userLocation.value.lng,
        radius: radiusFilter.value,
      },
    });
    
    nearbyRestaurants.value = response.data.data.map(restaurant => ({
      ...restaurant,
      distance: calculateDistance(
        userLocation.value.lat,
        userLocation.value.lng,
        restaurant.latitude,
        restaurant.longitude
      ),
    }));
    
    updateMapMarkers();
  } catch (error) {
    console.error('Search error:', error);
  } finally {
    loadingRestaurants.value = false;
  }
};

const initMap = () => {
  // Position par défaut : Dakar
  const defaultCenter = { lat: 14.7167, lng: -17.4677 };
  
  map.value = new google.maps.Map(document.getElementById('map'), {
    center: defaultCenter,
    zoom: 12,
    styles: [
      {
        featureType: 'poi',
        elementType: 'labels',
        stylers: [{ visibility: 'off' }],
      },
    ],
  });
};

const updateUserMarker = () => {
  if (!map.value || !userLocation.value) return;
  
  if (userMarker.value) {
    userMarker.value.setMap(null);
  }
  
  userMarker.value = new google.maps.Marker({
    position: userLocation.value,
    map: map.value,
    icon: {
      path: google.maps.SymbolPath.CIRCLE,
      scale: 10,
      fillColor: '#3B82F6',
      fillOpacity: 1,
      strokeColor: '#FFFFFF',
      strokeWeight: 3,
    },
    title: 'Votre position',
  });
};

const updateMapMarkers = () => {
  // Effacer les anciens markers
  markers.value.forEach(marker => marker.setMap(null));
  markers.value = [];
  
  // Créer les nouveaux markers
  nearbyRestaurants.value.forEach(restaurant => {
    const marker = new google.maps.Marker({
      position: {
        lat: parseFloat(restaurant.latitude),
        lng: parseFloat(restaurant.longitude),
      },
      map: map.value,
      title: restaurant.name,
      icon: {
        url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
          <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40">
            <circle cx="20" cy="20" r="18" fill="#DC2626" stroke="white" stroke-width="3"/>
            <text x="20" y="26" font-size="20" fill="white" text-anchor="middle" font-weight="bold">🍽️</text>
          </svg>
        `),
        scaledSize: new google.maps.Size(40, 40),
      },
    });
    
    marker.addListener('click', () => {
      selectRestaurant(restaurant);
    });
    
    markers.value.push(marker);
  });
};

const selectRestaurant = (restaurant) => {
  selectedRestaurant.value = restaurant;
  
  if (map.value) {
    map.value.panTo({
      lat: parseFloat(restaurant.latitude),
      lng: parseFloat(restaurant.longitude),
    });
    map.value.setZoom(15);
  }
};

const highlightMarker = (restaurant) => {
  // Find and animate marker
};

const unhighlightMarker = () => {
  // Reset marker animation
};

const getDirections = (restaurant) => {
  if (!userLocation.value) {
    alert('Veuillez activer votre localisation');
    return;
  }
  
  const origin = `${userLocation.value.lat},${userLocation.value.lng}`;
  const destination = `${restaurant.latitude},${restaurant.longitude}`;
  const url = `https://www.google.com/maps/dir/?api=1&origin=${origin}&destination=${destination}&travelmode=driving`;
  
  window.open(url, '_blank');
};

const viewRestaurant = (restaurant) => {
  router.push({ name: 'restaurant-detail', params: { id: restaurant.id } });
};

watch(radiusFilter, () => {
  if (userLocation.value) {
    searchNearbyRestaurants();
  }
});

onMounted(() => {
  // Charger Google Maps
  if (!window.google) {
    const script = document.createElement('script');
    script.src = `https://maps.googleapis.com/maps/api/js?key=${import.meta.env.VITE_GOOGLE_MAPS_API_KEY}&libraries=places`;
    script.async = true;
    script.defer = true;
    script.onload = () => {
      initMap();
      useMyLocation();
    };
    document.head.appendChild(script);
  } else {
    initMap();
    useMyLocation();
  }
});
</script>

<style scoped>
#map {
  width: 100%;
  height: 100%;
}
</style>

