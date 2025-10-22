<template>
  <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
      <!-- Header -->
      <div class="text-center mb-12">
        <h1 class="text-h1 text-dark-800 mb-4">
          🎨 Charte Graphique RestoConnect360
        </h1>
        <p class="text-body text-gray-600 max-w-3xl mx-auto">
          Guide de style complet de votre application de gestion. 
          Découvrez tous les composants UI, la palette de couleurs harmonieuse, 
          la typographie élégante et les standards visuels de RestoConnect360.
        </p>
      </div>

      <!-- Palette de couleurs -->
      <section class="mb-16">
        <h2 class="text-h2 text-dark-800 mb-6">Palette de couleurs</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <!-- Couleur principale - Brand -->
          <div class="card">
            <h3 class="text-h3 text-dark-800 mb-4">Brand (Vert vif)</h3>
            <div class="space-y-2">
              <div class="h-16 bg-brand-500 rounded-lg flex items-center justify-center text-white font-label">
                #28A745 - Principal
              </div>
              <div class="h-12 bg-brand-600 rounded-lg flex items-center justify-center text-white text-sm">
                #218838 - Hover
              </div>
              <div class="grid grid-cols-3 gap-2">
                <div class="h-10 bg-brand-300 rounded"></div>
                <div class="h-10 bg-brand-700 rounded"></div>
                <div class="h-10 bg-brand-900 rounded"></div>
              </div>
            </div>
            <p class="text-small text-gray-600 mt-3">
              Fraîcheur, santé, confiance
            </p>
          </div>

          <!-- Couleur secondaire - Orange -->
          <div class="card">
            <h3 class="text-h3 text-dark-800 mb-4">Secondary (Orange)</h3>
            <div class="space-y-2">
              <div class="h-16 bg-secondary-500 rounded-lg flex items-center justify-center text-white font-label">
                #FF7F11 - Principal
              </div>
              <div class="h-12 bg-secondary-600 rounded-lg flex items-center justify-center text-white text-sm">
                #e67300 - Hover
              </div>
              <div class="grid grid-cols-3 gap-2">
                <div class="h-10 bg-secondary-300 rounded"></div>
                <div class="h-10 bg-secondary-700 rounded"></div>
                <div class="h-10 bg-secondary-900 rounded"></div>
              </div>
            </div>
            <p class="text-small text-gray-600 mt-3">
              Dynamisme, action, appétence
            </p>
          </div>

          <!-- Success -->
          <div class="card">
            <h3 class="text-h3 text-dark-800 mb-4">Success (Vert clair)</h3>
            <div class="space-y-2">
              <div class="h-16 bg-success-400 rounded-lg flex items-center justify-center text-white font-label">
                #34D399
              </div>
              <div class="grid grid-cols-3 gap-2">
                <div class="h-10 bg-success-200 rounded"></div>
                <div class="h-10 bg-success-600 rounded"></div>
                <div class="h-10 bg-success-800 rounded"></div>
              </div>
            </div>
            <p class="text-small text-gray-600 mt-3">
              Succès, confirmations
            </p>
          </div>

          <!-- Danger -->
          <div class="card">
            <h3 class="text-h3 text-dark-800 mb-4">Danger (Rouge tomate)</h3>
            <div class="space-y-2">
              <div class="h-16 bg-danger-500 rounded-lg flex items-center justify-center text-white font-label">
                #E63946
              </div>
              <div class="grid grid-cols-3 gap-2">
                <div class="h-10 bg-danger-200 rounded"></div>
                <div class="h-10 bg-danger-600 rounded"></div>
                <div class="h-10 bg-danger-800 rounded"></div>
              </div>
            </div>
            <p class="text-small text-gray-600 mt-3">
              Alertes, erreurs
            </p>
          </div>

          <!-- Info -->
          <div class="card">
            <h3 class="text-h3 text-dark-800 mb-4">Info (Bleu clair)</h3>
            <div class="space-y-2">
              <div class="h-16 bg-info-500 rounded-lg flex items-center justify-center text-white font-label">
                #3B82F6
              </div>
              <div class="grid grid-cols-3 gap-2">
                <div class="h-10 bg-info-200 rounded"></div>
                <div class="h-10 bg-info-600 rounded"></div>
                <div class="h-10 bg-info-800 rounded"></div>
              </div>
            </div>
            <p class="text-small text-gray-600 mt-3">
              Informations, notifications
            </p>
          </div>

          <!-- Dark & Light -->
          <div class="card">
            <h3 class="text-h3 text-dark-800 mb-4">Dark & Light</h3>
            <div class="space-y-2">
              <div class="h-16 bg-dark-800 rounded-lg flex items-center justify-center text-white font-label">
                #1F2937 - Dark
              </div>
              <div class="h-16 bg-light-300 rounded-lg flex items-center justify-center text-dark-800 font-label border">
                #F3F4F6 - Light
              </div>
            </div>
            <p class="text-small text-gray-600 mt-3">
              Texte principal & backgrounds
            </p>
          </div>
        </div>
      </section>

      <!-- Typographie -->
      <section class="mb-16">
        <h2 class="text-h2 text-dark-800 mb-6">Typographie</h2>
        
        <div class="card space-y-6">
          <div>
            <p class="text-small text-gray-500 mb-2 font-label">Poppins - Titres & Branding</p>
            <h1 class="text-h1 text-dark-800">Heading 1 - Poppins Bold (2.5rem)</h1>
            <h2 class="text-h2 text-dark-800">Heading 2 - Poppins SemiBold (2rem)</h2>
            <h3 class="text-h3 text-dark-800">Heading 3 - Poppins SemiBold (1.5rem)</h3>
          </div>

          <div class="border-t pt-6">
            <p class="text-small text-gray-500 mb-2 font-label">Inter - Corps de texte</p>
            <p class="text-body text-gray-700">
              Ceci est un exemple de paragraphe en Inter Regular (1rem). 
              Cette police assure une lisibilité optimale sur tous les supports, 
              que ce soit sur desktop, tablette ou mobile.
            </p>
            <p class="text-small text-gray-600 mt-2">
              Texte petit en Inter Regular (0.875rem) pour les descriptions et notes.
            </p>
          </div>

          <div class="border-t pt-6">
            <p class="text-small text-gray-500 mb-2 font-label">Montserrat - Labels & Menus</p>
            <p class="font-label font-medium text-gray-700">
              Montserrat Medium pour les labels, boutons et navigation
            </p>
          </div>
        </div>
      </section>

      <!-- Boutons -->
      <section class="mb-16">
        <h2 class="text-h2 text-dark-800 mb-6">Boutons</h2>
        
        <div class="card">
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
              <p class="text-small text-gray-500 mb-3 font-label">Bouton Principal</p>
              <button class="btn-primary w-full">
                Action Principale
              </button>
            </div>

            <div>
              <p class="text-small text-gray-500 mb-3 font-label">Bouton Secondaire</p>
              <button class="btn-secondary w-full">
                Action Secondaire
              </button>
            </div>

            <div>
              <p class="text-small text-gray-500 mb-3 font-label">Bouton Outline</p>
              <button class="btn-outline w-full">
                Outline
              </button>
            </div>

            <div>
              <p class="text-small text-gray-500 mb-3 font-label">Bouton Disabled</p>
              <button class="btn-disabled w-full" disabled>
                Désactivé
              </button>
            </div>
          </div>

          <div class="mt-6 pt-6 border-t">
            <p class="text-small text-gray-500 mb-3 font-label">Avec icônes Heroicons</p>
            <div class="flex flex-wrap gap-3">
              <button class="btn-primary flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Ajouter
              </button>

              <button class="btn-secondary flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                Voir
              </button>

              <button class="btn-outline flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Télécharger
              </button>
            </div>
          </div>
        </div>
      </section>

      <!-- Formulaires -->
      <section class="mb-16">
        <h2 class="text-h2 text-dark-800 mb-6">Formulaires</h2>
        
        <div class="card">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-small font-label font-medium text-gray-700 mb-2">
                Input Normal
              </label>
              <input 
                type="text" 
                class="input" 
                placeholder="Entrez votre texte..."
              />
            </div>

            <div>
              <label class="block text-small font-label font-medium text-gray-700 mb-2">
                Input avec Erreur
              </label>
              <input 
                type="text" 
                class="input-error" 
                placeholder="Champ avec erreur"
                value="Valeur incorrecte"
              />
              <p class="text-small text-danger-600 mt-1">Ce champ contient une erreur</p>
            </div>

            <div>
              <label class="block text-small font-label font-medium text-gray-700 mb-2">
                Select
              </label>
              <select class="input">
                <option>Option 1</option>
                <option>Option 2</option>
                <option>Option 3</option>
              </select>
            </div>

            <div>
              <label class="block text-small font-label font-medium text-gray-700 mb-2">
                Textarea
              </label>
              <textarea 
                class="input" 
                rows="3" 
                placeholder="Votre message..."
              ></textarea>
            </div>
          </div>

          <div class="mt-6 pt-6 border-t">
            <label class="flex items-center gap-2 cursor-pointer">
              <input type="checkbox" class="w-4 h-4 text-brand focus:ring-brand rounded" checked />
              <span class="text-body text-gray-700">Accepter les conditions d'utilisation</span>
            </label>
          </div>
        </div>
      </section>

      <!-- Alerts / Notifications -->
      <section class="mb-16">
        <h2 class="text-h2 text-dark-800 mb-6">Alertes & Notifications</h2>
        
        <div class="space-y-4">
          <div class="alert-success">
            <div class="flex items-start gap-3">
              <svg class="w-6 h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
              </svg>
              <div>
                <p class="font-label font-semibold">Opération réussie !</p>
                <p class="text-small mt-1">Votre commande a été enregistrée avec succès.</p>
              </div>
            </div>
          </div>

          <div class="alert-info">
            <div class="flex items-start gap-3">
              <svg class="w-6 h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
              </svg>
              <div>
                <p class="font-label font-semibold">Information</p>
                <p class="text-small mt-1">Voici une notification informative pour l'utilisateur.</p>
              </div>
            </div>
          </div>

          <div class="alert-warning">
            <div class="flex items-start gap-3">
              <svg class="w-6 h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
              </svg>
              <div>
                <p class="font-label font-semibold">Attention</p>
                <p class="text-small mt-1">Cette action nécessite votre attention particulière.</p>
              </div>
            </div>
          </div>

          <div class="alert-danger">
            <div class="flex items-start gap-3">
              <svg class="w-6 h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
              </svg>
              <div>
                <p class="font-label font-semibold">Erreur</p>
                <p class="text-small mt-1">Une erreur s'est produite. Veuillez réessayer.</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Badges -->
      <section class="mb-16">
        <h2 class="text-h2 text-dark-800 mb-6">Badges</h2>
        
        <div class="card">
          <div class="flex flex-wrap gap-3">
            <span class="badge-success">Actif</span>
            <span class="badge-warning">En attente</span>
            <span class="badge-danger">Annulé</span>
            <span class="badge-info">Nouveau</span>
            <span class="badge bg-brand-500 text-white">Premium</span>
            <span class="badge bg-purple-100 text-purple-700">VIP</span>
          </div>
        </div>
      </section>

      <!-- Cartes -->
      <section class="mb-16">
        <h2 class="text-h2 text-dark-800 mb-6">Cartes</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div class="card">
            <div class="flex items-center justify-between mb-4">
              <h3 class="text-h3 text-dark-800">Carte Standard</h3>
              <span class="badge-success">Actif</span>
            </div>
            <p class="text-body text-gray-600 mb-4">
              Une carte avec ombre douce et coins arrondis suivant la charte graphique.
            </p>
            <button class="btn-primary w-full">Action</button>
          </div>

          <div class="card-light">
            <div class="flex items-center justify-between mb-4">
              <h3 class="text-h3 text-dark-800">Carte Light</h3>
              <span class="badge-info">Info</span>
            </div>
            <p class="text-body text-gray-600 mb-4">
              Carte avec fond gris clair pour différencier les zones.
            </p>
            <button class="btn-secondary w-full">Action</button>
          </div>

          <div class="bg-gradient-to-br from-brand-500 to-brand-700 rounded-xl shadow-floating p-6 text-white">
            <div class="flex items-center justify-between mb-4">
              <h3 class="text-h3">Carte Gradient</h3>
              <span class="badge bg-white text-brand-600">Premium</span>
            </div>
            <p class="text-body mb-4 opacity-90">
              Carte avec dégradé de la couleur principale pour mettre en avant.
            </p>
            <button class="bg-white text-brand-600 hover:bg-gray-100 px-6 py-3 rounded-lg font-label font-medium transition-smooth w-full">
              Action
            </button>
          </div>
        </div>
      </section>

      <!-- Tableaux -->
      <section class="mb-16">
        <h2 class="text-h2 text-dark-800 mb-6">Tableaux</h2>
        
        <div class="card overflow-hidden">
          <div class="overflow-x-auto">
            <table class="w-full">
              <thead class="bg-dark-800 text-white">
                <tr>
                  <th class="px-6 py-4 text-left font-label font-semibold">Restaurant</th>
                  <th class="px-6 py-4 text-left font-label font-semibold">Commandes</th>
                  <th class="px-6 py-4 text-left font-label font-semibold">Revenu</th>
                  <th class="px-6 py-4 text-left font-label font-semibold">Statut</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                <tr class="hover:bg-light-300 transition-colors">
                  <td class="px-6 py-4 text-body text-gray-900">Le Gourmet</td>
                  <td class="px-6 py-4 text-body text-gray-900">142</td>
                  <td class="px-6 py-4 text-body text-gray-900">12 450 €</td>
                  <td class="px-6 py-4"><span class="badge-success">Actif</span></td>
                </tr>
                <tr class="bg-light-300 hover:bg-gray-200 transition-colors">
                  <td class="px-6 py-4 text-body text-gray-900">Pizza Roma</td>
                  <td class="px-6 py-4 text-body text-gray-900">89</td>
                  <td class="px-6 py-4 text-body text-gray-900">7 820 €</td>
                  <td class="px-6 py-4"><span class="badge-success">Actif</span></td>
                </tr>
                <tr class="hover:bg-light-300 transition-colors">
                  <td class="px-6 py-4 text-body text-gray-900">Sushi Master</td>
                  <td class="px-6 py-4 text-body text-gray-900">67</td>
                  <td class="px-6 py-4 text-body text-gray-900">9 340 €</td>
                  <td class="px-6 py-4"><span class="badge-warning">Pause</span></td>
                </tr>
                <tr class="bg-light-300 hover:bg-gray-200 transition-colors">
                  <td class="px-6 py-4 text-body text-gray-900">Burger House</td>
                  <td class="px-6 py-4 text-body text-gray-900">103</td>
                  <td class="px-6 py-4 text-body text-gray-900">8 670 €</td>
                  <td class="px-6 py-4"><span class="badge-success">Actif</span></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </section>

      <!-- Animations -->
      <section class="mb-16">
        <h2 class="text-h2 text-dark-800 mb-6">Animations</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="card animate-fade-in">
            <h3 class="text-h3 text-dark-800 mb-3">Fade In</h3>
            <p class="text-body text-gray-600">
              Animation d'apparition en fondu avec translation verticale.
            </p>
          </div>

          <div class="card animate-slide-in">
            <h3 class="text-h3 text-dark-800 mb-3">Slide In</h3>
            <p class="text-body text-gray-600">
              Animation de glissement depuis la gauche.
            </p>
          </div>
        </div>
      </section>

      <!-- Ombres -->
      <section class="mb-16">
        <h2 class="text-h2 text-dark-800 mb-6">Ombres personnalisées</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div class="bg-white shadow-soft rounded-xl p-6">
            <h3 class="text-h3 text-dark-800 mb-3">Shadow Soft</h3>
            <p class="text-body text-gray-600">
              Ombre douce pour les cartes standards.
            </p>
          </div>

          <div class="bg-white shadow-card rounded-xl p-6">
            <h3 class="text-h3 text-dark-800 mb-3">Shadow Card</h3>
            <p class="text-body text-gray-600">
              Ombre subtile pour les composants.
            </p>
          </div>

          <div class="bg-white shadow-floating rounded-xl p-6">
            <h3 class="text-h3 text-dark-800 mb-3">Shadow Floating</h3>
            <p class="text-body text-gray-600">
              Ombre flottante pour les modales.
            </p>
          </div>
        </div>
      </section>

      <!-- Footer -->
      <div class="text-center pt-8 border-t border-gray-200">
        <p class="text-body text-gray-600">
          Charte graphique <span class="text-brand font-label font-semibold">RestoConnect360</span> - Version 1.0
        </p>
        <p class="text-small text-gray-500 mt-2">
          Solution digitale professionnelle, moderne et intuitive pour la restauration
        </p>
      </div>
    </div>
  </div>
</template>

<script setup>
// Composant de démonstration de la charte graphique
// Pas de logique nécessaire pour cette page de présentation
</script>

<style scoped>
/* Styles supplémentaires si nécessaire */
</style>

