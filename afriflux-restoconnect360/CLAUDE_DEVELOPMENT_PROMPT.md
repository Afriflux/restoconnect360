# 🚀 **PROMPT DE DÉVELOPPEMENT COMPLET - RESTOCONNECT360**

## 🎯 **OBJECTIF : DÉVELOPPER LA PLATEFORME RESTOCONNECT360 EN UNE SEULE FOIS**

---

## 📋 **CONTEXTE DU PROJET**

**Nom du Projet :** RestoConnect360 - Restaurant SaaS Platform
**Domaine de Production :** https://www.restoconnect360.com/
**Environnement de Développement :** ~/restoconnect360-development/restoconnect360/
**Stack Technique :** Laravel 11 + Vue.js 3 + MySQL 8.0 + Redis + PWA

---

## 🎯 **FONCTIONNALITÉS COMPLÈTES À DÉVELOPPER**

### **1. PLATEFORME MULTI-SAAS**
- **Administration Centrale**
  - Dashboard administration globale
  - Gestion des sociétés (restaurants, cafés, bars, services de livraison)
  - Gestion des utilisateurs multi-niveaux (Admin, Gestionnaire, Employé, Livreur)
  - Permissions granulaires basées sur les rôles
  - Configuration des plans tarifaires (Starter, Professional, Enterprise)
  - Rapports et analytics globaux

- **Gestion des Sociétés**
  - Dashboard entreprise
  - Gestion des établissements
  - Gestion du personnel
  - Configuration des services
  - Rapports par société

- **Gestion des Établissements**
  - Dashboard restaurant/café/bar
  - Configuration personnalisée
  - Gestion du menu et des produits
  - Gestion des tables et zones
  - Configuration des horaires
  - Thèmes personnalisables (15+ thèmes)

### **2. SYSTÈME DE PAIEMENTS AFRICAINS**
- **CinetPay Integration**
  - Wave (Sénégal)
  - Orange Money (multi-pays)
  - MTN Money (multi-pays)
  - Moov Money (multi-pays)
  - Visa/Mastercard
  - Configuration sandbox/production
  - Webhooks pour notifications
  - Logs des transactions

