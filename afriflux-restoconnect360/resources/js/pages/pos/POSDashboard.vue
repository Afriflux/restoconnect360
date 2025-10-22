<template>
  <div class="h-full flex flex-col lg:flex-row gap-2 sm:gap-4 p-2 sm:p-4 lg:p-6">
    <!-- Menu / Products - Gauche (scrollable) -->
    <div class="flex-1 bg-white rounded-lg shadow-md overflow-hidden flex flex-col">
      <!-- Search + Categories -->
      <div class="p-2 sm:p-4 border-b flex-shrink-0">
        <input
          type="text"
          v-model="searchQuery"
          placeholder="Rechercher un produit..."
          class="w-full px-3 sm:px-4 py-2 border rounded-lg text-sm sm:text-base text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-primary-500"
        />
        
        <!-- Categories - Scroll horizontal sur mobile -->
        <div class="mt-2 sm:mt-3 flex gap-1 sm:gap-2 overflow-x-auto pb-2">
          <button
            @click="selectedCategory = null"
            class="px-2 sm:px-4 py-1 sm:py-2 rounded-lg text-xs sm:text-sm whitespace-nowrap transition"
            :class="selectedCategory === null ? 'bg-primary-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
          >
            Tout
          </button>
          <button
            v-for="category in categories"
            :key="category.id"
            @click="selectedCategory = category.id"
            class="px-2 sm:px-4 py-1 sm:py-2 rounded-lg text-xs sm:text-sm whitespace-nowrap transition"
            :class="selectedCategory === category.id ? 'bg-primary-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
          >
            {{ category.name }}
          </button>
        </div>
      </div>

      <!-- Products Grid - Scrollable -->
      <div class="flex-1 overflow-y-auto p-2 sm:p-4">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-2 sm:gap-3 lg:gap-4">
          <button
            v-for="product in filteredProducts"
            :key="product.id"
            @click="addToCart(product)"
            class="bg-white border-2 rounded-lg p-2 sm:p-3 hover:border-primary-600 transition active:scale-95 touch-manipulation"
          >
            <img
              :src="product.image || '/images/placeholder-food.jpg'"
              :alt="product.name"
              class="w-full aspect-square object-cover rounded-lg mb-2"
            />
            <h3 class="font-semibold text-xs sm:text-sm text-gray-900 truncate">{{ product.name }}</h3>
            <p class="text-primary-600 font-bold text-sm sm:text-base">{{ formatCurrency(product.price) }}</p>
          </button>
        </div>
      </div>
    </div>

    <!-- Cart / Order - Droite (fixed width sur desktop, fullscreen modal sur mobile) -->
    <div class="w-full lg:w-96 xl:w-[28rem] bg-white rounded-lg shadow-md flex flex-col max-h-[50vh] lg:max-h-full">
      <!-- Header -->
      <div class="p-3 sm:p-4 border-b flex-shrink-0">
        <div class="flex justify-between items-center">
          <h2 class="text-base sm:text-lg font-bold text-gray-900">Commande en cours</h2>
          <button
            v-if="cartItems.length"
            @click="clearCart"
            class="text-xs sm:text-sm text-red-600 hover:text-red-700"
          >
            Vider
          </button>
        </div>
        <div class="mt-2 text-xs sm:text-sm text-gray-600">
          {{ cartItems.length }} article(s)
        </div>
      </div>

      <!-- Cart Items - Scrollable -->
      <div class="flex-1 overflow-y-auto p-3 sm:p-4">
        <div v-if="!cartItems.length" class="text-center text-gray-400 py-8 sm:py-12">
          <svg class="w-12 h-12 sm:w-16 sm:h-16 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
          </svg>
          <p class="text-sm sm:text-base">Panier vide</p>
        </div>

        <div v-else class="space-y-2 sm:space-y-3">
          <div
            v-for="item in cartItems"
            :key="item.id"
            class="flex items-center gap-2 sm:gap-3 p-2 bg-gray-50 rounded-lg"
          >
            <img
              :src="item.image || '/images/placeholder-food.jpg'"
              :alt="item.name"
              class="w-12 h-12 sm:w-16 sm:h-16 object-cover rounded"
            />
            <div class="flex-1 min-w-0">
              <h4 class="font-semibold text-xs sm:text-sm text-gray-900 truncate">{{ item.name }}</h4>
              <p class="text-primary-600 font-bold text-xs sm:text-sm">{{ formatCurrency(item.price) }}</p>
            </div>
            <div class="flex items-center gap-1 sm:gap-2">
              <button
                @click="decrementQuantity(item)"
                class="w-6 h-6 sm:w-8 sm:h-8 bg-gray-200 text-gray-900 rounded-lg hover:bg-gray-300 active:scale-95 touch-manipulation"
              >
                <span class="text-sm sm:text-base">−</span>
              </button>
              <span class="w-6 sm:w-8 text-center font-semibold text-sm sm:text-base text-gray-900">{{ item.quantity }}</span>
              <button
                @click="incrementQuantity(item)"
                class="w-6 h-6 sm:w-8 sm:h-8 bg-gray-200 text-gray-900 rounded-lg hover:bg-gray-300 active:scale-95 touch-manipulation"
              >
                <span class="text-sm sm:text-base">+</span>
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Summary + Actions -->
      <div class="border-t p-3 sm:p-4 flex-shrink-0 space-y-2 sm:space-y-3">
        <div class="space-y-1 text-sm sm:text-base text-gray-900">
          <div class="flex justify-between">
            <span>Sous-total</span>
            <span class="font-semibold">{{ formatCurrency(subtotal) }}</span>
          </div>
          <div class="flex justify-between text-gray-600">
            <span>TVA (18%)</span>
            <span>{{ formatCurrency(tax) }}</span>
          </div>
          <div class="flex justify-between text-lg sm:text-xl font-bold pt-2 border-t text-gray-900">
            <span>Total</span>
            <span class="text-primary-600">{{ formatCurrency(total) }}</span>
          </div>
        </div>

        <div class="grid grid-cols-2 gap-2">
          <button
            @click="saveOrder"
            class="px-3 sm:px-4 py-2 sm:py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition text-sm sm:text-base touch-manipulation active:scale-95"
            :disabled="!cartItems.length"
          >
            Enregistrer
          </button>
          <button
            @click="processPayment"
            class="px-3 sm:px-4 py-2 sm:py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition font-semibold text-sm sm:text-base touch-manipulation active:scale-95"
            :disabled="!cartItems.length"
          >
            Payer
          </button>
        </div>
      </div>
    </div>

    <!-- Payment Modal (overlay sur mobile) -->
    <teleport to="body">
      <div
        v-if="showPaymentModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
        @click.self="showPaymentModal = false"
      >
        <div class="bg-white rounded-lg p-4 sm:p-6 w-full max-w-md">
          <h3 class="text-lg sm:text-xl font-bold mb-4 text-gray-900">Méthode de paiement</h3>
          <div class="space-y-2 sm:space-y-3">
            <button
              @click="confirmPayment('cash')"
              class="w-full p-3 sm:p-4 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm sm:text-base touch-manipulation"
            >
              💵 Espèces
            </button>
            <button
              @click="confirmPayment('card')"
              class="w-full p-3 sm:p-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm sm:text-base touch-manipulation"
            >
              💳 Carte bancaire
            </button>
            <button
              @click="confirmPayment('mobile')"
              class="w-full p-3 sm:p-4 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition text-sm sm:text-base touch-manipulation"
            >
              📱 Mobile Money
            </button>
          </div>
          <button
            @click="showPaymentModal = false"
            class="mt-4 w-full p-2 sm:p-3 bg-gray-300 text-gray-900 rounded-lg hover:bg-gray-400 transition text-sm sm:text-base"
          >
            Annuler
          </button>
        </div>
      </div>
    </teleport>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { formatCurrency } from '../../utils/currency';
