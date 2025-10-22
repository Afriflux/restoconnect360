import { defineStore } from 'pinia';
import axios from 'axios';

export const useOrderStore = defineStore('order', {
    state: () => ({
        orders: [],
        currentOrder: null,
        loading: false,
        error: null,
    }),

    getters: {
        pendingOrders: (state) => state.orders.filter(o => o.status === 'pending'),
        confirmedOrders: (state) => state.orders.filter(o => o.status === 'confirmed'),
        preparingOrders: (state) => state.orders.filter(o => o.status === 'preparing'),
        readyOrders: (state) => state.orders.filter(o => o.status === 'ready'),
        deliveredOrders: (state) => state.orders.filter(o => o.status === 'delivered'),
    },

    actions: {
        async createOrder(orderData) {
            this.loading = true;
            this.error = null;
            
            try {
                const response = await axios.post('/api/orders', orderData);
                this.currentOrder = response.data.data;
                return response.data.data;
            } catch (error) {
                this.error = error.response?.data?.message || 'Failed to create order';
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async fetchOrders(params = {}) {
            this.loading = true;
            this.error = null;
            
            try {
                const response = await axios.get('/api/orders', { params });
                this.orders = response.data.data;
            } catch (error) {
                this.error = error.response?.data?.message || 'Failed to fetch orders';
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async fetchOrder(id) {
            this.loading = true;
            this.error = null;
            
            try {
                const response = await axios.get(`/api/orders/${id}`);
                this.currentOrder = response.data.data;
                return response.data.data;
            } catch (error) {
                this.error = error.response?.data?.message || 'Failed to fetch order';
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async updateOrderStatus(id, status) {
            this.loading = true;
            this.error = null;
            
            try {
                const response = await axios.patch(`/api/orders/${id}/status`, { status });
                const index = this.orders.findIndex(o => o.id === id);
                if (index !== -1) {
                    this.orders[index] = response.data.data;
                }
                if (this.currentOrder?.id === id) {
                    this.currentOrder = response.data.data;
                }
                return response.data.data;
            } catch (error) {
                this.error = error.response?.data?.message || 'Failed to update order';
                throw error;
            } finally {
                this.loading = false;
            }
        },

        async cancelOrder(id) {
            return this.updateOrderStatus(id, 'canceled');
        },
    },
});

