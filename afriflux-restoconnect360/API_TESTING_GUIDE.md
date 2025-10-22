# 🧪 **GUIDE DE TEST API - RESTOCONNECT360**

## 🚀 **Tests avec Postman / Insomnia**

### **Configuration de Base**

1. **Créer une collection Postman**
2. **Variable d'environnement** :
   - `BASE_URL` : `http://localhost:8000`
   - `TOKEN` : (sera rempli après login)

---

## 📋 **TESTS COMPLETS**

### **1. AUTHENTIFICATION**

#### **Register (Inscription)**
```http
POST {{BASE_URL}}/api/register
Content-Type: application/json

{
  "name": "Test User",
  "email": "test@example.com",
  "password": "password",
  "password_confirmation": "password",
  "phone": "+221771234567"
}
```

**Réponse attendue :**
```json
{
  "success": true,
  "user": { ... },
  "token": "1|abcd..."
}
```

#### **Login (Connexion)**
```http
POST {{BASE_URL}}/api/login
Content-Type: application/json

{
  "email": "admin@restoconnect360.com",
  "password": "password"
}
```

**Réponse attendue :**
```json
{
  "success": true,
  "user": {
    "id": 1,
    "name": "Admin RestoConnect360",
    "email": "admin@restoconnect360.com",
    "roles": [...]
  },
  "token": "2|xyz..."
}
```

**⚠️ Copier le token et le mettre dans la variable `TOKEN`**

#### **Me (Utilisateur connecté)**
```http
GET {{BASE_URL}}/api/me
Authorization: Bearer {{TOKEN}}
```

#### **Logout (Déconnexion)**
```http
POST {{BASE_URL}}/api/logout
Authorization: Bearer {{TOKEN}}
```

---

### **2. RESTAURANTS**

#### **Liste des restaurants**
```http
GET {{BASE_URL}}/api/restaurants
```

#### **Restaurants à proximité**
```http
GET {{BASE_URL}}/api/restaurants/nearby?latitude=14.7167&longitude=-17.4677&radius=10
```

#### **Détails d'un restaurant**
```http
GET {{BASE_URL}}/api/restaurants/1
```

#### **Menu d'un restaurant**
```http
GET {{BASE_URL}}/api/restaurants/1/menu
```

#### **Créer un restaurant** (Auth requise)
```http
POST {{BASE_URL}}/api/restaurants
Authorization: Bearer {{TOKEN}}
Content-Type: application/json

{
  "company_id": 1,
  "name": "Nouveau Restaurant",
  "slug": "nouveau-restaurant",
  "address": "123 Rue Test, Dakar",
  "city": "Dakar",
  "latitude": 14.7167,
  "longitude": -17.4677,
  "category": "restaurant"
}
```

---

### **3. COMMANDES**

#### **Créer une commande** (Auth requise)
```http
POST {{BASE_URL}}/api/orders
Authorization: Bearer {{TOKEN}}
Content-Type: application/json

{
  "restaurant_id": 1,
  "order_type": "delivery",
  "items": [
    {
      "product_id": 1,
      "quantity": 2
    },
    {
      "product_id": 2,
      "quantity": 1
    }
  ],
  "customer_name": "Jean Dupont",
  "customer_phone": "+221771234567",
  "customer_email": "jean@example.com",
  "delivery_address": "Plateau, Dakar",
  "delivery_latitude": 14.6928,
  "delivery_longitude": -17.4467,
  "customer_notes": "Sonnez à la porte"
}
```

#### **Lister les commandes**
```http
GET {{BASE_URL}}/api/orders
Authorization: Bearer {{TOKEN}}
```

#### **Détails d'une commande**
```http
GET {{BASE_URL}}/api/orders/1
Authorization: Bearer {{TOKEN}}
```

#### **Mettre à jour le statut**
```http
PUT {{BASE_URL}}/api/orders/1/status
Authorization: Bearer {{TOKEN}}
Content-Type: application/json

{
  "status": "confirmed"
}
```

**Statuts disponibles :**
- `pending` - En attente
- `confirmed` - Confirmée
- `preparing` - En préparation
- `ready` - Prête
- `on_delivery` - En livraison
- `completed` - Terminée
- `cancelled` - Annulée

#### **Annuler une commande**
```http
POST {{BASE_URL}}/api/orders/1/cancel
Authorization: Bearer {{TOKEN}}
Content-Type: application/json

{
  "reason": "Client a changé d'avis"
}
```

---

### **4. PAIEMENTS**

#### **Initialiser un paiement CinetPay**
```http
POST {{BASE_URL}}/api/payments/initialize
Authorization: Bearer {{TOKEN}}
Content-Type: application/json

{
  "order_id": 1,
  "payment_method": "cinetpay",
  "customer_name": "Jean Dupont",
  "customer_phone": "+221771234567",
  "customer_email": "jean@example.com"
}
```

#### **Initialiser un paiement PayTech**
```http
POST {{BASE_URL}}/api/payments/initialize
Authorization: Bearer {{TOKEN}}
Content-Type: application/json

{
  "order_id": 1,
  "payment_method": "paytech",
  "customer_name": "Jean Dupont",
  "customer_phone": "+221771234567"
}
```

#### **Paiement en espèces**
```http
POST {{BASE_URL}}/api/payments/initialize
Authorization: Bearer {{TOKEN}}
Content-Type: application/json

{
  "order_id": 1,
  "payment_method": "cash",
  "customer_name": "Jean Dupont",
  "customer_phone": "+221771234567"
}
```

