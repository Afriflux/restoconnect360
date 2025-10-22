#!/bin/bash

# RestoConnect360 - Script de Démarrage Complet
# Ce script démarre toute la plateforme RestoConnect360

echo "🚀 RestoConnect360 - Démarrage de la Plateforme"
echo "================================================"

# Vérifier si Docker est installé
if ! command -v docker &> /dev/null; then
    echo "❌ Docker n'est pas installé. Veuillez installer Docker d'abord."
    exit 1
fi

# Vérifier si Docker Compose est installé
if ! command -v docker-compose &> /dev/null; then
    echo "❌ Docker Compose n'est pas installé. Veuillez installer Docker Compose d'abord."
    exit 1
fi

echo "✅ Docker et Docker Compose détectés"

# Créer le fichier .env pour le backend si il n'existe pas
if [ ! -f "restoconnect-backend/.env" ]; then
    echo "📝 Création du fichier .env pour le backend..."
    cp restoconnect-backend/env.example restoconnect-backend/.env
    echo "✅ Fichier .env créé"
fi

# Démarrer les services avec Docker Compose
echo "🐳 Démarrage des services Docker..."
docker-compose up -d postgres redis

# Attendre que PostgreSQL soit prêt
echo "⏳ Attente que PostgreSQL soit prêt..."
sleep 10

# Générer le client Prisma
echo "🔧 Génération du client Prisma..."
cd restoconnect-backend
npx prisma generate

# Exécuter les migrations
echo "🗄️ Exécution des migrations de base de données..."
npx prisma migrate dev --name init

# Retourner au répertoire racine
cd ..

echo ""
echo "🎉 RestoConnect360 est prêt !"
echo ""
echo "📊 Services disponibles :"
echo "  • Frontend: http://localhost:3000"
echo "  • Backend API: http://localhost:3001"
echo "  • PostgreSQL: localhost:5432"
echo "  • Redis: localhost:6379"
echo ""
echo "🔑 Comptes de test :"
echo "  • Super Admin: admin@restoconnect360.com / admin123"
echo "  • Commerce Demo: demo@restaurant.com / demo123"
echo ""
echo "📚 Documentation :"
echo "  • API Docs: http://localhost:3001/api/docs"
echo "  • Prisma Studio: npx prisma studio (dans restoconnect-backend/)"
echo ""
echo "🚀 Pour démarrer le développement :"
echo "  • Backend: cd restoconnect-backend && npm run start:dev"
echo "  • Frontend: cd restoconnect-frontend && npm run dev"
echo ""
echo "✨ RestoConnect360 - Plateforme Multi-Commerces Horeca/CHR"
echo "   Zone UEMOA • Franc CFA (XOF) • 100% Digital"
