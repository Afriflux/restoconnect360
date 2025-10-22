#!/bin/bash

# Script de démarrage hybride - Laravel + Vite
# Solution complète pour Node.js 18.20.8

echo "🚀 RestoConnect360 - Démarrage Hybride (Laravel + Vite)"
echo "======================================================="
echo ""

# Vérifier les prérequis
echo "📋 Vérification des prérequis..."
echo "Node.js: $(node --version)"
echo "npm: $(npm --version)"
echo "PHP: $(php --version | head -1)"
echo ""

# Arrêter les serveurs existants
echo "🛑 Arrêt des serveurs existants..."
pkill -f "php artisan serve" 2>/dev/null || true
pkill -f "vite" 2>/dev/null || true
echo "✅ Serveurs arrêtés"
echo ""

# Construire les assets alternatifs
echo "🔧 Construction des assets alternatifs..."
./build-alternative.sh
echo ""

# Démarrer le serveur Laravel
echo "🌐 Démarrage du serveur Laravel..."
php artisan serve --port=8001 &
LARAVEL_PID=$!

# Attendre que le serveur Laravel démarre
sleep 3

# Vérifier que le serveur Laravel fonctionne
if curl -s http://localhost:8001 > /dev/null; then
    echo "✅ Serveur Laravel démarré sur http://localhost:8001"
else
    echo "❌ Erreur lors du démarrage du serveur Laravel"
    exit 1
fi

# Démarrer le serveur Vite
echo "⚡ Démarrage du serveur Vite..."
npm run dev &
VITE_PID=$!

# Attendre que le serveur Vite démarre
sleep 5

# Vérifier que le serveur Vite fonctionne
if curl -s http://localhost:5173 > /dev/null 2>&1; then
    echo "✅ Serveur Vite démarré sur http://localhost:5173"
    VITE_AVAILABLE=true
else
    echo "⚠️ Serveur Vite non disponible (utilise les assets statiques)"
    VITE_AVAILABLE=false
fi

echo ""
echo "🎉 Plateforme RestoConnect360 démarrée avec succès !"
echo ""
echo "📋 Informations importantes :"
echo "🌐 Site web: http://localhost:8001"
echo "🏪 Restaurants: http://localhost:8001/restaurants"
echo "💰 Tarifs: http://localhost:8001/pricing"
echo "🔧 API: http://localhost:8001/api/restaurants"
echo ""

if [ "$VITE_AVAILABLE" = true ]; then
    echo "⚡ Serveur Vite: http://localhost:5173"
    echo "🔥 Hot reload: Activé"
    echo "📦 Assets: Dynamiques"
else
    echo "📦 Assets: Statiques (compilés)"
fi

echo ""
echo "👤 Comptes de test disponibles :"
echo "Super Admin: superadmin@restoconnect360.com / Admin@2025"
echo "Admin: admin@restoconnect360.com / Admin@2025"
echo "Manager: manager@restaurantdakar.com / Manager@2025"
echo "Restaurant: restaurant@restoconnect360.com / Restaurant@2025"
echo "Agent: agent@restoconnect360.com / Agent@2025"
echo "Driver: driver@restoconnect360.com / Driver@2025"
echo ""
echo "📊 Fonctionnalités disponibles :"
echo "✅ Navigation SPA (Single Page Application)"
echo "✅ Actualisation sans erreur 404"
echo "✅ API REST fonctionnelle"
echo "✅ Base de données avec 3 restaurants"
echo "✅ Routes catch-all configurées"
echo "✅ Interface responsive"
echo "✅ Dashboard livreur amélioré"
echo ""

if [ "$VITE_AVAILABLE" = true ]; then
    echo "🚀 Fonctionnalités avancées :"
    echo "✅ Hot reload pour développement"
    echo "✅ Compilation automatique des assets"
    echo "✅ Source maps pour debugging"
    echo "✅ Optimisations de performance"
else
    echo "⚠️ Limitations actuelles :"
    echo "⚠️ Pas de hot reload (assets statiques)"
    echo "⚠️ Compilation manuelle des assets"
fi

echo ""
echo "🛑 Pour arrêter les serveurs: Ctrl+C"
echo ""

# Fonction de nettoyage
cleanup() {
    echo ""
    echo "🛑 Arrêt des serveurs..."
    kill $LARAVEL_PID 2>/dev/null
    kill $VITE_PID 2>/dev/null
    echo "✅ Serveurs arrêtés"
    exit 0
}

# Capturer l'interruption
trap cleanup INT

# Garder le script en vie
wait
