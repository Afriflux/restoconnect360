# 🚀 Guide d'Utilisation - Charte Graphique RestoConnect360

## 📖 Introduction

Ce guide pratique vous accompagne dans l'utilisation de la charte graphique **RestoConnect360** pour créer des interfaces cohérentes et professionnelles.

---

## 🎯 Accès rapide

### Visualiser la charte graphique

Pour voir tous les composants en action :

1. **Démarrez le serveur de développement** :
   ```bash
   npm run dev
   php artisan serve
   ```

2. **Accédez à la page Style Guide** :
   ```
   http://localhost:8000/style-guide
   ```

Cette page présente :
- ✅ Toutes les couleurs de la palette
- ✅ La hiérarchie typographique
- ✅ Tous les boutons et leurs états
- ✅ Les formulaires et inputs
- ✅ Les alertes et notifications
- ✅ Les badges et cartes
- ✅ Les tableaux
- ✅ Les animations

---

## 🎨 Utilisation des couleurs

### Dans les composants Vue

```vue
<template>
  <!-- Bouton avec couleur principale (brand) -->
  <button class="bg-brand-500 hover:bg-brand-600 text-white">
    Action principale
  </button>

  <!-- Texte avec couleur secondaire (orange) -->
  <h2 class="text-secondary-500">Titre en orange</h2>

  <!-- Alert de succès -->
  <div class="bg-success-50 border-l-4 border-success-400 text-success-700 p-4">
    Opération réussie !
  </div>
</template>
```

### Classes utilitaires personnalisées

```html
<!-- Classes directes pour la couleur brand -->
<div class="text-brand">Texte vert</div>
<div class="bg-brand">Fond vert</div>
<div class="border-brand">Bordure verte</div>
```

---

## 🖋 Utilisation de la typographie

### Polices disponibles

1. **Poppins** → Titres et branding
2. **Inter** → Corps de texte (par défaut)
3. **Montserrat** → Labels et menus

### Dans vos composants

```vue
<template>
  <!-- Titre avec Poppins -->
  <h1 class="font-heading text-4xl font-bold text-dark-800">
    Titre Principal
  </h1>

  <!-- Texte courant avec Inter (automatique) -->
  <p class="text-body text-gray-700">
    Ceci est un paragraphe en Inter.
  </p>

  <!-- Label avec Montserrat -->
  <label class="font-label font-medium text-gray-700">
    Nom du champ
  </label>

  <!-- Classes pré-définies -->
  <h1 class="text-h1">Heading 1 (2.5rem, Poppins Bold)</h1>
  <h2 class="text-h2">Heading 2 (2rem, Poppins SemiBold)</h2>
  <h3 class="text-h3">Heading 3 (1.5rem, Poppins SemiBold)</h3>
  <p class="text-body">Corps de texte (1rem, Inter)</p>
  <p class="text-small">Petit texte (0.875rem, Inter)</p>
</template>
```

---

## 🔘 Utilisation des boutons

### Classes pré-définies

```vue
<template>
  <!-- Bouton principal (vert) -->
  <button class="btn-primary">
    Commander maintenant
  </button>

  <!-- Bouton secondaire (orange) -->
  <button class="btn-secondary">
    En savoir plus
  </button>

  <!-- Bouton outline -->
  <button class="btn-outline">
    Annuler
  </button>

  <!-- Bouton désactivé -->
  <button class="btn-disabled" disabled>
    Indisponible
  </button>

  <!-- Bouton avec icône -->
  <button class="btn-primary flex items-center gap-2">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
    </svg>
    Ajouter
  </button>
</template>
```

### Boutons personnalisés avec Tailwind

```vue
<template>
  <!-- Si vous avez besoin de styles spécifiques -->
  <button class="bg-brand-500 hover:bg-brand-600 text-white px-6 py-3 rounded-lg font-label font-medium transition-smooth shadow-sm hover:shadow-md">
    Bouton personnalisé
  </button>
</template>
```

---

## 📝 Formulaires

### Inputs standards

```vue
<template>
  <div>
    <label class="block text-small font-label font-medium text-gray-700 mb-2">
      Nom du restaurant
    </label>
    <input 
      type="text" 
      class="input" 
      placeholder="Entrez le nom..."
    />
  </div>

  <!-- Input avec erreur -->
  <div>
    <label class="block text-small font-label font-medium text-gray-700 mb-2">
      Email
    </label>
    <input 
      type="email" 
      class="input-error" 
      value="email-invalide"
    />
    <p class="text-small text-danger-600 mt-1">
      Veuillez entrer un email valide
    </p>
  </div>

  <!-- Select -->
  <select class="input">
    <option>Option 1</option>
    <option>Option 2</option>
  </select>

  <!-- Textarea -->
  <textarea class="input" rows="4" placeholder="Description..."></textarea>
</template>
```

