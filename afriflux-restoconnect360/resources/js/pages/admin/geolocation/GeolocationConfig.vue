<template>
  <div class="p-6">
    <div class="mb-6">
      <h1 class="text-2xl font-bold text-gray-900">🗺️ Configuration Géolocalisation</h1>
      <p class="text-gray-600 mt-2">Configurez les services de géolocalisation, géofencing et zones de livraison</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="p-2 bg-blue-100 rounded-lg">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Zones Actives</p>
            <p class="text-2xl font-semibold text-gray-900">{{ zones.length }}</p>
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
            <p class="text-sm font-medium text-gray-600">API Google Maps</p>
            <p class="text-2xl font-semibold text-gray-900">{{ googleMaps.isActive ? 'Actif' : 'Inactif' }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="p-2 bg-purple-100 rounded-lg">
            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Géofencing</p>
            <p class="text-2xl font-semibold text-gray-900">{{ geofencing.isActive ? 'Activé' : 'Désactivé' }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="p-2 bg-yellow-100 rounded-lg">
            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Distance Max</p>
            <p class="text-2xl font-semibold text-gray-900">{{ maxDeliveryDistance }}km</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Configuration Google Maps API -->
    <div class="bg-white rounded-lg shadow mb-6">
      <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900">🗺️ Configuration Google Maps API</h2>
      </div>
      <div class="p-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <!-- Configuration API -->
          <div class="space-y-4">
            <div class="flex items-center justify-between">
              <h3 class="text-md font-semibold text-gray-900">État du Service</h3>
              <label class="flex items-center">
                <input type="checkbox" v-model="googleMaps.isActive" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                <span class="ml-2 text-sm text-gray-700">{{ googleMaps.isActive ? 'Activé' : 'Désactivé' }}</span>
              </label>
            </div>
            
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Clé API Google Maps</label>
              <input 
                type="password" 
                v-model="googleMaps.apiKey" 
                placeholder="Votre clé API Google Maps"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"
              >
              <p class="text-xs text-gray-500 mt-1">Obtenue depuis Google Cloud Console</p>
            </div>
            
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Type de Carte</label>
              <select v-model="googleMaps.mapType" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                <option value="roadmap">Carte routière</option>
                <option value="satellite">Satellite</option>
                <option value="hybrid">Hybride</option>
                <option value="terrain">Terrain</option>
              </select>
            </div>
            
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Zoom par Défaut</label>
              <input 
                type="range" 
                v-model="googleMaps.defaultZoom" 
                min="1" 
                max="20" 
                class="w-full"
              >
              <div class="flex justify-between text-xs text-gray-500 mt-1">
                <span>1 (Monde)</span>
                <span>{{ googleMaps.defaultZoom }}</span>
                <span>20 (Rue)</span>
              </div>
            </div>
          </div>
          
          <!-- Services Activés -->
          <div class="space-y-4">
            <h3 class="text-md font-semibold text-gray-900">Services Activés</h3>
            
            <div class="space-y-3">
              <label class="flex items-center">
                <input type="checkbox" v-model="googleMaps.services.geocoding" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                <span class="ml-2 text-sm text-gray-700">Geocoding API</span>
                <span class="ml-auto text-xs text-gray-500">Conversion adresse ↔ coordonnées</span>
              </label>
              
              <label class="flex items-center">
                <input type="checkbox" v-model="googleMaps.services.directions" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                <span class="ml-2 text-sm text-gray-700">Directions API</span>
                <span class="ml-auto text-xs text-gray-500">Calcul d'itinéraires</span>
              </label>
              
              <label class="flex items-center">
                <input type="checkbox" v-model="googleMaps.services.distanceMatrix" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                <span class="ml-2 text-sm text-gray-700">Distance Matrix API</span>
                <span class="ml-auto text-xs text-gray-500">Calcul de distances</span>
              </label>
              
              <label class="flex items-center">
                <input type="checkbox" v-model="googleMaps.services.places" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                <span class="ml-2 text-sm text-gray-700">Places API</span>
                <span class="ml-auto text-xs text-gray-500">Recherche de lieux</span>
              </label>
            </div>
            
            <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
              <p class="text-sm text-blue-800">
                <strong>Note :</strong> Assurez-vous d'activer ces services dans Google Cloud Console et de configurer les quotas appropriés.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Configuration Géofencing -->
    <div class="bg-white rounded-lg shadow mb-6">
      <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900">🎯 Configuration Géofencing</h2>
      </div>
      <div class="p-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <!-- Paramètres Généraux -->
          <div class="space-y-4">
            <div class="flex items-center justify-between">
              <h3 class="text-md font-semibold text-gray-900">Activation</h3>
              <label class="flex items-center">
                <input type="checkbox" v-model="geofencing.isActive" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                <span class="ml-2 text-sm text-gray-700">{{ geofencing.isActive ? 'Activé' : 'Désactivé' }}</span>
              </label>
            </div>
            
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Rayon de Détection (mètres)</label>
              <input 
                type="number" 
                v-model="geofencing.detectionRadius" 
                min="10" 
                max="1000"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"
              >
              <p class="text-xs text-gray-500 mt-1">Distance minimale pour déclencher une action</p>
            </div>
            
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Fréquence de Vérification</label>
              <select v-model="geofencing.checkFrequency" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                <option value="1000">1 seconde</option>
                <option value="5000">5 secondes</option>
                <option value="10000">10 secondes</option>
                <option value="30000">30 secondes</option>
                <option value="60000">1 minute</option>
              </select>
            </div>
            
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Précision Requise</label>
              <select v-model="geofencing.accuracy" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                <option value="high">Haute (GPS)</option>
                <option value="medium">Moyenne (WiFi + GPS)</option>
                <option value="low">Basse (Cellulaire)</option>
              </select>
            </div>
          </div>
          
          <!-- Actions Automatiques -->
          <div class="space-y-4">
            <h3 class="text-md font-semibold text-gray-900">Actions Automatiques</h3>
            
            <div class="space-y-3">
              <label class="flex items-center">
                <input type="checkbox" v-model="geofencing.actions.notifyArrival" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                <span class="ml-2 text-sm text-gray-700">Notification d'arrivée</span>
                <span class="ml-auto text-xs text-gray-500">Alerter le client</span>
              </label>
              
              <label class="flex items-center">
                <input type="checkbox" v-model="geofencing.actions.updateStatus" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                <span class="ml-2 text-sm text-gray-700">Mise à jour du statut</span>
                <span class="ml-auto text-xs text-gray-500">Changer automatiquement</span>
              </label>
              
              <label class="flex items-center">
                <input type="checkbox" v-model="geofencing.actions.trackDelivery" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                <span class="ml-2 text-sm text-gray-700">Suivi de livraison</span>
                <span class="ml-auto text-xs text-gray-500">Géolocaliser le livreur</span>
              </label>
              
              <label class="flex items-center">
                <input type="checkbox" v-model="geofencing.actions.autoComplete" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                <span class="ml-2 text-sm text-gray-700">Finalisation automatique</span>
                <span class="ml-auto text-xs text-gray-500">Marquer comme livré</span>
              </label>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Zones de Livraison -->
    <div class="bg-white rounded-lg shadow mb-6">
      <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex justify-between items-center">
          <h2 class="text-lg font-semibold text-gray-900">🚚 Zones de Livraison</h2>
          <ModernButton 
            @click="openZoneModal"
            variant="primary"
            icon="plus"
            size="md"
          >
            Nouvelle Zone
          </ModernButton>
        </div>
      </div>
      
      <div class="p-6">
        <!-- Configuration Générale -->
        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
          <h3 class="text-md font-semibold text-gray-900 mb-4">Configuration Générale</h3>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Distance Max de Livraison (km)</label>
              <input 
                type="number" 
                v-model="maxDeliveryDistance" 
                min="1" 
                max="50"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"
              >
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Frais de Livraison par km (FCFA)</label>
              <input 
                type="number" 
                v-model="deliveryCostPerKm" 
                min="0"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"
              >
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Frais Minimum (FCFA)</label>
              <input 
                type="number" 
                v-model="minDeliveryCost" 
                min="0"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"
              >
            </div>
          </div>
        </div>
        
        <!-- Liste des Zones -->
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Zone</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rayon</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Frais</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="zone in zones" :key="zone.id">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg flex items-center justify-center">
                      <span class="text-white font-bold text-sm">{{ zone.name.charAt(0) }}</span>
                    </div>
                    <div class="ml-3">
                      <div class="text-sm font-medium text-gray-900">{{ zone.name }}</div>
                      <div class="text-sm text-gray-500">{{ zone.description }}</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ zone.radius }} km
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ zone.deliveryCost }} FCFA
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span :class="getZoneStatusClass(zone.status)" class="px-2 py-1 text-xs font-semibold rounded-full">
                    {{ zone.status }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <div class="flex space-x-2">
                    <ModernButton 
                      @click="editZone(zone)"
                      variant="success"
                      icon="edit"
                      size="sm"
                    >
                      Modifier
                    </ModernButton>
                    <ModernButton 
                      @click="deleteZone(zone)"
                      variant="danger"
                      icon="delete"
                      size="sm"
                    >
                      Supprimer
                    </ModernButton>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Actions -->
    <div class="flex justify-end space-x-4">
      <ModernButton 
        @click="testConfiguration"
        variant="secondary"
        icon="sync"
        size="md"
      >
        Tester la Configuration
      </ModernButton>
      <ModernButton 
        @click="saveConfiguration"
        variant="primary"
        icon="save"
        size="md"
      >
        Sauvegarder
      </ModernButton>
    </div>

    <!-- Modal de Zone -->
    <div v-if="showZoneModal" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm flex items-center justify-center z-50 animate-fadeIn">
      <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full mx-4 transform transition-all duration-300 scale-100 animate-slideUp">
        <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-8 py-6 rounded-t-2xl">
          <div class="flex justify-between items-center">
            <div class="flex items-center space-x-3">
              <div class="w-10 h-10 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                </svg>
              </div>
              <div>
                <h3 class="text-xl font-bold text-white">Nouvelle Zone de Livraison</h3>
                <p class="text-green-100 text-sm">Définissez une zone de livraison</p>
              </div>
            </div>
            <button @click="closeZoneModal" class="text-white hover:text-green-200 transition-colors p-2 hover:bg-white hover:bg-opacity-10 rounded-lg">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>
        </div>
        
        <form @submit.prevent="saveZone" class="px-8 py-6">
          <div class="space-y-6">
            <div class="group">
              <label class="block text-sm font-semibold text-gray-700 mb-2 group-focus-within:text-green-600 transition-colors">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                Nom de la Zone
              </label>
              <input 
                v-model="newZone.name"
                type="text" 
                required
                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-green-100 focus:border-green-500 transition-all duration-200 placeholder-gray-400"
                placeholder="Ex: Zone Centre-Ville"
              >
            </div>
            
            <div class="group">
              <label class="block text-sm font-semibold text-gray-700 mb-2 group-focus-within:text-green-600 transition-colors">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                </svg>
                Description
              </label>
              <textarea 
                v-model="newZone.description"
                rows="2"
                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-green-100 focus:border-green-500 transition-all duration-200 placeholder-gray-400 resize-none"
                placeholder="Description de la zone de livraison"
              ></textarea>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
              <div class="group">
                <label class="block text-sm font-semibold text-gray-700 mb-2 group-focus-within:text-green-600 transition-colors">
                  <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                  </svg>
                  Rayon (km)
                </label>
                <input 
                  v-model="newZone.radius"
                  type="number" 
                  required
                  min="1"
                  max="50"
                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-green-100 focus:border-green-500 transition-all duration-200 placeholder-gray-400"
                  placeholder="5"
                >
              </div>
              
              <div class="group">
                <label class="block text-sm font-semibold text-gray-700 mb-2 group-focus-within:text-green-600 transition-colors">
                  <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                  </svg>
                  Frais (FCFA)
                </label>
                <input 
                  v-model="newZone.deliveryCost"
                  type="number" 
                  required
                  min="0"
                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-green-100 focus:border-green-500 transition-all duration-200 placeholder-gray-400"
                  placeholder="1000"
                >
              </div>
            </div>
            
            <div class="group">
              <label class="block text-sm font-semibold text-gray-700 mb-2 group-focus-within:text-green-600 transition-colors">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                </svg>
                Centre de la Zone (Coordonnées)
              </label>
              <div class="grid grid-cols-2 gap-4">
                <input 
                  v-model="newZone.latitude"
                  type="number" 
                  step="any"
                  placeholder="Latitude"
                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-green-100 focus:border-green-500 transition-all duration-200 placeholder-gray-400"
                >
                <input 
                  v-model="newZone.longitude"
                  type="number" 
                  step="any"
                  placeholder="Longitude"
                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-green-100 focus:border-green-500 transition-all duration-200 placeholder-gray-400"
                >
              </div>
              <p class="text-xs text-gray-500 mt-1">Utilisez Google Maps pour obtenir les coordonnées exactes</p>
            </div>
          </div>
          
          <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-100">
            <ModernButton 
              @click="closeZoneModal"
              variant="secondary"
              size="md"
            >
              Annuler
            </ModernButton>
            <ModernButton 
              @click="saveZone"
              variant="primary"
              icon="check"
              size="md"
            >
              Créer la Zone
            </ModernButton>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import ModernButton from '@/components/ui/ModernButton.vue';

// État de la modal
const showZoneModal = ref(false);

// Configuration Google Maps
const googleMaps = ref({
  isActive: true,
  apiKey: '',
  mapType: 'roadmap',
  defaultZoom: 13,
  services: {
    geocoding: true,
    directions: true,
    distanceMatrix: true,
    places: false
  }
});

// Configuration Géofencing
const geofencing = ref({
  isActive: true,
  detectionRadius: 100,
  checkFrequency: 10000,
  accuracy: 'high',
  actions: {
    notifyArrival: true,
    updateStatus: true,
    trackDelivery: true,
    autoComplete: false
  }
});

// Configuration des zones de livraison
const maxDeliveryDistance = ref(15);
const deliveryCostPerKm = ref(200);
const minDeliveryCost = ref(500);

// Zones de livraison
const zones = ref([
  {
    id: 1,
    name: 'Centre-Ville',
    description: 'Zone centrale de Dakar',
    radius: 5,
    deliveryCost: 1000,
    latitude: 14.6928,
    longitude: -17.4467,
    status: 'Active'
  },
  {
    id: 2,
    name: 'Plateau',
    description: 'Quartier des affaires',
    radius: 3,
    deliveryCost: 800,
    latitude: 14.6708,
    longitude: -17.4378,
    status: 'Active'
  },
  {
    id: 3,
    name: 'Almadies',
    description: 'Zone résidentielle',
    radius: 8,
    deliveryCost: 1500,
    latitude: 14.7167,
    longitude: -17.4667,
    status: 'Active'
  }
]);

// Nouvelle zone
const newZone = ref({
  name: '',
  description: '',
  radius: 5,
  deliveryCost: 1000,
  latitude: '',
  longitude: ''
});

// Méthodes
const openZoneModal = () => {
  showZoneModal.value = true;
};

const closeZoneModal = () => {
  showZoneModal.value = false;
  // Réinitialiser le formulaire
  newZone.value = {
    name: '',
    description: '',
    radius: 5,
    deliveryCost: 1000,
    latitude: '',
    longitude: ''
  };
};

const saveZone = () => {
  const zone = {
    id: Math.max(...zones.value.map(z => z.id)) + 1,
    ...newZone.value,
    status: 'Active'
  };
  
  zones.value.push(zone);
  closeZoneModal();
  
  if (window.notify) {
    window.notify.success('Zone créée avec succès !', 'La nouvelle zone de livraison a été ajoutée.');
  }
};

const editZone = (zone) => {
  console.log('Modification de la zone:', zone);
  // Logique de modification
};

const deleteZone = (zone) => {
  const index = zones.value.findIndex(z => z.id === zone.id);
  if (index > -1) {
    zones.value.splice(index, 1);
    if (window.notify) {
      window.notify.success('Zone supprimée !', 'La zone de livraison a été supprimée.');
    }
  }
};

const testConfiguration = () => {
  console.log('Test de la configuration géolocalisation');
  if (window.notify) {
    window.notify.info('Test en cours...', 'Vérification de la configuration Google Maps et géofencing.');
  }
};

const saveConfiguration = () => {
  console.log('Sauvegarde de la configuration géolocalisation');
  console.log('Google Maps:', googleMaps.value);
  console.log('Géofencing:', geofencing.value);
  console.log('Zones:', zones.value);
  
  if (window.notify) {
    window.notify.success('Configuration sauvegardée !', 'Tous les paramètres de géolocalisation ont été sauvegardés.');
  }
};

const getZoneStatusClass = (status) => {
  switch (status) {
    case 'Active': return 'bg-green-100 text-green-800';
    case 'Inactive': return 'bg-gray-100 text-gray-800';
    case 'Maintenance': return 'bg-yellow-100 text-yellow-800';
    default: return 'bg-gray-100 text-gray-800';
  }
};
</script>

<style scoped>
@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

@keyframes slideUp {
  from {
    opacity: 0;
    transform: translateY(20px) scale(0.95);
  }
  to {
    opacity: 1;
    transform: translateY(0) scale(1);
  }
}

.animate-fadeIn {
  animation: fadeIn 0.3s ease-out;
}

.animate-slideUp {
  animation: slideUp 0.3s ease-out;
}

.group:focus-within label {
  color: #059669;
}

.group:focus-within input,
.group:focus-within textarea,
.group:focus-within select {
  border-color: #10b981;
  box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
}
</style>
