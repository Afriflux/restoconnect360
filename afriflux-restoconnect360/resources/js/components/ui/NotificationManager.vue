<template>
  <div>
    <!-- Notifications -->
    <ModernNotification
      v-for="notification in notifications"
      :key="notification.id"
      :type="notification.type"
      :title="notification.title"
      :message="notification.message"
      :duration="notification.duration"
      @close="removeNotification(notification.id)"
    />
  </div>
</template>

<script setup>
import { ref } from 'vue';
import ModernNotification from './ModernNotification.vue';

const notifications = ref([]);

let nextId = 1;

const addNotification = (notification) => {
  const id = nextId++;
  notifications.value.push({
    id,
    ...notification
  });
  
  return id;
};

const removeNotification = (id) => {
  const index = notifications.value.findIndex(n => n.id === id);
  if (index > -1) {
    notifications.value.splice(index, 1);
  }
};

const success = (title, message = '', duration = 3000) => {
  return addNotification({ type: 'success', title, message, duration });
};

const error = (title, message = '', duration = 5000) => {
  return addNotification({ type: 'error', title, message, duration });
};

const warning = (title, message = '', duration = 4000) => {
  return addNotification({ type: 'warning', title, message, duration });
};

const info = (title, message = '', duration = 3000) => {
  return addNotification({ type: 'info', title, message, duration });
};

// Exposer les méthodes globalement
window.notify = {
  success,
  error,
  warning,
  info
};
</script>
