# 🎯 **RÈGLES DE DÉVELOPPEMENT RESTOCONNECT360**

## ⚠️ **RÈGLES ABSOLUES À RESPECTER**

### **1. PROTECTION DU PROJET EXISTANT**
- **JAMAIS** supprimer ou modifier le code existant sans autorisation explicite
- **TOUJOURS** faire des sauvegardes avant toute modification
- **TOUJOURS** tester en environnement de développement avant production
- **JAMAIS** modifier les fichiers de configuration sans validation

### **2. GESTION DES VERSIONS**
- **TOUJOURS** utiliser Git pour versionner le code
- **TOUJOURS** créer une branche pour chaque fonctionnalité
- **JAMAIS** commiter directement sur la branche principale
- **TOUJOURS** faire des commits descriptifs et atomiques

### **3. SÉCURITÉ ABSOLUE**
- **JAMAIS** exposer les clés API ou mots de passe dans le code
- **TOUJOURS** utiliser des variables d'environnement pour les secrets
- **TOUJOURS** valider et nettoyer les entrées utilisateur
- **JAMAIS** exécuter de code non vérifié

### **4. ARCHITECTURE RESPECTÉE**
- **TOUJOURS** suivre l'architecture Laravel existante
- **TOUJOURS** respecter les conventions de nommage
- **JAMAIS** créer de dépendances circulaires
- **TOUJOURS** documenter le code ajouté

## 🚫 **INTERDICTIONS STRICTES**

### **NE JAMAIS FAIRE :**
- ❌ Supprimer des fichiers existants
- ❌ Modifier la structure de la base de données sans migration
- ❌ Exposer des informations sensibles
- ❌ Ignorer les erreurs de linting
- ❌ Commiter du code non testé
- ❌ Modifier les fichiers de configuration de production
- ❌ Supprimer des dépendances existantes
- ❌ Ignorer les conventions de code

### **TOUJOURS FAIRE :**
- ✅ Créer des sauvegardes avant modification
- ✅ Tester le code avant déploiement
- ✅ Utiliser des variables d'environnement
- ✅ Documenter les modifications
- ✅ Respecter les conventions de code
- ✅ Valider les entrées utilisateur
- ✅ Gérer les erreurs proprement

## 📋 **PROCÉDURE DE DÉVELOPPEMENT OBLIGATOIRE**

### **1. AVANT TOUTE MODIFICATION :**
```bash
# 1. Sauvegarder le projet
git add .
git commit -m "Backup before modification"

# 2. Créer une branche
git checkout -b feature/nom-de-la-fonctionnalite

# 3. Vérifier l'état actuel
git status
```

### **2. PENDANT LE DÉVELOPPEMENT :**
```bash
# 1. Tester régulièrement
php artisan test

# 2. Vérifier le linting
./vendor/bin/pint --test

# 3. Vérifier la sécurité
php artisan security:check
```

### **3. AVANT COMMIT :**
```bash
# 1. Vérifier tous les tests
php artisan test

# 2. Vérifier le linting
./vendor/bin/pint

# 3. Vérifier la sécurité
php artisan security:check

# 4. Vérifier les migrations
php artisan migrate:status
```

## 🔒 **SÉCURITÉ RENFORCÉE**

### **Variables d'Environnement :**
```env
# JAMAIS exposer ces valeurs
APP_KEY=base64:...
DB_PASSWORD=...
CINETPAY_API_KEY=...
PAYTECH_API_KEY=...
WHATSAPP_TOKEN=...
```

### **Validation des Entrées :**
```php
// TOUJOURS valider les entrées
$request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|email|unique:users',
    'amount' => 'required|numeric|min:0'
]);
```

### **Gestion des Erreurs :**
```php
// TOUJOURS gérer les erreurs
try {
    // Code risqué
} catch (Exception $e) {
    Log::error('Erreur: ' . $e->getMessage());
    return response()->json(['error' => 'Erreur interne'], 500);
}
```

## 📁 **STRUCTURE À RESPECTER**

### **Dossiers Interdits :**
- ❌ Ne pas modifier `/config/` sans autorisation
- ❌ Ne pas toucher à `/database/migrations/` existantes
- ❌ Ne pas modifier `/routes/` sans validation
- ❌ Ne pas supprimer de fichiers dans `/public/`

### **Dossiers Autorisés :**
- ✅ `/app/Models/` (nouveaux modèles)
- ✅ `/app/Services/` (nouveaux services)
- ✅ `/app/Http/Controllers/` (nouveaux contrôleurs)
- ✅ `/resources/views/` (nouvelles vues)
- ✅ `/resources/js/` (nouveau JavaScript)

## 🧪 **TESTS OBLIGATOIRES**

### **Avant Chaque Commit :**
```bash
# 1. Tests unitaires
php artisan test

# 2. Tests d'intégration
php artisan test --testsuite=Feature

# 3. Vérification du code
./vendor/bin/pint --test

# 4. Vérification de sécurité
php artisan security:check
```

### **Avant Déploiement :**
```bash
# 1. Tests complets
php artisan test

# 2. Vérification des migrations
php artisan migrate:status

# 3. Vérification des routes
php artisan route:list

# 4. Vérification des permissions
php artisan permission:show
```

## 🚨 **ALERTES CRITIQUES**

### **Si une de ces situations se produit :**
1. **Erreur de base de données** → Arrêter immédiatement
2. **Exposition de secrets** → Révoquer les clés immédiatement
3. **Erreur de sécurité** → Analyser et corriger
4. **Perte de données** → Restaurer depuis la sauvegarde
5. **Conflit de dépendances** → Résoudre avant de continuer

### **Actions Immédiates :**
```bash
# 1. Arrêter le serveur
php artisan down

# 2. Restaurer depuis Git
git checkout HEAD~1

# 3. Restaurer la base de données
php artisan migrate:rollback

# 4. Redémarrer
php artisan up
```

## 📞 **CONTACT D'URGENCE**

### **En cas de problème critique :**
1. **Arrêter immédiatement** le développement
2. **Sauvegarder** l'état actuel
3. **Documenter** le problème
4. **Contacter** l'utilisateur pour validation

## ✅ **CHECKLIST DE VALIDATION**

### **Avant Chaque Modification :**
- [ ] Sauvegarde créée
- [ ] Branche Git créée
- [ ] Tests passent
- [ ] Linting OK
- [ ] Sécurité vérifiée
- [ ] Documentation mise à jour

### **Avant Chaque Commit :**
- [ ] Code testé
- [ ] Erreurs corrigées
- [ ] Conventions respectées
- [ ] Sécurité vérifiée
- [ ] Documentation à jour

### **Avant Déploiement :**
- [ ] Tests complets
- [ ] Migrations vérifiées
- [ ] Routes vérifiées
- [ ] Permissions vérifiées
- [ ] Sauvegarde production

---

**Ces instructions sont OBLIGATOIRES et doivent être respectées à la lettre. Toute violation peut compromettre l'intégrité du projet.**
