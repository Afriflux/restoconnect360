<template>
  <div class="py-8">
    <div class="max-w-7xl mx-auto px-4">
      <h1 class="text-3xl font-bold">{{ $t('cart.title') }}</h1>
      <div v-if="cartStore.isEmpty" class="text-center py-12">
        <p class="text-gray-600">{{ $t('cart.empty') }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useCartStore } from '../../stores/cart';
const cartStore = useCartStore();
</script>

