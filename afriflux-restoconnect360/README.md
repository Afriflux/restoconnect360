# 🚀 **RESTOCONNECT360 - RESTAURANT SAAS PLATFORM**

[![Laravel](https://img.shields.io/badge/Laravel-11-red.svg)](https://laravel.com)
[![Vue.js](https://img.shields.io/badge/Vue.js-3-green.svg)](https://vuejs.org)
[![License](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)

**RestoConnect360** est une plateforme SaaS multi-restaurant complète, spécialement conçue pour le marché africain avec intégration native des paiements locaux (Wave, Orange Money, MTN Money, YAS, etc.) et système de livraison avec tracking GPS en temps réel.

### **🌐 Site Web :** [www.restoconnect360.com](https://www.restoconnect360.com/)
### **📧 Contact :** contact@restoconnect360.com
### **📞 Téléphone :** +221781000064
### **📍 Localisation :** Liberté 6 JVC, Dakar, Sénégal

---

## ⚡ **DÉMARRAGE RAPIDE**

```bash
# Installation
composer install && npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed

# Démarrage
php artisan serve        # Terminal 1
npm run dev             # Terminal 2
```

➡️ **Guide complet :** [QUICK_START.md](QUICK_START.md)

## 🎯 **Fonctionnalités Principales**

### **🏪 Multi-Restaurant SaaS**
- Gestion de plusieurs restaurants, cafés, bars
- Dashboard administration centralisé
- Gestion du personnel multi-niveaux
- Configuration personnalisée par établissement

### **💳 Paiements Africains**
- **CinetPay** : Wave, Orange Money, MTN Money, Moov Money
- **PayTech** : YAS, Orange Money CI, MTN Money CI
- **International** : Stripe, PayPal
- Support multi-devises

### **🛒 Système de Commande**
- **POS System** : Point de vente complet
- **Kiosque Client** : Commande libre-service
- **WhatsApp Integration** : Commandes via WhatsApp
- **QR Code Menu** : Menu digital interactif
- **PWA Mobile** : Application mobile progressive

### **🚚 Système de Livraison**
- Gestion des livreurs
- Géolocalisation en temps réel
- Gestion des zones de livraison
- Notifications automatiques
- Workflow de livraison complet

## 🏗️ **Architecture Technique**

### **Backend :**
- **Laravel 11** (Framework PHP)
- **MySQL 8.0** (Base de données)
- **Redis** (Cache et sessions)
- **Laravel Sanctum** (Authentification API)

### **Frontend :**
- **Vue.js 3** (Interface utilisateur)
- **Pinia** (Gestion d'état)
- **Vite** (Build tool)
- **PWA** (Progressive Web App)
- **Tailwind CSS** (Design system)

### **Paiements :**
- **CinetPay API** (Paiements mobiles africains)
- **PayTech API** (Paiements locaux)
- **Webhook handling** (Notifications)
- **Transaction logging** (Audit)

## 🚀 **Installation et Configuration**

### **1. Prérequis**
```bash
# PHP 8.3+
# MySQL 8.0+
# Redis
# Node.js 18+
# Composer
# Git
```

### **2. Installation**
```bash
# Cloner le projet
git clone https://github.com/votre-username/restoconnect360.git
cd restoconnect360

# Installer les dépendances
composer install
npm install

# Configuration
cp .env.example .env
php artisan key:generate

# Base de données
php artisan migrate
php artisan db:seed

# Démarrer le serveur
php artisan serve
npm run dev
```

### **3. Configuration des Paiements**
```env
# CinetPay
CINETPAY_API_KEY=your_api_key
CINETPAY_SITE_ID=your_site_id
CINETPAY_ENVIRONMENT=sandbox

# PayTech
PAYTECH_API_KEY=your_api_key
PAYTECH_MERCHANT_ID=your_merchant_id
PAYTECH_ENVIRONMENT=sandbox
```

## 📁 **Structure du Projet**

```
restoconnect360/
├── app/
│   ├── Models/
│   │   ├── Platform/          # Administration
│   │   ├── Restaurant/         # Restaurants
│   │   ├── Delivery/          # Livraison
│   │   └── Payment/           # Paiements
│   ├── Services/              # Services métier
│   └── Http/Controllers/      # Contrôleurs
├── resources/
│   ├── views/                 # Vues Blade
│   └── js/                    # JavaScript
├── public/                    # Assets publics
├── database/
│   ├── migrations/            # Migrations
│   └── seeders/              # Seeders
└── tests/                    # Tests
```

## 🧪 **Tests et Qualité**

### **Tests**
```bash
# Exécuter tous les tests
php artisan test

# Tests avec couverture
php artisan test --coverage

# Tests spécifiques
php artisan test --filter=PaymentTest
```

### **Linting**
```bash
# Vérifier le code
./vendor/bin/pint --test

# Formater le code
./vendor/bin/pint
```

### **Sécurité**
```bash
# Vérification de sécurité
php artisan security:check
```

## 🚀 **Déploiement**

### **1. Préparation**
```bash
# Tests complets
php artisan test

# Optimisation
php artisan optimize

# Vérification de sécurité
php artisan security:check
```

### **2. Déploiement sur Hostinger**
```bash
# Connecter au serveur
ssh username@restoconnect360.com

# Aller dans le dossier
cd /path/to/restoconnect360

# Pull les modifications
git pull origin main

# Installer les dépendances
composer install --optimize-autoloader --no-dev

# Migrer la base de données
php artisan migrate --force

# Optimiser
php artisan optimize
```

## 📊 **Monitoring et Logs**

### **Logs**
```bash
# Voir les logs en temps réel
tail -f storage/logs/laravel.log

# Logs de paiement
tail -f storage/logs/payment.log
```

### **Performance**
```bash
# Voir les performances
php artisan horizon:status

# Voir les queues
php artisan queue:work
```

## 🔧 **Commandes Utiles**

### **Développement**
```bash
# Créer un modèle
php artisan make:model Restaurant/Restaurant -m

# Créer un contrôleur
php artisan make:controller Restaurant/RestaurantController --resource

# Créer un service
php artisan make:service CinetPayService

# Créer un test
php artisan make:test Payment/CinetPayTest --feature
```

### **Base de Données**
```bash
# Créer une migration
php artisan make:migration create_restaurants_table

# Exécuter les migrations
php artisan migrate

# Annuler la dernière migration
php artisan migrate:rollback
```

### **Cache**
```bash
# Vider le cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimiser
php artisan optimize
```

## 📞 **Support et Contact**

### **Développement**
- **Environnement :** Local (Développement)
- **Repository :** GitHub
- **Déploiement :** Hostinger

### **Support**
- **Email :** support@restoconnect360.com
- **Téléphone :** +221781000064
- **Adresse :** Liberté 6 JVC, Dakar, Sénégal

## 📋 **Documentation**

- **Règles de Développement :** `DEVELOPMENT_RULES.md`
- **Workflow :** `DEVELOPMENT_WORKFLOW.md`
- **Vue d'ensemble :** `PROJECT_OVERVIEW.md`
- **Configuration :** `.env.example`

## 🚨 **Sécurité**

### **Variables Sensibles**
- Ne jamais exposer les clés API
- Utiliser des variables d'environnement
- Valider toutes les entrées utilisateur
- Gérer les erreurs proprement

### **Bonnes Pratiques**
- Tests réguliers
- Linting automatique
- Vérification de sécurité
- Documentation à jour

## ✅ **Checklist de Développement**

### **Avant de Commencer :**
- [ ] Branche Git créée
- [ ] Tests passent
- [ ] Linting OK
- [ ] Sécurité vérifiée

### **Pendant le Développement :**
- [ ] Tests réguliers
- [ ] Linting régulier
- [ ] Commits fréquents
- [ ] Documentation mise à jour

### **Avant de Finaliser :**
- [ ] Tests complets
- [ ] Linting complet
- [ ] Sécurité vérifiée
- [ ] Documentation complète

---

**Ce projet est en cours de développement. Toutes les fonctionnalités seront implémentées selon le plan établi.**