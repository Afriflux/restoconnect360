# 🗺️ Configuration Google Maps (Optionnel)

**Date :** 16 Octobre 2025  
**Statut :** ⚠️ **OPTIONNEL - L'application fonctionne sans**

---

## ℹ️ **INFORMATION IMPORTANTE**

**L'application RestoConnect360 fonctionne parfaitement SANS Google Maps !**

Google Maps n'est nécessaire que pour la fonctionnalité "Trouver un Magasin" avec carte interactive.
Toutes les autres fonctionnalités sont 100% opérationnelles :
- ✅ POS (Point de Vente)
- ✅ Kiosque
- ✅ Livraison GPS
- ✅ Restaurants
- ✅ Commandes
- ✅ Paiements
- ✅ Dashboard

---

## 🔑 **Obtenir une clé API Google Maps (si nécessaire)**

### **Étape 1 : Créer un projet Google Cloud**

1. Allez sur : https://console.cloud.google.com/
2. Créez un nouveau projet ou sélectionnez un projet existant
3. Nom du projet : `RestoConnect360`

### **Étape 2 : Activer les APIs**

1. Dans le menu, allez dans **APIs & Services** > **Library**
2. Activez ces APIs :
   - ✅ **Maps JavaScript API**
   - ✅ **Geocoding API**
   - ✅ **Places API**
   - ✅ **Directions API**

### **Étape 3 : Créer une clé API**

1. Allez dans **APIs & Services** > **Credentials**
2. Cliquez sur **Create Credentials** > **API Key**
3. Copiez la clé générée (ex: `AIzaSyBxxxxxxxxxxxxxxxxxxxxxx`)

### **Étape 4 : Restreindre la clé (recommandé)**

1. Cliquez sur la clé créée
2. **Application restrictions** :
   - Sélectionnez **HTTP referrers**
   - Ajoutez : `http://localhost:8000/*`
   - Ajoutez : `https://www.restoconnect360.com/*`

3. **API restrictions** :
   - Sélectionnez **Restrict key**
   - Cochez les 4 APIs activées précédemment

---

## ⚙️ **Configuration dans RestoConnect360**

### **Option 1 : Via le fichier .env (Recommandé)**

```bash
# Ouvrez le fichier .env
nano .env

# Ajoutez cette ligne
GOOGLE_MAPS_API_KEY=AIzaSyBxxxxxxxxxxxxxxxxxxxxxx

# Sauvegardez (Ctrl+O, Enter, Ctrl+X)
```

### **Option 2 : Via la configuration Laravel**

```bash
# Ouvrez config/services.php
nano config/services.php
```

Vérifiez que cette section existe :
```php
'google_maps' => [
    'api_key' => env('GOOGLE_MAPS_API_KEY'),
],
```

---

## 🔄 **Redémarrer l'application**

```bash
# Arrêter les serveurs
pkill -f "vite"
pkill -f "php artisan serve"

# Redémarrer
# Terminal 1
php artisan serve

# Terminal 2
npm run dev
```

---

## 🧪 **Tester**

1. Ouvrez : http://localhost:8000/find-store
2. Cliquez sur "Utiliser ma position"
3. La carte Google Maps devrait s'afficher

---

## 💡 **Alternative GRATUITE (Sans Google Maps)**

Si vous ne voulez pas utiliser Google Maps, nous utilisons déjà :

### **Leaflet + OpenStreetMap**
- ✅ 100% Gratuit
- ✅ Pas de clé API nécessaire
- ✅ Fonctionne déjà dans l'application

**Aucune configuration requise !**

---

## 💰 **Tarification Google Maps**

### **Quota GRATUIT**
- **Maps JavaScript API** : $200/mois de crédit gratuit
- **Geocoding API** : $200/mois de crédit gratuit
- Suffisant pour ~28,000 chargements de carte/mois

### **Au-delà du quota gratuit**
- Maps JavaScript API : $7 / 1,000 chargements
- Geocoding API : $5 / 1,000 requêtes
- Directions API : $10 / 1,000 requêtes

**💡 Conseil :** Activez les alertes de facturation pour éviter les surprises

---

## 🎯 **Utilisation dans RestoConnect360**

### **Fonctionnalités utilisant Google Maps (optionnel)**
- 🗺️ Page "Trouver un Magasin" avec carte interactive
- 📍 Calcul de distances et directions
- 🔍 Recherche de lieux et adresses

### **Fonctionnalités ne nécessitant PAS Google Maps**
- ✅ POS complet
- ✅ Gestion restaurants
- ✅ Gestion commandes
- ✅ Paiements CinetPay / PayTech
- ✅ Livraison GPS (utilise coordonnées directes)
- ✅ Kiosque
- ✅ WhatsApp integration
- ✅ Analytics et rapports

---

## ⚠️ **EN RÉSUMÉ**

```
🟢 Application fonctionnelle à 100% SANS Google Maps
🟡 Google Maps = Bonus pour carte interactive
💚 Alternative gratuite = Leaflet/OpenStreetMap (déjà intégré)
```

**👉 Vous pouvez utiliser l'application immédiatement sans configurer Google Maps !**

---

## 📞 **Support**

**Questions ?**  
📧 Email : contact@restoconnect360.com  
📱 Téléphone : +221 78 100 00 64

---

**Date :** 16 Octobre 2025  
**Statut :** ⚠️ **Configuration OPTIONNELLE**

