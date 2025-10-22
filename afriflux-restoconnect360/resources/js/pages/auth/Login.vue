<template>
  <div class="min-h-screen flex">
    <!-- Left Side - Form -->
    <div class="flex-1 flex items-center justify-center px-4 sm:px-6 lg:px-8 bg-white">
      <div class="w-full max-w-md space-y-8">
        <!-- Logo & Title -->
        <div class="text-center">
          <router-link to="/" class="inline-flex items-center justify-center space-x-3 group">
            <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center shadow-xl transform group-hover:scale-110 transition-transform">
              <span class="text-white text-3xl font-bold">R</span>
            </div>
          </router-link>
          <h2 class="mt-6 text-4xl font-extrabold text-gray-900">
            Bon retour ! 👋
          </h2>
          <p class="mt-2 text-sm text-gray-600">
            Connectez-vous pour accéder à votre tableau de bord
          </p>
        </div>

        <!-- Test Accounts Info -->
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-4">
          <div class="flex items-start gap-3">
            <div class="flex-shrink-0">
              <svg class="w-5 h-5 text-green-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
              </svg>
            </div>
            <div class="flex-1 text-sm">
              <p class="font-semibold text-green-900 mb-2">Comptes de test disponibles :</p>
              <div class="space-y-1.5 text-green-800">
                <div class="flex items-center justify-between bg-white/60 px-3 py-1.5 rounded-lg">
                  <span class="font-medium text-xs">👑 Super Admin :</span>
                  <button 
                    @click="fillCredentials('superadmin@restoconnect360.com', 'Admin@2025')"
                    data-copy-btn="superadmin"
                    class="text-xs bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded transition-colors duration-200 flex items-center gap-1"
                  >
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    Remplir
                  </button>
                </div>
                <div class="flex items-center justify-between bg-white/60 px-3 py-1.5 rounded-lg">
                  <span class="font-medium text-xs">🏢 Admin :</span>
                  <button 
                    @click="fillCredentials('admin@restoconnect360.com', 'Admin@2025')"
                    data-copy-btn="admin"
                    class="text-xs bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded transition-colors duration-200 flex items-center gap-1"
                  >
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    Remplir
                  </button>
                </div>
                <div class="flex items-center justify-between bg-white/60 px-3 py-1.5 rounded-lg">
                  <span class="font-medium text-xs">🏪 Restaurant :</span>
                  <button 
                    @click="fillCredentials('restaurant@restoconnect360.com', 'Restaurant@2025')"
                    data-copy-btn="restaurant"
                    class="text-xs bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded transition-colors duration-200 flex items-center gap-1"
                  >
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    Remplir
                  </button>
                </div>
                <div class="flex items-center justify-between bg-white/60 px-3 py-1.5 rounded-lg">
                  <span class="font-medium text-xs">🎯 Agent :</span>
                  <button 
                    @click="fillCredentials('agent@restoconnect360.com', 'Agent@2025')"
                    data-copy-btn="agent"
                    class="text-xs bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded transition-colors duration-200 flex items-center gap-1"
                  >
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    Remplir
                  </button>
                </div>
                <div class="flex items-center justify-between bg-white/60 px-3 py-1.5 rounded-lg">
                  <span class="font-medium text-xs">🚗 Livreur :</span>
                  <button 
                    @click="fillCredentials('driver1@restoconnect360.com', 'Driver@2025')"
                    data-copy-btn="driver1"
                    class="text-xs bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded transition-colors duration-200 flex items-center gap-1"
                  >
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    Remplir
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Form -->
        <form class="mt-8 space-y-6" @submit.prevent="handleLogin">
          <div class="space-y-4">
            <!-- Email -->
            <div>
              <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                Adresse email
              </label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                  <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                  </svg>
                </div>
                <input
                  id="email"
                  v-model="form.email"
                  type="email"
                  required
                  class="appearance-none block w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                  placeholder="vous@exemple.com"
                />
              </div>
            </div>

            <!-- Password -->
            <div>
              <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                Mot de passe
              </label>
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                  <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                  </svg>
                </div>
                <input
                  id="password"
                  v-model="form.password"
                  :type="showPassword ? 'text' : 'password'"
                  required
                  class="appearance-none block w-full pl-12 pr-12 py-3 border border-gray-300 rounded-xl placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                  placeholder="••••••••"
                />
                <button
                  type="button"
                  @click="showPassword = !showPassword"
                  class="absolute inset-y-0 right-0 pr-4 flex items-center"
                >
                  <svg v-if="!showPassword" class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                  </svg>
                  <svg v-else class="h-5 w-5 text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                  </svg>
                </button>
              </div>
            </div>
          </div>

          <!-- Remember & Forgot -->
          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <input
                id="remember-me"
                v-model="rememberMe"
                type="checkbox"
                class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded"
              />
              <label for="remember-me" class="ml-2 block text-sm text-gray-900">
                Se souvenir de moi
              </label>
            </div>
            <a href="#" class="text-sm font-medium text-green-600 hover:text-green-500">
              Mot de passe oublié ?
            </a>
          </div>

          <!-- Error Message -->
          <div v-if="error" class="bg-red-50 border border-red-200 rounded-xl p-4">
            <div class="flex items-center gap-3">
              <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
              </svg>
              <p class="text-sm text-red-800">{{ error }}</p>
            </div>
          </div>

          <!-- Submit Button -->
          <button
            type="submit"
            :disabled="loading"
            class="w-full flex justify-center items-center gap-2 py-3.5 px-4 border border-transparent rounded-xl shadow-lg text-sm font-semibold text-white bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 disabled:opacity-50 disabled:cursor-not-allowed transform hover:scale-[1.02] transition-all"
          >
            <svg v-if="loading" class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span v-if="!loading">Se connecter</span>
            <span v-else>Connexion en cours...</span>
          </button>

          <!-- Register Link -->
          <div class="text-center">
            <p class="text-sm text-gray-600">
              Pas encore de compte ?
              <router-link to="/auth/register" class="font-semibold text-green-600 hover:text-green-500">
                Créer un compte gratuitement
              </router-link>
            </p>
          </div>
        </form>
      </div>
    </div>

    <!-- Right Side - Image/Branding -->
    <div class="hidden lg:block lg:flex-1 relative overflow-hidden">
      <div class="absolute inset-0 bg-gradient-to-br from-green-600 via-emerald-600 to-green-700">
        <div class="absolute inset-0 opacity-10">
          <div class="absolute top-0 -left-4 w-72 h-72 bg-white rounded-full mix-blend-multiply filter blur-xl animate-blob"></div>
          <div class="absolute top-0 -right-4 w-72 h-72 bg-yellow-300 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-2000"></div>
          <div class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-4000"></div>
        </div>
      </div>
      <div class="relative h-full flex flex-col justify-center items-center px-12 text-white">
        <div class="max-w-md space-y-8">
          <h1 class="text-5xl font-extrabold leading-tight">
            Gérez votre restaurant comme un pro
          </h1>
          <p class="text-xl text-green-100">
            POS, Livraison GPS, Paiements mobiles africains, WhatsApp, Analytics et bien plus dans une seule plateforme.
          </p>
          <div class="grid grid-cols-2 gap-6 pt-8">
            <div class="flex items-center gap-3">
              <div class="flex-shrink-0 w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                <span class="text-2xl">🛒</span>
              </div>
              <div>
                <div class="font-semibold">POS Multi-Support</div>
                <div class="text-sm text-green-100">Tous les appareils</div>
              </div>
            </div>
            <div class="flex items-center gap-3">
              <div class="flex-shrink-0 w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                <span class="text-2xl">🚗</span>
              </div>
              <div>
                <div class="font-semibold">Livraison GPS</div>
                <div class="text-sm text-green-100">Temps réel</div>
              </div>
            </div>
            <div class="flex items-center gap-3">
              <div class="flex-shrink-0 w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                <span class="text-2xl">💳</span>
              </div>
              <div>
                <div class="font-semibold">Paiements</div>
                <div class="text-sm text-green-100">Wave, OM, MTN</div>
              </div>
            </div>
            <div class="flex items-center gap-3">
              <div class="flex-shrink-0 w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                <span class="text-2xl">📊</span>
              </div>
              <div>
                <div class="font-semibold">Analytics</div>
                <div class="text-sm text-green-100">Temps réel</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../../stores/auth';

