<template>
  <div class="p-6">
    <div class="mb-6">
      <h1 class="text-2xl font-bold text-gray-900">📧 Gestion des Emails</h1>
      <p class="text-gray-600 mt-2">Envoyez des emails ciblés, par groupes ou généralisés à tous les utilisateurs</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="p-2 bg-blue-100 rounded-lg">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Total Utilisateurs</p>
            <p class="text-2xl font-semibold text-gray-900">{{ totalUsers }}</p>
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
            <p class="text-sm font-medium text-gray-600">Emails Envoyés</p>
            <p class="text-2xl font-semibold text-gray-900">{{ emailsSent }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
          <div class="p-2 bg-purple-100 rounded-lg">
            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Groupes Actifs</p>
            <p class="text-2xl font-semibold text-gray-900">{{ userGroups.length }}</p>
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
            <p class="text-2xl font-semibold text-gray-900">{{ pendingEmails }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Nouvel Email -->
    <div class="bg-white rounded-lg shadow mb-6">
      <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex justify-between items-center">
          <h2 class="text-lg font-semibold text-gray-900">✉️ Nouvel Email</h2>
          <ModernButton 
            @click="openEmailModal"
            variant="primary"
            icon="plus"
            size="md"
          >
            Nouvel Email
          </ModernButton>
        </div>
      </div>
      
      <div class="p-6">
        <!-- Sélection du Type d'Envoi -->
        <div class="mb-6">
          <h3 class="text-md font-semibold text-gray-900 mb-4">Type d'envoi</h3>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div 
              @click="selectEmailType('individual')"
              :class="emailType === 'individual' ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-green-300'"
              class="border-2 rounded-lg p-4 cursor-pointer transition-all"
            >
              <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                  <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                  </svg>
                </div>
                <div>
                  <h4 class="font-semibold text-gray-900">Utilisateur Spécifique</h4>
                  <p class="text-sm text-gray-500">Envoyer à un utilisateur précis</p>
                </div>
              </div>
            </div>
            
            <div 
              @click="selectEmailType('group')"
              :class="emailType === 'group' ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-green-300'"
              class="border-2 rounded-lg p-4 cursor-pointer transition-all"
            >
              <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                  <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                  </svg>
                </div>
                <div>
                  <h4 class="font-semibold text-gray-900">Groupe d'Utilisateurs</h4>
                  <p class="text-sm text-gray-500">Envoyer à un groupe défini</p>
                </div>
              </div>
            </div>
            
            <div 
              @click="selectEmailType('broadcast')"
              :class="emailType === 'broadcast' ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-green-300'"
              class="border-2 rounded-lg p-4 cursor-pointer transition-all"
            >
              <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                  <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                  </svg>
                </div>
                <div>
                  <h4 class="font-semibold text-gray-900">Diffusion Générale</h4>
                  <p class="text-sm text-gray-500">Envoyer à tous les utilisateurs</p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Sélection des Destinataires -->
        <div v-if="emailType" class="mb-6">
          <h3 class="text-md font-semibold text-gray-900 mb-4">Destinataires</h3>
          
          <!-- Utilisateur Spécifique -->
          <div v-if="emailType === 'individual'" class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Rechercher un utilisateur</label>
              <div class="relative">
                <input 
                  v-model="userSearch"
                  @input="searchUsers"
                  type="text" 
                  placeholder="Nom, email ou téléphone..."
                  class="w-full border border-gray-300 rounded-lg px-4 py-2 pl-10 focus:ring-2 focus:ring-green-500 focus:border-green-500"
                >
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
              </div>
            </div>
            
            <!-- Résultats de recherche -->
            <div v-if="searchResults.length > 0" class="border border-gray-200 rounded-lg max-h-60 overflow-y-auto">
              <div 
                v-for="user in searchResults" 
                :key="user.id"
                @click="selectUser(user)"
                class="flex items-center space-x-3 p-3 hover:bg-gray-50 cursor-pointer border-b border-gray-100 last:border-b-0"
              >
                <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center">
                  <span class="text-white text-sm font-bold">{{ user.name.charAt(0) }}</span>
                </div>
                <div class="flex-1">
                  <div class="text-sm font-medium text-gray-900">{{ user.name }}</div>
                  <div class="text-sm text-gray-500">{{ user.email }}</div>
                </div>
                <div class="text-xs text-gray-400">{{ user.role }}</div>
              </div>
            </div>
            
            <!-- Utilisateur sélectionné -->
            <div v-if="selectedUser" class="p-4 bg-green-50 border border-green-200 rounded-lg">
              <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                  <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center">
                    <span class="text-white font-bold">{{ selectedUser.name.charAt(0) }}</span>
                  </div>
                  <div>
                    <div class="font-semibold text-gray-900">{{ selectedUser.name }}</div>
                    <div class="text-sm text-gray-600">{{ selectedUser.email }}</div>
                  </div>
                </div>
                <button @click="removeSelectedUser" class="text-red-600 hover:text-red-800">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                  </svg>
                </button>
              </div>
            </div>
          </div>

          <!-- Groupe d'Utilisateurs -->
          <div v-if="emailType === 'group'" class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Sélectionner un groupe</label>
              <select v-model="selectedGroup" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                <option value="">Choisir un groupe...</option>
                <option v-for="group in userGroups" :key="group.id" :value="group.id">
                  {{ group.name }} ({{ group.userCount }} utilisateurs)
                </option>
              </select>
            </div>
            
            <!-- Groupe sélectionné -->
            <div v-if="selectedGroup" class="p-4 bg-purple-50 border border-purple-200 rounded-lg">
              <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                  <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center">
                    <span class="text-white font-bold">{{ getGroupById(selectedGroup)?.name.charAt(0) }}</span>
                  </div>
                  <div>
                    <div class="font-semibold text-gray-900">{{ getGroupById(selectedGroup)?.name }}</div>
                    <div class="text-sm text-gray-600">{{ getGroupById(selectedGroup)?.userCount }} utilisateurs</div>
                  </div>
                </div>
                <button @click="removeSelectedGroup" class="text-red-600 hover:text-red-800">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                  </svg>
                </button>
              </div>
            </div>
          </div>

          <!-- Diffusion Générale -->
          <div v-if="emailType === 'broadcast'" class="p-4 bg-green-50 border border-green-200 rounded-lg">
            <div class="flex items-center space-x-3">
              <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                </svg>
              </div>
              <div>
                <div class="font-semibold text-gray-900">Diffusion à tous les utilisateurs</div>
                <div class="text-sm text-gray-600">{{ totalUsers }} utilisateurs recevront cet email</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Actions -->
        <div v-if="emailType && (selectedUser || selectedGroup || emailType === 'broadcast')" class="flex justify-end">
          <ModernButton 
            @click="openEmailModal"
            variant="primary"
            icon="plus"
            size="md"
          >
            Composer l'Email
          </ModernButton>
        </div>
      </div>
    </div>

    <!-- Historique des Emails -->
    <div class="bg-white rounded-lg shadow">
      <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900">📋 Historique des Emails</h2>
      </div>
      
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sujet</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Destinataires</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="email in emailHistory" :key="email.id">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">{{ email.subject }}</div>
                <div class="text-sm text-gray-500">{{ email.preview }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                {{ email.recipientCount }} destinataires
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span :class="getEmailTypeClass(email.type)" class="px-2 py-1 text-xs font-semibold rounded-full">
                  {{ getEmailTypeLabel(email.type) }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                {{ formatDate(email.sentAt) }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span :class="getStatusClass(email.status)" class="px-2 py-1 text-xs font-semibold rounded-full">
                  {{ email.status }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <div class="flex space-x-2">
                  <ModernButton 
                    @click="viewEmail(email)"
                    variant="info"
                    icon="view"
                    size="sm"
                  >
                    Voir
                  </ModernButton>
                  <ModernButton 
                    @click="resendEmail(email)"
                    variant="warning"
                    icon="sync"
                    size="sm"
                  >
                    Renvoyer
                  </ModernButton>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal de Composition d'Email -->
    <div v-if="showEmailModal" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm flex items-center justify-center z-50 animate-fadeIn">
      <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full mx-4 transform transition-all duration-300 scale-100 animate-slideUp">
        <div class="bg-gradient-to-r from-green-600 to-emerald-600 px-8 py-6 rounded-t-2xl">
          <div class="flex justify-between items-center">
            <div class="flex items-center space-x-3">
              <div class="w-10 h-10 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
              </div>
              <div>
                <h3 class="text-xl font-bold text-white">Composer un Email</h3>
                <p class="text-green-100 text-sm">{{ getRecipientInfo() }}</p>
              </div>
            </div>
            <button @click="closeEmailModal" class="text-white hover:text-green-200 transition-colors p-2 hover:bg-white hover:bg-opacity-10 rounded-lg">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>
        </div>
        
        <form @submit.prevent="sendEmail" class="px-8 py-6">
          <div class="space-y-6">
            <!-- Sujet -->
            <div class="group">
              <label class="block text-sm font-semibold text-gray-700 mb-2 group-focus-within:text-green-600 transition-colors">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                Sujet de l'email
              </label>
              <input 
                v-model="emailData.subject"
                type="text" 
                required
                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-green-100 focus:border-green-500 transition-all duration-200 placeholder-gray-400"
                placeholder="Ex: Nouvelle fonctionnalité disponible"
              >
            </div>
            
            <!-- Template -->
            <div class="group">
              <label class="block text-sm font-semibold text-gray-700 mb-2 group-focus-within:text-green-600 transition-colors">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Template
              </label>
              <select v-model="emailData.template" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-green-100 focus:border-green-500 transition-all duration-200">
                <option value="custom">Personnalisé</option>
                <option value="newsletter">Newsletter</option>
                <option value="promotion">Promotion</option>
                <option value="notification">Notification</option>
                <option value="welcome">Bienvenue</option>
                <option value="maintenance">Maintenance</option>
              </select>
            </div>
            
            <!-- Contenu -->
            <div class="group">
              <label class="block text-sm font-semibold text-gray-700 mb-2 group-focus-within:text-green-600 transition-colors">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                </svg>
                Contenu de l'email
              </label>
              <textarea 
                v-model="emailData.content"
                rows="8"
                required
                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-4 focus:ring-green-100 focus:border-green-500 transition-all duration-200 placeholder-gray-400 resize-none"
                placeholder="Rédigez votre message ici..."
              ></textarea>
            </div>
            
            <!-- Options -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="space-y-4">
                <h4 class="text-md font-semibold text-gray-900">Options d'envoi</h4>
                <div class="space-y-3">
                  <label class="flex items-center">
                    <input type="checkbox" v-model="emailData.options.priority" class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                    <span class="ml-2 text-sm text-gray-700">Email prioritaire</span>
                  </label>
                  <label class="flex items-center">
                    <input type="checkbox" v-model="emailData.options.tracking" class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                    <span class="ml-2 text-sm text-gray-700">Suivi d'ouverture</span>
                  </label>
                  <label class="flex items-center">
                    <input type="checkbox" v-model="emailData.options.scheduled" class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                    <span class="ml-2 text-sm text-gray-700">Envoi programmé</span>
                  </label>
                </div>
              </div>
              
              <div v-if="emailData.options.scheduled" class="space-y-4">
                <h4 class="text-md font-semibold text-gray-900">Programmation</h4>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-1">Date et heure</label>
                  <input 
                    v-model="emailData.scheduledAt"
                    type="datetime-local"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                  >
                </div>
              </div>
            </div>
          </div>
          
          <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-100">
            <ModernButton 
              @click="closeEmailModal"
              variant="secondary"
              size="md"
            >
              Annuler
            </ModernButton>
            <ModernButton 
              @click="previewEmail"
              variant="info"
              icon="view"
              size="md"
            >
              Aperçu
            </ModernButton>
            <ModernButton 
              @click="sendEmail"
              variant="primary"
              icon="check"
              size="md"
            >
              Envoyer
            </ModernButton>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import ModernButton from '@/components/ui/ModernButton.vue';

// État de la modal
const showEmailModal = ref(false);

// Données générales
const totalUsers = ref(1247);
const emailsSent = ref(89);
const pendingEmails = ref(3);

// Type d'email sélectionné
const emailType = ref('');

// Sélection des destinataires
const selectedUser = ref(null);
const selectedGroup = ref('');
const userSearch = ref('');
const searchResults = ref([]);

// Données de l'email
const emailData = ref({
  subject: '',
  template: 'custom',
  content: '',
  options: {
    priority: false,
    tracking: true,
    scheduled: false
  },
  scheduledAt: ''
});

// Groupes d'utilisateurs
const userGroups = ref([
  {
    id: 1,
    name: 'Clients Premium',
    userCount: 156,
    description: 'Clients avec abonnement premium'
  },
  {
    id: 2,
    name: 'Restaurateurs',
    userCount: 89,
    description: 'Gestionnaires de restaurants'
  },
  {
    id: 3,
    name: 'Livreurs',
    userCount: 234,
    description: 'Équipe de livraison'
  },
  {
    id: 4,
    name: 'Nouveaux Utilisateurs',
    userCount: 67,
    description: 'Inscrits dans les 30 derniers jours'
  },
  {
    id: 5,
    name: 'Utilisateurs Inactifs',
    userCount: 445,
    description: 'Pas de connexion depuis 30 jours'
  }
]);

// Historique des emails
const emailHistory = ref([
  {
    id: 1,
    subject: 'Nouvelle fonctionnalité disponible',
    preview: 'Découvrez notre nouveau système de...',
    recipientCount: 1247,
    type: 'broadcast',
    sentAt: '2024-01-15T10:30:00Z',
    status: 'Envoyé'
  },
  {
    id: 2,
    subject: 'Promotion spéciale Premium',
    preview: 'Profitez de 20% de réduction sur...',
    recipientCount: 156,
    type: 'group',
    sentAt: '2024-01-14T15:45:00Z',
    status: 'Envoyé'
  },
  {
    id: 3,
    subject: 'Rappel de connexion',
    preview: 'Nous vous attendons sur notre plateforme...',
    recipientCount: 445,
    type: 'group',
    sentAt: '2024-01-13T09:15:00Z',
    status: 'En cours'
  }
]);

// Utilisateurs pour la recherche
const users = ref([
  { id: 1, name: 'Mamadou Diallo', email: 'mamadou@example.com', role: 'Client Premium' },
  { id: 2, name: 'Fatou Sall', email: 'fatou@restaurant.com', role: 'Restaurateur' },
  { id: 3, name: 'Omar Ba', email: 'omar@driver.com', role: 'Livreur' },
  { id: 4, name: 'Aïssa Diop', email: 'aissa@example.com', role: 'Client' },
  { id: 5, name: 'Khadija Ndiaye', email: 'khadija@restaurant.com', role: 'Restaurateur' }
]);

// Méthodes
const selectEmailType = (type) => {
  emailType.value = type;
  // Réinitialiser les sélections
  selectedUser.value = null;
  selectedGroup.value = '';
  userSearch.value = '';
  searchResults.value = [];
};

const searchUsers = () => {
  if (userSearch.value.length < 2) {
    searchResults.value = [];
    return;
  }
  
  const query = userSearch.value.toLowerCase();
  searchResults.value = users.value.filter(user => 
    user.name.toLowerCase().includes(query) ||
    user.email.toLowerCase().includes(query) ||
    user.role.toLowerCase().includes(query)
  );
};

const selectUser = (user) => {
  selectedUser.value = user;
  searchResults.value = [];
  userSearch.value = '';
};

const removeSelectedUser = () => {
  selectedUser.value = null;
};

const removeSelectedGroup = () => {
  selectedGroup.value = '';
};

const getGroupById = (id) => {
  return userGroups.value.find(group => group.id === id);
};

const getRecipientInfo = () => {
  if (emailType.value === 'individual' && selectedUser.value) {
    return `Envoyer à ${selectedUser.value.name}`;
  } else if (emailType.value === 'group' && selectedGroup.value) {
    const group = getGroupById(selectedGroup.value);
    return `Envoyer au groupe "${group?.name}" (${group?.userCount} utilisateurs)`;
  } else if (emailType.value === 'broadcast') {
    return `Diffusion générale (${totalUsers.value} utilisateurs)`;
  }
  return '';
};

const openEmailModal = () => {
  showEmailModal.value = true;
};

const closeEmailModal = () => {
  showEmailModal.value = false;
  // Réinitialiser le formulaire
  emailData.value = {
    subject: '',
    template: 'custom',
    content: '',
    options: {
      priority: false,
      tracking: true,
      scheduled: false
    },
    scheduledAt: ''
  };
};

const previewEmail = () => {
  console.log('Aperçu de l\'email:', emailData.value);
  if (window.notify) {
    window.notify.info('Aperçu', 'Fonctionnalité d\'aperçu en cours de développement');
  }
};

const sendEmail = () => {
  console.log('Envoi de l\'email:', emailData.value);
  console.log('Type:', emailType.value);
  console.log('Destinataires:', selectedUser.value || selectedGroup.value || 'broadcast');
  
  // Ajouter à l'historique
  const newEmail = {
    id: emailHistory.value.length + 1,
    subject: emailData.value.subject,
    preview: emailData.value.content.substring(0, 50) + '...',
    recipientCount: emailType.value === 'individual' ? 1 : 
                   emailType.value === 'group' ? getGroupById(selectedGroup.value)?.userCount : totalUsers.value,
    type: emailType.value,
    sentAt: new Date().toISOString(),
    status: emailData.value.options.scheduled ? 'Programmé' : 'Envoyé'
  };
  
  emailHistory.value.unshift(newEmail);
  
  closeEmailModal();
  
  if (window.notify) {
    window.notify.success('Email envoyé !', `L'email a été envoyé avec succès.`);
  }
};

const viewEmail = (email) => {
  console.log('Visualisation de l\'email:', email);
  if (window.notify) {
    window.notify.info('Visualisation', 'Fonctionnalité de visualisation en cours de développement');
  }
};

const resendEmail = (email) => {
  console.log('Renvoyer l\'email:', email);
  if (window.notify) {
    window.notify.success('Email renvoyé !', 'L\'email a été renvoyé avec succès.');
  }
};

const getEmailTypeClass = (type) => {
  switch (type) {
    case 'individual': return 'bg-blue-100 text-blue-800';
    case 'group': return 'bg-purple-100 text-purple-800';
    case 'broadcast': return 'bg-green-100 text-green-800';
    default: return 'bg-gray-100 text-gray-800';
  }
};

const getEmailTypeLabel = (type) => {
  switch (type) {
    case 'individual': return 'Individuel';
    case 'group': return 'Groupe';
    case 'broadcast': return 'Diffusion';
    default: return 'Inconnu';
  }
};

const getStatusClass = (status) => {
  switch (status) {
    case 'Envoyé': return 'bg-green-100 text-green-800';
    case 'En cours': return 'bg-yellow-100 text-yellow-800';
    case 'Programmé': return 'bg-blue-100 text-blue-800';
    case 'Échec': return 'bg-red-100 text-red-800';
    default: return 'bg-gray-100 text-gray-800';
  }
};

const formatDate = (dateString) => {
  const date = new Date(dateString);
  return date.toLocaleDateString('fr-FR', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  });
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

.group:focus-within label {
  color: #059669;
}

.group:focus-within input,
.group:focus-within textarea,
.group:focus-within select {
  border-color: #10b981;
  box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
}
</style>