import axios from 'axios';

const searchQuery = ref('');
const selectedCategory = ref(null);
const categories = ref([]);
const products = ref([]);
const cartItems = ref([]);
const showPaymentModal = ref(false);

const filteredProducts = computed(() => {
  let filtered = products.value;
  
  if (selectedCategory.value) {
    filtered = filtered.filter(p => p.category_id === selectedCategory.value);
  }
  
  if (searchQuery.value) {
    filtered = filtered.filter(p =>
      p.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
  }
  
  return filtered;
});

const subtotal = computed(() => {
  return cartItems.value.reduce((sum, item) => sum + item.price * item.quantity, 0);
});

const tax = computed(() => {
  return subtotal.value * 0.18;
});

const total = computed(() => {
  return subtotal.value + tax.value;
});

const addToCart = (product) => {
  const existing = cartItems.value.find(item => item.id === product.id);
  if (existing) {
    existing.quantity++;
  } else {
    cartItems.value.push({ ...product, quantity: 1 });
  }
};

const incrementQuantity = (item) => {
  item.quantity++;
};

const decrementQuantity = (item) => {
  if (item.quantity > 1) {
    item.quantity--;
  } else {
    cartItems.value = cartItems.value.filter(i => i.id !== item.id);
  }
};

const clearCart = () => {
  cartItems.value = [];
};

const saveOrder = () => {
  // Enregistrer la commande sans paiement (pour plus tard)
  console.log('Order saved:', cartItems.value);
};

const processPayment = () => {
  showPaymentModal.value = true;
};

const confirmPayment = async (method) => {
  try {
    const orderData = {
      items: cartItems.value.map(item => ({
        product_id: item.id,
        quantity: item.quantity,
        price: item.price,
      })),
      payment_method: method,
      total: total.value,
    };
    
    // Créer la commande via API
    await axios.post('/api/orders', orderData);
    
    // Réinitialiser
    cartItems.value = [];
    showPaymentModal.value = false;
    
    alert('Paiement confirmé !');
  } catch (error) {
    console.error('Payment error:', error);
    alert('Erreur lors du paiement');
  }
};

onMounted(async () => {
  // Charger les catégories et produits
  try {
    const [catRes, prodRes] = await Promise.all([
      axios.get('/api/categories'),
      axios.get('/api/products'),
    ]);
    categories.value = catRes.data.data;
    products.value = prodRes.data.data;
  } catch (error) {
    console.error('Failed to load data:', error);
  }
});
</script>

<style scoped>
/* Touch optimization */
button {
  -webkit-tap-highlight-color: transparent;
}

/* Hide scrollbar but keep functionality */
.overflow-y-auto::-webkit-scrollbar,
.overflow-x-auto::-webkit-scrollbar {
  width: 4px;
  height: 4px;
}

.overflow-y-auto::-webkit-scrollbar-track,
.overflow-x-auto::-webkit-scrollbar-track {
  background: transparent;
}

.overflow-y-auto::-webkit-scrollbar-thumb,
.overflow-x-auto::-webkit-scrollbar-thumb {
  background: #cbd5e0;
  border-radius: 2px;
}
</style>

