# 🔐 Identifiants de Test - RestoConnect360

## 📋 Comptes de Test par Rôle

Tous les comptes utilisent des mots de passe sécurisés pour le développement.

---

## 👑 Super Admin

**Accès complet à la plateforme**

```
📧 Email: superadmin@restoconnect360.com
🔑 Mot de passe: Admin@2025
🌐 Dashboard: /admin/super-admin
```

**Permissions:**
- Gestion complète de la plateforme
- Accès à tous les dashboards
- Gestion entreprises et commerces
- Configuration système
- Statistiques globales

---

## 🏢 Admin

**Gestion d'entreprise et commerces**

```
📧 Email: admin@restoconnect360.com
🔑 Mot de passe: Admin@2025
🌐 Dashboard: /admin/dashboard
```

**Permissions:**
- Gestion multi-commerces
- Gestion équipe
- Statistiques entreprise
- Configuration commerces
- Gestion commandes

---

## 🏪 Restaurant Manager

**Gestion d'un restaurant spécifique**

```
📧 Email: restaurant@restoconnect360.com
🔑 Mot de passe: Restaurant@2025
🌐 Dashboard: /admin/restaurant
```

**Permissions:**
- Gestion commandes du restaurant
- Gestion menu et produits
- Gestion tables
- Gestion personnel
- Statistiques restaurant
- Accès POS

---

## 🎯 Agent Commercial

**Ventes et support client**

```
📧 Email: agent@restoconnect360.com
🔑 Mot de passe: Agent@2025
🌐 Dashboard: /admin/agent
```

**Permissions:**
- Gestion prospects (CRM)
- Gestion clients
- Pipeline de ventes
- Tâches et calendrier
- Statistiques de performance
- Commissions

---

## 🚗 Livreur

**Gestion des livraisons**

```
📧 Email: driver1@restoconnect360.com
🔑 Mot de passe: Driver@2025
🌐 Dashboard: /driver
```

**Autres livreurs disponibles:**
- driver2@restoconnect360.com (Driver@2025)
- driver3@restoconnect360.com (Driver@2025)
- driver4@restoconnect360.com (Driver@2025)
- driver5@restoconnect360.com (Driver@2025)

**Permissions:**
- Voir livraisons disponibles
- Accepter livraisons
- Gérer livraisons en cours
- Tracking GPS
- Statistiques personnelles

---

## 👤 Employé

**Accès basique employé**

```
📧 Email: employee@restoconnect360.com
🔑 Mot de passe: Employee@2025
🌐 Dashboard: /pos
```

**Permissions:**
- Utilisation POS
- Prise de commandes
- Gestion tables
- Accès limité

---

## 🔄 Réinitialiser la Base de Données

Pour réinitialiser la base de données et créer tous ces comptes:

```bash
php artisan migrate:fresh --seed
```

**⚠️ Attention:** Cette commande supprime toutes les données existantes.

---

## 🧪 Tests de Connexion

### Test Rapide

1. Démarrer le serveur:
```bash
npm run dev
php artisan serve
```

2. Aller sur: `http://localhost:5173/auth/login`

3. Se connecter avec un des comptes ci-dessus

4. Vérifier la redirection vers le dashboard approprié

---

## 📊 Hiérarchie des Rôles

```
Super Admin (Accès total)
    ↓
Admin (Entreprise)
    ↓
Restaurant Manager (Restaurant)
    ↓
Agent (Commercial/Support)
    ↓
Employee (Employé)
    ↓
Driver (Livreur)
```

---

## 🎯 URLs des Dashboards

| Rôle | URL Dashboard |
|------|---------------|
| Super Admin | http://localhost:5173/admin/super-admin |
| Admin | http://localhost:5173/admin/dashboard |
| Restaurant Manager | http://localhost:5173/admin/restaurant |
| Agent | http://localhost:5173/admin/agent |
| Driver | http://localhost:5173/driver |
| POS | http://localhost:5173/pos |
| Kiosk | http://localhost:5173/kiosk |

---

## 🔒 Sécurité

**⚠️ Important pour la Production:**

1. **Changer tous les mots de passe** avant le déploiement
2. **Supprimer les comptes de test** en production
3. **Utiliser des variables d'environnement** pour les mots de passe
4. **Activer l'authentification à deux facteurs** (2FA)
5. **Configurer les restrictions IP** si nécessaire

---

## 📝 Notes

- Tous les utilisateurs sont liés à la même entreprise "Groupe Restaurant Dakar"
- Les restaurants "Le Teranga", "Café des Arts" et "Fast Food Lagon" sont pré-créés
- Chaque restaurant a 10 tables configurées
- Les menus et produits sont pré-remplis
- 5 livreurs sont disponibles (3 en ligne, 2 hors ligne)

---

## 🆘 Problèmes Courants

### Connexion Refusée
- Vérifier que la base de données est bien seeded
- Vérifier que les rôles sont créés
- Exécuter `php artisan migrate:fresh --seed`

### Redirection Incorrecte
- Vérifier le rôle de l'utilisateur
- Vérifier les routes dans `router/index.js`
- Vérifier le middleware d'authentification

### Erreur 403 (Accès Refusé)
- Vérifier que l'utilisateur a le bon rôle
- Vérifier les permissions dans les routes
- Vérifier le guard de navigation

---

## 📞 Support

Pour toute question concernant les identifiants de test ou l'authentification, consultez la documentation dans:
- `DASHBOARDS_GUIDE.md`
- `QUICK_START_DASHBOARDS.md`

---

**Dernière mise à jour:** Octobre 2025  
**Version:** 1.0.0

