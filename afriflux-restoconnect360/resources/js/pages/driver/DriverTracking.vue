<template>
  <div class="h-[calc(100vh-4rem)] sm:h-[calc(100vh-5rem)] flex flex-col">
    <!-- Delivery Info Header -->
    <div class="bg-white shadow-md p-3 sm:p-4 flex-shrink-0">
      <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-start mb-3">
          <div>
            <h2 class="text-lg sm:text-xl font-bold">Livraison #{{ delivery?.id }}</h2>
            <p class="text-sm text-gray-600">{{ delivery?.order?.restaurant?.name }}</p>
          </div>
          <span
            class="px-3 py-1 rounded-full text-xs font-semibold"
            :class="getStatusClass(delivery?.status)"
          >
            {{ getStatusLabel(delivery?.status) }}
          </span>
        </div>

        <div class="grid grid-cols-2 gap-3 text-sm">
          <div>
            <div class="text-gray-600 mb-1">Client</div>
            <div class="font-semibold">{{ delivery?.order?.customer_name }}</div>
            <div class="text-gray-600">{{ delivery?.order?.customer_phone }}</div>
          </div>
          <div>
            <div class="text-gray-600 mb-1">Adresse de livraison</div>
            <div class="font-semibold">{{ delivery?.delivery_address }}</div>
            <div class="text-primary-600">{{ delivery?.distance }} km</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Map -->
    <div class="flex-1 relative">
      <div id="tracking-map" class="w-full h-full"></div>

      <!-- Tracking Controls Overlay -->
      <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex gap-2 sm:gap-3">
        <button
          @click="centerOnDriver"
          class="px-4 sm:px-6 py-2 sm:py-3 bg-white rounded-full shadow-lg hover:bg-gray-50 transition font-semibold text-sm sm:text-base flex items-center gap-2 touch-manipulation"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
          </svg>
          <span class="hidden sm:inline">Ma position</span>
        </button>
        
        <button
          v-if="delivery?.status === 'picked_up' && !isTracking"
          @click="startLiveTracking"
          class="px-4 sm:px-6 py-2 sm:py-3 bg-green-600 text-white rounded-full shadow-lg hover:bg-green-700 transition font-semibold text-sm sm:text-base flex items-center gap-2 touch-manipulation"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
          </svg>
          Démarrer
        </button>
        
        <button
          v-if="isTracking"
          @click="completeDelivery"
          class="px-4 sm:px-6 py-2 sm:py-3 bg-green-600 text-white rounded-full shadow-lg hover:bg-green-700 transition font-semibold text-sm sm:text-base flex items-center gap-2 touch-manipulation"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
          </svg>
          Marquer livrée
        </button>
      </div>

      <!-- Distance & ETA Info -->
      <div class="absolute top-4 right-4 bg-white rounded-lg shadow-lg p-3 sm:p-4 text-sm sm:text-base">
        <div class="flex items-center gap-2 mb-2">
          <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
          </svg>
          <div>
            <div class="text-gray-600 text-xs">Distance restante</div>
            <div class="font-bold">{{ remainingDistance }} km</div>
          </div>
        </div>
        <div class="flex items-center gap-2">
          <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          <div>
            <div class="text-gray-600 text-xs">Temps estimé</div>
            <div class="font-bold">{{ estimatedTime }} min</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Actions Bar -->
    <div class="bg-white border-t p-3 flex-shrink-0">
      <div class="max-w-7xl mx-auto flex gap-2">
        <button
          @click="callCustomer"
          class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold text-sm flex items-center justify-center gap-2 touch-manipulation"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
          </svg>
          <span class="hidden sm:inline">Appeler</span>
        </button>
        <button
          @click="openNavigation"
          class="flex-1 px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition font-semibold text-sm flex items-center justify-center gap-2 touch-manipulation"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
          </svg>
          <span class="hidden sm:inline">Navigation</span>
        </button>
        <button
          @click="reportIssue"
          class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-semibold text-sm flex items-center justify-center gap-2 touch-manipulation"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
          </svg>
          <span class="hidden sm:inline">Problème</span>
        </button>
      </div>
    </div>

    <!-- Success Modal -->
    <teleport to="body">
      <div
        v-if="showSuccessModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
      >
        <div class="bg-white rounded-lg p-6 sm:p-8 max-w-md w-full text-center">
          <svg class="w-20 h-20 mx-auto text-green-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          <h3 class="text-2xl font-bold mb-2">Livraison terminée !</h3>
          <p class="text-gray-600 mb-6">Félicitations pour cette livraison réussie.</p>
          <button
            @click="backToDashboard"
            class="w-full px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-semibold"
          >
            Retour au tableau de bord
          </button>
        </div>
      </div>
    </teleport>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useDeliveryStore } from '../../stores/delivery';
import axios from 'axios';

const route = useRoute();
const router = useRouter();
const deliveryStore = useDeliveryStore();

const delivery = ref(null);
const map = ref(null);
const driverMarker = ref(null);
const destinationMarker = ref(null);
const routePath = ref(null);
const isTracking = ref(false);
const showSuccessModal = ref(false);
const remainingDistance = ref(0);
const estimatedTime = ref(0);
let watchId = null;

const getStatusClass = (status) => {
  const classes = {
    assigned: 'bg-blue-100 text-blue-800',
    picked_up: 'bg-yellow-100 text-yellow-800',
    in_transit: 'bg-green-100 text-green-800',
    delivered: 'bg-gray-100 text-gray-800',
  };
  return classes[status] || 'bg-gray-100 text-gray-800';
};

