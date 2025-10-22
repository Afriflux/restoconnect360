<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="auth-token" content="{{ request()->bearerToken() ?: '{{ csrf_token() }}' }}">

    <title>@yield('title', 'Admin Dashboard') - RestoConnect360</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet">

    <!-- PWA -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#10b981">
    <link rel="apple-touch-icon" href="/icon-192.png">

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Custom Admin Styles -->
    <style>
        .card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            border: 1px solid #e5e7eb;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            transition: all 0.2s;
            cursor: pointer;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #059669, #047857);
            transform: translateY(-1px);
        }
        
        .btn-outline {
            background: transparent;
            color: #10b981;
            padding: 12px 24px;
            border-radius: 8px;
            border: 2px solid #10b981;
            font-weight: 600;
            transition: all 0.2s;
            cursor: pointer;
        }
        
        .btn-outline:hover {
            background: #10b981;
            color: white;
        }
        
        .input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.2s;
        }
        
        .input:focus {
            outline: none;
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }
        
        .badge-success {
            background: #d1fae5;
            color: #065f46;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .badge-warning {
            background: #fef3c7;
            color: #92400e;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .badge-info {
            background: #dbeafe;
            color: #1e40af;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .alert-warning {
            background: #fef3c7;
            border: 1px solid #f59e0b;
            color: #92400e;
            padding: 16px;
            border-radius: 8px;
        }
        
        .alert-info {
            background: #dbeafe;
            border: 1px solid #3b82f6;
            color: #1e40af;
            padding: 16px;
            border-radius: 8px;
        }
        
        .alert-danger {
            background: #fee2e2;
            border: 1px solid #dc2626;
            color: #991b1b;
            padding: 16px;
            border-radius: 8px;
        }
        
        .text-h1 { font-size: 2.5rem; font-weight: 700; line-height: 1.2; }
        .text-h2 { font-size: 2rem; font-weight: 600; line-height: 1.3; }
        .text-h3 { font-size: 1.5rem; font-weight: 600; line-height: 1.4; }
        .text-body { font-size: 1rem; line-height: 1.6; }
        .text-small { font-size: 0.875rem; line-height: 1.5; }
        .font-label { font-weight: 500; }
        .text-dark-800 { color: #1f2937; }
        .text-gray-600 { color: #4b5563; }
        .text-gray-500 { color: #6b7280; }
        .text-brand-600 { color: #059669; }
        .text-secondary-500 { color: #f59e0b; }
        .text-success-600 { color: #059669; }
        .text-success-400 { color: #10b981; }
        .text-danger-500 { color: #dc2626; }
        .text-info-500 { color: #3b82f6; }
        .text-brand-600 { color: #059669; }
    </style>
</head>
<body class="antialiased bg-gray-50">
    <!-- Navigation Admin -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="/" class="flex items-center">
                        <div class="text-2xl font-bold text-green-600">RestoConnect360</div>
                        <div class="ml-2 text-xs text-gray-500">Admin</div>
                    </a>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="/admin" class="text-gray-700 hover:text-green-600 font-medium transition-colors">
                        Dashboard
                    </a>
                    <a href="/admin/subscriptions" class="text-gray-700 hover:text-green-600 font-medium transition-colors">
                        Abonnements
                    </a>
                    <a href="/admin/payments" class="text-gray-700 hover:text-green-600 font-medium transition-colors">
                        Paiements
                    </a>
                    <a href="/admin/orders" class="text-gray-700 hover:text-green-600 font-medium transition-colors">
                        Commandes
                    </a>
                    <a href="/admin/restaurants" class="text-gray-700 hover:text-green-600 font-medium transition-colors">
                        Restaurants
                    </a>
                    <a href="/admin/users" class="text-gray-700 hover:text-green-600 font-medium transition-colors">
                        Utilisateurs
                    </a>
                    <a href="/admin/deliveries" class="text-gray-700 hover:text-green-600 font-medium transition-colors">
                        Livraisons
                    </a>
                    
                    <div class="border-l border-gray-200 pl-4">
                        <a href="/login" class="text-gray-700 hover:text-green-600 font-medium transition-colors">
                            Connexion Vue.js
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenu Principal -->
    <main>
        @yield('content')
    </main>

    <!-- Script pour l'authentification -->
    <script>
        // Vérifier l'authentification et rediriger si nécessaire
        document.addEventListener('DOMContentLoaded', function() {
            const token = localStorage.getItem('token');
            const authUser = localStorage.getItem('auth_user');
            
            if (!token || !authUser) {
                // Pas d'authentification, rediriger vers la page de connexion
                window.location.href = '/login?redirect=' + encodeURIComponent(window.location.href);
                return;
            }
            
            // Vérifier si le token est valide
            fetch('/api/me', {
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Token invalide');
                }
                return response.json();
            })
            .catch(error => {
                console.error('Erreur d\'authentification:', error);
                // Token invalide, nettoyer et rediriger
                localStorage.removeItem('token');
                localStorage.removeItem('auth_user');
                window.location.href = '/login?redirect=' + encodeURIComponent(window.location.href);
            });
        });
    </script>
</body>
</html>
