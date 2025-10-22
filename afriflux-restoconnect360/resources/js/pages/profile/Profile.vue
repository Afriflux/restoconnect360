<template>
  <div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-md p-6">
      <div class="flex items-center space-x-4">
        <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center">
          <span class="text-white text-3xl font-bold">{{ userInitials }}</span>
        </div>
        <div class="flex-1">
          <h1 class="text-2xl font-bold text-gray-900">{{ user.name }}</h1>
          <p class="text-gray-600">{{ user.email }}</p>
          <span class="inline-block px-3 py-1 mt-2 bg-green-100 text-green-800 text-sm font-semibold rounded-full">
            {{ roleLabel }}
          </span>
        </div>
        <button 
          @click="editMode = !editMode"
          class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition"
        >
          {{ editMode ? 'Annuler' : 'Modifier' }}
        </button>
      </div>
    </div>

    <!-- Informations Personnelles -->
    <div class="bg-white rounded-xl shadow-md p-6">
      <h2 class="text-xl font-bold mb-6">Informations Personnelles</h2>
      
      <form @submit.prevent="saveProfile" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Nom complet</label>
            <input 
              v-model="form.name"
              :disabled="!editMode"
              type="text"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent disabled:bg-gray-100"
              required
            >
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
            <input 
              v-model="form.email"
              :disabled="!editMode"
              type="email"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent disabled:bg-gray-100"
              required
            >
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
            <input 
              v-model="form.phone"
              :disabled="!editMode"
              type="tel"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent disabled:bg-gray-100"
            >
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Langue</label>
            <select 
              v-model="form.language"
              :disabled="!editMode"
              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent disabled:bg-gray-100"
            >
              <option value="fr">Français</option>
              <option value="en">English</option>
              <option value="wo">Wolof</option>
            </select>
          </div>
        </div>

        <div v-if="editMode" class="flex justify-end space-x-3 pt-4">
          <button 
            type="button"
            @click="editMode = false"
            class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition"
          >
            Annuler
          </button>
          <button 
            type="submit"
            class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition"
          >
            Enregistrer
          </button>
        </div>
      </form>
    </div>

    <!-- Changer le mot de passe -->
    <div class="bg-white rounded-xl shadow-md p-6">
      <h2 class="text-xl font-bold mb-6">Sécurité</h2>
      
      <form @submit.prevent="changePassword" class="space-y-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Mot de passe actuel</label>
          <input 
            v-model="passwordForm.current"
            type="password"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
          >
        </div>
        
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Nouveau mot de passe</label>
          <input 
            v-model="passwordForm.new"
            type="password"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
          >
        </div>
        
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Confirmer le mot de passe</label>
          <input 
            v-model="passwordForm.confirm"
            type="password"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
          >
        </div>

        <button 
          type="submit"
          class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition"
        >
          Changer le mot de passe
        </button>
      </form>
    </div>

    <!-- Statistiques -->
    <div class="bg-white rounded-xl shadow-md p-6">
      <h2 class="text-xl font-bold mb-6">Activité</h2>
      
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="p-4 bg-green-50 rounded-lg">
          <div class="text-sm text-gray-600">Dernière connexion</div>
          <div class="text-lg font-semibold text-gray-900 mt-1">
            {{ lastLogin }}
          </div>
        </div>
        
        <div class="p-4 bg-blue-50 rounded-lg">
          <div class="text-sm text-gray-600">Compte créé le</div>
          <div class="text-lg font-semibold text-gray-900 mt-1">
            {{ accountCreated }}
          </div>
        </div>
        
        <div class="p-4 bg-purple-50 rounded-lg">
          <div class="text-sm text-gray-600">Statut</div>
          <div class="text-lg font-semibold text-green-600 mt-1">
            {{ user.is_active ? 'Actif' : 'Inactif' }}
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useAuthStore } from '../../stores/auth';

const authStore = useAuthStore();
const editMode = ref(false);

const user = computed(() => authStore.user || {});

const form = ref({
  name: '',
  email: '',
  phone: '',
  language: 'fr',
});

const passwordForm = ref({
  current: '',
  new: '',
  confirm: '',
});

const userInitials = computed(() => {
  const name = user.value.name || 'U';
  return name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);
});

const roleLabel = computed(() => {
  const role = user.value.role;
  const labels = {
    'super_admin': 'Super Administrateur',
    'admin': 'Administrateur',
    'restaurant_manager': 'Gestionnaire Restaurant',
    'agent': 'Agent Commercial',
    'employee': 'Employé',
    'driver': 'Livreur',
  };
  return labels[role] || 'Utilisateur';
});

const lastLogin = computed(() => {
  return user.value.last_login_at 
    ? new Date(user.value.last_login_at).toLocaleDateString('fr-FR')
    : 'Jamais';
});

const accountCreated = computed(() => {
  return user.value.created_at 
    ? new Date(user.value.created_at).toLocaleDateString('fr-FR')
    : 'Inconnu';
});

const saveProfile = async () => {
  try {
    // TODO: Appel API pour sauvegarder le profil
    console.log('Saving profile:', form.value);
    alert('Profil mis à jour avec succès!');
    editMode.value = false;
  } catch (error) {
    console.error('Error saving profile:', error);
    alert('Erreur lors de la mise à jour du profil');
  }
};

const changePassword = async () => {
  if (passwordForm.value.new !== passwordForm.value.confirm) {
    alert('Les mots de passe ne correspondent pas');
    return;
  }
  
  try {
    // TODO: Appel API pour changer le mot de passe
    console.log('Changing password');
    alert('Mot de passe changé avec succès!');
    passwordForm.value = {
      current: '',
      new: '',
      confirm: '',
    };
  } catch (error) {
    console.error('Error changing password:', error);
    alert('Erreur lors du changement de mot de passe');
  }
};

onMounted(() => {
  // Initialiser le formulaire avec les données utilisateur
  form.value = {
    name: user.value.name || '',
    email: user.value.email || '',
    phone: user.value.phone || '',
    language: user.value.language || 'fr',
  };
});
</script>

