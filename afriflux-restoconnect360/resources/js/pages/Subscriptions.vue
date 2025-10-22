<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-h1 text-dark-800 mb-2">Gestion des Abonnements</h1>
            <p class="text-body text-gray-600">Gérez vos plans et facturation RestoConnect360</p>
          </div>
          <div class="flex items-center gap-3">
            <div class="badge-success">Actif</div>
            <span class="text-small text-gray-500">Plan actuel</span>
          </div>
        </div>
      </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Plan Actuel -->
        <div class="lg:col-span-2 space-y-6">
          <!-- Plan Actuel -->
          <div class="card">
            <div class="flex items-center justify-between mb-6">
              <h2 class="text-h2 text-dark-800">Plan Actuel</h2>
              <div class="badge-success">Actif</div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
              <div class="bg-gradient-to-br from-brand-500 to-brand-700 rounded-xl p-6 text-white">
                <div class="flex items-center justify-between mb-4">
                  <h3 class="text-xl font-bold">Premium</h3>
                  <span class="text-2xl">👑</span>
                </div>
                <div class="text-3xl font-bold mb-2">89€</div>
                <div class="text-brand-100">/ mois</div>
              </div>
              
              <div class="space-y-4">
                <div>
                  <h4 class="font-label font-semibold text-gray-700 mb-2">Fonctionnalités incluses</h4>
                  <ul class="space-y-2">
                    <li class="flex items-center gap-2 text-small text-gray-600">
                      <svg class="w-4 h-4 text-success-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                      </svg>
                      POS complet
                    </li>
                    <li class="flex items-center gap-2 text-small text-gray-600">
                      <svg class="w-4 h-4 text-success-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                      </svg>
                      Livraison GPS
                    </li>
                    <li class="flex items-center gap-2 text-small text-gray-600">
                      <svg class="w-4 h-4 text-success-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                      </svg>
                      Paiements mobiles
                    </li>
                    <li class="flex items-center gap-2 text-small text-gray-600">
                      <svg class="w-4 h-4 text-success-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                      </svg>
                      Support prioritaire
                    </li>
                  </ul>
                </div>
              </div>
              
              <div class="space-y-4">
                <div>
                  <h4 class="font-label font-semibold text-gray-700 mb-2">Prochain renouvellement</h4>
                  <div class="text-h3 text-dark-800">15 Janvier 2025</div>
                  <div class="text-small text-gray-600">dans 23 jours</div>
                </div>
                
                <div class="flex gap-2">
                  <button class="btn-outline text-small px-4 py-2">Modifier</button>
                  <button class="btn-secondary text-small px-4 py-2">Annuler</button>
                </div>
              </div>
            </div>
          </div>

          <!-- Historique des Paiements -->
          <div class="card">
            <div class="flex items-center justify-between mb-6">
              <h2 class="text-h2 text-dark-800">Historique des Paiements</h2>
              <button class="btn-outline text-small">Télécharger</button>
            </div>
            
            <div class="overflow-x-auto">
              <table class="w-full">
                <thead class="bg-dark-800 text-white">
                  <tr>
                    <th class="px-4 py-3 text-left font-label font-semibold">Date</th>
                    <th class="px-4 py-3 text-left font-label font-semibold">Description</th>
                    <th class="px-4 py-3 text-left font-label font-semibold">Montant</th>
                    <th class="px-4 py-3 text-left font-label font-semibold">Statut</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                  <tr class="hover:bg-light-300 transition-colors">
                    <td class="px-4 py-3 text-body text-gray-900">15 Déc 2024</td>
                    <td class="px-4 py-3 text-body text-gray-900">Abonnement Premium</td>
                    <td class="px-4 py-3 text-body text-gray-900">89,00 €</td>
                    <td class="px-4 py-3"><span class="badge-success">Payé</span></td>
                  </tr>
                  <tr class="bg-light-300 hover:bg-gray-200 transition-colors">
                    <td class="px-4 py-3 text-body text-gray-900">15 Nov 2024</td>
                    <td class="px-4 py-3 text-body text-gray-900">Abonnement Premium</td>
                    <td class="px-4 py-3 text-body text-gray-900">89,00 €</td>
                    <td class="px-4 py-3"><span class="badge-success">Payé</span></td>
                  </tr>
                  <tr class="hover:bg-light-300 transition-colors">
                    <td class="px-4 py-3 text-body text-gray-900">15 Oct 2024</td>
                    <td class="px-4 py-3 text-body text-gray-900">Abonnement Premium</td>
                    <td class="px-4 py-3 text-body text-gray-900">89,00 €</td>
                    <td class="px-4 py-3"><span class="badge-success">Payé</span></td>
                  </tr>
                  <tr class="bg-light-300 hover:bg-gray-200 transition-colors">
                    <td class="px-4 py-3 text-body text-gray-900">15 Sep 2024</td>
                    <td class="px-4 py-3 text-body text-gray-900">Abonnement Premium</td>
                    <td class="px-4 py-3 text-body text-gray-900">89,00 €</td>
                    <td class="px-4 py-3"><span class="badge-success">Payé</span></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
          <!-- Plans Disponibles -->
          <div class="card">
            <h3 class="text-h3 text-dark-800 mb-4">Autres Plans</h3>
            
            <div class="space-y-4">
              <div class="border border-gray-200 rounded-lg p-4 hover:border-brand-300 transition-colors">
                <div class="flex items-center justify-between mb-2">
                  <h4 class="font-label font-semibold text-gray-800">Starter</h4>
                  <div class="text-lg font-bold text-gray-800">29€</div>
                </div>
                <div class="text-small text-gray-600 mb-3">/ mois</div>
                <div class="text-small text-gray-600 mb-3">POS de base, 1 restaurant</div>
                <button class="btn-outline w-full text-small">Dégradé</button>
              </div>
              
              <div class="border-2 border-brand-500 rounded-lg p-4 bg-brand-50">
                <div class="flex items-center justify-between mb-2">
                  <h4 class="font-label font-semibold text-gray-800">Premium</h4>
                  <div class="text-lg font-bold text-brand-600">89€</div>
                </div>
                <div class="text-small text-gray-600 mb-3">/ mois</div>
                <div class="text-small text-gray-600 mb-3">Tout inclus, support prioritaire</div>
                <div class="badge-success text-xs mb-3">Plan actuel</div>
                <button class="btn-disabled w-full text-small" disabled>Actuel</button>
              </div>
              
              <div class="border border-gray-200 rounded-lg p-4 hover:border-brand-300 transition-colors">
                <div class="flex items-center justify-between mb-2">
                  <h4 class="font-label font-semibold text-gray-800">Enterprise</h4>
                  <div class="text-lg font-bold text-gray-800">199€</div>
                </div>
                <div class="text-small text-gray-600 mb-3">/ mois</div>
                <div class="text-small text-gray-600 mb-3">Multi-restaurants, API</div>
                <button class="btn-primary w-full text-small">Upgrader</button>
              </div>
            </div>
          </div>

          <!-- Informations de Facturation -->
          <div class="card">
            <h3 class="text-h3 text-dark-800 mb-4">Informations de Facturation</h3>
            
            <div class="space-y-3">
              <div>
                <div class="text-small text-gray-500 mb-1">Méthode de paiement</div>
                <div class="flex items-center gap-2">
                  <div class="w-8 h-5 bg-blue-600 rounded text-white text-xs flex items-center justify-center font-bold">
                    VISA
                  </div>
                  <span class="text-body text-gray-800">•••• •••• •••• 4242</span>
                </div>
              </div>
              
              <div>
                <div class="text-small text-gray-500 mb-1">Email de facturation</div>
                <div class="text-body text-gray-800">admin@restaurant.com</div>
              </div>
              
              <div>
                <div class="text-small text-gray-500 mb-1">Prochaine facture</div>
                <div class="text-body text-gray-800">89,00 € le 15 Jan 2025</div>
              </div>
              
              <button class="btn-outline w-full text-small">Modifier</button>
            </div>
          </div>

          <!-- Support -->
          <div class="card">
            <h3 class="text-h3 text-dark-800 mb-4">Besoin d'aide ?</h3>
            
            <div class="space-y-3">
              <button class="w-full text-left p-3 border border-gray-200 rounded-lg hover:border-brand-300 hover:bg-brand-50 transition-colors">
                <div class="font-label font-medium text-gray-800">Questions sur la facturation</div>
                <div class="text-small text-gray-600">FAQ et support</div>
              </button>
              
              <button class="w-full text-left p-3 border border-gray-200 rounded-lg hover:border-brand-300 hover:bg-brand-50 transition-colors">
                <div class="font-label font-medium text-gray-800">Changer de plan</div>
                <div class="text-small text-gray-600">Guide d'upgrade</div>
              </button>
              
              <button class="w-full text-left p-3 border border-gray-200 rounded-lg hover:border-brand-300 hover:bg-brand-50 transition-colors">
                <div class="font-label font-medium text-gray-800">Contacter le support</div>
                <div class="text-small text-gray-600">Assistance personnalisée</div>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
