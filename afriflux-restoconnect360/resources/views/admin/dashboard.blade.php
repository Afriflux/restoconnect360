<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Afriflux RestoConnect360</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-gray-900">
                        <i class="fas fa-tachometer-alt mr-2 text-blue-600"></i>
                        Dashboard Admin
                    </h1>
                </div>
                <div class="text-sm text-gray-500">
                    Afriflux RestoConnect360
                </div>
            </div>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Users -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <i class="fas fa-users text-blue-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Utilisateurs</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_users'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Restaurants -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <i class="fas fa-store text-green-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Restaurants</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_restaurants'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Orders -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-yellow-100 rounded-lg">
                        <i class="fas fa-shopping-cart text-yellow-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Commandes</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_orders'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Payments -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <i class="fas fa-credit-card text-purple-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Paiements</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_payments'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Pending Payments -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-orange-100 rounded-lg">
                        <i class="fas fa-clock text-orange-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Paiements en attente</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['pending_payments'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Completed Orders -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <i class="fas fa-check-circle text-green-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Commandes terminées</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['completed_orders'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Active Deliveries -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-indigo-100 rounded-lg">
                        <i class="fas fa-truck text-indigo-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Livraisons actives</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['active_deliveries'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">
                    <i class="fas fa-bolt mr-2"></i>
                    Actions Rapides
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    <a href="{{ route('admin.payments') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="p-2 bg-blue-100 rounded-lg mr-3">
                            <i class="fas fa-credit-card text-blue-600"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Paiements</p>
                            <p class="text-sm text-gray-500">Gérer les paiements</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.orders') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="p-2 bg-green-100 rounded-lg mr-3">
                            <i class="fas fa-shopping-cart text-green-600"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Commandes</p>
                            <p class="text-sm text-gray-500">Voir les commandes</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.restaurants') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="p-2 bg-yellow-100 rounded-lg mr-3">
                            <i class="fas fa-store text-yellow-600"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Restaurants</p>
                            <p class="text-sm text-gray-500">Gérer les restaurants</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.users') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="p-2 bg-purple-100 rounded-lg mr-3">
                            <i class="fas fa-users text-purple-600"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Utilisateurs</p>
                            <p class="text-sm text-gray-500">Gérer les utilisateurs</p>
                        </div>
                    </a>

                    <a href="{{ route('admin.deliveries') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="p-2 bg-indigo-100 rounded-lg mr-3">
                            <i class="fas fa-truck text-indigo-600"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Livraisons</p>
                            <p class="text-sm text-gray-500">Suivre les livraisons</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