const getStatusLabel = (status) => {
  const labels = {
    assigned: 'Assignée',
    picked_up: 'Récupérée',
    in_transit: 'En livraison',
    delivered: 'Livrée',
  };
  return labels[status] || status;
};

const initMap = () => {
  if (!delivery.value) return;
  
  const center = {
    lat: parseFloat(delivery.value.delivery_latitude),
    lng: parseFloat(delivery.value.delivery_longitude),
  };
  
  map.value = new google.maps.Map(document.getElementById('tracking-map'), {
    center,
    zoom: 14,
    disableDefaultUI: true,
    zoomControl: true,
  });
  
  // Destination marker
  destinationMarker.value = new google.maps.Marker({
    position: center,
    map: map.value,
    icon: {
      url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40">
          <circle cx="20" cy="20" r="18" fill="#10B981" stroke="white" stroke-width="3"/>
          <text x="20" y="26" font-size="20" fill="white" text-anchor="middle" font-weight="bold">🏁</text>
        </svg>
      `),
      scaledSize: new google.maps.Size(40, 40),
    },
    title: 'Destination',
  });
};

const updateDriverPosition = (latitude, longitude) => {
  const position = { lat: latitude, lng: longitude };
  
  if (!driverMarker.value) {
    driverMarker.value = new google.maps.Marker({
      position,
      map: map.value,
      icon: {
        url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
          <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40">
            <circle cx="20" cy="20" r="18" fill="#3B82F6" stroke="white" stroke-width="3"/>
            <text x="20" y="26" font-size="20" fill="white" text-anchor="middle" font-weight="bold">🚗</text>
          </svg>
        `),
        scaledSize: new google.maps.Size(40, 40),
      },
      title: 'Ma position',
    });
  } else {
    driverMarker.value.setPosition(position);
  }
  
  // Calculate distance to destination
  const destination = {
    lat: parseFloat(delivery.value.delivery_latitude),
    lng: parseFloat(delivery.value.delivery_longitude),
  };
  
  const R = 6371; // Earth radius in km
  const dLat = (destination.lat - latitude) * Math.PI / 180;
  const dLon = (destination.lng - longitude) * Math.PI / 180;
  const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.cos(latitude * Math.PI / 180) * Math.cos(destination.lat * Math.PI / 180) *
            Math.sin(dLon/2) * Math.sin(dLon/2);
  const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
  const distance = R * c;
  
  remainingDistance.value = distance.toFixed(1);
  estimatedTime.value = Math.ceil(distance / 0.5); // ~30km/h average speed
  
  // Update route
  if (routePath.value) {
    routePath.value.setMap(null);
  }
  
  routePath.value = new google.maps.Polyline({
    path: [position, destination],
    geodesic: true,
    strokeColor: '#3B82F6',
    strokeOpacity: 1.0,
    strokeWeight: 3,
    map: map.value,
  });
};

const centerOnDriver = () => {
  if (driverMarker.value) {
    map.value.panTo(driverMarker.value.getPosition());
    map.value.setZoom(16);
  }
};

const startLiveTracking = () => {
  isTracking.value = true;
  
  // Update status to in_transit
  deliveryStore.updateDeliveryStatus(delivery.value.id, 'in_transit');
  
  // Start GPS tracking
  watchId = deliveryStore.startLiveTracking(delivery.value.id);
  
  // Update map every time position changes
  if ('geolocation' in navigator) {
    navigator.geolocation.watchPosition(
      (position) => {
        updateDriverPosition(
          position.coords.latitude,
          position.coords.longitude
        );
      },
      (error) => {
        console.error('Geolocation error:', error);
      },
      {
        enableHighAccuracy: true,
        timeout: 5000,
        maximumAge: 0,
      }
    );
  }
};

const completeDelivery = async () => {
  try {
    await deliveryStore.updateDeliveryStatus(delivery.value.id, 'delivered');
    showSuccessModal.value = true;
    
    if (watchId) {
      deliveryStore.stopLiveTracking(watchId);
    }
  } catch (error) {
    console.error('Failed to complete delivery:', error);
    alert('Erreur lors de la finalisation');
  }
};

const callCustomer = () => {
  window.location.href = `tel:${delivery.value.order.customer_phone}`;
};

const openNavigation = () => {
  const destination = `${delivery.value.delivery_latitude},${delivery.value.delivery_longitude}`;
  const url = `https://www.google.com/maps/dir/?api=1&destination=${destination}&travelmode=driving`;
  window.open(url, '_blank');
};

const reportIssue = () => {
  // Open issue modal
  alert('Fonctionnalité à venir : Signaler un problème');
};

const backToDashboard = () => {
  router.push({ name: 'driver-dashboard' });
};

onMounted(async () => {
  try {
    await deliveryStore.fetchDelivery(route.params.id);
    delivery.value = deliveryStore.currentDelivery;
    
    // Load Google Maps
    if (!window.google) {
      const script = document.createElement('script');
      script.src = `https://maps.googleapis.com/maps/api/js?key=${import.meta.env.VITE_GOOGLE_MAPS_API_KEY}`;
      script.async = true;
      script.defer = true;
      script.onload = () => {
        initMap();
      };
      document.head.appendChild(script);
    } else {
      initMap();
    }
  } catch (error) {
    console.error('Failed to load delivery:', error);
  }
});

onUnmounted(() => {
  if (watchId) {
    deliveryStore.stopLiveTracking(watchId);
  }
});
</script>

