<template>
  <Transition name="notification">
    <div 
      v-if="visible" 
      :class="notificationClasses"
      class="fixed top-4 right-4 z-50 max-w-sm w-full mx-4 transform transition-all duration-300"
    >
      <div class="flex items-center space-x-3 p-4 rounded-xl shadow-lg">
        <div :class="iconClasses" class="flex-shrink-0">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="iconPath"/>
          </svg>
        </div>
        <div class="flex-1">
          <p class="font-semibold text-white">{{ title }}</p>
          <p v-if="message" class="text-sm text-white text-opacity-90 mt-1">{{ message }}</p>
        </div>
        <button 
          @click="close"
          class="flex-shrink-0 text-white text-opacity-70 hover:text-opacity-100 transition-colors"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>
    </div>
  </Transition>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';

const props = defineProps({
  type: {
    type: String,
    default: 'success',
    validator: (value) => ['success', 'error', 'warning', 'info'].includes(value)
  },
  title: {
    type: String,
    required: true
  },
  message: {
    type: String,
    default: ''
  },
  duration: {
    type: Number,
    default: 3000
  },
  autoClose: {
    type: Boolean,
    default: true
  }
});

const emit = defineEmits(['close']);

const visible = ref(false);

const iconPaths = {
  success: 'M5 13l4 4L19 7',
  error: 'M6 18L18 6M6 6l12 12',
  warning: 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z',
  info: 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
};

const notificationClasses = computed(() => {
  const baseClasses = 'rounded-xl shadow-lg';
  
  const typeClasses = {
    success: 'bg-gradient-to-r from-green-500 to-emerald-500',
    error: 'bg-gradient-to-r from-red-500 to-red-600',
    warning: 'bg-gradient-to-r from-yellow-500 to-orange-500',
    info: 'bg-gradient-to-r from-blue-500 to-blue-600'
  };
  
  return `${baseClasses} ${typeClasses[props.type]}`;
});

const iconClasses = computed(() => {
  const typeClasses = {
    success: 'text-white',
    error: 'text-white',
    warning: 'text-white',
    info: 'text-white'
  };
  
  return typeClasses[props.type];
});

const iconPath = computed(() => {
  return iconPaths[props.type];
});

const close = () => {
  visible.value = false;
  setTimeout(() => {
    emit('close');
  }, 300);
};

onMounted(() => {
  visible.value = true;
  
  if (props.autoClose) {
    setTimeout(() => {
      close();
    }, props.duration);
  }
});
</script>

<style scoped>
.notification-enter-active,
.notification-leave-active {
  transition: all 0.3s ease;
}

.notification-enter-from {
  opacity: 0;
  transform: translateX(100%);
}

.notification-leave-to {
  opacity: 0;
  transform: translateX(100%);
}
</style>
