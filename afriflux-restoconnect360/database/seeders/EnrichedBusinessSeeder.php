<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Restaurant\Restaurant;
use App\Models\Restaurant\Category;
use App\Models\Restaurant\Product;
use App\Models\Platform\Company;
use Illuminate\Support\Str;

class EnrichedBusinessSeeder extends Seeder
{
    public function run()
    {
        // Company
        $company = Company::first() ?? Company::create([
            'name' => 'Groupe AfriFood',
            'slug' => 'groupe-afrifood',
            'description' => 'Leader des solutions food-tech en Afrique',
            'is_active' => true,
        ]);

        // 1. Restaurant Gastronomique
        $restaurant1 = Restaurant::create([
            'company_id' => $company->id,
            'name' => 'Le Dakarois Gourmand',
            'slug' => 'le-dakarois-gourmand',
            'description' => 'Restaurant gastronomique sénégalais avec terrasse vue mer',
            'category' => 'restaurant',
            'cuisine_type' => 'senegalaise',
            'address' => 'Corniche Ouest, Dakar',
            'city' => 'Dakar',
            'country' => 'Sénégal',
            'phone' => '+221 33 123 45 67',
            'latitude' => 14.7167,
            'longitude' => -17.4677,
            'opening_hours' => json_encode([
                'monday' => ['12:00-15:00', '19:00-23:00'],
                'tuesday' => ['12:00-15:00', '19:00-23:00'],
                'wednesday' => ['12:00-15:00', '19:00-23:00'],
                'thursday' => ['12:00-15:00', '19:00-23:00'],
                'friday' => ['12:00-15:00', '19:00-00:00'],
                'saturday' => ['12:00-00:00'],
                'sunday' => ['12:00-23:00'],
            ]),
            'is_active' => true,
        ]);

        $cat1 = Category::create(['restaurant_id' => $restaurant1->id, 'name' => 'Plats Sénégalais', 'slug' => 'plats-senegalais']);
        Product::create(['restaurant_id' => $restaurant1->id, 'category_id' => $cat1->id, 'name' => 'Thiéboudienne Royal', 'slug' => 'thieb-royal', 'description' => 'Riz au poisson, légumes variés', 'price' => 5500, 'is_available' => true]);
        Product::create(['restaurant_id' => $restaurant1->id, 'category_id' => $cat1->id, 'name' => 'Yassa Poulet', 'slug' => 'yassa-poulet', 'description' => 'Poulet mariné citron oignons', 'price' => 4500, 'is_available' => true]);
        Product::create(['restaurant_id' => $restaurant1->id, 'category_id' => $cat1->id, 'name' => 'Mafé', 'slug' => 'mafe', 'description' => 'Viande sauce arachide', 'price' => 4000, 'is_available' => true]);

        $cat2 = Category::create(['restaurant_id' => $restaurant1->id, 'name' => 'Desserts', 'slug' => 'desserts']);
        Product::create(['restaurant_id' => $restaurant1->id, 'category_id' => $cat2->id, 'name' => 'Thiakry', 'slug' => 'thiakry', 'description' => 'Couscous sucré lait caillé', 'price' => 1500, 'is_available' => true]);
        Product::create(['restaurant_id' => $restaurant1->id, 'category_id' => $cat2->id, 'name' => 'Fondant Chocolat', 'slug' => 'fondant-choco', 'description' => 'Coulant chocolat noir', 'price' => 2000, 'is_available' => true]);

        // 2. Bar Lounge
        $bar = Restaurant::create([
            'company_id' => $company->id,
            'name' => 'Le Sunset Lounge',
            'slug' => 'sunset-lounge',
            'description' => 'Bar lounge ambiance afro-jazz avec terrasse panoramique',
            'category' => 'bar',
            'cuisine_type' => 'lounge',
            'address' => 'Les Almadies, Dakar',
            'city' => 'Dakar',
            'country' => 'Sénégal',
            'phone' => '+221 33 234 56 78',
            'latitude' => 14.7472,
            'longitude' => -17.5092,
            'opening_hours' => json_encode([
                'monday' => ['18:00-02:00'],
                'tuesday' => ['18:00-02:00'],
                'wednesday' => ['18:00-02:00'],
                'thursday' => ['18:00-03:00'],
                'friday' => ['18:00-04:00'],
                'saturday' => ['16:00-04:00'],
                'sunday' => ['16:00-02:00'],
            ]),
            'is_active' => true,
        ]);

        $barCat1 = Category::create(['restaurant_id' => $bar->id, 'name' => 'Cocktails Signature', 'slug' => 'cocktails']);
        Product::create(['restaurant_id' => $bar->id, 'category_id' => $barCat1->id, 'name' => 'Dakar Mojito', 'slug' => 'dakar-mojito', 'description' => 'Mojito bissap menthe fraîche', 'price' => 3500, 'is_available' => true]);
        Product::create(['restaurant_id' => $bar->id, 'category_id' => $barCat1->id, 'name' => 'Teranga Punch', 'slug' => 'teranga-punch', 'description' => 'Punch fruits exotiques', 'price' => 4000, 'is_available' => true]);
        Product::create(['restaurant_id' => $bar->id, 'category_id' => $barCat1->id, 'name' => 'Ti-Punch Casamance', 'slug' => 'tipunch', 'description' => 'Rhum blanc citron vert', 'price' => 3000, 'is_available' => true]);

        $barCat2 = Category::create(['restaurant_id' => $bar->id, 'name' => 'Tapas', 'slug' => 'tapas']);
        Product::create(['restaurant_id' => $bar->id, 'category_id' => $barCat2->id, 'name' => 'Accras de Morue', 'slug' => 'accras', 'description' => 'Beignets morue épicés', 'price' => 2500, 'is_available' => true]);
        Product::create(['restaurant_id' => $bar->id, 'category_id' => $barCat2->id, 'name' => 'Pastels Thon', 'slug' => 'pastels', 'description' => 'Chaussons frits au thon', 'price' => 2000, 'is_available' => true]);

        // 3. Café & Pâtisserie
        $cafe = Restaurant::create([
            'company_id' => $company->id,
            'name' => 'Café Touba Premium',
            'slug' => 'cafe-touba-premium',
            'description' => 'Café artisanal, viennoiseries et pâtisseries maison',
            'category' => 'cafe',
            'cuisine_type' => 'cafe',
            'address' => 'Plateau, Dakar',
            'city' => 'Dakar',
            'country' => 'Sénégal',
            'phone' => '+221 33 345 67 89',
            'latitude' => 14.6928,
            'longitude' => -17.4467,
            'opening_hours' => json_encode([
                'monday' => ['07:00-20:00'],
                'tuesday' => ['07:00-20:00'],
                'wednesday' => ['07:00-20:00'],
                'thursday' => ['07:00-20:00'],
                'friday' => ['07:00-21:00'],
                'saturday' => ['08:00-21:00'],
                'sunday' => ['09:00-19:00'],
            ]),
            'is_active' => true,
        ]);

        $cafeCat1 = Category::create(['restaurant_id' => $cafe->id, 'name' => 'Boissons Chaudes', 'slug' => 'boissons-chaudes']);
        Product::create(['restaurant_id' => $cafe->id, 'category_id' => $cafeCat1->id, 'name' => 'Café Touba Traditionnel', 'slug' => 'cafe-touba', 'description' => 'Café épicé sénégalais', 'price' => 500, 'is_available' => true]);
        Product::create(['restaurant_id' => $cafe->id, 'category_id' => $cafeCat1->id, 'name' => 'Cappuccino', 'slug' => 'cappuccino', 'description' => 'Expresso lait mousseux', 'price' => 1500, 'is_available' => true]);
        Product::create(['restaurant_id' => $cafe->id, 'category_id' => $cafeCat1->id, 'name' => 'Thé Vert Menthe', 'slug' => 'the-menthe', 'description' => 'Thé vert menthe fraîche', 'price' => 800, 'is_available' => true]);

        $cafeCat2 = Category::create(['restaurant_id' => $cafe->id, 'name' => 'Pâtisseries', 'slug' => 'patisseries']);
        Product::create(['restaurant_id' => $cafe->id, 'category_id' => $cafeCat2->id, 'name' => 'Croissant Beurre', 'slug' => 'croissant', 'description' => 'Croissant pur beurre', 'price' => 1000, 'is_available' => true]);
        Product::create(['restaurant_id' => $cafe->id, 'category_id' => $cafeCat2->id, 'name' => 'Pain au Chocolat', 'slug' => 'pain-choco', 'description' => 'Viennoiserie chocolat', 'price' => 1200, 'is_available' => true]);
        Product::create(['restaurant_id' => $cafe->id, 'category_id' => $cafeCat2->id, 'name' => 'Éclair Café', 'slug' => 'eclair-cafe', 'description' => 'Pâte à choux crème café', 'price' => 1800, 'is_available' => true]);

        // 4. Fast-Food Afro-Fusion
        $fastfood = Restaurant::create([
            'company_id' => $company->id,
            'name' => 'AfroChicken Express',
            'slug' => 'afrochicken-express',
            'description' => 'Fast-food poulet grillé marinades africaines',
            'category' => 'fast_food',
            'cuisine_type' => 'africaine',
            'address' => 'Liberté 6, Dakar',
            'city' => 'Dakar',
            'country' => 'Sénégal',
            'phone' => '+221 33 456 78 90',
            'latitude' => 14.7219,
            'longitude' => -17.4694,
            'opening_hours' => json_encode([
                'monday' => ['10:00-23:00'],
                'tuesday' => ['10:00-23:00'],
                'wednesday' => ['10:00-23:00'],
                'thursday' => ['10:00-23:00'],
                'friday' => ['10:00-00:00'],
                'saturday' => ['10:00-00:00'],
                'sunday' => ['11:00-23:00'],
            ]),
            'is_active' => true,
        ]);

        $ffCat1 = Category::create(['restaurant_id' => $fastfood->id, 'name' => 'Menus', 'slug' => 'menus']);
        Product::create(['restaurant_id' => $fastfood->id, 'category_id' => $ffCat1->id, 'name' => 'Menu Yassa Burger', 'slug' => 'menu-yassa-burger', 'description' => 'Burger poulet yassa + frites + boisson', 'price' => 3500, 'is_available' => true]);
        Product::create(['restaurant_id' => $fastfood->id, 'category_id' => $ffCat1->id, 'name' => 'Menu Mafé Wrap', 'slug' => 'menu-mafe-wrap', 'description' => 'Wrap mafé + frites + boisson', 'price' => 3200, 'is_available' => true]);
        Product::create(['restaurant_id' => $fastfood->id, 'category_id' => $ffCat1->id, 'name' => 'Menu Poulet Grillé', 'slug' => 'menu-poulet-grille', 'description' => 'Demi-poulet + frites + salade', 'price' => 4000, 'is_available' => true]);

        // 5. Salon de Thé Oriental
        $salonthe = Restaurant::create([
            'company_id' => $company->id,
            'name' => 'Riad Thé & Délices',
            'slug' => 'riad-the-delices',
            'description' => 'Salon de thé oriental, pâtisseries orientales et shisha',
            'category' => 'cafe',
            'cuisine_type' => 'orientale',
            'address' => 'Sicap Liberté, Dakar',
            'city' => 'Dakar',
            'country' => 'Sénégal',
            'phone' => '+221 33 567 89 01',
            'latitude' => 14.7281,
            'longitude' => -17.4725,
            'opening_hours' => json_encode([
                'monday' => ['15:00-23:00'],
                'tuesday' => ['15:00-23:00'],
                'wednesday' => ['15:00-23:00'],
                'thursday' => ['15:00-00:00'],
                'friday' => ['15:00-01:00'],
                'saturday' => ['14:00-01:00'],
                'sunday' => ['14:00-23:00'],
            ]),
            'is_active' => true,
        ]);

        $theCat1 = Category::create(['restaurant_id' => $salonthe->id, 'name' => 'Thés & Infusions', 'slug' => 'thes-infusions']);
        Product::create(['category_id' => $theCat1->id, 'name' => 'Thé à la Menthe Marocain', 'slug' => 'the-menthe-maroc', 'description' => 'Thé vert menthe sucre', 'price' => 1500, 'is_available' => true]);
        Product::create(['category_id' => $theCat1->id, 'name' => 'Thé aux Épices Chai', 'slug' => 'chai', 'description' => 'Thé noir épices lait', 'price' => 1800, 'is_available' => true]);

        $theCat2 = Category::create(['restaurant_id' => $salonthe->id, 'name' => 'Pâtisseries Orientales', 'slug' => 'patisseries-orientales']);
        Product::create(['category_id' => $theCat2->id, 'name' => 'Assortiment Baklava', 'slug' => 'baklava', 'description' => '4 pièces variées', 'price' => 2500, 'is_available' => true]);
        Product::create(['category_id' => $theCat2->id, 'name' => 'Makrout', 'slug' => 'makrout', 'description' => 'Gâteau semoule dattes', 'price' => 1500, 'is_available' => true]);

        // 6. Buvette/Snack Local
        $buvette = Restaurant::create([
            'company_id' => $company->id,
            'name' => 'Buvette Chez Fatou',
            'slug' => 'buvette-chez-fatou',
            'description' => 'Snacks locaux, jus frais, sandwichs et grillades',
            'category' => 'fast_food',
            'cuisine_type' => 'locale',
            'address' => 'Marché Tilène, Dakar',
            'city' => 'Dakar',
            'country' => 'Sénégal',
            'phone' => '+221 77 123 45 67',
            'latitude' => 14.7000,
            'longitude' => -17.4500,
            'opening_hours' => json_encode([
                'monday' => ['08:00-20:00'],
                'tuesday' => ['08:00-20:00'],
                'wednesday' => ['08:00-20:00'],
                'thursday' => ['08:00-20:00'],
                'friday' => ['08:00-20:00'],
                'saturday' => ['08:00-21:00'],
                'sunday' => ['09:00-19:00'],
            ]),
            'is_active' => true,
        ]);

        $buvCat1 = Category::create(['restaurant_id' => $buvette->id, 'name' => 'Jus Frais', 'slug' => 'jus-frais']);
        Product::create(['category_id' => $buvCat1->id, 'name' => 'Jus Bouye', 'slug' => 'jus-bouye', 'description' => 'Jus pain de singe', 'price' => 500, 'is_available' => true]);
        Product::create(['category_id' => $buvCat1->id, 'name' => 'Jus Bissap', 'slug' => 'jus-bissap', 'description' => 'Boisson fleurs hibiscus', 'price' => 400, 'is_available' => true]);
        Product::create(['category_id' => $buvCat1->id, 'name' => 'Jus Dakhar', 'slug' => 'jus-dakhar', 'description' => 'Jus tamarin', 'price' => 400, 'is_available' => true]);

        $buvCat2 = Category::create(['restaurant_id' => $buvette->id, 'name' => 'Snacks', 'slug' => 'snacks']);
        Product::create(['category_id' => $buvCat2->id, 'name' => 'Fataya Viande', 'slug' => 'fataya-viande', 'description' => 'Chausson frit viande', 'price' => 300, 'is_available' => true]);
        Product::create(['category_id' => $buvCat2->id, 'name' => 'Sandwich Diaga', 'slug' => 'sandwich-diaga', 'description' => 'Pain sardines omelette', 'price' => 1000, 'is_available' => true]);

        // 7. Boutique Alimentaire / Épicerie Fine
        $boutique = Restaurant::create([
            'company_id' => $company->id,
            'name' => 'AfriGourmet Store',
            'slug' => 'afrigourmet-store',
            'description' => 'Épicerie fine, produits locaux bio, traiteur',
            'category' => 'restaurant',
            'cuisine_type' => 'epicerie_fine',
            'address' => 'Mermoz, Dakar',
            'city' => 'Dakar',
            'country' => 'Sénégal',
            'phone' => '+221 33 678 90 12',
            'latitude' => 14.7394,
            'longitude' => -17.4786,
            'opening_hours' => json_encode([
                'monday' => ['09:00-19:00'],
                'tuesday' => ['09:00-19:00'],
                'wednesday' => ['09:00-19:00'],
                'thursday' => ['09:00-19:00'],
                'friday' => ['09:00-20:00'],
                'saturday' => ['09:00-20:00'],
                'sunday' => ['10:00-17:00'],
            ]),
            'is_active' => true,
        ]);

        $epicCat1 = Category::create(['restaurant_id' => $boutique->id, 'name' => 'Produits Bio Locaux', 'slug' => 'bio-locaux']);
        Product::create(['category_id' => $epicCat1->id, 'name' => 'Miel de Nianing Bio', 'slug' => 'miel-nianing', 'description' => 'Pot 500g miel pur', 'price' => 5000, 'is_available' => true]);
        Product::create(['category_id' => $epicCat1->id, 'name' => 'Huile Arachide Artisanale', 'slug' => 'huile-arachide', 'description' => 'Bouteille 1L pressée à froid', 'price' => 3500, 'is_available' => true]);

        $epicCat2 = Category::create(['restaurant_id' => $boutique->id, 'name' => 'Plats Traiteur', 'slug' => 'plats-traiteur']);
        Product::create(['category_id' => $epicCat2->id, 'name' => 'Thiéboudienne Familial', 'slug' => 'thieb-familial', 'description' => 'Pour 6-8 personnes', 'price' => 15000, 'is_available' => true]);
        Product::create(['category_id' => $epicCat2->id, 'name' => 'Plateau Pastels 20pc', 'slug' => 'plateau-pastels', 'description' => '20 pastels assortis', 'price' => 8000, 'is_available' => true]);

        // 8. Cafétéria Moderne / Coworking
        $cafeteria = Restaurant::create([
            'company_id' => $company->id,
            'name' => 'CoWork Café & Kitchen',
            'slug' => 'cowork-cafe-kitchen',
            'description' => 'Cafétéria moderne, espace coworking, wifi haut débit',
            'category' => 'cafe',
            'cuisine_type' => 'internationale',
            'address' => 'Point E, Dakar',
            'city' => 'Dakar',
            'country' => 'Sénégal',
            'phone' => '+221 33 789 01 23',
            'latitude' => 14.7108,
            'longitude' => -17.4578,
            'opening_hours' => json_encode([
                'monday' => ['08:00-19:00'],
                'tuesday' => ['08:00-19:00'],
                'wednesday' => ['08:00-19:00'],
                'thursday' => ['08:00-19:00'],
                'friday' => ['08:00-19:00'],
                'saturday' => ['10:00-18:00'],
                'sunday' => ['Fermé'],
            ]),
            'is_active' => true,
        ]);

        $cafetCat1 = Category::create(['restaurant_id' => $cafeteria->id, 'name' => 'Formules Déjeuner', 'slug' => 'formules-dejeuner']);
        Product::create(['restaurant_id' => $cafe->id, 'category_id' => $cafetCat1->id, 'name' => 'Bowl Buddha Végétarien', 'slug' => 'bowl-buddha', 'description' => 'Quinoa légumes grillés avocat', 'price' => 4500, 'is_available' => true]);
        Product::create(['restaurant_id' => $cafe->id, 'category_id' => $cafetCat1->id, 'name' => 'Salade César Poulet', 'slug' => 'salade-cesar', 'description' => 'Salade romaine poulet parmesan', 'price' => 4000, 'is_available' => true]);

        $cafetCat2 = Category::create(['restaurant_id' => $cafeteria->id, 'name' => 'Smoothies & Juices', 'slug' => 'smoothies-juices']);
        Product::create(['restaurant_id' => $cafe->id, 'category_id' => $cafetCat2->id, 'name' => 'Green Detox Smoothie', 'slug' => 'green-detox', 'description' => 'Épinards kiwi pomme gingembre', 'price' => 2500, 'is_available' => true]);
        Product::create(['restaurant_id' => $cafe->id, 'category_id' => $cafetCat2->id, 'name' => 'Tropical Energy Smoothie', 'slug' => 'tropical-energy', 'description' => 'Mangue ananas coco', 'price' => 2800, 'is_available' => true]);

        $this->command->info('✅ 8 commerces variés créés avec succès !');
        $this->command->info('📍 Restaurants, Bars, Cafés, Fast-food, Salons de thé, Buvettes, Épiceries, Cafétérias');
    }
}

