<template>
  <div class="h-screen w-screen bg-gray-50 flex flex-col overflow-hidden">
    <!-- Header -->
    <header class="bg-green-600 text-white shadow-lg flex-shrink-0">
      <div class="px-8 py-6 flex justify-between items-center">
        <button
          @click="goBack"
          class="flex items-center gap-3 px-6 py-3 bg-green-700 rounded-lg hover:bg-green-800 transition text-xl touch-manipulation"
        >
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
          </svg>
          Retour
        </button>
        
        <h1 class="text-4xl font-bold">Menu</h1>
        
        <div class="flex items-center gap-4">
          <div class="text-right">
            <div class="text-sm opacity-75">Votre commande</div>
            <div class="text-2xl font-bold">{{ cartCount }} article(s)</div>
          </div>
          <button
            @click="goToCheckout"
            class="px-8 py-4 bg-white text-green-600 rounded-lg hover:bg-gray-100 transition font-bold text-xl touch-manipulation"
            :disabled="!cartCount"
          >
            Commander
          </button>
        </div>
      </div>
    </header>

    <div class="flex-1 flex overflow-hidden">
      <!-- Categories Sidebar -->
      <aside class="w-80 bg-white shadow-lg overflow-y-auto">
        <div class="p-6 space-y-3">
          <button
            @click="selectedCategory = null"
            class="w-full px-6 py-4 rounded-lg text-left text-xl font-semibold transition touch-manipulation"
            :class="selectedCategory === null ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
          >
            Tout Voir
          </button>
          <button
            v-for="category in categories"
            :key="category.id"
            @click="selectedCategory = category.id"
            class="w-full px-6 py-4 rounded-lg text-left text-xl font-semibold transition touch-manipulation"
            :class="selectedCategory === category.id ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'"
          >
            {{ category.name }}
          </button>
        </div>
      </aside>

      <!-- Products Grid -->
      <main class="flex-1 overflow-y-auto p-8">
        <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
          <button
            v-for="product in filteredProducts"
            :key="product.id"
            @click="addToCart(product)"
            class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all transform hover:scale-105 active:scale-95 overflow-hidden touch-manipulation"
          >
            <img
              :src="product.image || '/images/placeholder-food.jpg'"
              :alt="product.name"
              class="w-full aspect-square object-cover"
            />
            <div class="p-6">
              <h3 class="font-bold text-2xl mb-2 truncate">{{ product.name }}</h3>
              <p class="text-gray-600 text-lg mb-3 line-clamp-2">{{ product.description }}</p>
              <div class="text-green-600 font-bold text-3xl">{{ formatCurrency(product.price) }}</div>
            </div>
          </button>
        </div>
      </main>
    </div>

    <!-- Success Animation -->
    <transition name="fade">
      <div
        v-if="showAddedAnimation"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 pointer-events-none"
      >
        <div class="bg-white rounded-3xl p-12 text-center">
          <svg class="w-32 h-32 mx-auto text-green-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
          </svg>
          <p class="text-3xl font-bold">Ajouté au panier !</p>
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useCartStore } from '../../stores/cart';
import { formatCurrency } from '../../utils/currency';
import axios from 'axios';

const router = useRouter();
const cartStore = useCartStore();

const selectedCategory = ref(null);
const categories = ref([]);
const products = ref([]);
const showAddedAnimation = ref(false);

const cartCount = computed(() => cartStore.itemCount);

const filteredProducts = computed(() => {
  if (!selectedCategory.value) return products.value;
  return products.value.filter(p => p.category_id === selectedCategory.value);
});

const addToCart = (product) => {
  cartStore.addItem(product);
  
  // Animation de confirmation
  showAddedAnimation.value = true;
  setTimeout(() => {
    showAddedAnimation.value = false;
  }, 800);
};

const goBack = () => {
  router.push({ name: 'kiosk-home' });
};

const goToCheckout = () => {
  router.push({ name: 'kiosk-checkout' });
};

onMounted(async () => {
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
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* Prevent text selection */
* {
  user-select: none;
  -webkit-user-select: none;
}
</style>