---

## 🔔 Alertes et Notifications

### Classes pré-définies

```vue
<template>
  <!-- Success -->
  <div class="alert-success">
    <div class="flex items-start gap-3">
      <svg class="w-6 h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
      </svg>
      <div>
        <p class="font-label font-semibold">Succès !</p>
        <p class="text-small mt-1">Votre opération a réussi.</p>
      </div>
    </div>
  </div>

  <!-- Info -->
  <div class="alert-info">
    Information importante
  </div>

  <!-- Warning -->
  <div class="alert-warning">
    Attention requise
  </div>

  <!-- Danger -->
  <div class="alert-danger">
    Erreur critique
  </div>
</template>
```

---

## 🏷️ Badges

```vue
<template>
  <span class="badge-success">Actif</span>
  <span class="badge-warning">En attente</span>
  <span class="badge-danger">Annulé</span>
  <span class="badge-info">Nouveau</span>
  
  <!-- Badge personnalisé -->
  <span class="badge bg-brand-500 text-white">Premium</span>
</template>
```

---

## 🃏 Cartes

```vue
<template>
  <!-- Carte standard -->
  <div class="card">
    <h3 class="text-h3 text-dark-800 mb-3">Titre de la carte</h3>
    <p class="text-body text-gray-600 mb-4">
      Description de la carte avec texte.
    </p>
    <button class="btn-primary">Action</button>
  </div>

  <!-- Carte avec fond clair -->
  <div class="card-light">
    <h3 class="text-h3 text-dark-800 mb-3">Carte Light</h3>
    <p class="text-body text-gray-600">Contenu...</p>
  </div>

  <!-- Carte personnalisée -->
  <div class="bg-white rounded-xl shadow-card p-6 hover:shadow-soft transition-smooth">
    <h3 class="text-h3 text-dark-800">Carte custom</h3>
  </div>
</template>
```

---

## 📊 Tableaux

```vue
<template>
  <div class="card overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full">
        <thead class="bg-dark-800 text-white">
          <tr>
            <th class="px-6 py-4 text-left font-label font-semibold">Colonne 1</th>
            <th class="px-6 py-4 text-left font-label font-semibold">Colonne 2</th>
            <th class="px-6 py-4 text-left font-label font-semibold">Statut</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          <tr class="hover:bg-light-300 transition-colors">
            <td class="px-6 py-4 text-body text-gray-900">Données 1</td>
            <td class="px-6 py-4 text-body text-gray-900">Données 2</td>
            <td class="px-6 py-4"><span class="badge-success">Actif</span></td>
          </tr>
          <tr class="bg-light-300 hover:bg-gray-200 transition-colors">
            <td class="px-6 py-4 text-body text-gray-900">Données 3</td>
            <td class="px-6 py-4 text-body text-gray-900">Données 4</td>
            <td class="px-6 py-4"><span class="badge-warning">Pause</span></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
```

---

## ✨ Ombres personnalisées

```vue
<template>
  <!-- Ombre douce -->
  <div class="shadow-soft">...</div>

  <!-- Ombre pour cartes -->
  <div class="shadow-card">...</div>

  <!-- Ombre flottante -->
  <div class="shadow-floating">...</div>
</template>
```

---

## 🎬 Animations

```vue
<template>
  <!-- Fade in -->
  <div class="animate-fade-in">
    Apparaît en fondu
  </div>

  <!-- Slide in -->
  <div class="animate-slide-in">
    Glisse depuis la gauche
  </div>

  <!-- Transition douce (pour hover, etc.) -->
  <button class="transition-smooth hover:scale-105">
    Bouton avec transition
  </button>
</template>
```

---

## 📱 Responsive Design

### Breakpoints disponibles

```vue
<template>
  <!-- Utilisation des breakpoints -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
    <!-- Contenu responsive -->
  </div>

  <!-- Texte responsive -->
  <h1 class="text-2xl md:text-3xl lg:text-4xl xl:text-5xl">
    Titre responsive
  </h1>

  <!-- Padding responsive -->
  <div class="p-4 md:p-6 lg:p-8">
    Contenu avec padding adaptatif
  </div>
</template>
```

### Breakpoints personnalisés

