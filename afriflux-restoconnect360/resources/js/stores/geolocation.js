import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import { useGeolocation } from '@vueuse/core'

export const useGeolocationStore = defineStore('geolocation', () => {
  // State
  const currentLocation = ref(null)
  const locationPermission = ref('prompt')
  const isLocationLoading = ref(false)
  const locationError = ref(null)
  const nearbyRestaurants = ref([])
  const nearbyCompanies = ref([])
  const recommendations = ref(null)
  const geosensingData = ref(null)

  // Computed
  const hasLocation = computed(() => !!currentLocation.value)
  const canGetLocation = computed(() => locationPermission.value === 'granted')
  
  // Geolocation composable
  const {
    coords,
    locatedAt,
    error: geoError,
    resume,
    pause
  } = useGeolocation()

  // Actions
  const requestLocationPermission = async () => {
    if (!navigator.geolocation) {
      locationError.value = 'Geolocation is not supported by this browser'
      return false
    }

    try {
      isLocationLoading.value = true
      
      const position = await new Promise((resolve, reject) => {
        navigator.geolocation.getCurrentPosition(resolve, reject, {
          enableHighAccuracy: true,
          timeout: 10000,
          maximumAge: 300000 // 5 minutes
        })
      })

      currentLocation.value = {
        latitude: position.coords.latitude,
        longitude: position.coords.longitude,
        accuracy: position.coords.accuracy,
        altitude: position.coords.altitude,
        speed: position.coords.speed,
        timestamp: position.timestamp
      }

      locationPermission.value = 'granted'
      locationError.value = null

      // Create geolocation session
      await createGeolocationSession()
      
      return true
    } catch (err) {
      locationError.value = getLocationErrorMessage(err.code)
      locationPermission.value = 'denied'
      return false
    } finally {
      isLocationLoading.value = false
    }
  }

  const createGeolocationSession = async () => {
    if (!currentLocation.value) return

    try {
      const response = await fetch('/api/geolocation/current-location', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        },
        body: JSON.stringify({
          latitude: currentLocation.value.latitude,
          longitude: currentLocation.value.longitude,
          accuracy: currentLocation.value.accuracy,
          altitude: currentLocation.value.altitude,
          speed: currentLocation.value.speed,
          device_type: getDeviceType()
        })
      })

      const data = await response.json()
      
      if (data.success) {
        currentLocation.value.session_id = data.data.session_id
        currentLocation.value.address = data.data.location
      }
    } catch (error) {
      console.error('Failed to create geolocation session:', error)
    }
  }

  const findNearbyRestaurants = async (filters = {}) => {
    if (!currentLocation.value) {
      throw new Error('No current location available')
    }

    try {
      const params = new URLSearchParams({
        latitude: currentLocation.value.latitude,
        longitude: currentLocation.value.longitude,
        ...filters
      })

      const response = await fetch(`/api/geolocation/nearby-restaurants?${params}`)
      const data = await response.json()

      if (data.success) {
        nearbyRestaurants.value = data.data.restaurants
        return data.data.restaurants
      } else {
        throw new Error(data.message)
      }
    } catch (error) {
      console.error('Failed to find nearby restaurants:', error)
      throw error
    }
  }

  const findNearbyCompanies = async (radius = 10) => {
    if (!currentLocation.value) {
      throw new Error('No current location available')
    }

    try {
      const params = new URLSearchParams({
        latitude: currentLocation.value.latitude,
        longitude: currentLocation.value.longitude,
        radius: radius
      })

      const response = await fetch(`/api/geolocation/nearby-companies?${params}`)
      const data = await response.json()

      if (data.success) {
        nearbyCompanies.value = data.data.companies
        return data.data.companies
      } else {
        throw new Error(data.message)
      }
    } catch (error) {
      console.error('Failed to find nearby companies:', error)
      throw error
    }
  }

  const getRecommendations = async () => {
    if (!currentLocation.value) {
      throw new Error('No current location available')
    }

    try {
      const params = new URLSearchParams({
        latitude: currentLocation.value.latitude,
        longitude: currentLocation.value.longitude
      })

      const response = await fetch(`/api/geolocation/recommendations?${params}`)
      const data = await response.json()

      if (data.success) {
        recommendations.value = data.data
        return data.data
      } else {
        throw new Error(data.message)
      }
    } catch (error) {
      console.error('Failed to get recommendations:', error)
      throw error
    }
  }

  const reverseGeocode = async (latitude, longitude) => {
    try {
      const params = new URLSearchParams({
        latitude: latitude,
        longitude: longitude
      })

      const response = await fetch(`/api/geolocation/reverse-geocode?${params}`)
      const data = await response.json()

      if (data.success) {
        return data.data.address
      } else {
        throw new Error(data.message)
      }
    } catch (error) {
      console.error('Failed to reverse geocode:', error)
      throw error
    }
  }

  const calculateDistance = (lat1, lon1, lat2, lon2) => {
    const R = 6371 // Earth's radius in kilometers
    const dLat = (lat2 - lat1) * Math.PI / 180
    const dLon = (lon2 - lon1) * Math.PI / 180
    const a = 
      Math.sin(dLat/2) * Math.sin(dLat/2) +
      Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * 
      Math.sin(dLon/2) * Math.sin(dLon/2)
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a))
    return R * c
  }

  const getGeosensingData = async (filters = {}) => {
    try {
      const params = new URLSearchParams(filters)
      const response = await fetch(`/api/geolocation/geosensing-data?${params}`)
      const data = await response.json()

      if (data.success) {
        geosensingData.value = data.data
        return data.data
      } else {
        throw new Error(data.message)
      }
    } catch (error) {
      console.error('Failed to get geosensing data:', error)
      throw error
    }
  }

  const clearLocation = () => {
    currentLocation.value = null
    locationError.value = null
    nearbyRestaurants.value = []
    nearbyCompanies.value = []
    recommendations.value = null
  }

  // Helper functions
  const getDeviceType = () => {
    const userAgent = navigator.userAgent.toLowerCase()
    const screenWidth = window.screen.width
    
    if (/tablet|ipad|playbook|silk/i.test(userAgent)) {
      return 'tablet'
    } else if (/mobile|iphone|ipod|android|blackberry|opera|mini|windows\sce|palm|smartphone|iemobile/i.test(userAgent)) {
      return 'mobile'
    } else if (screenWidth >= 1920) {
      return 'desktop'
    } else {
      return 'desktop'
    }
  }

  const getLocationErrorMessage = (errorCode) => {
    switch (errorCode) {
      case 1:
        return 'Location access denied by user'
      case 2:
        return 'Location information is unavailable'
      case 3:
        return 'Location request timed out'
      default:
        return 'An unknown error occurred while retrieving location'
    }
  }

  return {
    // State
    currentLocation,
    locationPermission,
    isLocationLoading,
    locationError,
    nearbyRestaurants,
    nearbyCompanies,
    recommendations,
    geosensingData,
    
    // Computed
    hasLocation,
    canGetLocation,
    
    // Actions
    requestLocationPermission,
    findNearbyRestaurants,
    findNearbyCompanies,
    getRecommendations,
    reverseGeocode,
    calculateDistance,
    getGeosensingData,
    clearLocation,
    
    // Geolocation composable
    coords,
    locatedAt,
    geoError,
    resume,
    pause
  }
})