#### **Statut d'un paiement**
```http
GET {{BASE_URL}}/api/payments/1/status
Authorization: Bearer {{TOKEN}}
```

---

### **5. LIVRAISON**

#### **Liste des livraisons**
```http
GET {{BASE_URL}}/api/deliveries
Authorization: Bearer {{TOKEN}}
```

#### **Détails d'une livraison**
```http
GET {{BASE_URL}}/api/deliveries/1
Authorization: Bearer {{TOKEN}}
```

#### **Assigner un livreur**
```http
POST {{BASE_URL}}/api/deliveries/1/assign
Authorization: Bearer {{TOKEN}}
Content-Type: application/json

{
  "driver_id": 1
}
```

#### **Mettre à jour le statut de livraison**
```http
PUT {{BASE_URL}}/api/deliveries/1/status
Authorization: Bearer {{TOKEN}}
Content-Type: application/json

{
  "status": "picked_up"
}
```

**Statuts disponibles :**
- `assigned` - Assignée
- `picked_up` - Récupérée
- `on_delivery` - En cours
- `delivered` - Livrée
- `cancelled` - Annulée

#### **Tracking en temps réel**
```http
GET {{BASE_URL}}/api/deliveries/1/track
Authorization: Bearer {{TOKEN}}
```

---

### **6. LIVREURS**

#### **Liste des livreurs**
```http
GET {{BASE_URL}}/api/drivers
Authorization: Bearer {{TOKEN}}
```

#### **Livreurs disponibles uniquement**
```http
GET {{BASE_URL}}/api/drivers?available=1
Authorization: Bearer {{TOKEN}}
```

#### **Détails d'un livreur**
```http
GET {{BASE_URL}}/api/drivers/1
Authorization: Bearer {{TOKEN}}
```

#### **Mettre à jour la position** (En tant que livreur)
```http
POST {{BASE_URL}}/api/driver/location
Authorization: Bearer {{DRIVER_TOKEN}}
Content-Type: application/json

{
  "latitude": 14.7167,
  "longitude": -17.4677
}
```

#### **Changer le statut** (En tant que livreur)
```http
PUT {{BASE_URL}}/api/driver/status
Authorization: Bearer {{DRIVER_TOKEN}}
Content-Type: application/json

{
  "status": "online"
}
```

**Statuts disponibles :**
- `online` - En ligne
- `offline` - Hors ligne
- `on_break` - En pause

#### **Mes livraisons** (En tant que livreur)
```http
GET {{BASE_URL}}/api/driver/deliveries
Authorization: Bearer {{DRIVER_TOKEN}}
```

#### **Mes statistiques** (En tant que livreur)
```http
GET {{BASE_URL}}/api/driver/stats?period=today
Authorization: Bearer {{DRIVER_TOKEN}}
```

**Périodes disponibles :**
- `today` - Aujourd'hui
- `week` - Cette semaine
- `month` - Ce mois

---

## ✅ **SCÉNARIO DE TEST COMPLET**

### **Scénario : Commande complète avec livraison**

1. **Se connecter**
   ```http
   POST /api/login
   {"email": "admin@restoconnect360.com", "password": "password"}
   ```

2. **Rechercher un restaurant**
   ```http
   GET /api/restaurants/nearby?latitude=14.7167&longitude=-17.4677&radius=10
   ```

3. **Voir le menu**
   ```http
   GET /api/restaurants/1/menu
   ```

4. **Créer une commande**
   ```http
   POST /api/orders
   {
     "restaurant_id": 1,
     "order_type": "delivery",
     "items": [{"product_id": 1, "quantity": 2}],
     "customer_name": "Test",
     "customer_phone": "+221771234567",
     "delivery_address": "Dakar",
     "delivery_latitude": 14.7167,
     "delivery_longitude": -17.4677
   }
   ```

5. **Confirmer la commande**
   ```http
   PUT /api/orders/1/status
   {"status": "confirmed"}
   ```

6. **Initialiser le paiement**
   ```http
   POST /api/payments/initialize
   {
     "order_id": 1,
     "payment_method": "cash",
     "customer_name": "Test",
     "customer_phone": "+221771234567"
   }
   ```

7. **Voir les livraisons**
   ```http
   GET /api/deliveries
   ```

8. **Assigner un livreur**
   ```http
   POST /api/deliveries/1/assign
   {"driver_id": 1}
   ```

9. **Mettre à jour le statut de livraison**
   ```http
   PUT /api/deliveries/1/status
   {"status": "picked_up"}
   ```

10. **Tracker la livraison**
    ```http
    GET /api/deliveries/1/track
    ```

---

## 🔍 **VÉRIFICATIONS**

### **✅ Checklist de test**

- [ ] Inscription fonctionne
- [ ] Connexion fonctionne
- [ ] Liste des restaurants fonctionne
- [ ] Recherche géolocalisée fonctionne
- [ ] Création de commande fonctionne
- [ ] Calcul des totaux est correct
- [ ] Création de livraison automatique
- [ ] Assignation de livreur fonctionne
- [ ] Mise à jour de statut fonctionne
- [ ] Paiement cash fonctionne

---

## 📊 **CODES DE RÉPONSE**

- `200` - Succès
- `201` - Créé avec succès
- `400` - Erreur de requête
- `401` - Non authentifié
- `403` - Non autorisé
- `404` - Non trouvé
- `422` - Erreur de validation
- `500` - Erreur serveur

---

**✨ L'API est complète et prête à être testée !**