- `xs`: 475px
- `sm`: 640px
- `md`: 768px
- `lg`: 1024px
- `xl`: 1280px
- `2xl`: 1536px
- `3xl`: 1920px

---

## 🎨 Exemple complet

```vue
<template>
  <div class="min-h-screen bg-gray-50 py-12 px-4">
    <div class="max-w-7xl mx-auto">
      <!-- Header -->
      <div class="text-center mb-12">
        <h1 class="text-h1 text-dark-800 mb-4">
          Bienvenue sur RestoConnect360
        </h1>
        <p class="text-body text-gray-600 max-w-2xl mx-auto">
          Solution digitale professionnelle pour la restauration
        </p>
      </div>

      <!-- Grille de cartes -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
        <div class="card animate-fade-in">
          <h3 class="text-h3 text-dark-800 mb-3">Commandes</h3>
          <p class="text-body text-gray-600 mb-4">
            Gérez vos commandes en temps réel
          </p>
          <button class="btn-primary w-full">Accéder</button>
        </div>

        <div class="card animate-fade-in" style="animation-delay: 0.1s;">
          <h3 class="text-h3 text-dark-800 mb-3">Menu</h3>
          <p class="text-body text-gray-600 mb-4">
            Personnalisez votre carte
          </p>
          <button class="btn-secondary w-full">Modifier</button>
        </div>

        <div class="card animate-fade-in" style="animation-delay: 0.2s;">
          <h3 class="text-h3 text-dark-800 mb-3">Analytics</h3>
          <p class="text-body text-gray-600 mb-4">
            Suivez vos performances
          </p>
          <button class="btn-outline w-full">Voir</button>
        </div>
      </div>

      <!-- Alert de succès -->
      <div class="alert-success mb-6">
        <div class="flex items-start gap-3">
          <svg class="w-6 h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
          </svg>
          <div>
            <p class="font-label font-semibold">Bienvenue !</p>
            <p class="text-small mt-1">Votre compte a été créé avec succès.</p>
          </div>
        </div>
      </div>

      <!-- Tableau -->
      <div class="card overflow-hidden">
        <h2 class="text-h2 text-dark-800 mb-6">Dernières commandes</h2>
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead class="bg-dark-800 text-white">
              <tr>
                <th class="px-6 py-4 text-left font-label font-semibold">N°</th>
                <th class="px-6 py-4 text-left font-label font-semibold">Client</th>
                <th class="px-6 py-4 text-left font-label font-semibold">Montant</th>
                <th class="px-6 py-4 text-left font-label font-semibold">Statut</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              <tr class="hover:bg-light-300 transition-colors">
                <td class="px-6 py-4 text-body text-gray-900">#1234</td>
                <td class="px-6 py-4 text-body text-gray-900">Jean Dupont</td>
                <td class="px-6 py-4 text-body text-gray-900">45,90 €</td>
                <td class="px-6 py-4"><span class="badge-success">Livrée</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
// Votre logique ici
</script>
```

---

## 🛠️ Bonnes pratiques

### ✅ À FAIRE

1. **Utiliser les classes pré-définies** (`btn-primary`, `card`, `alert-success`, etc.)
2. **Respecter la hiérarchie typographique** (h1 > h2 > h3)
3. **Utiliser les couleurs de la palette** définie dans Tailwind
4. **Tester sur mobile et desktop**
5. **Ajouter des transitions** pour une meilleure UX (`transition-smooth`)
6. **Respecter le contraste** pour l'accessibilité

### ❌ À ÉVITER

1. ❌ Créer des couleurs custom en dehors de la palette
2. ❌ Utiliser trop de couleurs vives simultanément
3. ❌ Oublier les états hover/focus sur les éléments interactifs
4. ❌ Créer des boutons < 44px de hauteur sur mobile
5. ❌ Utiliser des polices autres que Poppins/Inter/Montserrat
6. ❌ Négliger l'espacement et la respiration visuelle

---

## 📚 Ressources

- **Documentation complète** : `CHARTE_GRAPHIQUE.md`
- **Page de démo** : http://localhost:8000/style-guide
- **Configuration Tailwind** : `tailwind.config.js`
- **Styles CSS** : `resources/css/app.css`
- **Composant de démo** : `resources/js/pages/StyleGuide.vue`

---

## 🤝 Support

Pour toute question sur l'utilisation de la charte graphique :

1. Consultez d'abord la page `/style-guide`
2. Référez-vous à `CHARTE_GRAPHIQUE.md`
3. Regardez les exemples dans `StyleGuide.vue`
4. Contactez l'équipe de développement

---

**Bonne création ! 🎨🚀**

