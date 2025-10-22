import { defineStore } from 'pinia';
import axios from 'axios';

export const useDeliveryStore = defineStore('delivery', {
    state: () => ({
        deliveries: [],
        currentDelivery: null,
        trackingHistory: [],
        loading: false,
        error: null,
        liveTracking: null, // Pour le tracking en temps réel
    }),

    getters: {
        pendingDeliveries: (state) => state.deliveries.filter(d => d.status === 'pending'),
        assignedDeliveries: (state) => state.deliveries.filter(d => d.status === 'assigned'),
        pickedUpDeliveries: (state) => state.deliveries.filter(d => d.status === 'picked_up'),
        inTransitDeliveries: (state) => state.deliveries.filter(d => d.status === 'in_transit'),
        deliveredDeliveries: (state) => state.deliveries.filter(d => d.status === 'delivered'),
    },

    actions: {
        async fetchDeliveries(params = {}) {
            this.loading = true;
            this.error = null;
            
            try {
                const response = await axios.get('/api/deliveries', { params });
                this.deliveries = response.data.data;
            } catch (error) {
                this.error = error.response?.data?.message || 'Failed to fetch deliveries';
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async fetchDelivery(id) {
            this.loading = true;
            this.error = null;
            
            try {
                const response = await axios.get(`/api/deliveries/${id}`);
                this.currentDelivery = response.data.data;
                return response.data.data;
            } catch (error) {
                this.error = error.response?.data?.message || 'Failed to fetch delivery';
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async trackDelivery(id) {
            this.loading = true;
            this.error = null;
            
            try {
                const response = await axios.get(`/api/deliveries/${id}/track`);
                this.trackingHistory = response.data.data;
                return response.data.data;
            } catch (error) {
                this.error = error.response?.data?.message || 'Failed to track delivery';
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async updateLocation(deliveryId, latitude, longitude) {
            try {
                const response = await axios.post(`/api/deliveries/${deliveryId}/location`, {
                    latitude,
                    longitude,
                });
                
                // Mettre à jour le tracking en temps réel
                this.liveTracking = {
                    latitude,
                    longitude,
                    timestamp: new Date(),
                };
                
                return response.data;
            } catch (error) {
                console.error('Failed to update location:', error);
                throw error;
            }
        },

        async updateDeliveryStatus(id, status) {
            this.loading = true;
            this.error = null;
            
            try {
                const response = await axios.patch(`/api/deliveries/${id}/status`, { status });
                const index = this.deliveries.findIndex(d => d.id === id);
                if (index !== -1) {
                    this.deliveries[index] = response.data.data;
                }
                if (this.currentDelivery?.id === id) {
                    this.currentDelivery = response.data.data;
                }
                return response.data.data;
            } catch (error) {
                this.error = error.response?.data?.message || 'Failed to update delivery';
                throw error;
            } finally {
                this.loading = false;
            }
        },

        startLiveTracking(deliveryId) {
            // Tracking GPS en temps réel toutes les 10 secondes
            if ('geolocation' in navigator) {
                const watchId = navigator.geolocation.watchPosition(
                    (position) => {
                        this.updateLocation(
                            deliveryId,
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
                
                return watchId;
            }
        },

        stopLiveTracking(watchId) {
            if (watchId && 'geolocation' in navigator) {
                navigator.geolocation.clearWatch(watchId);
            }
        },
    },
});