const router = useRouter();
const authStore = useAuthStore();

const form = ref({
  email: '',
  password: '',
});

const showPassword = ref(false);
const rememberMe = ref(false);
const loading = ref(false);
const error = ref(null);

const handleLogin = async () => {
  loading.value = true;
  error.value = null;
  
  try {
    // Simulate API call
    await new Promise(resolve => setTimeout(resolve, 1000));
    
    const email = form.value.email;
    const password = form.value.password;
    
    // Map des utilisateurs avec leurs informations
    const validUsers = {
      'superadmin@restoconnect360.com': {
        password: 'Admin@2025',
        role: 'super_admin',
        name: 'Super Admin',
        redirect: '/admin/super-admin'
      },
      'admin@restoconnect360.com': {
        password: 'Admin@2025',
        role: 'admin',
        name: 'Admin RestoConnect360',
        redirect: '/admin/dashboard'
      },
      'restaurant@restoconnect360.com': {
        password: 'Restaurant@2025',
        role: 'restaurant_manager',
        name: 'Fatou Sall',
        redirect: '/admin/restaurant'
      },
      'agent@restoconnect360.com': {
        password: 'Agent@2025',
        role: 'agent',
        name: 'Amadou Ndiaye',
        redirect: '/admin/agent'
      },
      'driver1@restoconnect360.com': {
        password: 'Driver@2025',
        role: 'driver',
        name: 'Livreur 1',
        redirect: '/driver'
      },
      'driver2@restoconnect360.com': {
        password: 'Driver@2025',
        role: 'driver',
        name: 'Livreur 2',
        redirect: '/driver'
      },
      'driver3@restoconnect360.com': {
        password: 'Driver@2025',
        role: 'driver',
        name: 'Livreur 3',
        redirect: '/driver'
      },
      'driver4@restoconnect360.com': {
        password: 'Driver@2025',
        role: 'driver',
        name: 'Livreur 4',
        redirect: '/driver'
      },
      'driver5@restoconnect360.com': {
        password: 'Driver@2025',
        role: 'driver',
        name: 'Livreur 5',
        redirect: '/driver'
      },
      'employee@restoconnect360.com': {
        password: 'Employee@2025',
        role: 'employee',
        name: 'Aïssa Diop',
        redirect: '/pos'
      },
      // Anciens identifiants pour compatibilité
      'manager@restaurantdakar.com': {
        password: 'Manager@2025',
        role: 'restaurant_manager',
        name: 'Mamadou Diallo',
        redirect: '/admin/restaurant'
      }
    };
    
    // Vérifier si l'utilisateur existe et le mot de passe est correct
    const user = validUsers[email];
    
    if (user && user.password === password) {
      // Simuler une connexion réussie
      const userData = {
        id: Math.floor(Math.random() * 1000),
        email: email,
        name: user.name,
        role: user.role,
        isAuthenticated: true,
        is_active: true,
        created_at: new Date().toISOString(),
        last_login_at: new Date().toISOString()
      };
      
      // Mettre à jour le store d'authentification
      authStore.setUser(userData);
      
      // Rediriger vers la route appropriée
      router.push(user.redirect);
      
    } else {
      error.value = 'Email ou mot de passe incorrect';
    }
  } catch (err) {
    error.value = 'Une erreur est survenue lors de la connexion';
    console.error('Login error:', err);
  } finally {
    loading.value = false;
  }
};

