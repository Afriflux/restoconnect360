<template>
  <div class="p-8 bg-gray-50 min-h-screen">
    <div class="max-w-6xl mx-auto">
      <h1 class="text-3xl font-bold text-gray-900 mb-8">🎨 Boutons Modernes - RestoConnect360</h1>
      
      <!-- Section Boutons Principaux -->
      <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
        <h2 class="text-2xl font-semibold text-gray-900 mb-6">Boutons Principaux</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div class="space-y-4">
            <h3 class="text-lg font-medium text-gray-700">Primary</h3>
            <div class="space-y-3">
              <ModernButton variant="primary" size="sm" icon="plus">Petit</ModernButton>
              <ModernButton variant="primary" size="md" icon="plus">Moyen</ModernButton>
              <ModernButton variant="primary" size="lg" icon="plus">Grand</ModernButton>
            </div>
          </div>
          
          <div class="space-y-4">
            <h3 class="text-lg font-medium text-gray-700">Secondary</h3>
            <div class="space-y-3">
              <ModernButton variant="secondary" size="sm" icon="sync">Petit</ModernButton>
              <ModernButton variant="secondary" size="md" icon="sync">Moyen</ModernButton>
              <ModernButton variant="secondary" size="lg" icon="sync">Grand</ModernButton>
            </div>
          </div>
          
          <div class="space-y-4">
            <h3 class="text-lg font-medium text-gray-700">Success</h3>
            <div class="space-y-3">
              <ModernButton variant="success" size="sm" icon="check">Petit</ModernButton>
              <ModernButton variant="success" size="md" icon="check">Moyen</ModernButton>
              <ModernButton variant="success" size="lg" icon="check">Grand</ModernButton>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Section Boutons d'Action -->
      <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
        <h2 class="text-2xl font-semibold text-gray-900 mb-6">Boutons d'Action</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <div class="space-y-4">
            <h3 class="text-lg font-medium text-gray-700">Édition</h3>
            <div class="space-y-3">
              <ModernButton variant="success" size="sm" icon="edit">Modifier</ModernButton>
              <ModernButton variant="success" size="md" icon="edit">Éditer</ModernButton>
            </div>
          </div>
          
          <div class="space-y-4">
            <h3 class="text-lg font-medium text-gray-700">Visualisation</h3>
            <div class="space-y-3">
              <ModernButton variant="info" size="sm" icon="view">Voir</ModernButton>
              <ModernButton variant="info" size="md" icon="view">Détails</ModernButton>
            </div>
          </div>
          
          <div class="space-y-4">
            <h3 class="text-lg font-medium text-gray-700">Configuration</h3>
            <div class="space-y-3">
              <ModernButton variant="warning" size="sm" icon="config">Config</ModernButton>
              <ModernButton variant="warning" size="md" icon="config">Paramètres</ModernButton>
            </div>
          </div>
          
          <div class="space-y-4">
            <h3 class="text-lg font-medium text-gray-700">Suppression</h3>
            <div class="space-y-3">
              <ModernButton variant="danger" size="sm" icon="delete">Supprimer</ModernButton>
              <ModernButton variant="danger" size="md" icon="delete">Effacer</ModernButton>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Section Boutons avec États -->
      <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
        <h2 class="text-2xl font-semibold text-gray-900 mb-6">États des Boutons</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div class="space-y-4">
            <h3 class="text-lg font-medium text-gray-700">Normal</h3>
            <div class="space-y-3">
              <ModernButton variant="primary" icon="save">Sauvegarder</ModernButton>
              <ModernButton variant="secondary" icon="sync">Synchroniser</ModernButton>
              <ModernButton variant="success" icon="check">Valider</ModernButton>
            </div>
          </div>
          
          <div class="space-y-4">
            <h3 class="text-lg font-medium text-gray-700">Désactivé</h3>
            <div class="space-y-3">
              <ModernButton variant="primary" icon="save" disabled>Sauvegarder</ModernButton>
              <ModernButton variant="secondary" icon="sync" disabled>Synchroniser</ModernButton>
              <ModernButton variant="success" icon="check" disabled>Valider</ModernButton>
            </div>
          </div>
          
          <div class="space-y-4">
            <h3 class="text-lg font-medium text-gray-700">Sans Icône</h3>
            <div class="space-y-3">
              <ModernButton variant="primary">Sauvegarder</ModernButton>
              <ModernButton variant="secondary">Synchroniser</ModernButton>
              <ModernButton variant="success">Valider</ModernButton>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Section Notifications -->
      <div class="bg-white rounded-2xl shadow-lg p-8">
        <h2 class="text-2xl font-semibold text-gray-900 mb-6">Notifications</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="space-y-4">
            <h3 class="text-lg font-medium text-gray-700">Types de Notifications</h3>
            <div class="space-y-3">
              <ModernButton @click="showSuccess" variant="success" icon="check">Succès</ModernButton>
              <ModernButton @click="showError" variant="danger" icon="delete">Erreur</ModernButton>
              <ModernButton @click="showWarning" variant="warning" icon="config">Avertissement</ModernButton>
              <ModernButton @click="showInfo" variant="info" icon="view">Information</ModernButton>
            </div>
          </div>
          
          <div class="space-y-4">
            <h3 class="text-lg font-medium text-gray-700">Actions Rapides</h3>
            <div class="space-y-3">
              <ModernButton @click="showAllNotifications" variant="primary" icon="plus">Toutes les Notifications</ModernButton>
              <ModernButton @click="clearAll" variant="secondary" icon="sync">Effacer Tout</ModernButton>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Notification Manager -->
    <NotificationManager />
  </div>
</template>

<script setup>
import ModernButton from '@/components/ui/ModernButton.vue';
import NotificationManager from '@/components/ui/NotificationManager.vue';

const showSuccess = () => {
  window.notify?.success('Opération réussie !', 'Votre action a été effectuée avec succès.');
};

const showError = () => {
  window.notify?.error('Erreur !', 'Une erreur s\'est produite lors de l\'opération.');
};

const showWarning = () => {
  window.notify?.warning('Attention !', 'Veuillez vérifier vos informations avant de continuer.');
};

const showInfo = () => {
  window.notify?.info('Information', 'Voici une information importante pour vous.');
};

const showAllNotifications = () => {
  showSuccess();
  setTimeout(() => showError(), 500);
  setTimeout(() => showWarning(), 1000);
  setTimeout(() => showInfo(), 1500);
};

const clearAll = () => {
  // Cette fonctionnalité pourrait être ajoutée au NotificationManager
  console.log('Effacer toutes les notifications');
};
</script>