// État des données
const currentPlan = {
  name: 'Premium',
  price: 89,
  currency: '€',
  period: 'mois',
  nextRenewal: '15 Janvier 2025',
  daysLeft: 23
}

const paymentHistory = [
  {
    date: '15 Déc 2024',
    description: 'Abonnement Premium',
    amount: '89,00 €',
    status: 'Payé'
  },
  {
    date: '15 Nov 2024',
    description: 'Abonnement Premium',
    amount: '89,00 €',
    status: 'Payé'
  },
  {
    date: '15 Oct 2024',
    description: 'Abonnement Premium',
    amount: '89,00 €',
    status: 'Payé'
  },
  {
    date: '15 Sep 2024',
    description: 'Abonnement Premium',
    amount: '89,00 €',
    status: 'Payé'
  }
]

const availablePlans = [
  {
    name: 'Starter',
    price: 29,
    description: 'POS de base, 1 restaurant',
    action: 'Dégradé'
  },
  {
    name: 'Premium',
    price: 89,
    description: 'Tout inclus, support prioritaire',
    action: 'Actuel',
    current: true
  },
  {
    name: 'Enterprise',
    price: 199,
    description: 'Multi-restaurants, API',
    action: 'Upgrader'
  }
]

// Méthodes
const downloadInvoice = () => {
  // Logique de téléchargement
  console.log('Téléchargement de la facture...')
}

const changePlan = (planName) => {
  // Logique de changement de plan
  console.log(`Changement vers le plan ${planName}`)
}

const cancelSubscription = () => {
  // Logique d'annulation
  console.log('Annulation de l\'abonnement...')
}
</script>

<style scoped>
/* Styles spécifiques à la page si nécessaire */
</style>
