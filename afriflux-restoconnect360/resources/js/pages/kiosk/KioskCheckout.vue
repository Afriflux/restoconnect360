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
          Retour au Menu
        </button>
        
        <h1 class="text-4xl font-bold">Votre Commande</h1>
        
        <div class="w-32"></div>
      </div>
    </header>

    <div class="flex-1 flex overflow-hidden">
      <!-- Cart Items -->
      <div class="flex-1 overflow-y-auto p-8">
        <div class="max-w-4xl mx-auto space-y-4">
          <div
            v-for="item in cartStore.items"
            :key="item.id"
            class="bg-white rounded-2xl shadow-lg p-6 flex items-center gap-6"
          >
            <img
              :src="item.image || '/images/placeholder-food.jpg'"
              :alt="item.name"
              class="w-32 h-32 object-cover rounded-lg"
            />
            <div class="flex-1">
              <h3 class="text-2xl font-bold mb-2">{{ item.name }}</h3>
              <p class="text-green-600 font-bold text-xl">{{ formatCurrency(item.price) }}</p>
            </div>
            <div class="flex items-center gap-4">
              <button
                @click="cartStore.updateQuantity(item.id, item.quantity - 1)"
                class="w-16 h-16 bg-gray-200 rounded-lg hover:bg-gray-300 transition text-3xl font-bold touch-manipulation"
              >
                −
              </button>
              <span class="text-3xl font-bold w-16 text-center">{{ item.quantity }}</span>
              <button
                @click="cartStore.updateQuantity(item.id, item.quantity + 1)"
                class="w-16 h-16 bg-gray-200 rounded-lg hover:bg-gray-300 transition text-3xl font-bold touch-manipulation"
              >
                +
              </button>
            </div>
            <div class="text-right">
              <div class="text-3xl font-bold text-green-600">
                {{ formatCurrency(item.price * item.quantity) }}
              </div>
              <button
                @click="cartStore.removeItem(item.id)"
                class="mt-2 text-red-600 hover:text-red-700 text-lg"
              >
                Retirer
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Summary & Payment -->
      <aside class="w-[32rem] bg-white shadow-lg p-8 flex flex-col">
        <h2 class="text-3xl font-bold mb-6">Récapitulatif</h2>
        
        <div class="flex-1 space-y-4 text-2xl">
          <div class="flex justify-between">
            <span>Sous-total</span>
            <span class="font-semibold">{{ formatCurrency(cartStore.subtotal) }}</span>
          </div>
          <div class="flex justify-between text-gray-600">
            <span>TVA (18%)</span>
            <span>{{ formatCurrency(cartStore.tax) }}</span>
          </div>
          <div class="flex justify-between text-4xl font-bold pt-4 border-t">
            <span>Total</span>
            <span class="text-green-600">{{ formatCurrency(cartStore.total) }}</span>
          </div>
        </div>

        <div class="mt-8 space-y-4">
          <h3 class="text-2xl font-bold">Méthode de paiement</h3>
          
          <button
            @click="processPayment('cash')"
            class="w-full p-6 bg-green-600 text-white rounded-2xl hover:bg-green-700 transition font-bold text-2xl flex items-center justify-center gap-4 touch-manipulation"
            :disabled="processing"
          >
            <span class="text-4xl">💵</span>
            <span>Espèces</span>
          </button>
          
          <button
            @click="processPayment('card')"
            class="w-full p-6 bg-blue-600 text-white rounded-2xl hover:bg-blue-700 transition font-bold text-2xl flex items-center justify-center gap-4 touch-manipulation"
            :disabled="processing"
          >
            <span class="text-4xl">💳</span>
            <span>Carte bancaire</span>
          </button>
          
          <button
            @click="processPayment('mobile')"
            class="w-full p-6 bg-orange-600 text-white rounded-2xl hover:bg-orange-700 transition font-bold text-2xl flex items-center justify-center gap-4 touch-manipulation"
            :disabled="processing"
          >
            <span class="text-4xl">📱</span>
            <span>Mobile Money</span>
          </button>
        </div>
      </aside>
    </div>

    <!-- Success Modal -->
    <teleport to="body">
      <div
        v-if="showSuccess"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
      >
        <div class="bg-white rounded-3xl p-16 text-center max-w-2xl">
          <svg class="w-48 h-48 mx-auto text-green-600 mb-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          <h2 class="text-5xl font-bold mb-4">Commande confirmée !</h2>
          <p class="text-3xl text-gray-600 mb-8">Numéro de commande : #{{ orderNumber }}</p>
          <p class="text-2xl text-gray-600 mb-8">Temps d'attente estimé : {{ estimatedTime }} minutes</p>
          <div class="text-xl text-gray-500">
            Redirection dans {{ countdown }} secondes...
          </div>
        </div>
      </div>
    </teleport>
  </div>
</template>

<script setup>
import { ref, onUnmounted } from 'vue';
import { useRouter } from 'vue-router';
import { useCartStore } from '../../stores/cart';
import { formatCurrency } from '../../utils/currency';
import axios from 'axios';

const router = useRouter();
const cartStore = useCartStore();

const processing = ref(false);
const showSuccess = ref(false);
const orderNumber = ref(null);
const estimatedTime = ref(15);
const countdown = ref(10);

let countdownInterval = null;

const goBack = () => {
  router.push({ name: 'kiosk-menu' });
};

const processPayment = async (method) => {
  processing.value = true;
  
  try {
    const orderData = {
      items: cartStore.items.map(item => ({
        product_id: item.id,
        quantity: item.quantity,
        price: item.price,
      })),
      payment_method: method,
      total: cartStore.total,
      order_type: 'dine_in', // Kiosk orders are for dine-in
    };
    
    const response = await axios.post('/api/orders', orderData);
    orderNumber.value = response.data.data.id;
    
    // Afficher le succès
    showSuccess.value = true;
    cartStore.clear();
    
    // Countdown pour retour auto
    countdownInterval = setInterval(() => {
      countdown.value--;
      if (countdown.value === 0) {
        clearInterval(countdownInterval);
        router.push({ name: 'kiosk-home' });
      }
    }, 1000);
    
  } catch (error) {
    console.error('Payment error:', error);
    alert('Erreur lors du paiement. Veuillez réessayer.');
  } finally {
    processing.value = false;
  }
};

onUnmounted(() => {
  if (countdownInterval) {
    clearInterval(countdownInterval);
  }
});
</script>

<style scoped>
/* Prevent text selection */
* {
  user-select: none;
  -webkit-user-select: none;
}
</style>

