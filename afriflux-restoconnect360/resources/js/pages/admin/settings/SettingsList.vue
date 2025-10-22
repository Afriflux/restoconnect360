<template>
  <div class="p-6">
    <div class="mb-6">
      <h1 class="text-2xl font-bold text-gray-900">⚙️ Centre de Configuration</h1>
      <p class="text-gray-600 mt-2">Configurez tous les paramètres de la plateforme</p>
    </div>

    <!-- Tabs Navigation -->
    <div class="bg-white rounded-lg shadow">
      <div class="border-b border-gray-200">
        <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
          <button
            v-for="tab in tabs"
            :key="tab.id"
            @click="activeTab = tab.id"
            :class="[
              activeTab === tab.id
                ? 'border-green-500 text-green-600'
                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
              'whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center space-x-2'
            ]"
          >
            <span class="text-lg">{{ tab.icon }}</span>
            <span>{{ tab.name }}</span>
          </button>
        </nav>
      </div>

      <!-- Tab Content -->
      <div class="p-6">
        <!-- General Tab -->
        <div v-if="activeTab === 'general'" class="space-y-6">
          <div>
            <h2 class="text-lg font-semibold text-gray-900 mb-4">🌐 Paramètres Généraux</h2>
            <div class="space-y-4">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Nom de la Plateforme</label>
                  <input type="text" value="RestoConnect360" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Email de Contact</label>
                  <input type="email" value="contact@restoconnect360.com" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea class="w-full border border-gray-300 rounded-lg px-3 py-2 h-20" placeholder="Description de la plateforme..."></textarea>
              </div>
            </div>
          </div>
        </div>

        <!-- Branding Tab -->
        <div v-if="activeTab === 'branding'" class="space-y-6">
          <div>
            <h2 class="text-lg font-semibold text-gray-900 mb-4">🎨 Branding & Identité Visuelle</h2>
            <div class="space-y-4">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Logo Principal</label>
                  <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                      <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <p class="mt-2 text-sm text-gray-600">Cliquez pour télécharger le logo</p>
                  </div>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Favicon</label>
                  <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                      <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <p class="mt-2 text-sm text-gray-600">Cliquez pour télécharger le favicon</p>
                  </div>
                </div>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Couleur Principale</label>
                  <input type="color" value="#10B981" class="w-full h-10 border border-gray-300 rounded-lg">
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Couleur Secondaire</label>
                  <input type="color" value="#059669" class="w-full h-10 border border-gray-300 rounded-lg">
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Couleur d'Accent</label>
                  <input type="color" value="#F59E0B" class="w-full h-10 border border-gray-300 rounded-lg">
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Communication Tab -->
        <div v-if="activeTab === 'communication'" class="space-y-6">
          <div>
            <h2 class="text-lg font-semibold text-gray-900 mb-4">📧 Communication & Notifications</h2>
            
            <!-- Email Settings -->
            <div class="mb-6">
              <h3 class="text-md font-semibold text-gray-800 mb-3">📧 Configuration Email</h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Serveur SMTP</label>
                  <input type="text" value="smtp.gmail.com" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Port</label>
                  <input type="number" value="587" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Email d'Envoi</label>
                  <input type="email" value="noreply@restoconnect360.com" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Mot de Passe</label>
                  <input type="password" placeholder="••••••••" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
              </div>
            </div>

            <!-- WhatsApp Settings -->
            <div class="mb-6">
              <h3 class="text-md font-semibold text-gray-800 mb-3">💬 Configuration WhatsApp</h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Token WhatsApp Business</label>
                  <input type="text" placeholder="Votre token WhatsApp" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Numéro WhatsApp</label>
                  <input type="tel" value="+221781234567" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
              </div>
            </div>

            <!-- SMS Settings -->
            <div>
              <h3 class="text-md font-semibold text-gray-800 mb-3">📱 Configuration SMS</h3>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Fournisseur SMS</label>
                  <select class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option>Orange SMS API</option>
                    <option>Free SMS API</option>
                    <option>Twilio</option>
                    <option>Autre</option>
                  </select>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Clé API</label>
                  <input type="password" placeholder="••••••••" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Payment Tab -->
        <div v-if="activeTab === 'payment'" class="space-y-6">
          <div>
            <h2 class="text-lg font-semibold text-gray-900 mb-4">💳 Paiements & Taxes</h2>
            <div class="space-y-4">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Commission Plateforme (%)</label>
                  <input type="number" value="5" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Frais de Livraison (FCFA)</label>
                  <input type="number" value="500" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">TVA (%)</label>
                  <input type="number" value="18" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Taxe de Service (%)</label>
                  <input type="number" value="2" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
              </div>
              <div class="flex items-center space-x-4">
                <label class="flex items-center">
                  <input type="checkbox" checked class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                  <span class="ml-2 text-sm text-gray-700">Paiement en ligne activé</span>
                </label>
                <label class="flex items-center">
                  <input type="checkbox" checked class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                  <span class="ml-2 text-sm text-gray-700">Paiement à la livraison</span>
                </label>
                <label class="flex items-center">
                  <input type="checkbox" class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                  <span class="ml-2 text-sm text-gray-700">TVA incluse dans les prix</span>
                </label>
              </div>
            </div>
          </div>
        </div>

        <!-- Promotions Tab -->
        <div v-if="activeTab === 'promotions'" class="space-y-6">
          <div>
            <h2 class="text-lg font-semibold text-gray-900 mb-4">🎯 Bannières Promotionnelles</h2>
            <div class="space-y-4">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Bannière Principale</label>
                  <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                      <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <p class="mt-2 text-sm text-gray-600">Télécharger une bannière (1200x300px)</p>
                  </div>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Bannière Mobile</label>
                  <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                      <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <p class="mt-2 text-sm text-gray-600">Télécharger une bannière mobile (600x200px)</p>
                  </div>
                </div>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Texte de la Bannière</label>
                  <input type="text" placeholder="Promotion spéciale - Livraison gratuite !" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Lien de la Bannière</label>
                  <input type="url" placeholder="https://restoconnect360.com/promotion" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
              </div>
              <div class="flex items-center space-x-4">
                <label class="flex items-center">
                  <input type="checkbox" checked class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                  <span class="ml-2 text-sm text-gray-700">Bannière active</span>
                </label>
                <label class="flex items-center">
                  <input type="checkbox" class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                  <span class="ml-2 text-sm text-gray-700">Afficher sur mobile uniquement</span>
                </label>
              </div>
            </div>
          </div>
        </div>

        <!-- CMS Tab -->
        <div v-if="activeTab === 'cms'" class="space-y-6">
          <div>
            <h2 class="text-lg font-semibold text-gray-900 mb-4">📄 Pages CMS & Politiques</h2>
            <div class="space-y-4">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Conditions d'Utilisation</label>
                  <textarea class="w-full border border-gray-300 rounded-lg px-3 py-2 h-32" placeholder="Contenu des conditions d'utilisation..."></textarea>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Politique de Confidentialité</label>
                  <textarea class="w-full border border-gray-300 rounded-lg px-3 py-2 h-32" placeholder="Contenu de la politique de confidentialité..."></textarea>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Mentions Légales</label>
                  <textarea class="w-full border border-gray-300 rounded-lg px-3 py-2 h-32" placeholder="Contenu des mentions légales..."></textarea>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">À Propos</label>
                  <textarea class="w-full border border-gray-300 rounded-lg px-3 py-2 h-32" placeholder="Contenu de la page À propos..."></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Localization Tab -->
        <div v-if="activeTab === 'localization'" class="space-y-6">
          <div>
            <h2 class="text-lg font-semibold text-gray-900 mb-4">🌍 Langues & Localisation</h2>
            <div class="space-y-4">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Langue par Défaut</label>
                  <select class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option>Français</option>
                    <option>English</option>
                    <option>العربية</option>
                    <option>Wolof</option>
                  </select>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Langues Disponibles</label>
                  <div class="space-y-2">
                    <label class="flex items-center">
                      <input type="checkbox" checked class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                      <span class="ml-2 text-sm text-gray-700">Français</span>
                    </label>
                    <label class="flex items-center">
                      <input type="checkbox" class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                      <span class="ml-2 text-sm text-gray-700">English</span>
                    </label>
                    <label class="flex items-center">
                      <input type="checkbox" class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                      <span class="ml-2 text-sm text-gray-700">العربية</span>
                    </label>
                    <label class="flex items-center">
                      <input type="checkbox" class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                      <span class="ml-2 text-sm text-gray-700">Wolof</span>
                    </label>
                  </div>
                </div>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Devise</label>
                  <select class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option>FCFA (XOF)</option>
                    <option>Euro (EUR)</option>
                    <option>Dollar US (USD)</option>
                  </select>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Fuseau Horaire</label>
                  <select class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option>GMT (Dakar)</option>
                    <option>GMT+1 (Paris)</option>
                    <option>GMT-5 (New York)</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- SEO Tab -->
        <div v-if="activeTab === 'seo'" class="space-y-6">
          <div>
            <h2 class="text-lg font-semibold text-gray-900 mb-4">🔍 SEO & Géolocalisation</h2>
            <div class="space-y-4">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Titre SEO</label>
                  <input type="text" value="RestoConnect360 - Livraison de repas au Sénégal" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Description SEO</label>
                  <textarea class="w-full border border-gray-300 rounded-lg px-3 py-2 h-20" placeholder="Description pour les moteurs de recherche..."></textarea>
                </div>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Mots-clés SEO</label>
                  <input type="text" value="livraison, repas, restaurant, dakar, sénégal" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Zone de Livraison (km)</label>
                  <input type="number" value="15" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Latitude</label>
                  <input type="number" step="0.000001" value="14.7167" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Longitude</label>
                  <input type="number" step="0.000001" value="-17.4677" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Social Tab -->
        <div v-if="activeTab === 'social'" class="space-y-6">
          <div>
            <h2 class="text-lg font-semibold text-gray-900 mb-4">📞 Quick Call & Réseaux Sociaux</h2>
            <div class="space-y-4">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Numéro Quick Call</label>
                  <input type="tel" value="+221781234567" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Heures d'Appel</label>
                  <input type="text" value="8h00 - 22h00" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
              </div>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Facebook</label>
                  <input type="url" placeholder="https://facebook.com/restoconnect360" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Instagram</label>
                  <input type="url" placeholder="https://instagram.com/restoconnect360" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">TikTok</label>
                  <input type="url" placeholder="https://tiktok.com/@restoconnect360" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Twitter</label>
                  <input type="url" placeholder="https://twitter.com/restoconnect360" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">LinkedIn</label>
                  <input type="url" placeholder="https://linkedin.com/company/restoconnect360" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Security Tab -->
        <div v-if="activeTab === 'security'" class="space-y-6">
          <div>
            <h2 class="text-lg font-semibold text-gray-900 mb-4">🔒 Sécurité</h2>
            <div class="space-y-4">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Durée de Session (heures)</label>
                  <input type="number" value="24" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Tentatives de Connexion Max</label>
                  <input type="number" value="5" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
              </div>
              <div class="flex items-center space-x-4">
                <label class="flex items-center">
                  <input type="checkbox" checked class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                  <span class="ml-2 text-sm text-gray-700">Authentification à deux facteurs</span>
                </label>
                <label class="flex items-center">
                  <input type="checkbox" class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                  <span class="ml-2 text-sm text-gray-700">Connexion par IP restreinte</span>
                </label>
              </div>
            </div>
          </div>
        </div>

        <!-- Save Buttons -->
        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
          <button class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition-colors">
            🔄 Réinitialiser
          </button>
          <button class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors">
            💾 Sauvegarder les Paramètres
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import ModernButton from '@/components/ui/ModernButton.vue';

const activeTab = ref('general');

const tabs = [
  { id: 'general', name: 'Général', icon: '🌐' },
  { id: 'branding', name: 'Branding', icon: '🎨' },
  { id: 'communication', name: 'Communication', icon: '📧' },
  { id: 'payment', name: 'Paiements', icon: '💳' },
  { id: 'promotions', name: 'Promotions', icon: '🎯' },
  { id: 'cms', name: 'CMS', icon: '📄' },
  { id: 'localization', name: 'Langues', icon: '🌍' },
  { id: 'seo', name: 'SEO', icon: '🔍' },
  { id: 'social', name: 'Social', icon: '📞' },
  { id: 'security', name: 'Sécurité', icon: '🔒' }
];
</script>