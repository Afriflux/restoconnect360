# 🎨 Charte Graphique RestoConnect360

> **Plateforme de gestion restauration** - Design professionnel, moderne et convivial

---

## 📋 Vue d'ensemble

RestoConnect360 est une solution digitale complète qui inspire **fiabilité, fraîcheur et appétence**. Cette charte graphique reflète nos valeurs à travers une palette de couleurs harmonieuse et une typographie soigneusement sélectionnée.

---

## 🎨 Palette de couleurs principale

| Usage | Couleur | Code HEX | Tailwind CSS | Commentaire |
|-------|---------|----------|--------------|-------------|
| **Couleur principale / Brand** | Vert vif | `#28A745` | `brand` | Évoque la fraîcheur, la santé, les aliments frais, confiance |
| **Couleur secondaire** | Orange chaud | `#FF7F11` | `secondary` | Dynamisme, incitation à l'action (CTA), appétence |
| **Accent 1** | Bleu nuit | `#1F2937` | `dark` | Texte principal, contrasté avec blanc |
| **Accent 2** | Gris clair | `#F3F4F6` | `light` | Backgrounds, cartes, zones neutres |
| **Danger / Erreur** | Rouge tomate | `#E63946` | `danger` | Pour alertes, erreurs |
| **Success / Validation** | Vert clair | `#34D399` | `success` | Pour succès, confirmations |
| **Info / Notifications** | Bleu clair | `#3B82F6` | `info` | Pour info et messages système |
| **Background général** | Blanc pur | `#FFFFFF` | `bg-white` | Épure et modernité |

### Palette étendue (nuances)

Chaque couleur principale dispose de nuances de 50 à 950 pour offrir une flexibilité maximale dans l'UI.

---

## 🖋 Typographie

### 1. Titres / Branding
- **Police** : **Poppins** (Bold / Extra Bold)
- **Usage** : Titres principaux, branding, headers
- **Classes Tailwind** : `font-heading`
- **Caractéristiques** : Moderne, lisible, friendly

### 2. Texte courant / Paragraphes
- **Police** : **Inter**
- **Usage** : Corps de texte, paragraphes, descriptions
- **Classes Tailwind** : `font-sans` (par défaut)
- **Caractéristiques** : Lisibilité optimale sur tous supports

### 3. Menus / Petits labels
- **Police** : **Montserrat** (Medium)
- **Usage** : Labels, boutons, menus, navigation
- **Classes Tailwind** : `font-label`
- **Caractéristiques** : Élégant et clair

### Hiérarchie typographique

```css
/* Titre principal */
.text-h1 { font-size: 2.5rem; font-weight: 700; }

/* Titre secondaire */
.text-h2 { font-size: 2rem; font-weight: 600; }

/* Titre tertiaire */
.text-h3 { font-size: 1.5rem; font-weight: 600; }

/* Corps de texte */
.text-body { font-size: 1rem; font-weight: 400; }

/* Petit texte */
.text-small { font-size: 0.875rem; font-weight: 400; }
```

---

## 🖌 Style UI & Composants

### 1. Boutons

#### CTA Principal
```html
<button class="bg-brand hover:bg-brand-600 text-white px-6 py-3 rounded-lg font-medium transition-colors">
  Action Principale
</button>
```
- Couleur : Vert vif (`#28A745`)
- Hover : Plus foncé (`#218838`)
- Texte : Blanc

#### CTA Secondaire
```html
<button class="bg-secondary hover:bg-secondary-600 text-white px-6 py-3 rounded-lg font-medium transition-colors">
  Action Secondaire
</button>
```
- Couleur : Orange (`#FF7F11`)
- Hover : `#e67300`
- Texte : Blanc

#### Bouton Disabled
```html
<button class="bg-gray-300 text-gray-500 px-6 py-3 rounded-lg cursor-not-allowed" disabled>
  Désactivé
</button>
```

### 2. Cartes / Containers

```html
<div class="bg-light rounded-xl shadow-soft p-6">
  <!-- Contenu -->
</div>
```

- Fond : Gris clair `#F3F4F6`
- Ombre douce : `0px 4px 6px rgba(0,0,0,0.1)`
- Coins arrondis : `8px` à `12px`

### 3. Tableaux / Dashboard

```html
<table class="w-full">
  <thead class="bg-dark text-white">
    <tr>
      <th class="px-4 py-3 text-left">Colonne</th>
    </tr>
  </thead>
  <tbody>
    <tr class="bg-white even:bg-light">
      <td class="px-4 py-3">Données</td>
    </tr>
  </tbody>
</table>
```

### 4. Notifications / Alerts

#### Info
```html
<div class="bg-info/10 border-l-4 border-info text-info-700 p-4 rounded">
  Message informatif
</div>
```

#### Success
```html
<div class="bg-success/10 border-l-4 border-success text-success-700 p-4 rounded">
  Opération réussie
</div>
```

#### Warning
```html
<div class="bg-secondary/10 border-l-4 border-secondary text-secondary-700 p-4 rounded">
  Attention
</div>
```

