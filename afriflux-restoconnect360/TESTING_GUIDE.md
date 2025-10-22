# 🧪 Guide de Test RestoConnect360

## 📋 Table des Matières
1. [Tests Backend (PHPUnit)](#tests-backend)
2. [Tests Frontend (Vitest)](#tests-frontend)
3. [Tests E2E (Playwright)](#tests-e2e)
4. [Tests d'Intégration](#tests-integration)
5. [Tests Paiements Sandbox](#tests-paiements)
6. [Tests Responsive](#tests-responsive)

---

## 🔧 Tests Backend (PHPUnit)

### Installation
```bash
composer install
```

### Configuration
```bash
# Créer base de données de test
cp .env .env.testing
# Modifier .env.testing :
DB_DATABASE=restoconnect360_test
```

### Exécution

```bash
# Tous les tests
php artisan test

# Tests spécifiques
php artisan test --filter=AuthenticationTest
php artisan test --filter=RestaurantTest
php artisan test --filter=OrderTest
php artisan test --filter=DeliveryTest
php artisan test --filter=PaymentTest

# Avec couverture
php artisan test --coverage
php artisan test --coverage-html coverage
```

### Tests Disponibles

#### 1. **AuthenticationTest** ✅
- ✅ Inscription utilisateur
- ✅ Connexion
- ✅ Connexion invalide
- ✅ Déconnexion
- ✅ Récupération profil

```bash
php artisan test --filter=AuthenticationTest
```

#### 2. **RestaurantTest** ✅
- ✅ Liste des restaurants
- ✅ Détails restaurant
- ✅ Recherche proximité
- ✅ Restaurants inactifs exclus

```bash
php artisan test --filter=RestaurantTest
```

#### 3. **OrderTest** ✅
- ✅ Création commande
- ✅ Mise à jour statut
- ✅ Liste commandes utilisateur
- ✅ Validation items requis

```bash
php artisan test --filter=OrderTest
```

#### 4. **DeliveryTest** ✅
- ✅ Acceptation livraison
- ✅ Mise à jour position GPS
- ✅ Tracking livraison
- ✅ Finalisation livraison

```bash
php artisan test --filter=DeliveryTest
```

#### 5. **PaymentTest** ✅
- ✅ Paiement espèces
- ✅ Historique paiements
- ✅ Validation montant
- ⏭️ CinetPay (nécessite credentials)

```bash
php artisan test --filter=PaymentTest
```

---

## 🎨 Tests Frontend (Vitest)

### Installation
```bash
npm install
```

### Configuration
```js
// vite.config.js
import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
  plugins: [vue()],
  test: {
    globals: true,
    environment: 'jsdom',
  },
});
```

### Exécution
```bash
# Tous les tests
npm run test

# Mode watch
npm run test:watch

# Couverture
npm run test:coverage
```

### Tests à Implémenter

#### 1. **Stores Pinia** 🔄
- [ ] AuthStore (login, logout, register)
- [ ] RestaurantStore (fetch, search)
- [ ] CartStore (add, remove, update)
- [ ] OrderStore (create, status)
- [ ] DeliveryStore (tracking)

#### 2. **Composables** 🔄
- [ ] useGeolocation (getCurrentPosition, distance)
- [ ] usePayment (CinetPay, PayTech, Cash)

#### 3. **Utils** 🔄
- [ ] currency.js (formatCurrency, calculateTax)
- [ ] date.js (formatDate, timeAgo)
- [ ] validators.js (email, phone, password)

---

## 🌐 Tests E2E (Playwright)

### Installation
```bash
npm install -D @playwright/test
npx playwright install
```

### Configuration
```js
// playwright.config.js
import { defineConfig, devices } from '@playwright/test';

export default defineConfig({
  testDir: './tests/e2e',
  use: {
    baseURL: 'http://localhost:8000',
  },
  projects: [
    { name: 'chromium', use: { ...devices['Desktop Chrome'] } },
    { name: 'firefox', use: { ...devices['Desktop Firefox'] } },
    { name: 'webkit', use: { ...devices['Desktop Safari'] } },
    { name: 'Mobile Chrome', use: { ...devices['Pixel 5'] } },
    { name: 'Mobile Safari', use: { ...devices['iPhone 12'] } },
  ],
});
```

### Tests E2E à Implémenter

```javascript
// tests/e2e/user-flow.spec.js
test('User can complete full order flow', async ({ page }) => {
  // 1. Navigate to home
  await page.goto('/');
  
  // 2. Search for restaurant
  await page.click('text=Trouver un Magasin');
  await page.click('text=Ma position');
  
  // 3. Select restaurant
  await page.click('.restaurant-card:first-child');
  
  // 4. Add items to cart
  await page.click('.product-card:first-child');
  await page.click('text=Ajouter au panier');
  
  // 5. Checkout
  await page.click('text=Commander');
  
  // 6. Complete payment
  await page.click('text=Espèces');
  
  // 7. Verify order created
  await expect(page.locator('text=Commande confirmée')).toBeVisible();
});
```

---

## 🔗 Tests d'Intégration

### Backend + Frontend

```bash
# 1. Démarrer serveur Laravel
php artisan serve

# 2. Démarrer Vite (terminal séparé)
npm run dev

# 3. Lancer tests E2E
npx playwright test
```

### Tests API + Frontend

```javascript
// tests/integration/api.test.js
describe('API Integration', () => {
  it('should fetch restaurants and display them', async () => {
    // Mock API response
    const mockRestaurants = [
      { id: 1, name: 'Restaurant 1', rating: 4.5 },
      { id: 2, name: 'Restaurant 2', rating: 4.8 },
    ];
    
    // Test component rendering
    // ...
  });
});
```

---

## 💳 Tests Paiements Sandbox

### CinetPay Sandbox

```bash
# Variables d'environnement
CINETPAY_API_KEY=your_sandbox_api_key
CINETPAY_SITE_ID=your_sandbox_site_id
CINETPAY_MODE=sandbox
```

**Cartes de test :**
- **Succès :** `4242 4242 4242 4242`
- **Échec :** `4000 0000 0000 0002`
- **Authentification 3D :** `4000 0027 6000 3184`

### PayTech Sandbox

```bash
# Variables d'environnement
PAYTECH_API_KEY=your_sandbox_api_key
PAYTECH_API_SECRET=your_sandbox_api_secret
PAYTECH_MODE=sandbox
```

**Numéros de test :**
- **Orange Money :** `77 123 45 67`
- **Wave :** `77 987 65 43`
- **MTN Money :** `76 123 45 67`

### Tests Automatisés

```php
// tests/Feature/PaymentSandboxTest.php
/** @test */
public function can_process_cinetpay_sandbox_payment()
{
    $response = $this->postJson('/api/payments/cinetpay/initiate', [
        'amount' => 1000,
        'card_number' => '4242424242424242',
        'card_cvv' => '123',
        'card_expiry' => '12/25',
    ]);
    
    $response->assertStatus(200)
        ->assertJsonStructure(['payment_url', 'transaction_id']);
}
```

---

## 📱 Tests Responsive

### Breakpoints à Tester

```javascript
// tests/responsive/breakpoints.test.js
const breakpoints = [
  { name: 'Mobile', width: 375, height: 667 },
  { name: 'Tablet', width: 768, height: 1024 },
  { name: 'Desktop', width: 1920, height: 1080 },
  { name: 'Large Desktop', width: 2560, height: 1440 },
  { name: 'POS Terminal', width: 1024, height: 768 },
  { name: 'Kiosk', width: 1080, height: 1920 }, // Portrait
];

breakpoints.forEach(({ name, width, height }) => {
  test(`Layout is correct on ${name}`, async ({ page }) => {
    await page.setViewportSize({ width, height });
    await page.goto('/');
    
    // Vérifier layout
    const header = await page.locator('header');
    await expect(header).toBeVisible();
    
    // Screenshot
    await page.screenshot({ path: `screenshots/${name}.png` });
  });
});
```

### Tests Manuels

#### 1. **Mobile (375px - 767px)**
- ✅ Navigation hamburger visible
- ✅ Cartes produits en 1 colonne
- ✅ Texte lisible
- ✅ Boutons touch-friendly (min 44px)

#### 2. **Tablet (768px - 1023px)**
- ✅ Navigation horizontale
- ✅ Cartes produits en 2 colonnes
- ✅ Sidebar rétractable

#### 3. **Desktop (1024px+)**
- ✅ Navigation complète
- ✅ Cartes produits en 3-4 colonnes
- ✅ Sidebar fixe

#### 4. **POS Terminal**
- ✅ Interface tactile optimisée
- ✅ Boutons larges (min 60px)
- ✅ Grille produits adaptée

#### 5. **Kiosque**
- ✅ Mode plein écran
- ✅ Texte extra-large
- ✅ Boutons extra-larges (min 80px)

---

## 📊 Couverture de Test Cible

### Backend
```
Overall:        85%+
Models:         90%+
Controllers:    80%+
Services:       85%+
```

### Frontend
```
Overall:        70%+
Components:     75%+
Stores:         85%+
Composables:    80%+
Utils:          90%+
```

---

## 🚀 CI/CD Tests

### GitHub Actions

```yaml
# .github/workflows/tests.yml
name: Tests

on: [push, pull_request]

jobs:
  backend:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: 8.2
      - name: Install Dependencies
        run: composer install
      - name: Run Tests
        run: php artisan test --coverage

  frontend:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: Setup Node
        uses: actions/setup-node@v2
        with:
          node-version: 18
      - name: Install Dependencies
        run: npm install
      - name: Run Tests
        run: npm run test

  e2e:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: Run E2E Tests
        run: |
          php artisan serve &
          npm run dev &
          npx playwright test
```

---

## ✅ Checklist Finale

### Tests Backend
- ✅ AuthenticationTest
- ✅ RestaurantTest
- ✅ OrderTest
- ✅ DeliveryTest
- ✅ PaymentTest
- ✅ GeolocationTest (Unit)
- ✅ CurrencyTest (Unit)

### Tests Frontend (À Implémenter)
- [ ] Stores Tests
- [ ] Components Tests
- [ ] Composables Tests
- [ ] Utils Tests

### Tests E2E (À Implémenter)
- [ ] User Registration Flow
- [ ] Order Creation Flow
- [ ] Driver Delivery Flow
- [ ] POS Order Flow
- [ ] Kiosk Order Flow

### Tests Paiements
- [ ] CinetPay Sandbox
- [ ] PayTech Sandbox
- [ ] Cash Payment

### Tests Responsive
- ✅ Mobile Layout
- ✅ Tablet Layout
- ✅ Desktop Layout
- ✅ POS Layout
- ✅ Kiosk Layout

---

## 📞 Support

Pour toute question sur les tests :
- 📧 Email : dev@restoconnect360.com
- 📱 Tél : +221 78 100 00 64

**🎉 Tests Backend Complets ! Frontend & E2E à implémenter.**

