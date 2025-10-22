<template>
  <div id="app" class="min-h-screen bg-gray-50">
    <router-view></router-view>
  </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { useAuthStore } from './stores/auth';
import { useCartStore } from './stores/cart';

const authStore = useAuthStore();
const cartStore = useCartStore();

onMounted(() => {
  // Charger l'utilisateur si connecté
  if (authStore.token) {
    authStore.fetchUser();
  }
  
  // Charger le panier depuis localStorage
  cartStore.loadFromLocalStorage();
});
</script>

<style>
/* Styles globaux déjà dans app.css avec Tailwind */
</style>

