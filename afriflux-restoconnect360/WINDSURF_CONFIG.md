# RestoConnect360 - Configuration Windsurf
# Fichier de configuration pour l'environnement de développement Windsurf

## 🎯 Configuration de Base

### Ports par défaut
- Laravel: 8000
- Vite: 5173
- MySQL: 3306
- Redis: 6379

### Variables d'environnement critiques
```env
APP_NAME=RestoConnect360
APP_ENV=local
APP_URL=http://localhost:8000
APP_DEBUG=true

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=restoconnect360
DB_USERNAME=root
DB_PASSWORD=

REDIS_HOST=127.0.0.1
REDIS_PORT=6379

CACHE_DRIVER=redis
SESSION_DRIVER=database
QUEUE_CONNECTION=redis
```

## 🚀 Scripts de Démarrage

### Démarrage rapide
```bash
# Option 1: Script automatisé
./windsurf-start.sh

# Option 2: Composer
composer run windsurf

# Option 3: NPM
npm run windsurf
```

### Démarrage complet (avec Horizon)
```bash
# Option 1: Script automatisé complet
./windsurf-setup.sh

# Option 2: Composer complet
composer run windsurf:full

# Option 3: NPM complet
npm run windsurf:full
```

## 🔧 Configuration Avancée

### Prérequis système
- PHP 8.2+
- Node.js 18+
- MySQL 8.0+
- Redis
- Composer

### Extensions PHP requises
- BCMath
- Ctype
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PDO
- Tokenizer
- XML
- cURL
- GD
- Imagick

### Dépendances NPM critiques
- Vue.js 3.5+
- Vite 4.5+
- Pinia 3.0+
- Tailwind CSS 3.4+
- Axios 1.12+
- Vue Router 4.6+

## 📊 Monitoring & Debug

### URLs de monitoring
- Application: http://localhost:8000
- Telescope: http://localhost:8000/telescope
- Horizon: http://localhost:8000/horizon
- Vite Dev: http://localhost:5173

### Commandes de monitoring
```bash
# Status Horizon
php artisan horizon:status

# Logs en temps réel
tail -f storage/logs/laravel.log

# Cache status
php artisan cache:table

# Queue status
php artisan queue:work --once
```

## 🔐 Sécurité

### 2FA Configuration
- Obligatoire pour: super_admin, admin, company_manager
- Google Authenticator compatible
- Codes de récupération: 8 codes uniques

### Rate Limiting
- API: 60 requêtes/minute
- Actions sensibles: 5 requêtes/5 minutes
- Login: 5 tentatives avant verrouillage

### Permissions Spatie
- 5 rôles définis
- Permissions granulaires
- Middleware sécurité renforcé

## 🎨 Frontend

### Lazy Loading
- Toutes les pages en lazy loading
- Layouts synchrones (utilisation fréquente)
- Chunking optimisé par fonctionnalité

### PWA Features
- Service Worker activé
- Mode hors-ligne
- Notifications push
- Installation native

### Internationalisation
- 4 langues: FR, EN, AR, WO
- Formatage local (devises, dates)
- Validation formats africains

## 💳 Paiements

### Intégrations configurées
- CinetPay (Wave, Orange Money, MTN Money)
- PayTech (YAS, Orange Money CI)
- Stripe (international)

### Configuration requise
```env
CINETPAY_API_KEY=your_api_key
CINETPAY_SITE_ID=your_site_id
CINETPAY_ENVIRONMENT=sandbox

PAYTECH_API_KEY=your_api_key
PAYTECH_MERCHANT_ID=your_merchant_id
PAYTECH_ENVIRONMENT=sandbox

STRIPE_KEY=your_stripe_key
STRIPE_SECRET=your_stripe_secret
```

## 🚚 Livraison

### Géolocalisation
- Google Maps API intégrée
- Calcul distance Haversine
- Zones de livraison configurables
- Tracking temps réel

### Configuration requise
```env
GOOGLE_MAPS_API_KEY=your_google_maps_key
```

## 📱 Communication

### Services configurés
- Twilio (SMS/WhatsApp)
- Email (SMTP)
- Notifications push

### Configuration requise
```env
TWILIO_SID=your_twilio_sid
TWILIO_TOKEN=your_twilio_token
TWILIO_FROM=your_twilio_number

MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
```

## 🧪 Tests

### Commandes de test
```bash
# Tests complets
php artisan test

# Tests avec couverture
php artisan test --coverage

# Tests spécifiques
php artisan test --filter=PaymentTest
php artisan test --filter=AuthTest
```

### Tests disponibles
- AuthTest (authentification)
- PaymentTest (paiements)
- RestaurantTest (restaurants)
- DeliveryTest (livraison)
- OrderTest (commandes)

## 🚀 Déploiement

### Préparation production
```bash
# Optimisation
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build

# Tests
php artisan test
```

### Variables production
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

SENTRY_LARAVEL_DSN=your_sentry_dsn
VITE_SENTRY_DSN=your_sentry_dsn
```

## 📚 Documentation

### Fichiers de référence
- WINDSURF_README.md (documentation complète)
- README.md (documentation générale)
- API_TESTING_GUIDE.md (guide API)
- TESTING_GUIDE.md (guide tests)

### Support
- Email: contact@restoconnect360.com
- Téléphone: +221 78 100 00 64
- Site: https://www.restoconnect360.com

---

**Statut**: 🟢 Production Ready - Prêt pour Windsurf
