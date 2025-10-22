# ⚡ **RESTOCONNECT360 - DÉMARRAGE RAPIDE**

## 🚀 **Démarrage en 5 Minutes**

### **1. Installation (2 minutes)**

```bash
# 1. Aller dans le dossier du projet
cd ~/restoconnect360-development/restoconnect360

# 2. Installer les dépendances backend
composer install

# 3. Installer les dépendances frontend
npm install

# 4. Copier le fichier d'environnement
cp .env.example .env

# 5. Générer la clé d'application
php artisan key:generate

# 6. Configurer la base de données dans .env
# DB_DATABASE=restoconnect360
# DB_USERNAME=root
# DB_PASSWORD=

# 7. Créer la base de données
mysql -u root -e "CREATE DATABASE restoconnect360;"

# 8. Exécuter les migrations
php artisan migrate

# 9. Publier les configurations Spatie
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate
```

### **2. Créer des Données de Test (1 minute)**

```bash
# Créer un seeder pour les données de base
php artisan make:seeder DatabaseSeeder

# Ensuite, exécuter le seeder
php artisan db:seed
```

### **3. Démarrer le Serveur (1 minute)**

```bash
# Terminal 1 : Serveur Laravel
php artisan serve

# Terminal 2 : Vite (Frontend)
npm run dev
```

### **4. Accéder à l'Application (1 minute)**

- **Frontend :** http://localhost:8000
- **API :** http://localhost:8000/api

---

## 📁 **STRUCTURE DU PROJET**

```
restoconnect360/
├── app/
│   ├── Models/
│   │   ├── Platform/        # ✅ Modèles plateforme (Company, Subscription)
│   │   ├── Restaurant/      # ✅ Modèles restaurant (Restaurant, Order, Product, etc.)
│   │   ├── Delivery/        # ✅ Modèles livraison (Delivery, Driver, etc.)
│   │   ├── Payment/         # ✅ Modèles paiement (Payment, Transaction, etc.)
│   │   └── Geolocation/     # ✅ Modèles géolocalisation (Location, GeoZone, etc.)
│   ├── Services/            # ✅ Services métier
│   │   ├── CinetPayService.php
│   │   ├── PayTechService.php
│   │   ├── WhatsAppService.php
│   │   ├── GeolocationService.php
│   │   ├── DeliveryService.php
│   │   └── NotificationService.php
│   └── Http/Controllers/    # 🔄 À créer
├── database/
│   └── migrations/          # ✅ 20+ migrations complètes
├── config/
│   └── services.php         # ✅ Configuration complète
└── resources/
    ├── js/                  # 🔄 À développer (Vue.js)
    └── css/                 # 🔄 À développer (Tailwind)
```

---

## 🔧 **CONFIGURATION RAPIDE**

### **Variables d'Environnement Essentielles**

Éditez `.env` et configurez :

```env
# Base de données
DB_DATABASE=restoconnect360
DB_USERNAME=root
DB_PASSWORD=

# CinetPay (Sandbox)
CINETPAY_API_KEY=votre_api_key
CINETPAY_SITE_ID=votre_site_id
CINETPAY_ENVIRONMENT=sandbox

# PayTech (Sandbox)
PAYTECH_API_KEY=votre_api_key
PAYTECH_MERCHANT_ID=votre_merchant_id
PAYTECH_ENVIRONMENT=sandbox

# WhatsApp Business API
WHATSAPP_TOKEN=votre_token
WHATSAPP_PHONE_NUMBER_ID=votre_phone_id

# Google Maps
GOOGLE_MAPS_API_KEY=votre_google_maps_key
```

---

## 📝 **CRÉER DES DONNÉES DE TEST**

### **Créer le DatabaseSeeder**

Éditez `database/seeders/DatabaseSeeder.php` :

