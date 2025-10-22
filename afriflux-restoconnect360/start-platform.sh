#!/bin/bash

# Script de démarrage complet pour RestoConnect360
# Compatible avec Node.js 18.20.8

echo "🚀 RestoConnect360 - Démarrage de la plateforme"
echo "================================================"
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

# Attendre que le serveur démarre
sleep 3

# Vérifier que le serveur fonctionne
if curl -s http://localhost:8001 > /dev/null; then
    echo "✅ Serveur Laravel démarré sur http://localhost:8001"
else
    echo "❌ Erreur lors du démarrage du serveur Laravel"
    exit 1
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
echo "👤 Comptes de test disponibles :"
echo "Super Admin: superadmin@restoconnect360.com / Admin@2025"
echo "Admin: admin@restoconnect360.com / Admin@2025"
echo "Manager: manager@restaurantdakar.com / Manager@2025"
echo "Restaurant: restaurant@restoconnect360.com / Restaurant@2025"
echo "Agent: agent@restoconnect360.com / Agent@2025"
echo ""
echo "📊 Fonctionnalités disponibles :"
echo "✅ Navigation SPA (Single Page Application)"
echo "✅ Actualisation sans erreur 404"
echo "✅ API REST fonctionnelle"
echo "✅ Base de données avec 3 restaurants"
echo "✅ Routes catch-all configurées"
echo "✅ Interface responsive"
echo ""
echo "⚠️ Limitations actuelles :"
echo "⚠️ Pas de hot reload (nécessite Node.js 20+)"
echo "⚠️ Compilation manuelle des assets"
echo ""
echo "🚀 Pour une expérience complète :"
echo "1. Mettre à jour Node.js vers la version 20+"
echo "2. Exécuter: npm install && npm run dev"
echo "3. Profiter du hot reload et des fonctionnalités complètes"
echo ""
echo "🛑 Pour arrêter le serveur: Ctrl+C ou kill $LARAVEL_PID"
echo ""

# Attendre l'interruption
trap 'echo ""; echo "🛑 Arrêt du serveur..."; kill $LARAVEL_PID 2>/dev/null; echo "✅ Serveur arrêté"; exit 0' INT

# Garder le script en vie
wait $LARAVEL_PID
