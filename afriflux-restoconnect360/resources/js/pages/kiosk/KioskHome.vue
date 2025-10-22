<template>
  <div class="h-screen w-screen bg-gradient-to-br from-green-600 to-green-800 flex items-center justify-center overflow-hidden">
    <div class="text-center text-white px-8">
      <!-- Logo -->
      <div class="mb-12">
        <h1 class="text-6xl md:text-8xl lg:text-9xl font-bold mb-4">
          RestoConnect360
        </h1>
        <p class="text-2xl md:text-4xl lg:text-5xl font-light">
          {{ $t('kiosk.welcome') }}
        </p>
      </div>

      <!-- CTA -->
      <button
        @click="startOrder"
        class="bg-white text-green-600 px-16 py-8 rounded-3xl text-3xl md:text-4xl lg:text-5xl font-bold hover:bg-gray-100 transition-all transform hover:scale-105 active:scale-95 shadow-2xl touch-manipulation"
      >
        {{ $t('kiosk.startOrder') }}
      </button>

      <!-- Language Selector -->
      <div class="mt-12 flex justify-center gap-4">
        <button
          v-for="lang in languages"
          :key="lang.code"
          @click="changeLanguage(lang.code)"
          class="px-6 py-3 rounded-lg text-xl font-semibold transition-all touch-manipulation"
          :class="currentLanguage === lang.code ? 'bg-white text-green-600' : 'bg-green-600 text-white hover:bg-green-500'"
        >
          {{ lang.flag }} {{ lang.name }}
        </button>
      </div>

      <!-- Idle timer message -->
      <p class="mt-8 text-lg md:text-xl opacity-75">
        {{ $t('kiosk.touchToStart') }}
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { useRouter } from 'vue-router';
import { useI18n } from 'vue-i18n';

const router = useRouter();
const { locale } = useI18n();

const currentLanguage = ref(locale.value);
const languages = [
  { code: 'fr', name: 'Français', flag: '🇫🇷' },
  { code: 'en', name: 'English', flag: '🇬🇧' },
  { code: 'ar', name: 'العربية', flag: '🇸🇦' },
  { code: 'wo', name: 'Wolof', flag: '🇸🇳' },
];

let idleTimer = null;

const startOrder = () => {
  router.push({ name: 'kiosk-menu' });
};

const changeLanguage = (lang) => {
  currentLanguage.value = lang;
  locale.value = lang;
  localStorage.setItem('locale', lang);
};

// Retour auto à l'accueil après inactivité
const resetIdleTimer = () => {
  if (idleTimer) clearTimeout(idleTimer);
  idleTimer = setTimeout(() => {
    router.push({ name: 'kiosk-home' });
  }, 60000); // 1 minute
};

onMounted(() => {
  document.addEventListener('touchstart', resetIdleTimer);
  document.addEventListener('click', resetIdleTimer);
  
  // Fullscreen
  if (document.documentElement.requestFullscreen) {
    document.documentElement.requestFullscreen().catch(() => {});
  }
});

onUnmounted(() => {
  document.removeEventListener('touchstart', resetIdleTimer);
  document.removeEventListener('click', resetIdleTimer);
  if (idleTimer) clearTimeout(idleTimer);
});
</script>

<style scoped>
/* Prevent text selection for kiosk mode */
* {
  user-select: none;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
}
</style>

