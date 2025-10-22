# Guide des Dashboards - RestoConnect360

## 📊 Vue d'ensemble

Ce document décrit tous les dashboards disponibles dans RestoConnect360, organisés par rôle utilisateur.

---

## 🎯 Dashboards par Rôle

### 1. 👑 Super Admin Dashboard
**Route:** `/admin/super-admin`  
**Rôles autorisés:** `super_admin`  
**Fichier:** `resources/js/pages/admin/SuperAdminDashboard.vue`

#### Fonctionnalités
- **Stats Globales Plateforme**
  - Total entreprises inscrites
  - Total commerces actifs
  - Total utilisateurs
  - Revenus mensuels de la plateforme
  
- **Activités Récentes**
  - Nouvelles inscriptions
  - Paiements reçus
  - Upgrades de comptes
  - Activations de modules
  
- **État du Système**
  - Statut serveurs API
  - Statut base de données
  - Statut passerelles de paiement
  - Statut SMS Gateway
  
- **Vue d'ensemble Abonnements**
  - Répartition par plan (Starter, Pro, Enterprise)

---

### 2. 🏢 Admin Dashboard
**Route:** `/admin/dashboard`  
**Rôles autorisés:** `admin`, `super_admin`  
**Fichier:** `resources/js/pages/admin/AdminDashboard.vue`

#### Fonctionnalités
- **Gestion Multi-Commerces**
  - Vue d'ensemble de tous les commerces
  - Stats par commerce (commandes, revenus, notes)
  - Statut ouvert/fermé en temps réel
  
- **Stats Globales Entreprise**
  - Total commerces
  - Commandes du jour
  - Revenus du jour
  - Équipe active
  
- **Actions Rapides**
  - Ajouter nouveau commerce
  - Créer nouvelle commande
  - Gérer l'équipe
  - Voir rapports
  
- **Notifications**
  - Alertes en temps réel

---

### 3. 🏪 Restaurant Manager Dashboard
**Route:** `/admin/restaurant`  
**Rôles autorisés:** `restaurant_manager`, `admin`, `super_admin`  
**Fichier:** `resources/js/pages/admin/RestaurantManagerDashboard.vue`

#### Fonctionnalités
- **Gestion Commandes en Cours**
  - Visualisation en temps réel
  - Changement de statut (En attente → Préparation → Prêt → Livré)
  - Détails complets des commandes
  
- **Stats Restaurant**
  - Commandes du jour
  - Revenus du jour
  - Tables actives
  - Note moyenne et avis
  
- **Plats Populaires**
  - Top des ventes
  - Stats par plat
  
- **Équipe en Service**
  - Membres actifs
  - Statut en ligne
  
- **Actions Rapides**
  - Accès direct au POS
  - Gestion des tables
  - Ajout de plats
  - Consultation des stats

---

### 4. 🎯 Agent Commercial Dashboard
**Route:** `/admin/agent`  
**Rôles autorisés:** `agent`, `admin`, `super_admin`  
**Fichier:** `resources/js/pages/admin/AgentDashboard.vue`

#### Fonctionnalités
- **Pipeline de Ventes (CRM)**
  - Gestion des leads/prospects
  - Statuts : Nouveau → Contacté → Qualifié → Proposition → Négociation → Gagné/Perdu
  - Valeur potentielle par lead
  - Actions rapides (Appel, Email)
  
- **Performance Agent**
  - Ventes du mois
  - Objectifs et progression
  - Commission du mois
  - Taux de conversion
  
- **Tâches du Jour**
  - To-do list intégrée
  - Rappels et suivis
  
- **Classement & Bonus**
  - Position dans l'équipe
  - Meilleur vendeur
  - Bonus potentiel

---

### 5. 🚗 Driver Dashboard (Amélioré)
**Route:** `/driver`  
**Rôles autorisés:** `driver`, `admin`  
**Fichier:** `resources/js/pages/driver/DriverDashboard.vue`

#### Améliorations
- **Header Modernisé**
  - Design cohérent avec les autres dashboards
  - Gradient vert/émeraude
  
