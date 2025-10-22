# 🚀 Accès Rapide - Charte Graphique RestoConnect360

**Utilisez immédiatement la charte graphique dans vos développements**

---

## ⚡ Démarrage Express

### 1️⃣ Démarrer les serveurs
```bash
npm run dev
php artisan serve
```

### 2️⃣ Ouvrir la page de démo
```
http://localhost:8000/style-guide
```

### 3️⃣ Utiliser dans vos composants
```vue
<template>
  <button class="btn-primary">Mon Bouton</button>
</template>
```

---

## 📚 Documentation Rapide

| Je veux... | Document | Temps |
|-----------|----------|-------|
| **Tout comprendre** | `CHARTE_GRAPHIQUE.md` | 15 min |
| **Des exemples de code** | `GUIDE_UTILISATION_CHARTE.md` | 10 min |
| **Un résumé** | `CHARTE_GRAPHIQUE_RECAP.md` | 2 min |
| **Voir en action** | http://localhost:8000/style-guide | 5 min |

---

## 🎨 Classes les Plus Utilisées

### Boutons
```html
<button class="btn-primary">Action Principale</button>
<button class="btn-secondary">Action Secondaire</button>
<button class="btn-outline">Outline</button>
```

### Cartes
```html
<div class="card">Carte standard</div>
<div class="card-light">Carte fond gris</div>
```

### Alertes
```html
<div class="alert-success">Succès !</div>
<div class="alert-danger">Erreur !</div>
<div class="alert-info">Info</div>
<div class="alert-warning">Attention</div>
```

### Formulaires
```html
<input type="text" class="input" placeholder="..." />
<input type="email" class="input-error" />
```

### Titres
```html
<h1 class="text-h1">Titre Principal</h1>
<h2 class="text-h2">Titre Secondaire</h2>
<h3 class="text-h3">Titre Tertiaire</h3>
```

---

## 🎨 Couleurs Principales

| Classe Tailwind | Couleur | Usage |
|----------------|---------|-------|
| `bg-brand-500` | Vert (#28A745) | Action principale |
| `bg-secondary-500` | Orange (#FF7F11) | Action secondaire |
| `bg-success-400` | Vert clair (#34D399) | Succès |
| `bg-danger-500` | Rouge (#E63946) | Erreur |
| `bg-info-500` | Bleu (#3B82F6) | Information |

---

## 💡 Exemples Ultra-Rapides

### Carte avec bouton
```vue
<div class="card">
  <h3 class="text-h3 text-dark-800 mb-3">Titre</h3>
  <p class="text-body text-gray-600 mb-4">Description</p>
  <button class="btn-primary">Action</button>
</div>
```

### Formulaire simple
```vue
<div>
  <label class="block text-small font-label font-medium text-gray-700 mb-2">
    Nom
  </label>
  <input type="text" class="input" placeholder="Votre nom..." />
</div>
```

### Alert avec icône
```vue
<div class="alert-success flex items-start gap-3">
  <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
  </svg>
  <div>
    <p class="font-label font-semibold">Succès !</p>
    <p class="text-small mt-1">Opération réussie.</p>
  </div>
</div>
```

---

## 📖 Polices

- **Poppins** → `.font-heading` → Titres
- **Inter** → Par défaut → Texte
- **Montserrat** → `.font-label` → Labels

---

## 🔗 Liens Utiles

- 🌐 **Page démo** : http://localhost:8000/style-guide
- 📄 **Charte complète** : `CHARTE_GRAPHIQUE.md`
- 📖 **Guide pratique** : `GUIDE_UTILISATION_CHARTE.md`
- 📊 **Implémentation** : `IMPLEMENTATION_CHARTE_GRAPHIQUE.md`

---

✅ **C'est tout ! Vous êtes prêt à utiliser la charte graphique RestoConnect360 !**

