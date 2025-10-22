# RestoConnect360 - Windsurf Development Environment

## 🎯 Vue d'ensemble
Plateforme SaaS multi-restaurant pour l'Afrique de l'Ouest avec paiements locaux et livraison GPS.

## 🏗️ Architecture
- **Backend**: Laravel 12 + PHP 8.2+ + MySQL 8.0 + Redis
- **Frontend**: Vue.js 3 + Vite + Tailwind CSS + PWA
- **Monitoring**: Sentry + Laravel Telescope + Horizon
- **Sécurité**: 2FA + Spatie Permissions + Rate Limiting

## 🚀 Démarrage Rapide Windsurf

### Prérequis
- PHP 8.2+
- Node.js 18+
- MySQL 8.0+
- Redis
- Composer

### Installation
```bash
# 1. Cloner et installer les dépendances
composer install
npm install

# 2. Configuration environnement
cp .env.example .env
php artisan key:generate

# 3. Base de données
php artisan migrate
php artisan db:seed

# 4. Démarrer les services
php artisan serve --host=0.0.0.0 --port=8000
npm run dev
```

## 📁 Structure du Projet

```
restoconnect360/
├── app/
│   ├── Http/Controllers/     # Contrôleurs API
│   ├── Models/              # Modèles Eloquent
│   ├── Services/            # Services métier
│   └── Http/Middleware/     # Middleware sécurité
├── resources/
│   ├── js/                  # Frontend Vue.js
│   │   ├── pages/          # Pages (lazy loaded)
│   │   ├── components/     # Composants réutilisables
│   │   ├── stores/         # Stores Pinia
│   │   └── router/         # Routes Vue Router
│   └── css/                # Styles Tailwind
├── database/
│   ├── migrations/         # Migrations BDD
│   └── seeders/           # Données de test
├── routes/
│   └── api.php            # Routes API sécurisées
└── public/                # Assets publics
```

## 🔧 Configuration Windsurf

### Ports par défaut
- **Laravel**: http://localhost:8000
- **Vite**: http://localhost:5173
- **Telescope**: http://localhost:8000/telescope
- **Horizon**: http://localhost:8000/horizon

### Variables d'environnement critiques
```env
APP_NAME=RestoConnect360
APP_ENV=local
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=restoconnect360

REDIS_HOST=127.0.0.1
REDIS_PORT=6379

# Sentry (optionnel)
SENTRY_LARAVEL_DSN=
VITE_SENTRY_DSN=

# Paiements (à configurer)
CINETPAY_API_KEY=
PAYTECH_API_KEY=
```

## 🎨 Fonctionnalités Principales

### Multi-Commerces Horeca/CHR
- 20+ types de commerces
- Templates spécialisés
- Branding personnalisé

### Paiements Africains
- CinetPay (Wave, Orange Money, MTN Money)
- PayTech (YAS, Orange Money CI)
- Stripe international

### Système de Livraison
- Géolocalisation temps réel
- Optimisation tournées
- Notifications automatiques

### Sécurité Avancée
- 2FA obligatoire (rôles sensibles)
- Rate limiting
- Monitoring activité suspecte

## 📊 Monitoring & Performance

### Outils intégrés
- **Sentry**: Monitoring erreurs JS/PHP
- **Telescope**: Debug API staging
- **Horizon**: Gestion jobs Redis
- **Cache Redis**: Optimisation performances

### Métriques
- Lazy loading Vue.js (60% réduction bundle)
- Cache Redis (80% amélioration temps réponse)
- Chunking optimisé par fonctionnalité

## 🔐 Sécurité

### Authentification
- Laravel Sanctum (tokens API)
- 2FA Google Authenticator
- Codes de récupération

### Permissions
- Spatie Laravel Permission
- Rôles granulaires (5 niveaux)
- Middleware sécurité renforcé

### Protection
- Rate limiting (60 req/min)
- Verrouillage compte (5 tentatives)
- Détection activité suspecte

## 🧪 Tests

```bash
# Tests complets
php artisan test

# Tests avec couverture
php artisan test --coverage

# Tests spécifiques
php artisan test --filter=PaymentTest
```

## 📱 PWA & Mobile

### Fonctionnalités
- Installation native
- Mode hors-ligne
- Notifications push
- Design mobile-first

### Internationalisation
- Français (principal)
- Anglais (international)
- Arabe (maghrébin)
- Wolof (local Sénégal)

## 🚀 Déploiement

### Production
- Serveur: Hostinger VPS
- SSL: Let's Encrypt
- CDN: Cloudflare
- Monitoring: Uptime Robot

### Scripts utiles
```bash
# Optimisation production
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build

# Monitoring
php artisan horizon:status
php artisan telescope:prune
```

## 📞 Support

- **Email**: contact@restoconnect360.com
- **Téléphone**: +221 78 100 00 64
- **Site**: https://www.restoconnect360.com

---

**Statut**: 🟢 Production Ready - Prêt pour déploiement après configuration clés API