const fillCredentials = (email, password) => {
  // Animation de feedback visuel avant de remplir
  const clickedBtn = document.querySelector(`[data-copy-btn="${email.split('@')[0]}"]`);
  if (clickedBtn) {
    clickedBtn.style.transform = 'scale(0.95)';
    clickedBtn.style.backgroundColor = '#059669'; // green-600
    setTimeout(() => {
      clickedBtn.style.transform = 'scale(1)';
      clickedBtn.style.backgroundColor = '#10b981'; // green-500
    }, 150);
  }
  
  // Remplir les champs avec un léger délai pour l'effet visuel
  setTimeout(() => {
    form.value.email = email;
    form.value.password = password;
    
    // Effacer les erreurs précédentes
    error.value = null;
    
    // Focus sur le champ email pour montrer que c'est rempli
    const emailInput = document.getElementById('email');
    if (emailInput) {
      emailInput.focus();
      emailInput.blur();
    }
  }, 100);
};
</script>

<style scoped>
@keyframes blob {
  0%, 100% {
    transform: translate(0, 0) scale(1);
  }
  33% {
    transform: translate(30px, -50px) scale(1.1);
  }
  66% {
    transform: translate(-20px, 20px) scale(0.9);
  }
}

.animate-blob {
  animation: blob 7s infinite;
}

.animation-delay-2000 {
  animation-delay: 2s;
}

.animation-delay-4000 {
  animation-delay: 4s;
}
</style>