- **Stats Cartes Améliorées**
  - Icônes colorées
  - Bordures colorées par catégorie
  - Design plus moderne avec rounded-xl
  
- **Stats Enrichies**
  - Livraisons du jour
  - Gains du jour
  - Distance parcourue
  - Note moyenne + nombre d'avis
  
- **Fonctionnalités Existantes Conservées**
  - Livraisons disponibles
  - Livraisons en cours
  - Auto-refresh toutes les 30 secondes
  - Navigation GPS intégrée

---

## 🎨 Layout AdminLayout

**Fichier:** `resources/js/layouts/AdminLayout.vue`

### Caractéristiques
- **Top Navigation Bar**
  - Logo RestoConnect360
  - Indicateur de rôle
  - Notifications
  - Menu utilisateur (Profil, Paramètres, Déconnexion)
  
- **Sidebar Navigation**
  - Navigation adaptée au rôle
  - Slot personnalisable
  
- **Responsive Design**
  - Adapté mobile, tablette, desktop

---

## 🛣️ Routes Configurées

```javascript
// Super Admin
/admin/super-admin → SuperAdminDashboard

// Admin
/admin/dashboard → AdminDashboard

// Restaurant Manager
/admin/restaurant → RestaurantManagerDashboard

// Agent Commercial
/admin/agent → AgentDashboard

// Livreur
/driver → DriverDashboard
/driver/deliveries → DriverDeliveries
/driver/tracking/:id → DriverTracking
```

---

## 🔐 Permissions & Rôles

### Hiérarchie des Rôles
1. **super_admin** - Accès complet plateforme
2. **admin** - Gestion entreprise/commerces
3. **restaurant_manager** - Gestion restaurant spécifique
4. **agent** - Commercial/Support
5. **employee** - Employé restaurant
6. **driver** - Livreur
7. **customer** - Client

### Guards de Navigation
- Authentification requise pour tous les dashboards
- Vérification du rôle avant accès
- Redirection automatique vers login si non authentifié
- Redirection vers home si rôle insuffisant

---

## 🎨 Design System

### Couleurs par Dashboard
- **Super Admin:** Vert/Émeraude
- **Admin:** Bleu/Indigo
- **Restaurant Manager:** Émeraude/Vert
- **Agent Commercial:** Violet/Indigo
- **Driver:** Vert/Émeraude

### Stats Cards
Chaque card suit le pattern:
- Bordure colorée gauche (4px)
- Icône avec fond coloré
- Titre métrique
- Valeur principale (grande)
- Sous-texte informatif

### Responsive
- Mobile-first design
- Grid adaptatif (1/2/3/4 colonnes selon taille écran)
- Touch-friendly sur mobile

---

## 📱 Utilisation

### Pour Développeur

#### Ajouter un nouveau dashboard
1. Créer le fichier dans `resources/js/pages/admin/`
2. Importer dans `router/index.js`
3. Ajouter la route avec meta `requiresRole`
4. Configurer la sidebar dans `AdminLayout.vue`

#### Personnaliser un dashboard existant
Les dashboards utilisent:
- **ref()** pour les données réactives
- **onMounted()** pour chargement initial
- **formatCurrency()** pour formatage prix
- **Axios** pour appels API

### Pour Utilisateur

Chaque utilisateur est automatiquement redirigé vers son dashboard approprié selon son rôle après connexion.

---

## 🚀 Prochaines Étapes

### Recommandations
1. **Intégration API Backend**
   - Connecter les dashboards aux vraies données
   - Implémenter les endpoints API correspondants
   
2. **WebSockets/Real-time**
   - Mise à jour en temps réel des commandes
   - Notifications push
   
3. **Rapports & Analytics**
   - Graphiques avec Chart.js ou similar
   - Export PDF/Excel
   
4. **Personnalisation**
   - Widgets déplaçables
   - Préférences utilisateur
   
5. **Mobile Apps**
   - Version React Native pour livreurs
   - App dédiée agents commerciaux

---

## 📞 Support

Pour toute question ou amélioration, contactez l'équipe de développement RestoConnect360.

**Version:** 1.0.0  
**Date:** Octobre 2025  
**Auteur:** RestoConnect360 Team

