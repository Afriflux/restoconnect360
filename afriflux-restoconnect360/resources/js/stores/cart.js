import { defineStore } from 'pinia';

export const useCartStore = defineStore('cart', {
    state: () => ({
        items: [],
        restaurantId: null,
        deliveryMethod: 'delivery', // delivery, takeaway, dine_in
        deliveryAddress: null,
        notes: '',
    }),

    getters: {
        itemCount: (state) => state.items.reduce((total, item) => total + item.quantity, 0),
        
        subtotal: (state) => {
            return state.items.reduce((total, item) => {
                return total + (item.price * item.quantity);
            }, 0);
        },
        
        tax: (state) => {
            const taxRate = 0.18; // 18% TVA
            return state.items.reduce((total, item) => {
                return total + (item.price * item.quantity * taxRate);
            }, 0);
        },
        
        deliveryFee: (state) => {
            if (state.deliveryMethod !== 'delivery') return 0;
            return 2000; // 2000 CFA par défaut
        },
        
        total: (state) => {
            const subtotal = state.items.reduce((total, item) => {
                return total + (item.price * item.quantity);
            }, 0);
            const tax = state.items.reduce((total, item) => {
                return total + (item.price * item.quantity * 0.18);
            }, 0);
            const deliveryFee = state.deliveryMethod === 'delivery' ? 2000 : 0;
            return subtotal + tax + deliveryFee;
        },
        
        isEmpty: (state) => state.items.length === 0,
    },

    actions: {
        addItem(product, quantity = 1) {
            // Vérifier si le restaurant est le même
            if (this.restaurantId && this.restaurantId !== product.restaurant_id) {
                throw new Error('Vous ne pouvez commander que dans un seul restaurant à la fois');
            }
            
            this.restaurantId = product.restaurant_id;
            
            const existingItem = this.items.find(item => item.id === product.id);
            
            if (existingItem) {
                existingItem.quantity += quantity;
            } else {
                this.items.push({
                    id: product.id,
                    name: product.name,
                    price: product.price,
                    quantity: quantity,
                    image: product.image,
                    restaurant_id: product.restaurant_id,
                });
            }
            
            this.saveToLocalStorage();
        },
        
        removeItem(productId) {
            this.items = this.items.filter(item => item.id !== productId);
            
            if (this.items.length === 0) {
                this.restaurantId = null;
            }
            
            this.saveToLocalStorage();
        },
        
        updateQuantity(productId, quantity) {
            const item = this.items.find(item => item.id === productId);
            
            if (item) {
                if (quantity <= 0) {
                    this.removeItem(productId);
                } else {
                    item.quantity = quantity;
                }
            }
            
            this.saveToLocalStorage();
        },
        
        clear() {
            this.items = [];
            this.restaurantId = null;
            this.deliveryMethod = 'delivery';
            this.deliveryAddress = null;
            this.notes = '';
            localStorage.removeItem('cart');
        },
        
        setDeliveryMethod(method) {
            this.deliveryMethod = method;
            this.saveToLocalStorage();
        },
        
        setDeliveryAddress(address) {
            this.deliveryAddress = address;
            this.saveToLocalStorage();
        },
        
        setNotes(notes) {
            this.notes = notes;
            this.saveToLocalStorage();
        },
        
        saveToLocalStorage() {
            localStorage.setItem('cart', JSON.stringify(this.$state));
        },
        
        loadFromLocalStorage() {
            const saved = localStorage.getItem('cart');
            if (saved) {
                const data = JSON.parse(saved);
                this.$patch(data);
            }
        },
    },
});

