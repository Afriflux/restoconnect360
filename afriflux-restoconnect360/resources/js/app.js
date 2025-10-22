import './bootstrap';
import '../css/app.css';

// Sentry Configuration
import * as Sentry from '@sentry/vue';
import { BrowserTracing } from '@sentry/tracing';

// Initialize Sentry
Sentry.init({
    app: null, // Will be set after Vue app creation
    dsn: import.meta.env.VITE_SENTRY_DSN || '',
    integrations: [
        new BrowserTracing({
            routingInstrumentation: Sentry.vueRouterInstrumentation(router),
            tracePropagationTargets: ['localhost', '127.0.0.1', /^https:\/\/.*\.restoconnect360\.com/],
        }),
    ],
    tracesSampleRate: import.meta.env.VITE_SENTRY_TRACES_SAMPLE_RATE || 1.0,
    environment: import.meta.env.VITE_APP_ENV || 'development',
    beforeSend(event) {
        // Filter out development errors
        if (import.meta.env.DEV) {
            console.log('Sentry Event:', event);
        }
        return event;
    },
});

import { createApp } from 'vue';
import { createPinia } from 'pinia';
import { createI18n } from 'vue-i18n';
import App from './App.vue';
import router from './router';

// Import des traductions
import fr from './locales/fr.json';
import en from './locales/en.json';
import ar from './locales/ar.json';
import wo from './locales/wo.json';

// Configuration i18n
const i18n = createI18n({
    legacy: false,
    locale: localStorage.getItem('locale') || 'fr',
    fallbackLocale: 'fr',
    messages: {
        fr,
        en,
        ar,
        wo,
    },
});

// Création de l'app
const app = createApp(App);
const pinia = createPinia();

// Set Sentry app instance
Sentry.setApp(app);

// Configuration Axios pour l'authentification
import axios from 'axios';
const token = localStorage.getItem('token');
if (token) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}

// Plugins
app.use(pinia);
app.use(router);
app.use(i18n);

// Montage de l'app
app.mount('#app');

// Register Service Worker pour PWA
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker
            .register('/sw.js')
            .then((registration) => {
                console.log('ServiceWorker registered:', registration);
            })
            .catch((error) => {
                console.log('ServiceWorker registration failed:', error);
            });
    });
}

// Request notification permission
if ('Notification' in window && Notification.permission === 'default') {
    Notification.requestPermission();
}
