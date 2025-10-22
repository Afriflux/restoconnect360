<template>
  <div class="p-6">
    <div class="mb-6">
      <h1 class="text-2xl font-bold text-gray-900">💳 Gestion des Agrégateurs de Paiement</h1>
      <p class="text-gray-600 mt-2">Configurez et gérez les agrégateurs de paiement pour vos clients B2B selon la documentation officielle.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="p-2 bg-blue-100 rounded-lg">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Clients BtoB</p>
            <p class="text-2xl font-semibold text-gray-900">24</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="p-2 bg-green-100 rounded-lg">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">PayTech Actifs</p>
            <p class="text-2xl font-semibold text-gray-900">18</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="p-2 bg-purple-100 rounded-lg">
            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">CinetPay Actifs</p>
            <p class="text-2xl font-semibold text-gray-900">15</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="p-2 bg-yellow-100 rounded-lg">
            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Délégation Active</p>
            <p class="text-2xl font-semibold text-gray-900">8</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Configuration Globale -->
    <div class="bg-white rounded-lg shadow mb-6">
      <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900">⚙️ Configuration Globale</h2>
      </div>
      <div class="p-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <!-- PayTech Configuration -->
          <div class="border border-gray-200 rounded-lg p-4">
            <div class="flex items-center justify-between mb-4">
              <h3 class="text-md font-semibold text-gray-900 flex items-center">
                <span class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                  <span class="text-blue-600 font-bold text-sm">P</span>
                </span>
                PayTech
              </h3>
              <label class="flex items-center">
                <input type="checkbox" v-model="paytech.isActive" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                <span class="ml-2 text-sm text-gray-700">{{ paytech.isActive ? 'Activé' : 'Désactivé' }}</span>
              </label>
            </div>
            <div class="space-y-3">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">API Key</label>
                <input type="password" v-model="paytech.apiKey" placeholder="Votre clé API PayTech" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                <p class="text-xs text-gray-500 mt-1">Récupérée depuis le Dashboard PayTech</p>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Secret Key</label>
                <input type="password" v-model="paytech.secretKey" placeholder="Votre clé secrète PayTech" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                <p class="text-xs text-gray-500 mt-1">Gardez cette clé confidentielle</p>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Environnement</label>
                <select v-model="paytech.environment" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                  <option value="test">Test (Sandbox)</option>
                  <option value="prod">Production</option>
                </select>
                <p class="text-xs text-gray-500 mt-1">
                  <span v-if="paytech.environment === 'test'">Mode test : montant aléatoire 100-150 CFA débité</span>
                  <span v-else>Mode production : montant exact débité (compte activé requis)</span>
                </p>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">URL de Base</label>
                <input type="text" value="https://paytech.sn/api" readonly class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-gray-50">
              </div>
            </div>
          </div>

          <!-- CinetPay Configuration -->
          <div class="border border-gray-200 rounded-lg p-4">
            <div class="flex items-center justify-between mb-4">
              <h3 class="text-md font-semibold text-gray-900 flex items-center">
                <span class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                  <span class="text-purple-600 font-bold text-sm">C</span>
                </span>
                CinetPay
              </h3>
              <label class="flex items-center">
                <input type="checkbox" v-model="cinetpay.isActive" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                <span class="ml-2 text-sm text-gray-700">{{ cinetpay.isActive ? 'Activé' : 'Désactivé' }}</span>
              </label>
            </div>
            <div class="space-y-3">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">API Key</label>
                <input type="password" v-model="cinetpay.apiKey" placeholder="Votre clé API CinetPay" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                <p class="text-xs text-gray-500 mt-1">Récupérée depuis le Back-office CinetPay (menu integration)</p>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Site ID</label>
                <input type="text" v-model="cinetpay.siteId" placeholder="Votre Site ID CinetPay" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                <p class="text-xs text-gray-500 mt-1">Obtenu après abonnement à un service</p>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">URL de Base</label>
                <input type="text" value="https://api-checkout.cinetpay.com/v2/payment" readonly class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-gray-50">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Univers de Paiement</label>
                <select v-model="cinetpay.channels" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                  <option value="ALL">Tous les univers</option>
                  <option value="MOBILE_MONEY">Mobile Money uniquement</option>
                  <option value="CREDIT_CARD">Cartes bancaires uniquement</option>
                  <option value="WALLET">Portefeuilles électroniques</option>
                </select>
                <p class="text-xs text-gray-500 mt-1">Définit les univers présents sur le guichet</p>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Devise</label>
                <select v-model="cinetpay.currency" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                  <option value="XOF">XOF (Franc CFA Ouest)</option>
                  <option value="XAF">XAF (Franc CFA Centre)</option>
                  <option value="CDF">CDF (Franc Congolais)</option>
                  <option value="GNF">GNF (Franc Guinéen)</option>
                  <option value="USD">USD (Dollar Américain)</option>
                </select>
                <p class="text-xs text-gray-500 mt-1">Devise autorisée pour votre compte CinetPay</p>
              </div>
            </div>
          </div>
        </div>

        <!-- URLs de Notification et Retour -->
        <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
          <h4 class="text-md font-semibold text-blue-800 mb-3">🔗 URLs de Notification et Retour</h4>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-blue-700 mb-1">URL de Notification</label>
              <input type="url" v-model="notificationUrls.notifyUrl" placeholder="https://votre-domaine.com/api/payment/notify" class="w-full border border-blue-300 rounded-lg px-3 py-2 text-sm">
              <p class="text-xs text-blue-600 mt-1">URL où CinetPay enverra les notifications de paiement</p>
            </div>
            <div>
              <label class="block text-sm font-medium text-blue-700 mb-1">URL de Retour</label>
              <input type="url" v-model="notificationUrls.returnUrl" placeholder="https://votre-domaine.com/payment/success" class="w-full border border-blue-300 rounded-lg px-3 py-2 text-sm">
              <p class="text-xs text-blue-600 mt-1">URL où le client sera redirigé après paiement</p>
            </div>
          </div>
          <div class="mt-3 p-2 bg-blue-100 rounded text-xs text-blue-700">
            <strong>Note :</strong> Les URLs doivent être accessibles publiquement (pas de localhost). Utilisez HTTPS pour la sécurité.
          </div>
        </div>

        <!-- Délégation de Collecte -->
        <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
          <div class="flex items-center justify-between">
            <div>
              <h4 class="text-md font-semibold text-yellow-800">🏦 Délégation de Collecte de Fonds</h4>
              <p class="text-sm text-yellow-700 mt-1">Permettre aux clients de faire des appels de fonds (décaissements sur demande)</p>
            </div>
            <label class="flex items-center">
              <input type="checkbox" v-model="delegationEnabled" class="rounded border-gray-300 text-yellow-600 focus:ring-yellow-500">
              <span class="ml-2 text-sm text-yellow-800 font-medium">{{ delegationEnabled ? 'Activée' : 'Désactivée' }}</span>
            </label>
          </div>
        </div>
      </div>
    </div>

    <!-- Univers de Paiement CinetPay -->
    <div class="bg-white rounded-lg shadow mb-6">
      <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900">🌐 Univers de Paiement CinetPay</h2>
        <p class="text-sm text-gray-600 mt-1">Selon la documentation officielle CinetPay</p>
      </div>
      <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
          <div class="border border-purple-200 rounded-lg p-4 text-center">
            <div class="text-3xl mb-2">📱</div>
            <div class="text-sm font-medium text-gray-900">MOBILE_MONEY</div>
            <div class="text-xs text-gray-500 mt-1">Orange Money, MTN, Moov, Wave</div>
          </div>
          <div class="border border-purple-200 rounded-lg p-4 text-center">
            <div class="text-3xl mb-2">💳</div>
            <div class="text-sm font-medium text-gray-900">CREDIT_CARD</div>
            <div class="text-xs text-gray-500 mt-1">Cartes bancaires internationales</div>
          </div>
          <div class="border border-purple-200 rounded-lg p-4 text-center">
            <div class="text-3xl mb-2">👛</div>
            <div class="text-sm font-medium text-gray-900">WALLET</div>
            <div class="text-xs text-gray-500 mt-1">Portefeuilles électroniques</div>
          </div>
          <div class="border border-purple-200 rounded-lg p-4 text-center">
            <div class="text-3xl mb-2">🌍</div>
            <div class="text-sm font-medium text-gray-900">ALL</div>
            <div class="text-xs text-gray-500 mt-1">Tous les univers disponibles</div>
          </div>
        </div>
        <div class="mt-4 p-3 bg-purple-50 border border-purple-200 rounded-lg">
          <p class="text-sm text-purple-800">
            <strong>Configuration :</strong> Utilisez le paramètre <code>channels</code> pour définir les univers présents sur le guichet de paiement.
          </p>
        </div>
      </div>
    </div>

    <!-- Méthodes de Paiement Disponibles -->
    <div class="bg-white rounded-lg shadow mb-6">
      <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900">💳 Méthodes de Paiement Disponibles (PayTech)</h2>
        <p class="text-sm text-gray-600 mt-1">Selon la documentation officielle PayTech</p>
      </div>
      <div class="p-6">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
          <div v-for="method in paymentMethods" :key="method.name" class="border border-gray-200 rounded-lg p-3 text-center">
            <div class="text-2xl mb-2">{{ method.icon }}</div>
            <div class="text-sm font-medium text-gray-900">{{ method.name }}</div>
            <div class="text-xs text-gray-500 mt-1">{{ method.country }}</div>
          </div>
        </div>
        <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
          <p class="text-sm text-blue-800">
            <strong>Note :</strong> Vous pouvez cibler des méthodes spécifiques avec le paramètre <code>target_payment</code> 
            pour une méthode unique ou plusieurs méthodes séparées par des virgules.
          </p>
        </div>
      </div>
    </div>

    <!-- Gestion par Client -->
    <div class="bg-white rounded-lg shadow">
      <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex justify-between items-center">
          <h2 class="text-lg font-semibold text-gray-900">👥 Configuration par Client BtoB</h2>
          <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
            ➕ Nouveau Client
          </button>
        </div>
      </div>

      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PayTech</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CinetPay</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Délégation</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="client in clients" :key="client.id">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg flex items-center justify-center">
                    <span class="text-white font-bold">{{ client.name.charAt(0) }}</span>
                  </div>
                  <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900">{{ client.name }}</div>
                    <div class="text-sm text-gray-500">{{ client.email }}</div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <label class="flex items-center">
                  <input type="checkbox" :checked="client.paytech" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                  <span class="ml-2 text-sm text-gray-700">{{ client.paytech ? 'Actif' : 'Inactif' }}</span>
                </label>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <label class="flex items-center">
                  <input type="checkbox" :checked="client.cinetpay" class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                  <span class="ml-2 text-sm text-gray-700">{{ client.cinetpay ? 'Actif' : 'Inactif' }}</span>
                </label>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <label class="flex items-center">
                  <input type="checkbox" :checked="client.delegation" class="rounded border-gray-300 text-yellow-600 focus:ring-yellow-500">
                  <span class="ml-2 text-sm text-gray-700">{{ client.delegation ? 'Activée' : 'Désactivée' }}</span>
                </label>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span :class="getStatusClass(client.status)" class="px-2 py-1 text-xs font-semibold rounded-full">
                  {{ client.status }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <button @click="configureClient(client.id)" class="text-green-600 hover:text-green-900 mr-3">Configurer</button>
                <button @click="viewClient(client.id)" class="text-blue-600 hover:text-blue-900 mr-3">Voir</button>
                <button @click="suspendClient(client.id)" class="text-red-600 hover:text-red-900">Suspendre</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Actions Globales -->
    <div class="flex justify-between mt-6">
      <button @click="syncAllClients" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
        🔄 Synchroniser Tous les Clients
      </button>
      <button @click="saveSettings" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors">
        💾 Sauvegarder les Configurations
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import ModernButton from '@/components/ui/ModernButton.vue';

// État de la modal
const showNewClientModal = ref(false);

// Données des agrégateurs
const paytech = ref({
  isActive: true,
  apiKey: '',
  secretKey: '',
  environment: 'test'
});

const cinetpay = ref({
  isActive: true,
  apiKey: '',
  siteId: '',
  channels: 'ALL', // ALL, MOBILE_MONEY, CREDIT_CARD, WALLET
  currency: 'XOF', // XOF, XAF, CDF, GNF, USD
});

// URLs de notification et retour
const notificationUrls = ref({
  notifyUrl: '',
  returnUrl: ''
});

const delegationEnabled = ref(false);

// Méthodes
const openNewClientModal = () => {
  showNewClientModal.value = true;
};

const configureClient = (clientId) => {
  console.log('Configuration du client:', clientId);
  // Logique de configuration
};

const viewClient = (clientId) => {
  console.log('Visualisation du client:', clientId);
  // Logique de visualisation
};

const suspendClient = (clientId) => {
  console.log('Suspension du client:', clientId);
  // Logique de suspension
};

const syncAllClients = () => {
  console.log('Synchronisation de tous les clients');
  // Logique de synchronisation
};

const saveSettings = () => {
  console.log('Sauvegarde des configurations');
  // Logique de sauvegarde
};


// Méthodes de paiement disponibles selon la documentation PayTech
const paymentMethods = ref([
  { name: 'Orange Money', icon: '🟠', country: 'Sénégal' },
  { name: 'Orange Money CI', icon: '🟠', country: 'Côte d\'Ivoire' },
  { name: 'Orange Money ML', icon: '🟠', country: 'Mali' },
  { name: 'Mtn Money CI', icon: '🟡', country: 'Côte d\'Ivoire' },
  { name: 'Moov Money CI', icon: '🔵', country: 'Côte d\'Ivoire' },
  { name: 'Moov Money ML', icon: '🔵', country: 'Mali' },
  { name: 'Wave', icon: '🌊', country: 'Sénégal' },
  { name: 'Wave CI', icon: '🌊', country: 'Côte d\'Ivoire' },
  { name: 'Wizall', icon: '💜', country: 'Sénégal' },
  { name: 'Carte Bancaire', icon: '💳', country: 'International' },
  { name: 'Emoney', icon: '💰', country: 'Sénégal' },
  { name: 'Tigo Cash', icon: '🟢', country: 'Sénégal' },
  { name: 'Free Money', icon: '🆓', country: 'Sénégal' },
  { name: 'Moov Money BJ', icon: '🔵', country: 'Bénin' },
  { name: 'Mtn Money BJ', icon: '🟡', country: 'Bénin' }
]);

const clients = ref([
  {
    id: 1,
    name: 'Le Teranga',
    email: 'le-teranga@restaurantdakar.com',
    paytech: true,
    cinetpay: true,
    delegation: false,
    status: 'Actif'
  },
  {
    id: 2,
    name: 'Café des Arts',
    email: 'cafe-des-arts@restaurantdakar.com',
    paytech: true,
    cinetpay: false,
    delegation: true,
    status: 'Actif'
  },
  {
    id: 3,
    name: 'Fast Food Lagon',
    email: 'fast-food-lagon@restaurantdakar.com',
    paytech: false,
    cinetpay: true,
    delegation: false,
    status: 'En Attente'
  },
  {
    id: 4,
    name: 'Le Dakarois Gourmand',
    email: 'le-dakarois-gourmand@restaurantdakar.com',
    paytech: true,
    cinetpay: true,
    delegation: true,
    status: 'Suspendu'
  }
]);

const getStatusClass = (status) => {
  switch (status) {
    case 'Actif': return 'bg-green-100 text-green-800';
    case 'En Attente': return 'bg-yellow-100 text-yellow-800';
    case 'Suspendu': return 'bg-red-100 text-red-800';
    default: return 'bg-gray-100 text-gray-800';
  }
};

</script>
