# 🚀 Guide d'Implémentation Soketi + Cloudflare R2

**Date :** 22 Octobre 2025  
**Projet :** RestoConnect360  
**Objectif :** Ajouter temps réel (WebSockets) et storage cloud

---

## 📋 Table des Matières

1. [Vue d'ensemble](#vue-densemble)
2. [Prérequis](#prérequis)
3. [Phase 1 : Configuration Soketi](#phase-1--configuration-soketi)
4. [Phase 2 : Configuration Cloudflare R2](#phase-2--configuration-cloudflare-r2)
5. [Phase 3 : Événements Temps Réel](#phase-3--événements-temps-réel)
6. [Phase 4 : Tests](#phase-4--tests)
7. [Troubleshooting](#troubleshooting)

---

## 🎯 Vue d'ensemble

### Qu'est-ce que Soketi ?
**Soketi** est un serveur WebSocket open-source, compatible avec Pusher, conçu pour Laravel. Il permet la communication temps réel entre le serveur et les clients.

**Cas d'usage pour RestoConnect360 :**
- 📱 Notifications live aux clients (commande prête, livreur en route)
- 👨‍🍳 Updates cuisine en temps réel
- 🚚 Suivi livreur sur carte
- 📊 Dashboard live (nouvelles commandes)
- 💬 Chat support instantané

### Qu'est-ce que Cloudflare R2 ?
**R2** est le service de stockage S3-compatible de Cloudflare, sans frais de sortie.

**Cas d'usage pour RestoConnect360 :**
- 🖼️ Images menus et produits
- 🎨 Logos white label
- 📱 QR codes générés
- 🧾 Factures PDF
- 📸 Photos utilisateurs

---

## ✅ Prérequis

### Système
- [x] Docker installé et fonctionnel
- [x] Node.js 18+ installé
- [x] Composer installé
- [x] Git configuré
- [x] Repository GitHub protégé

### Comptes requis
- [ ] Compte Cloudflare (gratuit) - https://dash.cloudflare.com/sign-up
- [ ] Accès au projet RestoConnect360

### Connaissances requises
- ⚠️ Aucune expertise technique requise
- ✅ Je vous guide à chaque étape
- ✅ Validation avant chaque modification

---

## 🎪 Phase 1 : Configuration Soketi

### Pourquoi Soketi et pas Pusher ?
| Critère | Soketi | Pusher |
|---------|--------|--------|
| **Coût** | Gratuit ✅ | $49-$499/mois 💸 |
| **Hébergement** | Auto-hébergé ✅ | Cloud uniquement |
| **Limites** | Aucune ✅ | 100-500 connexions |
| **Open Source** | Oui ✅ | Non ❌ |
| **Performance** | Excellente ✅ | Excellente ✅ |

### Étape 1.1 : Installation du package Laravel

**Fichiers à modifier :**
- `composer.json` (ajouter dépendance)

**Commande à exécuter :**
```bash
cd afriflux-restoconnect360
composer require pusher/pusher-php-server
```

**Ce que ça fait :**
- Installe le client Pusher/Soketi pour Laravel
- Aucun impact sur le code existant
- Réversible si problème

**Risques :** 🟢 Aucun (juste une installation)

---

### Étape 1.2 : Création du fichier de configuration Broadcasting

**Fichier à créer :**
- `config/broadcasting.php`

**Contenu :**
```php
<?php

return [
    'default' => env('BROADCAST_CONNECTION', 'pusher'),

    'connections' => [
        'pusher' => [
            'driver' => 'pusher',
            'key' => env('PUSHER_APP_KEY'),
            'secret' => env('PUSHER_APP_SECRET'),
            'app_id' => env('PUSHER_APP_ID'),
            'options' => [
                'host' => env('PUSHER_HOST', '127.0.0.1'),
                'port' => env('PUSHER_PORT', 6001),
                'scheme' => env('PUSHER_SCHEME', 'http'),
                'encrypted' => true,
                'useTLS' => env('PUSHER_SCHEME', 'http') === 'https',
            ],
            'client_options' => [
                // Configuration Guzzle
            ],
        ],

        'log' => [
            'driver' => 'log',
        ],

        'null' => [
            'driver' => 'null',
        ],
    ],
];
```

**Ce que ça fait :**
- Configure les WebSockets pour Laravel
- Pointe vers Soketi (host local)
- Compatible avec l'environnement existant

**Risques :** 🟢 Aucun (fichier de config seulement)

---

### Étape 1.3 : Mise à jour du fichier .env

**Fichier à modifier :**
- `.env.example` (template)
- `.env` (votre config locale)

**Lignes à ajouter/modifier :**
```env
# Broadcasting - Soketi (WebSocket Real-time)
BROADCAST_CONNECTION=pusher
PUSHER_APP_ID=restoconnect360
PUSHER_APP_KEY=restoconnect360key
PUSHER_APP_SECRET=restoconnect360secret
PUSHER_HOST=127.0.0.1
PUSHER_PORT=6001
PUSHER_SCHEME=http
PUSHER_APP_CLUSTER=mt1
```

**Ce que ça fait :**
- Active le broadcasting dans Laravel
- Configure les identifiants Soketi (locaux pour le moment)
- Aucun impact si Soketi n'est pas démarré

**Risques :** 🟢 Aucun (variables d'environnement)

---

### Étape 1.4 : Configuration Docker avec Soketi

**Fichier à modifier :**
- `docker-compose.yml`

**Service à ajouter :**
```yaml
  soketi:
    image: quay.io/soketi/soketi:1.6-16-debian
    container_name: afriflux-soketi
    ports:
      - "6001:6001"
      - "9601:9601"  # Metrics
    environment:
      SOKETI_DEBUG: 1
      SOKETI_DEFAULT_APP_ID: restoconnect360
      SOKETI_DEFAULT_APP_KEY: restoconnect360key
      SOKETI_DEFAULT_APP_SECRET: restoconnect360secret
      SOKETI_USER_AUTHENTICATION_TIMEOUT: 30000
    networks:
      - afriflux-network
    restart: unless-stopped
```

**Ce que ça fait :**
- Ajoute un conteneur Soketi à votre stack
- Expose le port 6001 pour WebSocket
- Expose le port 9601 pour monitoring
- Se lance automatiquement avec `docker-compose up`

**Risques :** 🟡 Mineur (nouveau service)
- Si erreur, juste arrêter le conteneur

---

### Étape 1.5 : Activation du BroadcastServiceProvider

**Fichier à modifier :**
- `config/app.php`

**Ligne à décommenter :**
```php
'providers' => ServiceProvider::defaultProviders()->merge([
    // ...
    App\Providers\BroadcastServiceProvider::class, // ← Décommenter cette ligne
])->toArray(),
```

**Ce que ça fait :**
- Active le système de broadcasting dans Laravel
- Nécessaire pour envoyer des événements temps réel

**Risques :** 🟢 Aucun (juste activation d'un provider)

---

### Étape 1.6 : Création du fichier routes/channels.php

**Fichier à créer :**
- `routes/channels.php`

**Contenu :**
```php
<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Définition des canaux de broadcasting et leurs autorisations.
|
*/

// Canal privé pour un commerce spécifique
Broadcast::channel('commerce.{commerceId}', function ($user, $commerceId) {
    return $user->commerce_id === (int) $commerceId;
});

// Canal privé pour une commande spécifique
Broadcast::channel('order.{orderId}', function ($user, $orderId) {
    return $user->orders()->where('id', $orderId)->exists();
});

// Canal privé pour un utilisateur spécifique
Broadcast::channel('user.{userId}', function ($user, $userId) {
    return $user->id === (int) $userId;
});

// Canal public pour les notifications générales
Broadcast::channel('notifications', function () {
    return true;
});
```

**Ce que ça fait :**
- Définit les canaux de communication temps réel
- Sécurise l'accès aux canaux privés
- Permet le broadcast d'événements

**Risques :** 🟢 Aucun (routes de canaux seulement)

---

### Étape 1.7 : Test de la configuration Soketi

**Commandes de test :**
```bash
# 1. Démarrer Soketi
docker-compose up -d soketi

# 2. Vérifier que Soketi fonctionne
curl http://localhost:6001/

# 3. Tester depuis Laravel
php artisan tinker
>>> broadcast(new App\Events\TestEvent());
```

**Résultat attendu :**
```json
{
  "name": "Soketi",
  "version": "1.6.0"
}
```

**En cas d'erreur :**
- Vérifier que le port 6001 n'est pas utilisé : `lsof -i :6001`
- Relancer Docker : `docker-compose restart soketi`
- Vérifier les logs : `docker-compose logs soketi`

---

## ☁️ Phase 2 : Configuration Cloudflare R2

### Pourquoi Cloudflare R2 et pas AWS S3 ?

| Critère | Cloudflare R2 | AWS S3 |
|---------|---------------|--------|
| **Frais de sortie** | 0€ ✅ | ~$90/TB 💸 |
| **Performance** | Excellent ✅ | Excellent ✅ |
| **Prix stockage** | $0.015/GB 💰 | $0.023/GB |
| **Compatible S3** | Oui ✅ | Natif ✅ |
| **CDN intégré** | Oui ✅ | CloudFront séparé |

**Économie estimée pour RestoConnect360 :**
- 100 GB de stockage
- 1 TB de bande passante/mois
- **R2 :** $1.50/mois
- **S3 :** $92.30/mois
- **Économie :** $90.80/mois (98% moins cher !)

---

### Étape 2.1 : Création du Bucket R2

**Procédure manuelle (5 min) :**

1. **Connectez-vous à Cloudflare Dashboard**
   - URL : https://dash.cloudflare.com
   - Si pas de compte : créez-en un (gratuit)

2. **Accédez à R2**
   - Dans le menu latéral → **R2**
   - Cliquez sur **Create Bucket**

3. **Configuration du Bucket**
   - **Bucket Name** : `restoconnect360-production`
   - **Location** : Automatic (optimal)
   - Cliquez sur **Create Bucket**

4. **Notez l'Endpoint URL**
   - Format : `https://<account-id>.r2.cloudflarestorage.com`
   - Exemple : `https://abc123.r2.cloudflarestorage.com`

**Résultat attendu :**
✅ Bucket créé avec succès  
✅ Endpoint URL disponible

---

### Étape 2.2 : Génération des clés d'accès API

**Procédure manuelle (3 min) :**

1. **Dans la page R2, cliquez sur "Manage R2 API Tokens"**
2. **Cliquez sur "Create API Token"**
3. **Configuration :**
   - **Token Name** : `restoconnect360-api`
   - **Permissions** : Object Read & Write
   - **Bucket** : `restoconnect360-production`
4. **Cliquez sur "Create API Token"**

5. **⚠️ IMPORTANT : Copiez immédiatement ces informations**
   ```
   Access Key ID: xxxxxxxxxxxxxxxxxxxx
   Secret Access Key: yyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyy
   Endpoint: https://abc123.r2.cloudflarestorage.com
   ```

**⚠️ Le Secret ne sera plus jamais affiché ! Sauvegardez-le en sécurité.**

---

### Étape 2.3 : Installation du package AWS S3 pour Laravel

**Commande à exécuter :**
```bash
cd afriflux-restoconnect360
composer require league/flysystem-aws-s3-v3 "^3.0"
```

**Ce que ça fait :**
- Installe le driver S3 pour Laravel
- Compatible avec Cloudflare R2 (API S3)
- Aucun impact sur le code existant

**Risques :** 🟢 Aucun (juste une installation)

---

### Étape 2.4 : Configuration R2 dans filesystems.php

**Fichier à modifier :**
- `config/filesystems.php`

**Disque à ajouter :**
```php
'disks' => [
    // ... autres disks existants

    'r2' => [
        'driver' => 's3',
        'key' => env('R2_ACCESS_KEY_ID'),
        'secret' => env('R2_SECRET_ACCESS_KEY'),
        'region' => 'auto',
        'bucket' => env('R2_BUCKET'),
        'endpoint' => env('R2_ENDPOINT'),
        'use_path_style_endpoint' => false,
        'throw' => false,
        'visibility' => 'public',
    ],
],
```

**Ce que ça fait :**
- Ajoute R2 comme option de stockage
- Configure la compatibilité S3
- Permet l'usage via `Storage::disk('r2')`

**Risques :** 🟢 Aucun (nouvelle config seulement)

---

### Étape 2.5 : Mise à jour du fichier .env avec R2

**Fichier à modifier :**
- `.env.example` (template)
- `.env` (votre config locale)

**Lignes à ajouter :**
```env
# Cloudflare R2 Storage
FILESYSTEM_DISK=r2
R2_ACCESS_KEY_ID=your_r2_access_key_id
R2_SECRET_ACCESS_KEY=your_r2_secret_access_key
R2_BUCKET=restoconnect360-production
R2_ENDPOINT=https://your-account-id.r2.cloudflarestorage.com
R2_PUBLIC_URL=https://r2.restoconnect360.com
```

**⚠️ Remplacez les valeurs avec celles notées à l'étape 2.2**

**Ce que ça fait :**
- Active R2 comme système de fichiers par défaut
- Configure les accès sécurisés
- Définit l'URL publique des fichiers

**Risques :** 🟢 Aucun (variables d'environnement)

---

### Étape 2.6 : Configuration du domaine personnalisé (Optionnel)

**Avantages :**
- URLs propres : `https://cdn.restoconnect360.com/images/menu.jpg`
- Cache CDN Cloudflare gratuit
- Certificat SSL automatique

**Procédure (si vous avez un domaine) :**

1. Dans R2 Dashboard → Votre bucket → **Settings**
2. Section **Custom Domains** → **Connect Domain**
3. Entrez : `cdn.restoconnect360.com` (ou sous-domaine de votre choix)
4. Cloudflare configure automatiquement le DNS
5. Certificat SSL activé sous 5 minutes

**Si vous n'avez pas de domaine :**
- Utilisez l'endpoint R2 direct
- Fonctionne parfaitement, juste moins "pro"

---

### Étape 2.7 : Test de R2

**Test depuis Tinker :**
```bash
php artisan tinker
```

```php
// Test 1 : Upload fichier
Storage::disk('r2')->put('test.txt', 'Hello RestoConnect360!');

// Test 2 : Vérifier existence
Storage::disk('r2')->exists('test.txt'); // true

// Test 3 : Récupérer URL publique
Storage::disk('r2')->url('test.txt');
// https://your-account.r2.cloudflarestorage.com/restoconnect360-production/test.txt

// Test 4 : Supprimer fichier de test
Storage::disk('r2')->delete('test.txt');
```

**Résultat attendu :**
```
= true
```

**En cas d'erreur :**
- Vérifier les credentials R2 dans `.env`
- Vérifier les permissions du token API
- Vérifier le nom du bucket

---

## 🎪 Phase 3 : Événements Temps Réel

### Cas d'usage : Notification nouvelle commande

Nous allons créer un événement qui notifie en temps réel :
- 👨‍🍳 La cuisine quand une nouvelle commande arrive
- 🏪 Le dashboard commerce
- 📱 L'application mobile (si implémentée)

---

### Étape 3.1 : Création de l'événement OrderCreated

**Commande à exécuter :**
```bash
cd afriflux-restoconnect360
php artisan make:event OrderCreated
```

**Fichier créé :**
- `app/Events/OrderCreated.php`

**Contenu à modifier :**
```php
<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;

    /**
     * Créer une nouvelle instance de l'événement
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Canal(aux) sur lesquels diffuser l'événement
     */
    public function broadcastOn(): Channel|array
    {
        return [
            new PrivateChannel('commerce.' . $this->order->commerce_id),
        ];
    }

    /**
     * Nom de l'événement à diffuser
     */
    public function broadcastAs(): string
    {
        return 'order.created';
    }

    /**
     * Données à diffuser avec l'événement
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->order->id,
            'number' => $this->order->order_number,
            'total' => $this->order->total_amount,
            'status' => $this->order->status,
            'customer' => $this->order->customer->name ?? 'Guest',
            'created_at' => $this->order->created_at->toISOString(),
        ];
    }
}
```

**Ce que ça fait :**
- Crée un événement broadcastable
- Envoie les données de commande en temps réel
- Sécurisé par canal privé (seul le commerce concerné reçoit)

**Risques :** 🟢 Aucun (classe d'événement seulement)

---

### Étape 3.2 : Déclenchement de l'événement

**Fichier à modifier :**
- `app/Http/Controllers/OrderController.php` (ou là où vous créez les commandes)

**Code à ajouter après création de commande :**
```php
use App\Events\OrderCreated;

public function store(Request $request)
{
    // ... votre logique de création de commande existante
    $order = Order::create([...]);

    // 🚀 Nouveau : Broadcast de l'événement
    broadcast(new OrderCreated($order))->toOthers();

    return response()->json($order, 201);
}
```

**Ce que ça fait :**
- Déclenche l'événement après création de commande
- `toOthers()` évite de notifier le créateur lui-même
- Tous les clients connectés au canal reçoivent la notification

**Risques :** 🟢 Aucun (si Soketi n'est pas lancé, pas d'erreur)

---

### Étape 3.3 : Écoute de l'événement côté frontend

**Fichier JavaScript/Vue à créer/modifier :**
```javascript
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

// Configuration Echo
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    wsHost: import.meta.env.VITE_PUSHER_HOST,
    wsPort: import.meta.env.VITE_PUSHER_PORT,
    wssPort: import.meta.env.VITE_PUSHER_PORT,
    forceTLS: false,
    encrypted: true,
    disableStats: true,
    enabledTransports: ['ws', 'wss'],
});

// Écoute du canal privé
Echo.private(`commerce.${commerceId}`)
    .listen('.order.created', (e) => {
        console.log('Nouvelle commande reçue !', e);
        // Afficher une notification
        // Jouer un son
        // Rafraîchir la liste des commandes
    });
```

**Packages NPM requis :**
```bash
npm install --save laravel-echo pusher-js
```

**Ce que ça fait :**
- Se connecte au serveur Soketi
- Écoute les événements sur le canal du commerce
- Réagit en temps réel aux nouvelles commandes

**Risques :** 🟡 Mineur (vérifier la config frontend)

---

## ✅ Phase 4 : Tests

### Test 1 : Soketi fonctionne

```bash
# Vérifier que Soketi tourne
docker-compose ps soketi

# Doit afficher : Up (healthy)
```

### Test 2 : Broadcasting Laravel

```bash
php artisan tinker
```

```php
broadcast(new \App\Events\OrderCreated(\App\Models\Order::first()));
```

**Résultat attendu :**  
Aucune erreur = ✅

### Test 3 : R2 Storage

```bash
php artisan tinker
```

```php
Storage::disk('r2')->put('test-image.jpg', file_get_contents('https://via.placeholder.com/150'));
Storage::disk('r2')->url('test-image.jpg');
```

**Résultat attendu :**  
URL publique de l'image = ✅

### Test 4 : Bout en bout (E2E)

1. Ouvrir 2 navigateurs
2. Se connecter avec 2 comptes du même commerce
3. Créer une commande dans le navigateur 1
4. Vérifier notification temps réel dans navigateur 2

**Résultat attendu :**  
Notification instantanée = ✅

---

## 🔧 Troubleshooting

### Problème : Soketi ne démarre pas

**Symptôme :**
```
Error: Port 6001 already in use
```

**Solution :**
```bash
# Trouver le processus
lsof -i :6001

# Tuer le processus
kill -9 <PID>

# Redémarrer
docker-compose up -d soketi
```

---

### Problème : R2 "Access Denied"

**Symptôme :**
```
AccessDenied: Access Denied
```

**Solutions :**
1. Vérifier les credentials dans `.env`
2. Vérifier les permissions du token API
3. Vérifier le nom du bucket (sensible à la casse)
4. Régénérer un nouveau token API

---

### Problème : Broadcasting ne fonctionne pas

**Checklist :**
- [ ] `BROADCAST_CONNECTION=pusher` dans `.env`
- [ ] `BroadcastServiceProvider` décommenté dans `config/app.php`
- [ ] Soketi tourne : `docker-compose ps soketi`
- [ ] Event implémente `ShouldBroadcast`
- [ ] Canal défini dans `routes/channels.php`

---

## 🎓 Commandes Utiles

### Soketi
```bash
# Démarrer
docker-compose up -d soketi

# Arrêter
docker-compose stop soketi

# Logs
docker-compose logs -f soketi

# Redémarrer
docker-compose restart soketi
```

### Laravel Broadcasting
```bash
# Tester un événement
php artisan tinker
>>> broadcast(new App\Events\TestEvent());

# Lister les routes de broadcasting
php artisan route:list --name=broadcasting

# Clear cache
php artisan config:clear
php artisan cache:clear
```

### R2 Storage
```bash
# Test upload via Tinker
php artisan tinker
>>> Storage::disk('r2')->put('test.txt', 'Hello');
>>> Storage::disk('r2')->url('test.txt');
```

---

## 📊 Checklist Finale

### Configuration Soketi
- [ ] Package `pusher/pusher-php-server` installé
- [ ] `config/broadcasting.php` créé
- [ ] Variables `.env` configurées
- [ ] Service Soketi dans `docker-compose.yml`
- [ ] `BroadcastServiceProvider` activé
- [ ] `routes/channels.php` créé
- [ ] Soketi démarre sans erreur

### Configuration R2
- [ ] Bucket Cloudflare R2 créé
- [ ] Token API généré et noté
- [ ] Package `league/flysystem-aws-s3-v3` installé
- [ ] Disk R2 dans `config/filesystems.php`
- [ ] Variables `.env` configurées
- [ ] Test upload réussi

### Événements
- [ ] Événement `OrderCreated` créé
- [ ] Événement déclenché après création commande
- [ ] Frontend configuré avec Echo
- [ ] Test bout en bout réussi

---

## 🚀 Prochaines Étapes Suggérées

1. **Créer plus d'événements**
   - `OrderStatusUpdated` (changement statut)
   - `DeliveryLocationUpdated` (position livreur)
   - `PaymentReceived` (paiement confirmé)

2. **Optimiser R2**
   - Configurer domaine personnalisé
   - Ajouter compression d'images
   - Implémenter cache local

3. **Monitoring**
   - Ajouter Soketi metrics dashboard
   - Surveiller usage R2
   - Logs centralisés

---

## 📞 Support

En cas de problème :
1. Vérifier la section [Troubleshooting](#troubleshooting)
2. Consulter les logs : `docker-compose logs`
3. Tester étape par étape
4. Demander de l'aide dans le chat

---

**Guide créé le 22 Octobre 2025**  
**Version 1.0**  
**RestoConnect360 - Afriflux**

🎉 **Bonne implémentation !**