#### Danger
```html
<div class="bg-danger/10 border-l-4 border-danger text-danger-700 p-4 rounded">
  Erreur
</div>
```

### 5. Formulaires

```html
<input 
  type="text" 
  placeholder="Votre texte..."
  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-brand focus:ring-2 focus:ring-brand/20 outline-none transition-all"
>
```

- Border : Gris moyen `#D1D5DB`
- Focus : Vert vif `#28A745`
- Placeholder : Gris clair `#9CA3AF`

### 6. Icons / Illustrations

- Style : Flat / Minimaliste
- Couleurs : Palette principale ou dégradés légers (vert → orange)
- Principe : Éviter la surcharge de couleurs

---

## 🎯 Règles générales

### Cohérence
- ✅ Garder les mêmes couleurs pour actions similaires
- ✅ Vert = succès, validation, action principale
- ✅ Orange = action secondaire, incitation
- ✅ Rouge = danger, erreur
- ✅ Bleu = information

### Contraste
- ✅ Texte toujours lisible sur fond
- ✅ Respecter WCAG 2.1 niveau AA minimum
- ✅ Ratio de contraste ≥ 4.5:1 pour texte normal
- ✅ Ratio de contraste ≥ 3:1 pour texte large

### Minimalisme
- ✅ Éviter trop de couleurs vives simultanément
- ✅ Focus sur CTA et hiérarchie visuelle
- ✅ Espaces blancs généreux
- ✅ Maximum 3 couleurs par écran

### Adaptabilité mobile
- ✅ Touch targets ≥ 44px × 44px
- ✅ Utiliser variantes hover/active pour états tactiles
- ✅ Espacements adaptés pour mobile
- ✅ Police ≥ 16px pour éviter le zoom automatique

---

## 💡 Bonnes Pratiques UX

### 1. **Boutons et Actions**
- Utilisez le vert (`brand`) pour les **actions principales** - Attire l'attention
- Utilisez l'orange (`secondary`) pour les **actions secondaires** - Incite sans dominer
- **Limitez à 1 bouton principal par écran** - Évite la confusion

### 2. **Messages et Alertes**
- **Rouge** : Erreurs critiques, actions destructives irréversibles
- **Vert** : Succès, confirmations positives
- **Bleu** : Informations neutres, conseils
- **Orange** : Avertissements, actions requises, attention

### 3. **Arrière-plans et Espaces**
- **Privilégiez les fonds clairs** - Lisibilité optimale
- **Blanc pour les surfaces principales** - Mise en avant du contenu
- **Gris clair pour différencier** - Sections et zones distinctes
- **Espacements généreux** - Respiration visuelle

### 4. **Hiérarchie Visuelle**
- **Taille** : Éléments importants → Police plus grande
- **Couleur** : Actions prioritaires → Couleurs vives et contrastées
- **Poids** : Titres → Bold | Texte courant → Regular
- **Proximité** : Éléments liés → Regroupés visuellement

---

## 📦 Classes Tailwind personnalisées

```css
/* Couleurs de marque */
.text-brand { color: #28A745; }
.bg-brand { background-color: #28A745; }
.border-brand { border-color: #28A745; }

/* Ombres personnalisées */
.shadow-soft { box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); }
.shadow-card { box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.08); }
.shadow-floating { box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.12); }

/* Transitions */
.transition-smooth { transition: all 0.3s ease-in-out; }
```

---

## 🚀 Utilisation dans les composants Vue

```vue
<template>
  <div class="bg-white rounded-xl shadow-card p-6">
    <h2 class="font-heading text-2xl text-dark mb-4">
      Titre du composant
    </h2>
    <p class="font-sans text-gray-700 mb-6">
      Texte descriptif utilisant la police Inter pour une lecture optimale.
    </p>
    <button class="bg-brand hover:bg-brand-600 text-white px-6 py-3 rounded-lg font-label transition-smooth">
      Action principale
    </button>
  </div>
</template>
```

---

## 📱 Responsive Design

### Breakpoints
- `xs`: 475px - Petits mobiles
- `sm`: 640px - Mobiles
- `md`: 768px - Tablettes
- `lg`: 1024px - Laptops
- `xl`: 1280px - Desktops
- `2xl`: 1536px - Large screens
- `3xl`: 1920px - Extra large screens

### Stratégie mobile-first
1. Concevoir d'abord pour mobile
2. Enrichir progressivement pour écrans plus larges
3. Tester sur vrais appareils
4. Optimiser les performances

---

## ✅ Checklist de conformité

Avant de déployer un nouveau composant :

- [ ] Utilise les couleurs de la palette définie
- [ ] Respecte la hiérarchie typographique
- [ ] Texte lisible (contraste suffisant)
- [ ] Responsive sur tous breakpoints
- [ ] Espacement cohérent (padding/margin)
- [ ] États hover/focus/active définis
- [ ] Transitions fluides (0.3s ease)
- [ ] Icons cohérents avec le style
- [ ] Accessible (WCAG AA)
- [ ] Testé sur mobile et desktop

---

**Date de création** : 16 octobre 2025  
**Version** : 1.0  
**Auteur** : Équipe RestoConnect360

