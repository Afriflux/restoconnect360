@extends('layouts.admin')

@section('title', 'Gestion des Abonnements')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-h1 text-dark-800 mb-2">Gestion des Abonnements</h1>
                    <p class="text-body text-gray-600">Administrez tous les abonnements RestoConnect360</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-brand-600">{{ $totalSubscriptions ?? 1,247 }}</div>
                        <div class="text-small text-gray-500">Abonnements actifs</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-success-400">{{ number_format($monthlyRevenue ?? 89,247, ',', ' ') }}€</div>
                        <div class="text-small text-gray-500">Revenus mensuels</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Contenu Principal -->
            <div class="lg:col-span-3 space-y-6">
                <!-- Filtres et Recherche -->
                <div class="card">
                    <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center justify-between">
                        <div class="flex flex-wrap gap-3">
                            <select class="input w-auto">
                                <option>Tous les plans</option>
                                <option>Starter (29€)</option>
                                <option>Premium (89€)</option>
                                <option>Enterprise (199€)</option>
                            </select>
                            <select class="input w-auto">
                                <option>Tous les statuts</option>
                                <option>Actif</option>
                                <option>Suspendu</option>
                                <option>Annulé</option>
                                <option>En attente</option>
                            </select>
                            <input type="date" class="input w-auto" placeholder="Date de début">
                            <input type="date" class="input w-auto" placeholder="Date de fin">
                        </div>
                        <div class="flex gap-2">
                            <input type="text" class="input w-64" placeholder="Rechercher par email, nom...">
                            <button class="btn-primary">Rechercher</button>
                        </div>
                    </div>
                </div>

                <!-- Statistiques Rapides -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="card text-center">
                        <div class="text-2xl font-bold text-brand-600 mb-1">{{ $activeSubscriptions ?? 1,089 }}</div>
                        <div class="text-small text-gray-600">Actifs</div>
                    </div>
                    <div class="card text-center">
                        <div class="text-2xl font-bold text-secondary-500 mb-1">{{ $trialSubscriptions ?? 45 }}</div>
                        <div class="text-small text-gray-600">Essai gratuit</div>
                    </div>
                    <div class="card text-center">
                        <div class="text-2xl font-bold text-danger-500 mb-1">{{ $cancelledSubscriptions ?? 23 }}</div>
                        <div class="text-small text-gray-600">Annulés</div>
                    </div>
                    <div class="card text-center">
                        <div class="text-2xl font-bold text-success-400 mb-1">{{ $newThisMonth ?? 67 }}</div>
                        <div class="text-small text-gray-600">Nouveaux ce mois</div>
                    </div>
                </div>

                <!-- Options Promotionnelles -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Cartes Cadeaux -->
                    <div class="card">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-h3 text-dark-800">🎁 Cartes Cadeaux</h3>
                            <button class="btn-primary text-small px-3 py-1">+ Créer</button>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-body text-gray-600">Total émises</span>
                                <span class="text-body font-semibold text-gray-800">{{ $giftCards['total_issued'] ?? 234 }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-body text-gray-600">Valeur totale</span>
                                <span class="text-body font-semibold text-success-600">{{ number_format($giftCards['total_value'] ?? 45680, 0, ',', ' ') }}€</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-body text-gray-600">Actives</span>
                                <span class="text-body font-semibold text-brand-600">{{ $giftCards['active_cards'] ?? 189 }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-body text-gray-600">Utilisées</span>
                                <span class="text-body font-semibold text-secondary-500">{{ $giftCards['used_cards'] ?? 45 }}</span>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <div class="flex gap-2">
                                <button class="btn-outline text-small flex-1">Voir toutes</button>
                                <button class="btn-primary text-small flex-1">Gérer</button>
                            </div>
                        </div>
                    </div>

                    <!-- Coupons -->
                    <div class="card">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-h3 text-dark-800">🎫 Coupons</h3>
                            <button class="btn-primary text-small px-3 py-1">+ Créer</button>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-body text-gray-600">Total créés</span>
                                <span class="text-body font-semibold text-gray-800">{{ $coupons['total_created'] ?? 156 }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-body text-gray-600">Actifs</span>
                                <span class="text-body font-semibold text-brand-600">{{ $coupons['active_coupons'] ?? 89 }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-body text-gray-600">Utilisés</span>
                                <span class="text-body font-semibold text-secondary-500">{{ $coupons['used_coupons'] ?? 67 }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-body text-gray-600">Réduction totale</span>
                                <span class="text-body font-semibold text-success-600">{{ number_format($coupons['total_discount'] ?? 12340, 0, ',', ' ') }}€</span>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <div class="flex gap-2">
                                <button class="btn-outline text-small flex-1">Voir toutes</button>
                                <button class="btn-primary text-small flex-1">Gérer</button>
                            </div>
                        </div>
                    </div>

                    <!-- Offres Spéciales -->
                    <div class="card">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-h3 text-dark-800">⭐ Offres Spéciales</h3>
                            <button class="btn-primary text-small px-3 py-1">+ Créer</button>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-body text-gray-600">Total offres</span>
                                <span class="text-body font-semibold text-gray-800">{{ $specialOffers['total_offers'] ?? 34 }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-body text-gray-600">Actives</span>
                                <span class="text-body font-semibold text-brand-600">{{ $specialOffers['active_offers'] ?? 12 }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-body text-gray-600">Expirées</span>
                                <span class="text-body font-semibold text-gray-500">{{ $specialOffers['expired_offers'] ?? 18 }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-body text-gray-600">Revenus générés</span>
                                <span class="text-body font-semibold text-success-600">{{ number_format($specialOffers['total_revenue'] ?? 23450, 0, ',', ' ') }}€</span>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <div class="flex gap-2">
                                <button class="btn-outline text-small flex-1">Voir toutes</button>
                                <button class="btn-primary text-small flex-1">Gérer</button>
                            </div>
                        </div>
                    </div>

                    <!-- Promos Spéciales -->
                    <div class="card">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-h3 text-dark-800">🎯 Promos Spéciales</h3>
                            <button class="btn-primary text-small px-3 py-1">+ Créer</button>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-body text-gray-600">Total promos</span>
                                <span class="text-body font-semibold text-gray-800">{{ $promotions['total_promos'] ?? 67 }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-body text-gray-600">Actives</span>
                                <span class="text-body font-semibold text-brand-600">{{ $promotions['active_promos'] ?? 23 }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-body text-gray-600">Programmées</span>
                                <span class="text-body font-semibold text-info-500">{{ $promotions['scheduled_promos'] ?? 8 }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-body text-gray-600">Économies totales</span>
                                <span class="text-body font-semibold text-success-600">{{ number_format($promotions['total_savings'] ?? 45670, 0, ',', ' ') }}€</span>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <div class="flex gap-2">
                                <button class="btn-outline text-small flex-1">Voir toutes</button>
                                <button class="btn-primary text-small flex-1">Gérer</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tableau des Abonnements -->
                <div class="card">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-h2 text-dark-800">Abonnements</h2>
                        <div class="flex gap-2">
                            <button class="btn-outline text-small">Exporter CSV</button>
                            <button class="btn-primary text-small">+ Nouvel abonnement</button>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-dark-800 text-white">
                                <tr>
                                    <th class="px-6 py-4 text-left font-label font-semibold">Utilisateur</th>
                                    <th class="px-6 py-4 text-left font-label font-semibold">Plan</th>
                                    <th class="px-6 py-4 text-left font-label font-semibold">Statut</th>
                                    <th class="px-6 py-4 text-left font-label font-semibold">Montant</th>
                                    <th class="px-6 py-4 text-left font-label font-semibold">Début</th>
                                    <th class="px-6 py-4 text-left font-label font-semibold">Renouvellement</th>
                                    <th class="px-6 py-4 text-left font-label font-semibold">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @for($i = 1; $i <= 10; $i++)
                                <tr class="hover:bg-light-300 transition-colors {{ $i % 2 === 0 ? 'bg-light-300' : '' }}">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-gradient-to-br from-brand-500 to-brand-700 rounded-full flex items-center justify-center text-white font-bold">
                                                {{ chr(64 + ($i % 26) + 1) }}
                                            </div>
                                            <div>
                                                <div class="text-body text-gray-900 font-medium">Restaurant {{ $i }}</div>
                                                <div class="text-small text-gray-500">restaurant{{ $i }}@example.com</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-label font-medium text-gray-800">
                                            @if($i % 3 === 0)
                                                Enterprise
                                            @elseif($i % 2 === 0)
                                                Premium
                                            @else
                                                Starter
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($i % 5 === 0)
                                            <span class="badge-danger">Suspendu</span>
                                        @elseif($i % 7 === 0)
                                            <span class="badge-warning">En attente</span>
                                        @elseif($i % 11 === 0)
                                            <span class="badge-info">Essai</span>
                                        @else
                                            <span class="badge-success">Actif</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-body text-gray-900 font-medium">
                                        @if($i % 3 === 0)
                                            199€
                                        @elseif($i % 2 === 0)
                                            89€
                                        @else
                                            29€
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-body text-gray-900">{{ date('d/m/Y', strtotime("-{$i} months")) }}</td>
                                    <td class="px-6 py-4 text-body text-gray-900">{{ date('d/m/Y', strtotime('+1 month')) }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex gap-2">
                                            <button class="text-brand-600 hover:text-brand-700 text-small font-medium">Voir</button>
                                            <button class="text-secondary-600 hover:text-secondary-700 text-small font-medium">Modifier</button>
                                            @if($i % 5 !== 0)
                                                <button class="text-danger-600 hover:text-danger-700 text-small font-medium">Suspendre</button>
                                            @else
                                                <button class="text-success-600 hover:text-success-700 text-small font-medium">Réactiver</button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="flex items-center justify-between mt-6 pt-6 border-t border-gray-200">
                        <div class="text-small text-gray-600">
                            Affichage de 1 à 10 sur {{ $totalSubscriptions ?? 1,247 }} résultats
                        </div>
                        <div class="flex gap-2">
                            <button class="btn-outline text-small px-3 py-1" disabled>Précédent</button>
                            <button class="btn-primary text-small px-3 py-1">1</button>
                            <button class="btn-outline text-small px-3 py-1">2</button>
                            <button class="btn-outline text-small px-3 py-1">3</button>
                            <span class="px-3 py-1 text-gray-500">...</span>
                            <button class="btn-outline text-small px-3 py-1">125</button>
                            <button class="btn-outline text-small px-3 py-1">Suivant</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Revenus -->
                <div class="card">
                    <h3 class="text-h3 text-dark-800 mb-4">Revenus</h3>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-body text-gray-600">Ce mois</span>
                            <span class="text-body font-semibold text-gray-800">{{ number_format($monthlyRevenue ?? 89,247, ',', ' ') }}€</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-body text-gray-600">Mois dernier</span>
                            <span class="text-body font-semibold text-gray-800">{{ number_format($lastMonthRevenue ?? 85,432, ',', ' ') }}€</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-body text-gray-600">Cette année</span>
                            <span class="text-body font-semibold text-gray-800">{{ number_format($yearlyRevenue ?? 1,067,234, ',', ' ') }}€</span>
                        </div>
                        
                        <div class="pt-4 border-t border-gray-200">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-4 h-4 text-success-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-small text-success-600 font-medium">+4.5% vs mois dernier</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Plans Populaires -->
                <div class="card">
                    <h3 class="text-h3 text-dark-800 mb-4">Plans Populaires</h3>
                    
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="font-label font-medium text-gray-800">Premium</div>
                                <div class="text-small text-gray-600">89€/mois</div>
                            </div>
                            <div class="text-right">
                                <div class="text-body font-bold text-gray-800">{{ $premiumCount ?? 756 }}</div>
                                <div class="text-small text-gray-500">utilisateurs</div>
                            </div>
                        </div>
                        
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-brand-500 h-2 rounded-full" style="width: 65%"></div>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="font-label font-medium text-gray-800">Starter</div>
                                <div class="text-small text-gray-600">29€/mois</div>
                            </div>
                            <div class="text-right">
                                <div class="text-body font-bold text-gray-800">{{ $starterCount ?? 312 }}</div>
                                <div class="text-small text-gray-500">utilisateurs</div>
                            </div>
                        </div>
                        
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-secondary-500 h-2 rounded-full" style="width: 27%"></div>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="font-label font-medium text-gray-800">Enterprise</div>
                                <div class="text-small text-gray-600">199€/mois</div>
                            </div>
                            <div class="text-right">
                                <div class="text-body font-bold text-gray-800">{{ $enterpriseCount ?? 179 }}</div>
                                <div class="text-small text-gray-500">utilisateurs</div>
                            </div>
                        </div>
                        
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-info-500 h-2 rounded-full" style="width: 15%"></div>
                        </div>
                    </div>
                </div>

                <!-- Actions Rapides -->
                <div class="card">
                    <h3 class="text-h3 text-dark-800 mb-4">Actions Rapides</h3>
                    
                    <div class="space-y-3">
                        <button class="w-full text-left p-3 border border-gray-200 rounded-lg hover:border-brand-300 hover:bg-brand-50 transition-colors">
                            <div class="font-label font-medium text-gray-800">Nouvel abonnement</div>
                            <div class="text-small text-gray-600">Créer un abonnement manuel</div>
                        </button>
                        
                        <button class="w-full text-left p-3 border border-gray-200 rounded-lg hover:border-brand-300 hover:bg-brand-50 transition-colors">
                            <div class="font-label font-medium text-gray-800">Rapport mensuel</div>
                            <div class="text-small text-gray-600">Générer les statistiques</div>
                        </button>
                        
                        <button class="w-full text-left p-3 border border-gray-200 rounded-lg hover:border-brand-300 hover:bg-brand-50 transition-colors">
                            <div class="font-label font-medium text-gray-800">Export des données</div>
                            <div class="text-small text-gray-600">Télécharger en CSV/Excel</div>
                        </button>
                        
                        <button class="w-full text-left p-3 border border-gray-200 rounded-lg hover:border-brand-300 hover:bg-brand-50 transition-colors">
                            <div class="font-label font-medium text-gray-800">Gestion des échecs</div>
                            <div class="text-small text-gray-600">Paiements échoués</div>
                        </button>
                    </div>
                </div>

                <!-- Alertes -->
                <div class="card">
                    <h3 class="text-h3 text-dark-800 mb-4">Alertes</h3>
                    
                    <div class="space-y-3">
                        @if(($failedPayments ?? 12) > 0)
                        <div class="alert-warning">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                <div>
                                    <div class="font-label font-semibold">{{ $failedPayments ?? 12 }} paiements échoués</div>
                                    <div class="text-small">Action requise</div>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if(($trialsEnding ?? 8) > 0)
                        <div class="alert-info">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                                <div>
                                    <div class="font-label font-semibold">{{ $trialsEnding ?? 8 }} essais se terminent</div>
                                    <div class="text-small">Cette semaine</div>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if(($cancellations ?? 3) > 0)
                        <div class="alert-danger">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                                <div>
                                    <div class="font-label font-semibold">{{ $cancellations ?? 3 }} annulations</div>
                                    <div class="text-small">Cette semaine</div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Performance Live -->
                <div class="card">
                    <h3 class="text-h3 text-dark-800 mb-4">📈 Performance Live</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-body text-gray-600">Commandes/min</span>
                            <span class="text-body font-bold text-green-600">{{ $liveStats['orders_per_minute'] ?? 12 }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-body text-gray-600">Utilisateurs actifs</span>
                            <span class="text-body font-bold text-blue-600">{{ $liveStats['active_users'] ?? 247 }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-body text-gray-600">Revenus/heure</span>
                            <span class="text-body font-bold text-purple-600">{{ number_format($liveStats['revenue_per_hour'] ?? 1234, 0, ',', ' ') }}€</span>
                        </div>
                    </div>
                </div>

                <!-- Objectifs du Mois -->
                <div class="card">
                    <h3 class="text-h3 text-dark-800 mb-4">🎯 Objectifs du Mois</h3>
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-body text-gray-600">Revenus</span>
                                <span class="text-body font-bold text-gray-800">{{ $monthlyGoals['revenue_percentage'] ?? 78 }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: {{ $monthlyGoals['revenue_percentage'] ?? 78 }}%"></div>
                            </div>
                            <div class="text-small text-gray-500 mt-1">{{ number_format($monthlyGoals['revenue_current'] ?? 156000, 0, ',', ' ') }}€ / {{ number_format($monthlyGoals['revenue_target'] ?? 200000, 0, ',', ' ') }}€</div>
                        </div>
                        
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-body text-gray-600">Nouveaux clients</span>
                                <span class="text-body font-bold text-gray-800">{{ $monthlyGoals['customers_percentage'] ?? 65 }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $monthlyGoals['customers_percentage'] ?? 65 }}%"></div>
                            </div>
                            <div class="text-small text-gray-500 mt-1">{{ $monthlyGoals['customers_current'] ?? 130 }} / {{ $monthlyGoals['customers_target'] ?? 200 }}</div>
                        </div>
                    </div>
                </div>

                <!-- Événements -->
                <div class="card">
                    <h3 class="text-h3 text-dark-800 mb-4">📅 Événements</h3>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3 p-2 bg-blue-50 rounded-lg">
                            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                <span class="text-white text-small font-bold">15</span>
                            </div>
                            <div>
                                <div class="font-label font-medium text-gray-800">Black Friday</div>
                                <div class="text-small text-gray-600">Promotion spéciale</div>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-3 p-2 bg-green-50 rounded-lg">
                            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                <span class="text-white text-small font-bold">20</span>
                            </div>
                            <div>
                                <div class="font-label font-medium text-gray-800">Réunion équipe</div>
                                <div class="text-small text-gray-600">14:00 - 16:00</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Performers -->
                <div class="card">
                    <h3 class="text-h3 text-dark-800 mb-4">🏆 Top Performers</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center">
                                    <span class="text-white text-small font-bold">1</span>
                                </div>
                                <div>
                                    <div class="font-label font-medium text-gray-800">Le Dakarois Gourmand</div>
                                    <div class="text-small text-gray-600">Restaurant</div>
                                </div>
                            </div>
                            <div class="text-body font-bold text-green-600">+24%</div>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-gray-400 rounded-full flex items-center justify-center">
                                    <span class="text-white text-small font-bold">2</span>
                                </div>
                                <div>
                                    <div class="font-label font-medium text-gray-800">Sunset Lounge</div>
                                    <div class="text-small text-gray-600">Bar</div>
                                </div>
                            </div>
                            <div class="text-body font-bold text-green-600">+18%</div>
                        </div>
                    </div>
                </div>

                <!-- Activité Récente -->
                <div class="card">
                    <h3 class="text-h3 text-dark-800 mb-4">💬 Activité Récente</h3>
                    <div class="space-y-3">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <div class="font-label font-medium text-gray-800">Nouveau restaurant ajouté</div>
                                <div class="text-small text-gray-600">Il y a 5 minutes</div>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <div class="font-label font-medium text-gray-800">Paiement de 1,250€ reçu</div>
                                <div class="text-small text-gray-600">Il y a 12 minutes</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activité Géographique -->
                <div class="card">
                    <h3 class="text-h3 text-dark-800 mb-4">🌍 Activité Géographique</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-body text-gray-600">Dakar</span>
                            <span class="text-body font-bold text-gray-800">{{ $geographicStats['dakar'] ?? 45 }}%</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-body text-gray-600">Thiès</span>
                            <span class="text-body font-bold text-gray-800">{{ $geographicStats['thies'] ?? 23 }}%</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-body text-gray-600">Saint-Louis</span>
                            <span class="text-body font-bold text-gray-800">{{ $geographicStats['saint_louis'] ?? 18 }}%</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-body text-gray-600">Autres</span>
                            <span class="text-body font-bold text-gray-800">{{ $geographicStats['others'] ?? 14 }}%</span>
                        </div>
                    </div>
                </div>

                <!-- Notifications -->
                <div class="card">
                    <h3 class="text-h3 text-dark-800 mb-4">🔔 Notifications</h3>
                    <div class="space-y-3">
                        <div class="p-3 bg-red-50 border border-red-200 rounded-lg">
                            <div class="flex items-start gap-3">
                                <div class="w-2 h-2 bg-red-500 rounded-full mt-2"></div>
                                <div>
                                    <div class="font-label font-medium text-red-800">Système de paiement</div>
                                    <div class="text-small text-red-600">Maintenance programmée à 02:00</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-3 bg-blue-50 border border-blue-200 rounded-lg">
                            <div class="flex items-start gap-3">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                                <div>
                                    <div class="font-label font-medium text-blue-800">Nouvelle fonctionnalité</div>
                                    <div class="text-small text-blue-600">Gestion des stocks disponible</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tendances -->
                <div class="card">
                    <h3 class="text-h3 text-dark-800 mb-4">📊 Tendances</h3>
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-body text-gray-600">Commandes (7j)</span>
                                <span class="text-body font-bold text-green-600">+12%</span>
                            </div>
                            <div class="h-16 bg-gray-100 rounded-lg flex items-end justify-between p-2">
                                <div class="w-2 bg-green-500 rounded-t" style="height: 40%"></div>
                                <div class="w-2 bg-green-500 rounded-t" style="height: 60%"></div>
                                <div class="w-2 bg-green-500 rounded-t" style="height: 45%"></div>
                                <div class="w-2 bg-green-500 rounded-t" style="height: 80%"></div>
                                <div class="w-2 bg-green-500 rounded-t" style="height: 70%"></div>
                                <div class="w-2 bg-green-500 rounded-t" style="height: 90%"></div>
                                <div class="w-2 bg-green-500 rounded-t" style="height: 100%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Outils Dev -->
                <div class="card">
                    <h3 class="text-h3 text-dark-800 mb-4">🔧 Outils Dev</h3>
                    <div class="space-y-3">
                        <button class="w-full text-left p-3 border border-gray-200 rounded-lg hover:border-blue-300 hover:bg-blue-50 transition-colors">
                            <div class="font-label font-medium text-gray-800">Logs système</div>
                            <div class="text-small text-gray-600">Voir les derniers logs</div>
                        </button>
                        
                        <button class="w-full text-left p-3 border border-gray-200 rounded-lg hover:border-green-300 hover:bg-green-50 transition-colors">
                            <div class="font-label font-medium text-gray-800">Cache</div>
                            <div class="text-small text-gray-600">Vider le cache</div>
                        </button>
                        
                        <button class="w-full text-left p-3 border border-gray-200 rounded-lg hover:border-purple-300 hover:bg-purple-50 transition-colors">
                            <div class="font-label font-medium text-gray-800">Backup</div>
                            <div class="text-small text-gray-600">Créer une sauvegarde</div>
                        </button>
                    </div>
                </div>

                <!-- Personnalisation Interface -->
                <div class="card">
                    <h3 class="text-h3 text-dark-800 mb-4">🎨 Interface</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-body text-gray-600">Mode sombre</span>
                            <button class="w-12 h-6 bg-gray-300 rounded-full relative">
                                <div class="w-4 h-4 bg-white rounded-full absolute top-1 left-1 transition-transform"></div>
                            </button>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-body text-gray-600">Notifications</span>
                            <button class="w-12 h-6 bg-green-500 rounded-full relative">
                                <div class="w-4 h-4 bg-white rounded-full absolute top-1 right-1 transition-transform"></div>
                            </button>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <span class="text-body text-gray-600">Auto-refresh</span>
                            <button class="w-12 h-6 bg-green-500 rounded-full relative">
                                <div class="w-4 h-4 bg-white rounded-full absolute top-1 right-1 transition-transform"></div>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Alertes Promotionnelles -->
                <div class="card">
                    <h3 class="text-h3 text-dark-800 mb-4">🎯 Alertes Promotionnelles</h3>
                    
                    <div class="space-y-3">
                        @if(($giftCards['pending_cards'] ?? 8) > 0)
                        <div class="alert-info">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                                <div>
                                    <div class="font-label font-semibold">{{ $giftCards['pending_cards'] ?? 8 }} cartes cadeaux en attente</div>
                                    <div class="text-small">Validation requise</div>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if(($coupons['pending_approval'] ?? 5) > 0)
                        <div class="alert-warning">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                <div>
                                    <div class="font-label font-semibold">{{ $coupons['pending_approval'] ?? 5 }} coupons en attente</div>
                                    <div class="text-small">Approbation requise</div>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if(($specialOffers['pending_offers'] ?? 3) > 0)
                        <div class="alert-info">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                                <div>
                                    <div class="font-label font-semibold">{{ $specialOffers['pending_offers'] ?? 3 }} offres en attente</div>
                                    <div class="text-small">Activation requise</div>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        @if(($promotions['pending_promos'] ?? 6) > 0)
                        <div class="alert-warning">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                <div>
                                    <div class="font-label font-semibold">{{ $promotions['pending_promos'] ?? 6 }} promos en attente</div>
                                    <div class="text-small">Programmation requise</div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Styles spécifiques pour la page admin */
.animate-blob {
    animation: blob 7s infinite;
}

@keyframes blob {
    0% {
        transform: translate(0px, 0px) scale(1);
    }
    33% {
        transform: translate(30px, -50px) scale(1.1);
    }
    66% {
        transform: translate(-20px, 20px) scale(0.9);
    }
    100% {
        transform: translate(0px, 0px) scale(1);
    }
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}
</style>
@endpush
