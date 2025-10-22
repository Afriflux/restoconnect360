import { defineStore } from 'pinia';
import axios from 'axios';

export const useRestaurantStore = defineStore('restaurant', {
    state: () => ({
        restaurants: [],
        currentRestaurant: null,
        menus: [],
        categories: [],
        products: [],
        loading: false,
        error: null,
        pagination: {
            total: 0,
            perPage: 12,
            currentPage: 1,
            lastPage: 1,
        },
    }),

    getters: {
        activeRestaurants: (state) => state.restaurants.filter(r => r.is_active),
        featuredRestaurants: (state) => state.restaurants.filter(r => r.is_featured),
        productsByCategory: (state) => (categoryId) => {
            return state.products.filter(p => p.category_id === categoryId);
        },
        availableProducts: (state) => state.products.filter(p => p.is_available),
    },

    actions: {
        async fetchRestaurants(params = {}) {
            this.loading = true;
            this.error = null;
            
            try {
                const response = await axios.get('/api/restaurants', { params });
                this.restaurants = response.data.data;
                this.pagination = {
                    total: response.data.total,
                    perPage: response.data.per_page,
                    currentPage: response.data.current_page,
                    lastPage: response.data.last_page,
                };
            } catch (error) {
                this.error = error.response?.data?.message || 'Failed to fetch restaurants';
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async fetchRestaurant(id) {
            this.loading = true;
            this.error = null;
            
            try {
                const response = await axios.get(`/api/restaurants/${id}`);
                this.currentRestaurant = response.data.data;
                return response.data.data;
            } catch (error) {
                this.error = error.response?.data?.message || 'Failed to fetch restaurant';
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async searchNearby(latitude, longitude, radius = 10) {
            this.loading = true;
            this.error = null;
            
            try {
                const response = await axios.get('/api/geolocation/nearby', {
                    params: { latitude, longitude, radius }
                });
                this.restaurants = response.data.data;
                return response.data.data;
            } catch (error) {
                this.error = error.response?.data?.message || 'Failed to search nearby';
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async fetchMenus(restaurantId) {
            this.loading = true;
            
            try {
                const response = await axios.get(`/api/restaurants/${restaurantId}/menus`);
                this.menus = response.data.data;
            } catch (error) {
                this.error = error.response?.data?.message || 'Failed to fetch menus';
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async fetchProducts(restaurantId) {
            this.loading = true;
            
            try {
                const response = await axios.get(`/api/restaurants/${restaurantId}/products`);
                this.products = response.data.data;
            } catch (error) {
                this.error = error.response?.data?.message || 'Failed to fetch products';
                throw error;
            } finally {
                this.loading = false;
            }
        },
    },
});

