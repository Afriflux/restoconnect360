<template>
  <div class="space-y-6">
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-xl p-6 text-white">
      <h1 class="text-3xl font-bold mb-2">🎯 Dashboard Agent Commercial</h1>
      <p class="text-purple-100">Gérez vos prospects et clients</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-600">
        <div class="flex items-center justify-between mb-2">
          <div class="text-sm text-gray-600 font-medium">Ventes ce Mois</div>
          <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
        </div>
        <div class="text-3xl font-bold text-gray-900">{{ stats.monthlySales }}</div>
        <div class="text-sm text-green-600 mt-1">{{ stats.salesTarget }}% de l'objectif</div>
      </div>

      <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-600">
        <div class="flex items-center justify-between mb-2">
          <div class="text-sm text-gray-600 font-medium">Prospects Actifs</div>
          <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
          </div>
        </div>
        <div class="text-3xl font-bold text-gray-900">{{ stats.activeProspects }}</div>
        <div class="text-sm text-blue-600 mt-1">{{ stats.newProspects }} nouveaux cette semaine</div>
      </div>

      <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-600">
        <div class="flex items-center justify-between mb-2">
          <div class="text-sm text-gray-600 font-medium">Commission ce Mois</div>
          <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
        </div>
        <div class="text-3xl font-bold text-gray-900">{{ formatCurrency(stats.monthlyCommission) }}</div>
        <div class="text-sm text-purple-600 mt-1">+{{ stats.commissionGrowth }}% vs mois dernier</div>
      </div>

      <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-600">
        <div class="flex items-center justify-between mb-2">
          <div class="text-sm text-gray-600 font-medium">Taux de Conversion</div>
          <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
            </svg>
          </div>
        </div>
        <div class="text-3xl font-bold text-gray-900">{{ stats.conversionRate }}%</div>
        <div class="text-sm text-yellow-600 mt-1">Sur {{ stats.totalLeads }} leads</div>
      </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Leads Pipeline -->
      <div class="lg:col-span-2 bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center justify-between mb-6">
          <h2 class="text-xl font-bold flex items-center">
            <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
            Pipeline de Ventes
          </h2>
          <button class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition text-sm font-semibold">
            + Nouveau Lead
          </button>
        </div>

        <div class="space-y-3">
          <div v-for="lead in leads" :key="lead.id" class="border-2 rounded-lg p-4 hover:border-purple-600 transition" :class="getLeadBorderClass(lead.status)">
            <div class="flex items-start justify-between mb-3">
              <div class="flex items-start space-x-3">
                <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-full flex items-center justify-center flex-shrink-0">
                  <span class="text-white text-lg font-bold">{{ lead.initials }}</span>
                </div>
                <div>
                  <h3 class="font-bold text-gray-900">{{ lead.name }}</h3>
                  <div class="text-sm text-gray-600">{{ lead.company }}</div>
                  <div class="flex items-center space-x-2 mt-1">
                    <span class="px-2 py-1 text-xs font-semibold rounded-full" :class="getStatusClass(lead.status)">
                      {{ lead.statusLabel }}
                    </span>
                    <span class="text-xs text-gray-500">{{ lead.lastContact }}</span>
                  </div>
                </div>
              </div>
              <div class="text-right">
                <div class="text-xl font-bold text-purple-600">{{ formatCurrency(lead.potentialValue) }}</div>
                <div class="text-xs text-gray-500">Valeur potentielle</div>
              </div>
            </div>

            <div class="flex items-center space-x-2 text-sm text-gray-600 mb-3">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
              </svg>
              <span>{{ lead.phone }}</span>
              <span class="text-gray-400">•</span>
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
              </svg>
              <span>{{ lead.email }}</span>
            </div>

            <div class="flex space-x-2">
              <button 
                @click="callLead(lead)"
                class="flex-1 px-3 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-semibold flex items-center justify-center"
              >
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                Appeler
              </button>
              <button 
                @click="emailLead(lead)"
                class="flex-1 px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-semibold flex items-center justify-center"
              >
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Email
              </button>
              <button 
                @click="updateLead(lead)"
                class="px-3 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition text-sm font-semibold"
              >
                Mettre à jour
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Sidebar -->
      <div class="space-y-6">
        <!-- Today's Tasks -->
        <div class="bg-white rounded-xl shadow-md p-6">
          <h2 class="text-lg font-bold mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
            Tâches du Jour
          </h2>
          <div class="space-y-2">
            <div v-for="task in todayTasks" :key="task.id" class="flex items-start space-x-2 p-2 hover:bg-gray-50 rounded-lg">
              <input type="checkbox" :checked="task.completed" class="mt-1">
              <div class="flex-1">
                <div class="text-sm font-medium" :class="task.completed ? 'line-through text-gray-400' : 'text-gray-900'">
                  {{ task.title }}
                </div>
                <div class="text-xs text-gray-500">{{ task.time }}</div>
              </div>
            </div>
          </div>
          <button class="w-full mt-3 px-4 py-2 bg-purple-50 text-purple-700 rounded-lg hover:bg-purple-100 transition text-sm font-semibold">
            + Ajouter une tâche
          </button>
        </div>

        <!-- Performance This Month -->
        <div class="bg-white rounded-xl shadow-md p-6">
          <h2 class="text-lg font-bold mb-4">Performance</h2>
          <div class="space-y-4">
            <div>
              <div class="flex justify-between text-sm mb-1">
                <span class="text-gray-600">Objectif mensuel</span>
                <span class="font-semibold text-gray-900">{{ stats.salesTarget }}%</span>
              </div>
              <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-green-600 h-2 rounded-full" :style="{ width: stats.salesTarget + '%' }"></div>
              </div>
            </div>
            <div>
              <div class="flex justify-between text-sm mb-1">
                <span class="text-gray-600">Conversion</span>
                <span class="font-semibold text-gray-900">{{ stats.conversionRate }}%</span>
              </div>
              <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-blue-600 h-2 rounded-full" :style="{ width: stats.conversionRate + '%' }"></div>
              </div>
            </div>
          </div>
        </div>

        <!-- Quick Stats -->
        <div class="bg-gradient-to-br from-purple-600 to-indigo-600 rounded-xl shadow-md p-6 text-white">
          <h2 class="text-lg font-bold mb-4">🏆 Classement</h2>
          <div class="space-y-3">
            <div class="flex justify-between items-center">
              <span class="text-sm text-purple-100">Votre position</span>
              <span class="text-2xl font-bold">#{{ stats.ranking }}</span>
            </div>
            <div class="flex justify-between items-center">
              <span class="text-sm text-purple-100">Meilleur vendeur</span>
              <span class="text-sm font-semibold">{{ stats.topSeller }}</span>
            </div>
            <div class="pt-3 border-t border-purple-400">
              <div class="text-sm text-purple-100 mb-1">Bonus potentiel</div>
              <div class="text-2xl font-bold">{{ formatCurrency(stats.potentialBonus) }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { formatCurrency } from '../../utils/currency';

const stats = ref({
  monthlySales: 0,
  salesTarget: 0,
  activeProspects: 0,
  newProspects: 0,
  monthlyCommission: 0,
  commissionGrowth: 0,
  conversionRate: 0,
  totalLeads: 0,
  ranking: 0,
  topSeller: '',
  potentialBonus: 0,
});

const leads = ref([]);
const todayTasks = ref([]);

const getStatusClass = (status) => {
  const classes = {
    'new': 'bg-blue-100 text-blue-800',
    'contacted': 'bg-yellow-100 text-yellow-800',
    'qualified': 'bg-purple-100 text-purple-800',
    'proposal': 'bg-orange-100 text-orange-800',
    'negotiation': 'bg-indigo-100 text-indigo-800',
    'won': 'bg-green-100 text-green-800',
    'lost': 'bg-red-100 text-red-800',
  };
  return classes[status] || 'bg-gray-100 text-gray-800';
};

const getLeadBorderClass = (status) => {
  const classes = {
    'new': 'border-blue-200',
    'contacted': 'border-yellow-200',
    'qualified': 'border-purple-200',
    'proposal': 'border-orange-200',
    'negotiation': 'border-indigo-200',
    'won': 'border-green-200',
    'lost': 'border-red-200',
  };
  return classes[status] || 'border-gray-200';
};

const callLead = (lead) => {
  console.log('Calling:', lead);
  window.location.href = `tel:${lead.phone}`;
};

const emailLead = (lead) => {
  console.log('Emailing:', lead);
  window.location.href = `mailto:${lead.email}`;
};

const updateLead = (lead) => {
  console.log('Updating:', lead);
};

const loadStats = async () => {
  stats.value = {
    monthlySales: 12,
    salesTarget: 75,
    activeProspects: 34,
    newProspects: 8,
    monthlyCommission: 1850000,
    commissionGrowth: 18.5,
    conversionRate: 35,
    totalLeads: 89,
    ranking: 3,
    topSeller: 'Amadou Seck',
    potentialBonus: 500000,
  };
};

const loadLeads = async () => {
  leads.value = [
    {
      id: 1,
      name: 'Moussa Diop',
      initials: 'MD',
      company: 'Restaurant Le Délice',
      phone: '+221 77 123 45 67',
      email: 'moussa@ledelice.sn',
      status: 'qualified',
      statusLabel: 'Qualifié',
      potentialValue: 2500000,
      lastContact: 'Il y a 2 jours',
    },
    {
      id: 2,
      name: 'Fatou Ndiaye',
      initials: 'FN',
      company: 'Café Teranga',
      phone: '+221 78 234 56 78',
      email: 'fatou@teranga.sn',
      status: 'proposal',
      statusLabel: 'Proposition envoyée',
      potentialValue: 1800000,
      lastContact: 'Il y a 1 jour',
    },
    {
      id: 3,
      name: 'Omar Seck',
      initials: 'OS',
      company: 'Fast Food Paradise',
      phone: '+221 76 345 67 89',
      email: 'omar@paradise.sn',
      status: 'negotiation',
      statusLabel: 'Négociation',
      potentialValue: 3200000,
      lastContact: 'Il y a 3 heures',
    },
  ];
};

const loadTasks = async () => {
  todayTasks.value = [
    { id: 1, title: 'Appeler Moussa Diop', time: '10:00', completed: false },
    { id: 2, title: 'Envoyer proposition à Fatou', time: '11:30', completed: false },
    { id: 3, title: 'Rendez-vous avec Omar', time: '14:00', completed: false },
    { id: 4, title: 'Suivre dossier ABC Restaurant', time: '16:00', completed: true },
  ];
};

onMounted(() => {
  loadStats();
  loadLeads();
  loadTasks();
});
</script>

