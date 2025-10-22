# 🚀 Guide d'Installation RestoConnect360

## ⚠️ **PRÉREQUIS**

Avant de commencer, assurez-vous d'avoir installé :

- ✅ PHP 8.2+ (`php --version`)
- ✅ Composer (`composer --version`)
- ✅ MySQL 8.0+ (`mysql --version`)
- ✅ **Node.js 18+** (`node --version`) - **À INSTALLER**
- ✅ NPM (`npm --version`) - **Vient avec Node.js**

---

## 📦 **ÉTAPE 1 : INSTALLER NODE.JS**

### **Option A : Via Homebrew (Recommandé macOS)**

```bash
# Si vous n'avez pas Homebrew
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"

# Installer Node.js
brew install node

# Vérifier
node --version
npm --version
```

### **Option B : Téléchargement Direct**

1. Allez sur : https://nodejs.org/
2. Téléchargez la version **LTS (Long Term Support)**
3. Installez le fichier .pkg
4. Redémarrez votre terminal
5. Vérifiez : `node --version`

---

## 🛠️ **ÉTAPE 2 : INSTALLATION DU PROJET**

Une fois Node.js installé :

```bash
# Aller dans le dossier du projet
cd ~/restoconnect360-development/restoconnect360

# 1. Installation des dépendances PHP
composer install

# 2. Installation des dépendances JavaScript
npm install

# 3. Copier le fichier de configuration
cp .env.example .env

# 4. Générer la clé de l'application
php artisan key:generate
```

---

## 🗄️ **ÉTAPE 3 : CONFIGURATION BASE DE DONNÉES**

### **3.1. Éditer le fichier .env**

Ouvrez `.env` et modifiez :

```env
APP_NAME=RestoConnect360
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=restoconnect360
DB_USERNAME=root
DB_PASSWORD=votre_mot_de_passe

# Google Maps (optionnel pour tests)
VITE_GOOGLE_MAPS_API_KEY=votre_clé_google_maps

# Paiements (optionnel pour tests)
CINETPAY_API_KEY=
CINETPAY_SITE_ID=
CINETPAY_MODE=sandbox

PAYTECH_API_KEY=
PAYTECH_API_SECRET=
PAYTECH_MODE=sandbox
```

### **3.2. Créer la base de données**

```bash
# Se connecter à MySQL
mysql -u root -p

# Créer la base de données
CREATE DATABASE restoconnect360;
exit;

# Ou en une seule commande
mysql -u root -p -e "CREATE DATABASE restoconnect360;"
```

### **3.3. Lancer les migrations**

```bash
# Créer les tables
php artisan migrate

# Publier les permissions (Spatie)
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

# Relancer les migrations
php artisan migrate

# Peupler la base de données avec des données de test
php artisan db:seed
```

---

## 🚀 **ÉTAPE 4 : DÉMARRAGE**

Ouvrez **2 terminaux** :

### **Terminal 1 : Backend Laravel**

```bash
cd ~/restoconnect360-development/restoconnect360
php artisan serve
```

Vous verrez :
```
INFO  Server running on [http://127.0.0.1:8000]
```

### **Terminal 2 : Frontend Vite**

```bash
cd ~/restoconnect360-development/restoconnect360
npm run dev
```

Vous verrez :
```
VITE v5.x.x  ready in xxx ms

➜  Local:   http://localhost:5173/
➜  Network: use --host to expose
```

---

## 🌐 **ÉTAPE 5 : ACCÉDER À L'APPLICATION**

Ouvrez votre navigateur :

**🏠 Application principale :**
```
http://localhost:8000
```

**📍 Pages disponibles :**
- Home : http://localhost:8000
- Restaurants : http://localhost:8000/restaurants
- Trouver un Magasin : http://localhost:8000/find-store
- POS : http://localhost:8000/pos
- Kiosque : http://localhost:8000/kiosk
- Livreur : http://localhost:8000/driver

---

## 👤 **COMPTES DE TEST**

Après avoir exécuté `php artisan db:seed` :

### **Admin**
- Email : `admin@restoconnect360.com`
- Mot de passe : `password`

### **Manager de Restaurant**
- Email : `manager@restaurantdakar.com`
- Mot de passe : `password`

### **Livreurs**
- Email : `driver1@restoconnect360.com` à `driver5@restoconnect360.com`
- Mot de passe : `password`

---

## 🧪 **ÉTAPE 6 : TESTS (OPTIONNEL)**

```bash
# Tests Backend
php artisan test

# Tests Frontend (quand Vitest sera configuré)
npm run test

# Tests E2E (quand Playwright sera configuré)
npx playwright test
```

---

## 🔍 **VÉRIFICATION**

### **Vérifier que tout fonctionne :**

1. ✅ Backend Laravel : http://localhost:8000 (doit afficher Vue.js app)
2. ✅ Vite dev server : http://localhost:5173 (proxy vers Laravel)
3. ✅ Base de données : Vérifier les tables
   ```bash
   mysql -u root -p restoconnect360 -e "SHOW TABLES;"
   ```
4. ✅ API : Tester un endpoint
   ```bash
   curl http://localhost:8000/api/restaurants
   ```

---

## ❌ **DÉPANNAGE**

### **Problème : "npm: command not found"**

➡️ Node.js n'est pas installé. Voir ÉTAPE 1.

### **Problème : "SQLSTATE[HY000] [1045] Access denied"**

➡️ Vérifiez vos credentials MySQL dans `.env`

### **Problème : "Class 'Spatie\Permission\...' not found"**

➡️ Exécutez :
```bash
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate
```

### **Problème : Page blanche / Erreur 500**

➡️ Vérifiez les logs :
```bash
tail -f storage/logs/laravel.log
```

➡️ Permissions dossiers :
```bash
chmod -R 775 storage bootstrap/cache
```

### **Problème : "Mix manifest does not exist"**

➡️ Compilez les assets :
```bash
npm run build
# ou en dev
npm run dev
```

---

## 📚 **DOCUMENTATION**

- **[PROJECT_COMPLETION.md](PROJECT_COMPLETION.md)** : Résumé complet du projet
- **[TESTING_GUIDE.md](TESTING_GUIDE.md)** : Guide des tests
- **[API_TESTING_GUIDE.md](API_TESTING_GUIDE.md)** : Tests API
- **[QUICK_START.md](QUICK_START.md)** : Démarrage rapide

---

## 📞 **SUPPORT**

**RestoConnect360**  
📧 Email : contact@restoconnect360.com  
📱 Téléphone : +221 78 100 00 64

---

## ✅ **CHECKLIST D'INSTALLATION**

- [ ] Node.js installé (`node --version`)
- [ ] Dépendances PHP installées (`composer install`)
- [ ] Dépendances JS installées (`npm install`)
- [ ] Fichier `.env` configuré
- [ ] Base de données créée
- [ ] Migrations exécutées (`php artisan migrate`)
- [ ] Seeders exécutés (`php artisan db:seed`)
- [ ] Backend démarré (`php artisan serve`)
- [ ] Frontend démarré (`npm run dev`)
- [ ] Application accessible sur http://localhost:8000

---

**🎉 Une fois tout installé, vous aurez accès à RestoConnect360 complet !**