```php
<?php

namespace Database\Seeders;

use App\Models\Platform\Company;
use App\Models\Platform\Subscription;
use App\Models\Restaurant\Restaurant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Créer les rôles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'company_manager']);
        Role::create(['name' => 'restaurant_manager']);
        Role::create(['name' => 'employee']);
        Role::create(['name' => 'driver']);

        // Créer un admin
        $admin = User::create([
            'name' => 'Admin RestoConnect360',
            'email' => 'admin@restoconnect360.com',
            'password' => bcrypt('password'),
            'is_active' => true,
        ]);
        $admin->assignRole('admin');

        // Créer une entreprise
        $company = Company::create([
            'name' => 'Entreprise Test',
            'slug' => 'entreprise-test',
            'email' => 'contact@entreprise-test.com',
            'phone' => '+221781000064',
            'city' => 'Dakar',
            'country' => 'Senegal',
            'is_active' => true,
        ]);

        // Créer un abonnement
        Subscription::create([
            'company_id' => $company->id,
            'plan_name' => 'professional',
            'price' => 50000,
            'billing_cycle' => 'monthly',
            'max_restaurants' => 5,
            'max_products' => 500,
            'max_orders' => 1000,
            'has_pos' => true,
            'has_delivery' => true,
            'has_whatsapp' => true,
            'has_analytics' => true,
            'starts_at' => now(),
            'ends_at' => now()->addMonth(),
            'status' => 'active',
        ]);

        // Créer un restaurant
        Restaurant::create([
            'company_id' => $company->id,
            'name' => 'Restaurant Test',
            'slug' => 'restaurant-test',
            'description' => 'Restaurant de test pour RestoConnect360',
            'phone' => '+221781000064',
            'email' => 'contact@restaurant-test.com',
            'address' => 'Liberté 6 JVC, Dakar',
            'city' => 'Dakar',
            'country' => 'Senegal',
            'latitude' => 14.7167,
            'longitude' => -17.4677,
            'category' => 'restaurant',
            'accepts_delivery' => true,
            'accepts_takeaway' => true,
            'accepts_dine_in' => true,
            'has_pos' => true,
            'has_whatsapp' => true,
            'is_active' => true,
        ]);

        echo "✅ Données de test créées avec succès!\n";
        echo "📧 Email admin: admin@restoconnect360.com\n";
        echo "🔑 Mot de passe: password\n";
    }
}
```

Puis exécutez :
```bash
php artisan db:seed
```

---

## 🧪 **TESTER L'API**

### **1. Créer un Utilisateur**

```bash
POST /api/register
Content-Type: application/json

{
  "name": "Test User",
  "email": "test@example.com",
  "password": "password",
  "password_confirmation": "password"
}
```

### **2. Connexion**

```bash
POST /api/login
Content-Type: application/json

{
  "email": "test@example.com",
  "password": "password"
}
```

### **3. Lister les Restaurants**

```bash
GET /api/restaurants
Authorization: Bearer {token}
```

---

## 📚 **RESSOURCES**

### **Documentation**
- `README.md` - Vue d'ensemble
- `DEVELOPMENT_STATUS.md` - État du développement
- `DEVELOPMENT_WORKFLOW.md` - Workflow de développement
- `DEVELOPMENT_RULES.md` - Règles de développement
- `CLAUDE_DEVELOPMENT_PROMPT.md` - Prompt complet

### **Fichiers Importants**
- `.env.example` - Variables d'environnement
- `config/services.php` - Configuration des services
- `database/migrations/` - Migrations de base de données

---

## ✅ **VÉRIFICATION**

### **Vérifier que tout fonctionne**

```bash
# Vérifier les migrations
php artisan migrate:status

# Vérifier les modèles
php artisan tinker
>>> App\Models\User::count()
>>> App\Models\Restaurant\Restaurant::count()

# Vérifier les routes
php artisan route:list

# Exécuter les tests (si disponibles)
php artisan test
```

---

## 🎯 **PROCHAINES ÉTAPES**

### **Pour Développeurs**
1. **Créer les contrôleurs API** (voir `DEVELOPMENT_STATUS.md`)
2. **Configurer Vue.js 3** (voir section Frontend)
3. **Développer les interfaces** (POS, Kiosque, etc.)

### **Pour Administrateurs**
1. **Configurer les clés API** (CinetPay, PayTech, Google Maps)
2. **Créer des utilisateurs et restaurants**
3. **Configurer les méthodes de paiement**

---

## 💡 **ASTUCES**

### **Développement Rapide**
```bash
# Auto-reload avec Vite
npm run dev

# Logs en temps réel
tail -f storage/logs/laravel.log

# Vider le cache
php artisan optimize:clear
```

### **Debugging**
```bash
# Mode debug activé dans .env
APP_DEBUG=true

# Afficher les requêtes SQL
DB_LOG_QUERIES=true
```

---

## 🆘 **BESOIN D'AIDE ?**

- **Documentation :** Consultez `DEVELOPMENT_STATUS.md`
- **Email :** contact@restoconnect360.com
- **Téléphone :** +221781000064

---

**🚀 Bon développement avec RestoConnect360 !**

