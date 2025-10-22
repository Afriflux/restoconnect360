<template>
  <div class="p-6">
    <div class="mb-6">
      <h1 class="text-2xl font-bold text-gray-900">🏢 Gestion des Entreprises</h1>
      <p class="text-gray-600 mt-2">Gérez toutes les entreprises partenaires de la plateforme</p>
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
            <p class="text-sm font-medium text-gray-600">Total Entreprises</p>
            <p class="text-2xl font-semibold text-gray-900">{{ companies.length }}</p>
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
            <p class="text-sm font-medium text-gray-600">Actives</p>
            <p class="text-2xl font-semibold text-gray-900">{{ companies.filter(c => c.status === 'Active').length }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="p-2 bg-yellow-100 rounded-lg">
            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">En Attente</p>
            <p class="text-2xl font-semibold text-gray-900">{{ companies.filter(c => c.status === 'En Attente').length }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="p-2 bg-red-100 rounded-lg">
            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Suspendues</p>
            <p class="text-2xl font-semibold text-gray-900">{{ companies.filter(c => c.status === 'Suspendue').length }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Actions -->
    <div class="bg-white rounded-lg shadow mb-6">
      <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex justify-between items-center">
          <h2 class="text-lg font-semibold text-gray-900">Liste des Entreprises</h2>
          <ModernButton 
            @click="openCreateModal"
            variant="primary"
            icon="plus"
            size="md"
          >
            Nouvelle Entreprise
          </ModernButton>
        </div>
      </div>

      <!-- Table -->
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Entreprise</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Commerces</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="company in companies" :key="company.id">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg flex items-center justify-center">
                    <span class="text-white font-bold">{{ company.name.charAt(0) }}</span>
                  </div>
                  <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900">{{ company.name }}</div>
                    <div class="text-sm text-gray-500">{{ company.sector }}</div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">{{ company.contact }}</div>
                <div class="text-sm text-gray-500">{{ company.email }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span :class="getStatusClass(company.status)" class="px-2 py-1 text-xs font-semibold rounded-full">
                  {{ company.status }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                {{ company.restaurants }} commerces
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <div class="flex space-x-2">
                  <ModernButton 
                    @click="editCompany(company)"
                    variant="success"
                    icon="edit"
                    size="sm"
                  >
                    Modifier
                  </ModernButton>
                  <ModernButton 
                    @click="viewCompany(company)"
                    variant="info"
                    icon="view"
                    size="sm"
                  >
                    Voir
                  </ModernButton>
                  <ModernButton 
                    @click="suspendCompany(company)"
                    variant="danger"
                    icon="delete"
                    size="sm"
                  >
                    Suspendre
                  </ModernButton>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal de création d'entreprise -->
    <div v-if="showCreateModal" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm flex items-center justify-center z-50 animate-fadeIn">
      <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full mx-4 transform transition-all duration-300 scale-100 animate-slideUp">
        <!-- Header avec gradient -->
        <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-8 py-6 rounded-t-2xl">
          <div class="flex justify-between items-center">
            <div class="flex items-center space-x-3">
              <div class="w-10 h-10 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
              </div>
              <div>
                <h3 class="text-xl font-bold text-white">Nouvelle Entreprise</h3>
                <p class="text-green-100 text-sm">Créez un nouveau partenaire</p>
              </div>
            </div>
            <button @click="closeCreateModal" class="text-white hover:text-green-200 transition-colors p-2 hover:bg-white hover:bg-opacity-10 rounded-lg">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>
        </div>
        
        <form @submit.prevent="createCompany" class="px-8 py-6">
          <div class="space-y-6">
            <!-- Nom de l'entreprise -->
            <div class="group">
              <label class="block text-sm font-semibold text-gray-700 mb-2 group-focus-within:text-green-600 transition-colors">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                Nom de l'entreprise
              </label>
              <input 
                v-model="newCompany.name"
                type="text" 
                required
                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-green-100 focus:border-green-500 transition-all duration-200 placeholder-gray-400"
                placeholder="Ex: RestoConnect Group"
              >
            </div>
            
            <!-- Secteur d'activité -->
            <div class="group">
              <label class="block text-sm font-semibold text-gray-700 mb-2 group-focus-within:text-green-600 transition-colors">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                Secteur d'activité
              </label>
              <select 
                v-model="newCompany.sector"
                required
                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-green-100 focus:border-green-500 transition-all duration-200 bg-white"
              >
                <option value="">Sélectionner un secteur</option>
                <option value="Restauration">🍽️ Restauration</option>
                <option value="Alimentaire">🛒 Alimentaire</option>
                <option value="Livraison">🚚 Livraison</option>
                <option value="Fast Food">🍔 Fast Food</option>
                <option value="Café & Pâtisserie">☕ Café & Pâtisserie</option>
                <option value="Bar & Lounge">🍻 Bar & Lounge</option>
                <option value="Épicerie">🏪 Épicerie</option>
                <option value="Autre">🔧 Autre</option>
              </select>
            </div>
            
            <!-- Contact principal -->
            <div class="group">
              <label class="block text-sm font-semibold text-gray-700 mb-2 group-focus-within:text-green-600 transition-colors">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Contact principal
              </label>
              <input 
                v-model="newCompany.contact"
                type="text" 
                required
                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-green-100 focus:border-green-500 transition-all duration-200 placeholder-gray-400"
                placeholder="Ex: Mamadou Diallo"
              >
            </div>
            
            <!-- Email -->
            <div class="group">
              <label class="block text-sm font-semibold text-gray-700 mb-2 group-focus-within:text-green-600 transition-colors">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Email
              </label>
              <input 
                v-model="newCompany.email"
                type="email" 
                required
                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-green-100 focus:border-green-500 transition-all duration-200 placeholder-gray-400"
                placeholder="Ex: contact@entreprise.com"
              >
            </div>
            
            <!-- Téléphone -->
            <div class="group">
              <label class="block text-sm font-semibold text-gray-700 mb-2 group-focus-within:text-green-600 transition-colors">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                Téléphone
              </label>
              <input 
                v-model="newCompany.phone"
                type="tel" 
                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-green-100 focus:border-green-500 transition-all duration-200 placeholder-gray-400"
                placeholder="Ex: +221 77 123 45 67"
              >
            </div>
            
            <!-- Adresse -->
            <div class="group">
              <label class="block text-sm font-semibold text-gray-700 mb-2 group-focus-within:text-green-600 transition-colors">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Adresse
              </label>
              <textarea 
                v-model="newCompany.address"
                rows="3"
                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-green-100 focus:border-green-500 transition-all duration-200 placeholder-gray-400 resize-none"
                placeholder="Adresse complète de l'entreprise"
              ></textarea>
            </div>
          </div>
          
          <!-- Actions -->
          <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-100">
            <ModernButton 
              @click="closeCreateModal"
              variant="secondary"
              size="md"
            >
              Annuler
            </ModernButton>
            <ModernButton 
              @click="createCompany"
              variant="primary"
              icon="check"
              size="md"
            >
              Créer l'entreprise
            </ModernButton>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import ModernButton from '@/components/ui/ModernButton.vue';

// État de la modal
const showCreateModal = ref(false);

// Données du nouveau formulaire
const newCompany = ref({
  name: '',
  sector: '',
  contact: '',
  email: '',
  phone: '',
  address: ''
});

// Méthodes
const openCreateModal = () => {
  showCreateModal.value = true;
};

const closeCreateModal = () => {
  showCreateModal.value = false;
  // Réinitialiser le formulaire
  newCompany.value = {
    name: '',
    sector: '',
    contact: '',
    email: '',
    phone: '',
    address: ''
  };
};

const createCompany = () => {
  // Générer un nouvel ID
  const newId = Math.max(...companies.value.map(c => c.id)) + 1;
  
  // Créer la nouvelle entreprise
  const company = {
    id: newId,
    name: newCompany.value.name,
    sector: newCompany.value.sector,
    contact: newCompany.value.contact,
    email: newCompany.value.email,
    status: 'En Attente',
    restaurants: 0
  };
  
  // Ajouter à la liste
  companies.value.push(company);
  
  // Fermer la modal
  closeCreateModal();
  
  // Afficher un message de succès élégant
  showSuccessMessage();
};

// Méthodes pour les boutons d'action
const editCompany = (company) => {
  console.log('Modification de l\'entreprise:', company);
  // Logique de modification
};

const viewCompany = (company) => {
  console.log('Visualisation de l\'entreprise:', company);
  // Logique de visualisation
};

const suspendCompany = (company) => {
  console.log('Suspension de l\'entreprise:', company);
  // Logique de suspension
};

// Message de succès
const showSuccessMessage = () => {
  if (window.notify) {
    window.notify.success('Entreprise créée avec succès !', 'La nouvelle entreprise a été ajoutée à la liste.');
  } else {
    // Fallback si le système de notifications n'est pas disponible
    alert('✅ Entreprise créée avec succès !');
  }
};

const companies = ref([
  {
    id: 1,
    name: 'RestoConnect Group',
    sector: 'Restauration',
    contact: 'Mamadou Diallo',
    email: 'contact@restoconnect.com',
    status: 'Active',
    restaurants: 12
  },
  {
    id: 2,
    name: 'FoodCorp Senegal',
    sector: 'Alimentaire',
    contact: 'Aïssa Diop',
    email: 'info@foodcorp.sn',
    status: 'Active',
    restaurants: 8
  },
  {
    id: 3,
    name: 'Dakar Eats',
    sector: 'Livraison',
    contact: 'Fatou Sall',
    email: 'admin@dakareats.com',
    status: 'En Attente',
    restaurants: 3
  },
  {
    id: 4,
    name: 'Cuisine Express',
    sector: 'Fast Food',
    contact: 'Omar Ba',
    email: 'contact@cuisineexpress.sn',
    status: 'Suspendue',
    restaurants: 1
  }
]);

const getStatusClass = (status) => {
  switch (status) {
    case 'Active': return 'bg-green-100 text-green-800';
    case 'En Attente': return 'bg-yellow-100 text-yellow-800';
    case 'Suspendue': return 'bg-red-100 text-red-800';
    default: return 'bg-gray-100 text-gray-800';
  }
};
</script>

<style scoped>
@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

@keyframes slideUp {
  from {
    opacity: 0;
    transform: translateY(20px) scale(0.95);
  }
  to {
    opacity: 1;
    transform: translateY(0) scale(1);
  }
}

.animate-fadeIn {
  animation: fadeIn 0.3s ease-out;
}

.animate-slideUp {
  animation: slideUp 0.3s ease-out;
}

/* Effet de focus amélioré pour les inputs */
.group:focus-within label {
  color: #059669;
}

.group:focus-within input,
.group:focus-within select,
.group:focus-within textarea {
  border-color: #10b981;
  box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
}

/* Animation pour les boutons */
button:active {
  transform: scale(0.98);
}

/* Effet de survol pour les icônes */
.group:hover svg {
  transform: scale(1.1);
  transition: transform 0.2s ease;
}
</style>