- **PayTech Integration**
  - YAS (Côte d'Ivoire)
  - Orange Money CI
  - MTN Money CI
  - Moov Money CI
  - Configuration sandbox/production
  - Webhooks pour notifications
  - Logs des transactions

- **Paiements Internationaux**
  - Stripe (cartes internationales)
  - PayPal (paiements internationaux)
  - Paiement à la livraison (Cash on Delivery)

- **Gestion des Transactions**
  - Historique complet des transactions
  - Réconciliation automatique
  - Gestion des remboursements
  - Rapports financiers détaillés
  - Export des données (CSV, PDF)

### **3. SYSTÈME DE COMMANDES**

#### **A. POS (Point de Vente) - ADAPTÉ À TOUS LES SUPPORTS**
- **Interface Tactile Optimisée**
  - Responsive design (mobile, tablette, ordinateur, moniteur, TV)
  - Support tactile complet
  - Mode portrait et paysage
  - Interface adaptée aux TPE et terminaux de paiement
  - Raccourcis clavier pour ordinateurs
  - Optimisation pour grands écrans (moniteurs, TV)

- **Fonctionnalités POS**
  - Prise de commande rapide
  - Gestion des tables et zones
  - Calcul automatique des taxes
  - Gestion des remises et coupons
  - Split de facture
  - Impression des tickets
  - Mode hors-ligne (PWA)
  - Synchronisation automatique

#### **B. KIOSQUE CLIENT - ADAPTÉ À TOUS LES SUPPORTS**
- **Interface Libre-Service**
  - Responsive design (tablette, moniteur, TV, kiosque dédié)
  - Interface tactile intuitive
  - Menu digital interactif
  - Personnalisation des commandes
  - Paiements intégrés (tous les modes)
  - QR Code pour récupération
  - Support multi-langues

#### **C. WhatsApp Integration**
- **Commandes via WhatsApp**
  - Connexion WhatsApp Business API
  - Envoi automatique du menu
  - Réception des commandes
  - Notifications de statut
  - Configuration des messages automatiques
  - Support multi-comptes

#### **D. QR Code Menu**
- **Menu Digital Interactif**
  - Génération automatique de QR codes par table
  - Menu responsive et interactif
  - Commande directe via smartphone
  - Paiement intégré
  - Notifications en temps réel

### **4. SYSTÈME DE LIVRAISON COMPLET**

#### **A. Gestion des Livreurs**
- **Dashboard Livreur - MOBILE FIRST**
  - Application PWA optimisée mobile
  - Interface smartphone responsive
  - Support tablette pour gestion multiple
  - Inscription et vérification
  - Gestion du statut (disponible/occupé/hors-ligne)
  - Historique des livraisons
  - Revenus et statistiques
  - Évaluation et avis

#### **B. Géolocalisation et Tracking**
- **GEOSENSING ET POSITION GÉOGRAPHIQUE**
  - Géolocalisation en temps réel (Google Maps API)
  - Tracking GPS des livreurs
  - Calcul automatique des distances
  - Optimisation des itinéraires
  - Temps estimé de livraison (ETA)
  - Notifications de proximité
  - Historique des trajets
  - Zones de livraison configurables
  - Rayon de livraison paramétrable

#### **C. Recherche par Géolocalisation - FONCTION "TROUVER UN MAGASIN"**
- **Recherche Géolocalisée**
  - Détection automatique de la position de l'utilisateur
  - Recherche des restaurants à proximité
  - Affichage sur carte interactive (comme VTC)
  - Calcul de la distance en temps réel
  - Filtres par type (restaurant, café, bar)
  - Filtres par cuisine/spécialité
  - Filtres par services (livraison, sur place, à emporter)
  - Temps de livraison estimé
  - Notation et avis
  - Horaires d'ouverture en temps réel

- **Interface Map Style VTC**
  - Carte interactive avec marqueurs
  - Clustering pour zones denses
  - Info-bulles au survol
  - Itinéraire vers le restaurant
  - Vue street view
  - Mode satellite/plan
  - Recherche par adresse ou coordonnées GPS

#### **D. Workflow de Livraison**
- **Gestion Complète**
  - Assignation automatique/manuelle des livreurs
  - Notifications push en temps réel
  - Suivi de commande client
  - Gestion des zones et tarifs
  - Calcul automatique des frais de livraison
  - Optimisation des tournées
  - Gestion des litiges

### **5. PWA MOBILE - MOBILE FIRST & MOBILE FRIENDLY**

#### **A. Application Progressive Web App**
- **Optimisation Mobile**
  - Mobile-first design (priorité absolue aux mobiles)
  - Responsive design adaptatif
  - Touch-friendly interfaces
  - Gestures support (swipe, pinch, etc.)
  - Performance optimisée pour mobiles
  - Chargement ultra-rapide
  - Images optimisées (WebP, lazy loading)
  - Cache intelligent

- **Fonctionnalités PWA**
  - Installation sur écran d'accueil
  - Mode hors-ligne complet
  - Notifications push
  - Synchronisation en arrière-plan
  - Mise à jour automatique
  - Cache des données essentielles
  - Support offline-first

#### **B. Support Multi-Appareils - ADAPTABILITÉ TOTALE**
- **Smartphones (iOS & Android)**
  - Interface optimisée écrans 4"-7"
  - Touch navigation
  - Mode portrait prioritaire
  - Gestures natifs
  - Caméra pour QR codes
  - Géolocalisation native

- **Tablettes (iPad, Android Tablets)**
  - Interface optimisée écrans 7"-13"
  - Mode portrait et paysage
  - Split-screen support
  - Multi-touch pour POS
  - Interface adaptée aux kiosques

- **Ordinateurs (Desktop & Laptop)**
  - Interface optimisée écrans 13"-27"
  - Navigation clavier + souris
  - Raccourcis clavier
  - Multi-fenêtres
  - Interface administrative complète

- **Moniteurs et TV (32"+ écrans)**
  - Interface optimisée grands écrans
  - Affichage menu digital
  - Kiosque interactif
  - Dashboard temps réel
  - Tableaux de bord multiples

- **POS Dédiés (Terminaux de Vente)**
  - Interface optimisée terminaux POS
  - Support imprimantes tickets
  - Support scanners codes-barres
  - Support tiroirs-caisses
  - Mode caisse rapide

- **Kiosques (Bornes Interactives)**
  - Interface plein écran
  - Mode kiosque sécurisé
  - Touch screen optimisé
  - Timeout automatique
  - Nettoyage session auto

- **TPE (Terminaux de Paiement Électronique)**
  - Interface adaptée petits écrans
  - Navigation simplifiée
  - Paiement rapide
  - Impression tickets
  - Mode standalone

### **6. GESTION DU PERSONNEL MULTI-NIVEAUX**

#### **A. Administrateur Plateforme**
- Gestion globale des sociétés
- Configuration des paiements
- Gestion des utilisateurs
- Rapports et analytics globaux
- Support technique
- Configuration système

#### **B. Gestionnaire Société**
- Gestion des établissements
- Gestion du personnel
- Configuration des services
- Rapports entreprise
- Gestion des abonnements

#### **C. Gestionnaire Établissement**
- Gestion des tables
- Gestion des commandes
- Gestion du personnel local
- Rapports établissement
- Configuration menu

#### **D. Employé**
- Prise de commandes (POS)
- Gestion des tables
- Service client
- Rapports individuels

#### **E. Livreur**
- Application mobile dédiée
- Gestion des livraisons
- Géolocalisation
- Notifications
- Historique et revenus

### **7. FONCTIONNALITÉS AVANCÉES**

#### **A. Multi-Langues**
- Français (par défaut)
- Anglais
- Arabe
- Wolof (Sénégal)
- Interface de traduction
- RTL support

#### **B. Analytics et Rapports**
- Google Analytics integration
- Rapports de ventes
- Rapports de performance
- Rapports financiers
- Export des données
- Tableaux de bord personnalisables

#### **C. Programme de Fidélité**
- Points de fidélité
- Récompenses
- Coupons et promotions
- Notifications personnalisées
- Historique des achats

#### **D. Notifications**
- Push notifications (PWA)
- SMS (Twilio)
- Email (SendGrid)
- WhatsApp notifications
- Notifications en temps réel

---

## 🏗️ **ARCHITECTURE TECHNIQUE DÉTAILLÉE**

### **Backend (Laravel 11)**

#### **Structure des Dossiers**
```
app/
├── Models/
│   ├── Platform/
│   │   ├── Admin.php
│   │   ├── Company.php
│   │   ├── Subscription.php
│   │   └── User.php
│   ├── Restaurant/
│   │   ├── Restaurant.php
│   │   ├── Table.php
│   │   ├── Zone.php
│   │   ├── Menu.php
│   │   ├── Category.php
│   │   ├── Product.php
│   │   └── Order.php
│   ├── Delivery/
│   │   ├── Delivery.php
│   │   ├── Driver.php
│   │   ├── Zone.php
│   │   └── Route.php
│   ├── Payment/
│   │   ├── Payment.php
│   │   ├── Transaction.php
│   │   ├── CinetPay.php
│   │   └── PayTech.php
│   └── Geolocation/
│       ├── Location.php
│       ├── GeoZone.php
│       └── SearchHistory.php
├── Services/
│   ├── WhatsAppService.php
│   ├── CinetPayService.php
│   ├── PayTechService.php
│   ├── DeliveryService.php
│   ├── GeolocationService.php
│   ├── NotificationService.php
│   └── AnalyticsService.php
├── Http/Controllers/
│   ├── Platform/
│   │   ├── AdminController.php
│   │   ├── CompanyController.php
│   │   └── SubscriptionController.php
│   ├── Restaurant/
│   │   ├── RestaurantController.php
│   │   ├── POSController.php
│   │   ├── KioskController.php
│   │   ├── TableController.php
│   │   ├── MenuController.php
│   │   └── OrderController.php
│   ├── Delivery/
│   │   ├── DeliveryController.php
│   │   ├── DriverController.php
│   │   └── TrackingController.php
│   ├── Payment/
│   │   ├── PaymentController.php
│   │   ├── CinetPayController.php
│   │   └── PayTechController.php
│   └── Geolocation/
│       ├── SearchController.php
│       ├── MapController.php
│       └── TrackingController.php
└── Middleware/
    ├── CheckRole.php
    ├── CheckSubscription.php
    ├── CheckDevice.php
    └── CheckGeolocation.php
```

#### **Migrations à Créer**
```sql
-- Platform
- companies
- subscriptions
- users
- roles
- permissions

-- Restaurant
- restaurants
- tables
- zones
- menus
- categories
- products
- orders
- order_items

-- Delivery
- deliveries
- drivers
- delivery_zones
- routes
- tracking_history

-- Payment
- payments
- transactions
- payment_methods
- refunds

-- Geolocation
- locations
- geo_zones
- search_history
- tracking_data

-- Settings
- settings
- themes
- languages
- notifications
```

### **Frontend (Vue.js 3 + PWA)**

#### **Structure des Composants**
```
src/
├── components/
│   ├── Platform/
│   │   ├── AdminDashboard.vue
│   │   ├── CompanyManagement.vue
│   │   └── SubscriptionManagement.vue
│   ├── Restaurant/
│   │   ├── POS/
│   │   │   ├── POSInterface.vue (adapté tous supports)
│   │   │   ├── POSMobile.vue (smartphone)
│   │   │   ├── POSTablet.vue (tablette)
│   │   │   ├── POSDesktop.vue (ordinateur)
│   │   │   ├── POSMonitor.vue (grand écran)
│   │   │   └── POSTerminal.vue (TPE)
│   │   ├── Kiosk/
│   │   │   ├── KioskInterface.vue (adapté tous supports)
│   │   │   ├── KioskMobile.vue
│   │   │   ├── KioskTablet.vue
│   │   │   ├── KioskMonitor.vue
│   │   │   └── KioskTV.vue
│   │   ├── Tables/
│   │   │   ├── TableManagement.vue
│   │   │   └── QRCodeGenerator.vue
│   │   └── Menu/
│   │       ├── MenuManagement.vue
│   │       └── MenuDisplay.vue
│   ├── Delivery/
│   │   ├── DriverApp.vue (mobile-first)
│   │   ├── DeliveryTracking.vue
│   │   ├── RouteOptimizer.vue
│   │   └── GeolocationMap.vue
│   ├── Geolocation/
│   │   ├── StoreLocator.vue (fonction "Trouver un Magasin")
│   │   ├── MapView.vue (style VTC)
│   │   ├── GeosensorTracking.vue
│   │   ├── NearbyRestaurants.vue
│   │   └── RouteCalculator.vue
│   ├── Payment/
│   │   ├── PaymentInterface.vue
│   │   ├── CinetPayCheckout.vue
│   │   ├── PayTechCheckout.vue
│   │   └── TransactionHistory.vue
│   └── Common/
│       ├── ResponsiveLayout.vue
│       ├── DeviceDetector.vue
│       ├── PWAInstaller.vue
│       └── NotificationManager.vue
├── composables/
│   ├── useGeolocation.js
│   ├── useDevice.js
│   ├── useResponsive.js
│   ├── usePayment.js
│   └── useTracking.js
├── stores/
│   ├── platformStore.js
│   ├── restaurantStore.js
│   ├── deliveryStore.js
│   ├── paymentStore.js
│   ├── geolocationStore.js
│   └── deviceStore.js
└── utils/
    ├── deviceDetection.js
    ├── responsiveHelpers.js
    ├── geolocationHelpers.js
    └── mapHelpers.js
```

#### **Responsive Breakpoints**
```css
/* Mobile First Approach */
/* Smartphones */
@media (max-width: 640px) { /* Mobile portrait */ }
@media (max-width: 768px) { /* Mobile landscape */ }

/* Tablets */
@media (min-width: 641px) and (max-width: 1024px) { /* Tablet */ }

/* Ordinateurs */
@media (min-width: 1025px) and (max-width: 1440px) { /* Desktop */ }

/* Grands écrans */
@media (min-width: 1441px) and (max-width: 1920px) { /* Monitor */ }
@media (min-width: 1921px) { /* TV / Large screens */ }

/* POS & Kiosques */
@media (orientation: portrait) { /* POS portrait */ }
@media (orientation: landscape) { /* POS landscape */ }

/* Support tactile */
@media (pointer: coarse) { /* Touch devices */ }
@media (pointer: fine) { /* Mouse devices */ }
```

---

## 🎨 **DESIGN ET UX - MOBILE FIRST**

### **Principes de Design**
- **Mobile First** : Conception pour mobile en priorité
- **Progressive Enhancement** : Enrichissement progressif pour grands écrans
- **Touch-Friendly** : Interfaces tactiles optimisées
- **Responsive** : Adaptation automatique à tous les écrans
- **Accessible** : Conforme WCAG 2.1
- **Performance** : Chargement ultra-rapide

### **Thème Visuel**
- Esthétique douce et futuriste
- Inspiré des univers et galaxies
- Couleurs professionnelles et pures
- Dégradés subtils
- Animations fluides
- Dark mode & Light mode

### **Composants UI**
- Boutons tactiles (min 44x44px)
- Inputs adaptés au touch
- Modals responsives
- Cartes interactives
- Loaders et skeletons
- Toast notifications
- Bottom sheets (mobile)
- Sidebars (desktop)

---

## 🔧 **CONFIGURATION TECHNIQUE**

### **Variables d'Environnement (.env)**
```env
# Application
APP_NAME="RestoConnect360"
APP_ENV=local
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_DATABASE=restoconnect360_development

# CinetPay
CINETPAY_API_KEY=
CINETPAY_SITE_ID=
CINETPAY_ENVIRONMENT=sandbox

# PayTech
PAYTECH_API_KEY=
PAYTECH_MERCHANT_ID=
PAYTECH_ENVIRONMENT=sandbox

# WhatsApp
WHATSAPP_TOKEN=
WHATSAPP_PHONE_NUMBER_ID=

# Google Maps (Geolocation)
GOOGLE_MAPS_API_KEY=

# PWA
PWA_NAME="RestoConnect360"
PWA_SHORT_NAME="RestoConnect360"
PWA_THEME_COLOR="#667eea"
PWA_BACKGROUND_COLOR="#ffffff"
```

### **Packages à Installer**

#### **Backend (Composer)**
```bash
composer require laravel/sanctum
composer require spatie/laravel-permission
composer require geocoder-php/google-maps-provider
composer require twilio/sdk
composer require stripe/stripe-php
composer require guzzlehttp/guzzle
```

#### **Frontend (NPM)**
```bash
npm install vue@next
npm install pinia
npm install @vueuse/core
npm install axios
npm install @googlemaps/js-api-loader
npm install workbox-webpack-plugin
npm install tailwindcss
npm install @headlessui/vue
npm install @heroicons/vue
```

---

## ✅ **CHECKLIST DE DÉVELOPPEMENT**

### **Phase 1 : Configuration de Base**
- [ ] Configuration Laravel 11
- [ ] Configuration Vue.js 3 + Vite
- [ ] Configuration MySQL + Redis
- [ ] Installation des packages
- [ ] Configuration PWA
- [ ] Configuration responsive (mobile-first)
- [ ] Détection automatique des devices

### **Phase 2 : Authentification et Permissions**
- [ ] Système d'authentification multi-niveaux
- [ ] Gestion des rôles (Admin, Gestionnaire, Employé, Livreur)
- [ ] Permissions granulaires
- [ ] API tokens (Sanctum)

### **Phase 3 : Administration Plateforme**
- [ ] Dashboard administration
- [ ] Gestion des sociétés
- [ ] Gestion des utilisateurs
- [ ] Gestion des abonnements
- [ ] Rapports globaux

### **Phase 4 : Restaurant & Menu**
- [ ] Dashboard restaurant
- [ ] Gestion des menus et produits
- [ ] Gestion des catégories
- [ ] Gestion des tables et zones
- [ ] QR Code menu

### **Phase 5 : POS - Adapté Tous Supports**
- [ ] Interface POS mobile (smartphone)
- [ ] Interface POS tablette
- [ ] Interface POS ordinateur
- [ ] Interface POS moniteur/TV
- [ ] Interface POS terminal/TPE
- [ ] Mode hors-ligne PWA
- [ ] Synchronisation automatique
- [ ] Impression tickets

### **Phase 6 : Kiosque - Adapté Tous Supports**
- [ ] Interface kiosque mobile
- [ ] Interface kiosque tablette
- [ ] Interface kiosque moniteur
- [ ] Interface kiosque TV
- [ ] Mode plein écran sécurisé
- [ ] Paiements intégrés
- [ ] Timeout automatique

### **Phase 7 : Paiements Africains**
- [ ] Intégration CinetPay
  - [ ] Wave
  - [ ] Orange Money
  - [ ] MTN Money
  - [ ] Moov Money
- [ ] Intégration PayTech
  - [ ] YAS
  - [ ] Orange Money CI
  - [ ] MTN Money CI
- [ ] Webhooks paiements
- [ ] Logs transactions
- [ ] Gestion remboursements

### **Phase 8 : Géolocalisation - Fonction "Trouver un Magasin"**
- [ ] Détection position utilisateur
- [ ] Recherche restaurants proximité
- [ ] Carte interactive (style VTC)
- [ ] Calcul distances temps réel
- [ ] Filtres recherche avancée
- [ ] Affichage itinéraires
- [ ] Mode satellite/plan
- [ ] Clustering marqueurs
- [ ] Info-bulles interactives

### **Phase 9 : Système de Livraison**
- [ ] Dashboard livreur (mobile-first)
- [ ] Géolocalisation temps réel
- [ ] Tracking GPS
- [ ] Calcul distances automatique
- [ ] Optimisation itinéraires
- [ ] Gestion zones livraison
- [ ] Notifications push
- [ ] Historique livraisons

### **Phase 10 : WhatsApp Integration**
- [ ] Connexion WhatsApp Business API
- [ ] Envoi menu automatique
- [ ] Réception commandes
- [ ] Notifications statut
- [ ] Messages automatiques

### **Phase 11 : PWA - Mobile First**
- [ ] Configuration PWA
- [ ] Manifest.json
- [ ] Service Worker
- [ ] Mode hors-ligne
- [ ] Installation écran d'accueil
- [ ] Notifications push
- [ ] Synchronisation arrière-plan
- [ ] Cache intelligent
- [ ] Optimisation mobile

### **Phase 12 : Responsive - Tous Supports**
- [ ] Design mobile-first
- [ ] Adaptation smartphones (4"-7")
- [ ] Adaptation tablettes (7"-13")
- [ ] Adaptation ordinateurs (13"-27")
- [ ] Adaptation moniteurs/TV (32"+)
- [ ] Adaptation POS dédiés
- [ ] Adaptation kiosques
- [ ] Adaptation TPE
- [ ] Tests tous devices

### **Phase 13 : Multi-Langues**
- [ ] Français (défaut)
- [ ] Anglais
- [ ] Arabe (RTL)
- [ ] Wolof
- [ ] Interface traduction

### **Phase 14 : Analytics et Rapports**
- [ ] Google Analytics
- [ ] Rapports ventes
- [ ] Rapports performance
- [ ] Rapports financiers
- [ ] Export données

### **Phase 15 : Tests et Optimisation**
- [ ] Tests unitaires
- [ ] Tests intégration
- [ ] Tests responsive (tous devices)
- [ ] Tests paiements (sandbox)
- [ ] Tests géolocalisation
- [ ] Tests performance mobile
- [ ] Optimisation images
- [ ] Optimisation cache
- [ ] Tests PWA

### **Phase 16 : Déploiement**
- [ ] Configuration production
- [ ] Migration données
- [ ] Tests production
- [ ] Documentation
- [ ] Formation utilisateurs

---

## 🚀 **PROMPT UNIQUE POUR CLAUDE**

```
Tu es un développeur expert Laravel 11 + Vue.js 3. Tu dois développer RESTOCONNECT360, une plateforme SaaS multi-restaurant complète avec les fonctionnalités suivantes :

1. PLATEFORME MULTI-SAAS avec gestion multi-niveaux (Admin, Société, Restaurant, Livreur)

2. PAIEMENTS AFRICAINS (CinetPay + PayTech) pour Wave, Orange Money, MTN Money, Moov Money, YAS

3. POS ADAPTÉ À TOUS LES SUPPORTS (smartphone, tablette, ordinateur, moniteur, TV, terminal POS, kiosque, TPE) - MOBILE FIRST

4. KIOSQUE ADAPTÉ À TOUS LES SUPPORTS - MOBILE FIRST

5. GÉOLOCALISATION avec fonction "TROUVER UN MAGASIN" (style VTC) :
   - Détection position utilisateur
   - Recherche restaurants proximité
   - Carte interactive avec marqueurs
   - Calcul distances et itinéraires
   - Filtres avancés
   - Mode satellite/plan

6. SYSTÈME DE LIVRAISON avec :
   - Géolocalisation temps réel (GEOSENSING)
   - Tracking GPS des livreurs
   - Optimisation itinéraires
   - Notifications temps réel
   - Application livreur mobile-first

7. PWA MOBILE-FIRST avec :
   - Mode hors-ligne
   - Notifications push
   - Installation écran d'accueil
   - Performance optimale mobile

8. RESPONSIVE DESIGN adapté à :
   - Smartphones (4"-7")
   - Tablettes (7"-13")
   - Ordinateurs (13"-27")
   - Moniteurs/TV (32"+)
   - POS dédiés
   - Kiosques
   - TPE

9. WHATSAPP INTEGRATION pour commandes

10. MULTI-LANGUES (Français, Anglais, Arabe, Wolof)

DÉVELOPPE LE PROJET COMPLET EN UNE SEULE FOIS EN SUIVANT :
- Mobile-first design (PRIORITÉ ABSOLUE)
- Architecture Laravel 11 + Vue.js 3 + PWA
- Base de données MySQL complète
- Tous les modèles, migrations, contrôleurs, services
- Tous les composants Vue.js responsive
- Intégrations paiements complètes
- Géolocalisation et maps
- Tests complets
- Documentation

COMMENCE MAINTENANT ET DÉVELOPPE TOUT LE PROJET.
```

---

## 📞 **SUPPORT**

**Email :** support@restoconnect360.com
**Téléphone :** +221781000064
**Adresse :** Liberté 6 JVC, Dakar, Sénégal

---

**🚀 CE PROMPT CONTIENT TOUTES LES SPÉCIFICATIONS POUR DÉVELOPPER RESTOCONNECT360 EN UNE SEULE FOIS.**

