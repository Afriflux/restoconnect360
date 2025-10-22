<template>
  <div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-md p-6">
      <h1 class="text-2xl font-bold text-gray-900">Paramètres</h1>
      <p class="text-gray-600 mt-1">Gérez vos préférences et paramètres</p>
    </div>

    <!-- Préférences Générales -->
    <div class="bg-white rounded-xl shadow-md p-6">
      <h2 class="text-xl font-bold mb-6">Préférences Générales</h2>
      
      <div class="space-y-6">
        <!-- Langue -->
        <div class="flex items-center justify-between">
          <div>
            <div class="font-medium text-gray-900">Langue de l'interface</div>
            <div class="text-sm text-gray-500">Choisissez la langue d'affichage</div>
          </div>
          <select 
            v-model="settings.language"
            @change="saveSettings"
            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
          >
            <option value="fr">Français</option>
            <option value="en">English</option>
            <option value="wo">Wolof</option>
          </select>
        </div>

        <!-- Timezone -->
        <div class="flex items-center justify-between">
          <div>
            <div class="font-medium text-gray-900">Fuseau horaire</div>
            <div class="text-sm text-gray-500">Sélectionnez votre fuseau horaire</div>
          </div>
          <select 
            v-model="settings.timezone"
            @change="saveSettings"
            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
          >
            <option value="Africa/Dakar">Dakar (GMT+0)</option>
            <option value="Africa/Abidjan">Abidjan (GMT+0)</option>
            <option value="Africa/Lagos">Lagos (GMT+1)</option>
            <option value="Africa/Cairo">Le Caire (GMT+2)</option>
          </select>
        </div>

        <!-- Format Date -->
        <div class="flex items-center justify-between">
          <div>
            <div class="font-medium text-gray-900">Format de date</div>
            <div class="text-sm text-gray-500">Comment afficher les dates</div>
          </div>
          <select 
            v-model="settings.dateFormat"
            @change="saveSettings"
            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
          >
            <option value="DD/MM/YYYY">JJ/MM/AAAA</option>
            <option value="MM/DD/YYYY">MM/JJ/AAAA</option>
            <option value="YYYY-MM-DD">AAAA-MM-JJ</option>
          </select>
        </div>

        <!-- Devise -->
        <div class="flex items-center justify-between">
          <div>
            <div class="font-medium text-gray-900">Devise</div>
            <div class="text-sm text-gray-500">Devise par défaut</div>
          </div>
          <select 
            v-model="settings.currency"
            @change="saveSettings"
            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
          >
            <option value="XOF">FCFA (XOF)</option>
            <option value="EUR">Euro (EUR)</option>
            <option value="USD">Dollar (USD)</option>
          </select>
        </div>
      </div>
    </div>

    <!-- Notifications -->
    <div class="bg-white rounded-xl shadow-md p-6">
      <h2 class="text-xl font-bold mb-6">Notifications</h2>
      
      <div class="space-y-4">
        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
          <div>
            <div class="font-medium text-gray-900">Notifications Email</div>
            <div class="text-sm text-gray-500">Recevoir des notifications par email</div>
          </div>
          <label class="relative inline-flex items-center cursor-pointer">
            <input 
              type="checkbox" 
              v-model="settings.emailNotifications"
              @change="saveSettings"
              class="sr-only peer"
            >
            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
          </label>
        </div>

        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
          <div>
            <div class="font-medium text-gray-900">Notifications Push</div>
            <div class="text-sm text-gray-500">Recevoir des notifications dans le navigateur</div>
          </div>
          <label class="relative inline-flex items-center cursor-pointer">
            <input 
              type="checkbox" 
              v-model="settings.pushNotifications"
              @change="saveSettings"
              class="sr-only peer"
            >
            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
          </label>
        </div>

        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
          <div>
            <div class="font-medium text-gray-900">Notifications SMS</div>
            <div class="text-sm text-gray-500">Recevoir des notifications par SMS</div>
          </div>
          <label class="relative inline-flex items-center cursor-pointer">
            <input 
              type="checkbox" 
              v-model="settings.smsNotifications"
              @change="saveSettings"
              class="sr-only peer"
            >
            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
          </label>
        </div>
      </div>
    </div>

    <!-- Confidentialité -->
    <div class="bg-white rounded-xl shadow-md p-6">
      <h2 class="text-xl font-bold mb-6">Confidentialité & Sécurité</h2>
      
      <div class="space-y-4">
        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
          <div>
            <div class="font-medium text-gray-900">Authentification à deux facteurs</div>
            <div class="text-sm text-gray-500">Ajouter une couche de sécurité supplémentaire</div>
          </div>
          <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
            Activer
          </button>
        </div>

        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
          <div>
            <div class="font-medium text-gray-900">Sessions actives</div>
            <div class="text-sm text-gray-500">Gérer vos sessions de connexion</div>
          </div>
          <button class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
            Voir ({{ activeSessions }})
          </button>
        </div>

        <div class="flex items-center justify-between p-4 bg-red-50 rounded-lg">
          <div>
            <div class="font-medium text-red-900">Supprimer le compte</div>
            <div class="text-sm text-red-600">Action irréversible</div>
          </div>
          <button class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
            Supprimer
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const settings = ref({
  language: 'fr',
  timezone: 'Africa/Dakar',
  dateFormat: 'DD/MM/YYYY',
  currency: 'XOF',
  emailNotifications: true,
  pushNotifications: true,
  smsNotifications: false,
});

const activeSessions = ref(1);

const saveSettings = async () => {
  try {
    // TODO: Appel API pour sauvegarder les paramètres
    console.log('Saving settings:', settings.value);
    // Afficher un toast de succès
  } catch (error) {
    console.error('Error saving settings:', error);
  }
};

onMounted(() => {
  // Charger les paramètres depuis l'API ou localStorage
  const savedSettings = localStorage.getItem('user_settings');
  if (savedSettings) {
    settings.value = { ...settings.value, ...JSON.parse(savedSettings) };
  }
});
</script>

