<?php

namespace Database\Seeders;

use App\Models\Delivery\Driver;
use App\Models\Platform\Company;
use App\Models\Platform\Subscription;
use App\Models\Restaurant\Category;
use App\Models\Restaurant\Menu;
use App\Models\Restaurant\Product;
use App\Models\Restaurant\Restaurant;
use App\Models\Restaurant\Table;
use App\Models\Restaurant\Zone;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles
        $superAdminRole = Role::create(['name' => 'super_admin']);
        $adminRole = Role::create(['name' => 'admin']);
        $companyManagerRole = Role::create(['name' => 'company_manager']);
        $restaurantManagerRole = Role::create(['name' => 'restaurant_manager']);
        $agentRole = Role::create(['name' => 'agent']);
        $employeeRole = Role::create(['name' => 'employee']);
        $driverRole = Role::create(['name' => 'driver']);

        // Create Super Admin user
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@restoconnect360.com',
            'password' => Hash::make('Admin@2025'),
            'phone' => '+221781000001',
            'is_active' => true,
        ]);
        $superAdmin->assignRole($superAdminRole);

        // Create admin user
        $admin = User::create([
            'name' => 'Admin RestoConnect360',
            'email' => 'admin@restoconnect360.com',
            'password' => Hash::make('Admin@2025'),
            'phone' => '+221781000064',
            'is_active' => true,
        ]);
        $admin->assignRole($adminRole);

        // Create company
        $company = Company::create([
            'name' => 'Groupe Restaurant Dakar',
            'slug' => 'groupe-restaurant-dakar',
            'email' => 'contact@restaurantdakar.com',
            'phone' => '+221771234567',
            'address' => 'Plateau, Dakar',
            'city' => 'Dakar',
            'country' => 'Senegal',
            'is_active' => true,
            'verified_at' => now(),
        ]);

        // Create subscription
        Subscription::create([
            'company_id' => $company->id,
            'plan_name' => 'professional',
            'price' => 50000,
            'billing_cycle' => 'monthly',
            'max_restaurants' => 5,
            'max_products' => 500,
            'max_orders' => 1000,
            'has_pos' => true,
            'has_delivery' => true,
            'has_whatsapp' => true,
            'has_analytics' => true,
            'starts_at' => now(),
            'ends_at' => now()->addMonth(),
            'status' => 'active',
        ]);

        // Create company manager
        $manager = User::create([
            'name' => 'Mamadou Diallo',
            'email' => 'manager@restaurantdakar.com',
            'password' => Hash::make('Manager@2025'),
            'phone' => '+221771234568',
            'company_id' => $company->id,
            'is_active' => true,
        ]);
        $manager->assignRole($companyManagerRole);

        // Create restaurant manager
        $restaurantManager = User::create([
            'name' => 'Fatou Sall',
            'email' => 'restaurant@restoconnect360.com',
            'password' => Hash::make('Restaurant@2025'),
            'phone' => '+221771234570',
            'company_id' => $company->id,
            'is_active' => true,
        ]);
        $restaurantManager->assignRole($restaurantManagerRole);

        // Create agent
        $agent = User::create([
            'name' => 'Amadou Ndiaye',
            'email' => 'agent@restoconnect360.com',
            'password' => Hash::make('Agent@2025'),
            'phone' => '+221771234571',
            'company_id' => $company->id,
            'is_active' => true,
        ]);
        $agent->assignRole($agentRole);

        // Create employee
        $employee = User::create([
            'name' => 'Aïssa Diop',
            'email' => 'employee@restoconnect360.com',
            'password' => Hash::make('Employee@2025'),
            'phone' => '+221771234572',
            'company_id' => $company->id,
            'is_active' => true,
        ]);
        $employee->assignRole($employeeRole);

        // Create restaurants
        $restaurants = [
            [
                'name' => 'Le Teranga',
                'slug' => 'le-teranga',
                'description' => 'Restaurant sénégalais authentique au cœur de Dakar',
                'address' => 'Rue 10, Plateau, Dakar',
                'latitude' => 14.6928,
                'longitude' => -17.4467,
                'category' => 'restaurant',
                'cuisine_type' => 'senegalaise',
            ],
            [
                'name' => 'Café des Arts',
                'slug' => 'cafe-des-arts',
                'description' => 'Café cosy avec terrasse et wifi gratuit',
                'address' => 'Avenue Georges Pompidou, Dakar',
                'latitude' => 14.7167,
                'longitude' => -17.4677,
                'category' => 'cafe',
                'cuisine_type' => 'francaise',
            ],
            [
                'name' => 'Fast Food Lagon',
                'slug' => 'fast-food-lagon',
                'description' => 'Fast food moderne avec burgers et pizzas',
                'address' => 'Rond-point Lagon, Dakar',
                'latitude' => 14.7342,
                'longitude' => -17.4892,
                'category' => 'fast_food',
                'cuisine_type' => 'americaine',
            ],
        ];

        foreach ($restaurants as $restaurantData) {
            $restaurant = Restaurant::create(array_merge($restaurantData, [
                'company_id' => $company->id,
                'phone' => '+221771234569',
                'email' => $restaurantData['slug'] . '@restaurantdakar.com',
                'city' => 'Dakar',
                'country' => 'Senegal',
                'accepts_delivery' => true,
                'accepts_takeaway' => true,
                'accepts_dine_in' => true,
                'has_pos' => true,
                'has_whatsapp' => true,
                'whatsapp_number' => '+221771234569',
                'is_active' => true,
            ]));

            // Create zones
            $terrasse = Zone::create([
                'restaurant_id' => $restaurant->id,
                'name' => 'Terrasse',
                'slug' => 'terrasse',
                'capacity' => 40,
                'is_outdoor' => true,
                'is_active' => true,
                'display_order' => 1,
            ]);

            $salle = Zone::create([
                'restaurant_id' => $restaurant->id,
                'name' => 'Salle principale',
                'slug' => 'salle-principale',
                'capacity' => 60,
                'is_outdoor' => false,
                'is_active' => true,
                'display_order' => 2,
            ]);

            // Create tables
            for ($i = 1; $i <= 10; $i++) {
                Table::create([
                    'restaurant_id' => $restaurant->id,
                    'zone_id' => $i <= 5 ? $terrasse->id : $salle->id,
                    'name' => "Table $i",
                    'number' => "T$i",
                    'capacity' => rand(2, 6),
                    'status' => 'available',
                    'is_active' => true,
                ]);
            }

            // Create menu
            $menu = Menu::create([
                'restaurant_id' => $restaurant->id,
                'name' => 'Carte Principale',
                'slug' => 'carte-principale',
                'type' => 'all_day',
                'is_active' => true,
                'display_order' => 1,
            ]);

            // Create categories and products
            $categories = [
                ['name' => 'Entrées', 'products' => [
                    ['name' => 'Salade César', 'price' => 3500],
                    ['name' => 'Soupe du jour', 'price' => 2500],
                ]],
                ['name' => 'Plats Principaux', 'products' => [
                    ['name' => 'Thiéboudienne', 'price' => 5000],
                    ['name' => 'Yassa Poulet', 'price' => 4500],
                    ['name' => 'Mafé', 'price' => 4500],
                ]],
                ['name' => 'Boissons', 'products' => [
                    ['name' => 'Jus de Bissap', 'price' => 1000],
                    ['name' => 'Eau minérale', 'price' => 500],
                ]],
                ['name' => 'Desserts', 'products' => [
                    ['name' => 'Thiakry', 'price' => 2000],
                    ['name' => 'Salade de fruits', 'price' => 2500],
                ]],
            ];

            foreach ($categories as $index => $categoryData) {
                $category = Category::create([
                    'restaurant_id' => $restaurant->id,
                    'menu_id' => $menu->id,
                    'name' => $categoryData['name'],
                    'slug' => \Illuminate\Support\Str::slug($categoryData['name']),
                    'is_active' => true,
                    'display_order' => $index + 1,
                ]);

                foreach ($categoryData['products'] as $productIndex => $productData) {
                    Product::create([
                        'restaurant_id' => $restaurant->id,
                        'category_id' => $category->id,
                        'name' => $productData['name'],
                        'slug' => \Illuminate\Support\Str::slug($productData['name']),
                        'price' => $productData['price'],
                        'is_available' => true,
                        'display_order' => $productIndex + 1,
                    ]);
                }
            }
        }

        // Create drivers
        for ($i = 1; $i <= 5; $i++) {
            $driverUser = User::create([
                'name' => "Livreur $i",
                'email' => "driver$i@restoconnect360.com",
                'password' => Hash::make('Driver@2025'),
                'phone' => '+22177123456' . $i,
                'company_id' => $company->id,
                'is_active' => true,
            ]);
            $driverUser->assignRole($driverRole);

            Driver::create([
                'user_id' => $driverUser->id,
                'company_id' => $company->id,
                'vehicle_type' => 'motorcycle',
                'vehicle_make' => 'Honda',
                'vehicle_model' => 'CBR',
                'vehicle_plate_number' => "DK-123$i-AB",
                'status' => $i <= 3 ? 'online' : 'offline',
                'current_latitude' => 14.7167 + (rand(-100, 100) / 1000),
                'current_longitude' => -17.4677 + (rand(-100, 100) / 1000),
                'is_available' => true,
                'is_verified' => true,
                'verified_at' => now(),
            ]);
        }

        // Call EnrichedBusinessSeeder for additional businesses
        // $this->call(EnrichedBusinessSeeder::class); // ⚠️ Temporairement désactivé (bugs à corriger)

        $this->command->info('');
        $this->command->info('✅ Base de données peuplée avec succès!');
        $this->command->info('');
        $this->command->info('========================================');
        $this->command->info('📋 IDENTIFIANTS DE TEST');
        $this->command->info('========================================');
        $this->command->info('');
        $this->command->info('👑 SUPER ADMIN');
        $this->command->info('   Email: superadmin@restoconnect360.com');
        $this->command->info('   Mot de passe: Admin@2025');
        $this->command->info('   Dashboard: /admin/super-admin');
        $this->command->info('');
        $this->command->info('🏢 ADMIN');
        $this->command->info('   Email: admin@restoconnect360.com');
        $this->command->info('   Mot de passe: Admin@2025');
        $this->command->info('   Dashboard: /admin/dashboard');
        $this->command->info('');
        $this->command->info('🏪 RESTAURANT MANAGER');
        $this->command->info('   Email: restaurant@restoconnect360.com');
        $this->command->info('   Mot de passe: Restaurant@2025');
        $this->command->info('   Dashboard: /admin/restaurant');
        $this->command->info('');
        $this->command->info('🎯 AGENT COMMERCIAL');
        $this->command->info('   Email: agent@restoconnect360.com');
        $this->command->info('   Mot de passe: Agent@2025');
        $this->command->info('   Dashboard: /admin/agent');
        $this->command->info('');
        $this->command->info('🚗 LIVREUR');
        $this->command->info('   Email: driver1@restoconnect360.com');
        $this->command->info('   Mot de passe: Driver@2025');
        $this->command->info('   Dashboard: /driver');
        $this->command->info('');
        $this->command->info('👤 EMPLOYÉ');
        $this->command->info('   Email: employee@restoconnect360.com');
        $this->command->info('   Mot de passe: Employee@2025');
        $this->command->info('');
        $this->command->info('========================================');
        $this->command->info('');
    }
}
