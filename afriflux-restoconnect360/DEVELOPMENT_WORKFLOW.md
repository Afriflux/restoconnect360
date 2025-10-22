# 🔄 **WORKFLOW DE DÉVELOPPEMENT RESTOCONNECT360**

## 🚀 **Démarrage Rapide**

### **1. Configuration Initiale**
```bash
# Aller dans le dossier du projet
cd ~/restoconnect360-development/restoconnect360

# Copier le fichier d'environnement
cp .env.example .env

# Générer la clé d'application
php artisan key:generate

# Installer les dépendances
composer install
npm install

# Configurer la base de données
# Éditer .env avec vos paramètres de base de données

# Migrer la base de données
php artisan migrate

# Créer un utilisateur admin
php artisan make:command CreateAdminUser
```

### **2. Démarrage du Serveur**
```bash
# Démarrer le serveur de développement
php artisan serve

# Dans un autre terminal, démarrer Vite
npm run dev
```

## 📋 **Workflow de Développement**

### **1. Avant de Commencer**
```bash
# Vérifier l'état du projet
git status

# Créer une branche pour la fonctionnalité
git checkout -b feature/nom-de-la-fonctionnalite

# Vérifier que tout fonctionne
php artisan test
```

### **2. Pendant le Développement**
```bash
# Tester régulièrement
php artisan test

# Vérifier le linting
./vendor/bin/pint --test

# Vérifier la sécurité
php artisan security:check

# Commiter les changements
git add .
git commit -m "Add: Description de la fonctionnalité"
```

### **3. Avant de Finaliser**
```bash
# Tests complets
php artisan test

# Linting complet
./vendor/bin/pint

# Vérification de sécurité
php artisan security:check

# Vérification des migrations
php artisan migrate:status

# Push vers le repository
git push origin feature/nom-de-la-fonctionnalite
```

## 🏗️ **Structure de Développement**

### **1. Modèles (Models)**
```bash
# Créer un nouveau modèle
php artisan make:model Platform/Admin -m

# Créer un modèle avec migration et factory
php artisan make:model Restaurant/Restaurant -mf

# Créer un modèle avec migration, factory et seeder
php artisan make:model Delivery/Driver -mfs
```

### **2. Contrôleurs (Controllers)**
```bash
# Créer un contrôleur simple
php artisan make:controller Platform/AdminController

# Créer un contrôleur avec ressources
php artisan make:controller Restaurant/RestaurantController --resource

# Créer un contrôleur API
php artisan make:controller Api/PaymentController --api
```

### **3. Services**
```bash
# Créer un service
php artisan make:service CinetPayService

# Créer un service avec interface
php artisan make:service PaymentService --interface
```

### **4. Tests**
```bash
# Créer un test unitaire
php artisan make:test Platform/AdminTest --unit

# Créer un test d'intégration
php artisan make:test Restaurant/RestaurantTest

# Créer un test de fonctionnalité
php artisan make:test Payment/CinetPayTest --feature
```

## 🔧 **Commandes Utiles**

### **Base de Données**
```bash
# Créer une migration
php artisan make:migration create_restaurants_table

# Exécuter les migrations
php artisan migrate

# Annuler la dernière migration
php artisan migrate:rollback

# Réinitialiser toutes les migrations
php artisan migrate:reset

# Recréer la base de données
php artisan migrate:fresh --seed
```

### **Cache et Optimisation**
```bash
# Vider le cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimiser pour la production
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### **Développement**
```bash
# Générer des données de test
php artisan db:seed

# Créer un utilisateur
php artisan make:user

# Voir les routes
php artisan route:list

# Voir les commandes disponibles
php artisan list
```

## 🧪 **Tests et Qualité**

### **Tests Automatiques**
```bash
# Exécuter tous les tests
php artisan test

# Exécuter les tests unitaires
php artisan test --testsuite=Unit

# Exécuter les tests d'intégration
php artisan test --testsuite=Feature

# Exécuter les tests avec couverture
php artisan test --coverage
```

### **Linting et Formatage**
```bash
# Vérifier le code (sans modification)
./vendor/bin/pint --test

# Formater le code
./vendor/bin/pint

# Vérifier la sécurité
php artisan security:check
```

### **Analyse de Code**
```bash
# Analyser le code avec PHPStan
./vendor/bin/phpstan analyse

# Analyser le code avec Psalm
./vendor/bin/psalm
```

## 🚀 **Déploiement**

### **1. Préparation**
```bash
# Tests complets
php artisan test

# Linting
./vendor/bin/pint

# Optimisation
php artisan optimize

# Vérification de sécurité
php artisan security:check
```

### **2. Déploiement Local**
```bash
# Créer une branche de production
git checkout -b production

# Merge depuis la branche de développement
git merge feature/nom-de-la-fonctionnalite

# Tag de version
git tag -a v1.0.0 -m "Version 1.0.0"
git push origin v1.0.0
```

### **3. Déploiement Production**
```bash
# Connecter au serveur
ssh username@restoconnect360.com

# Aller dans le dossier du projet
cd /path/to/restoconnect360

# Pull les dernières modifications
git pull origin production

# Installer les dépendances
composer install --optimize-autoloader --no-dev

# Migrer la base de données
php artisan migrate --force

# Optimiser
php artisan optimize

# Redémarrer les services
sudo systemctl restart nginx
sudo systemctl restart php8.3-fpm
```

## 📊 **Monitoring et Logs**

### **Logs**
```bash
# Voir les logs en temps réel
tail -f storage/logs/laravel.log

# Voir les logs d'erreur
tail -f storage/logs/laravel-error.log

# Voir les logs de paiement
tail -f storage/logs/payment.log
```

### **Monitoring**
```bash
# Voir les performances
php artisan horizon:status

# Voir les queues
php artisan queue:work

# Voir les tâches planifiées
php artisan schedule:list
```

## 🚨 **Dépannage**

### **Problèmes Courants**
```bash
# Erreur de permissions
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 755 storage bootstrap/cache

# Erreur de base de données
php artisan migrate:status
php artisan migrate:rollback

# Erreur de cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Erreur de dépendances
composer install
npm install
```

### **Restauration**
```bash
# Restaurer depuis Git
git checkout HEAD~1

# Restaurer la base de données
php artisan migrate:rollback

# Restaurer les dépendances
composer install
npm install
```

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
- [ ] Code review

### **Avant le Déploiement :**
- [ ] Tests de production
- [ ] Optimisation
- [ ] Sauvegarde
- [ ] Monitoring activé

---

**Ce workflow doit être suivi à la lettre pour assurer la qualité et la stabilité du projet.**
