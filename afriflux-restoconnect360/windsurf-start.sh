#!/bin/bash

# RestoConnect360 - Démarrage rapide Windsurf
# Script optimisé pour Windsurf avec démarrage parallèle

set -e

echo "🚀 RestoConnect360 - Démarrage Windsurf"
echo "========================================"

# Fonction pour vérifier si un port est libre
check_port() {
    local port=$1
    if lsof -Pi :$port -sTCP:LISTEN -t >/dev/null 2>&1; then
        return 1
    else
        return 0
    fi
}

# Fonction pour attendre qu'un service soit prêt
wait_for_service() {
    local url=$1
    local max_attempts=30
    local attempt=1
    
    while [ $attempt -le $max_attempts ]; do
        if curl -s "$url" >/dev/null 2>&1; then
            return 0
        fi
        sleep 1
        attempt=$((attempt + 1))
    done
    return 1
}

# Vérifier les ports
echo "🔍 Vérification des ports..."

if ! check_port 8000; then
    echo "❌ Port 8000 (Laravel) est déjà utilisé"
    exit 1
fi

if ! check_port 5173; then
    echo "❌ Port 5173 (Vite) est déjà utilisé"
    exit 1
fi

echo "✅ Ports disponibles"

# Configuration rapide
echo "⚙️  Configuration rapide..."

# Vérifier .env
if [ ! -f .env ]; then
    if [ -f .env.example ]; then
        cp .env.example .env
        echo "📝 Fichier .env créé"
    else
        echo "❌ Fichier .env.example non trouvé"
        exit 1
    fi
fi

# Générer la clé si nécessaire
if ! grep -q "APP_KEY=" .env || grep -q "APP_KEY=$" .env; then
    php artisan key:generate --force
    echo "🔑 Clé d'application générée"
fi

# Cache rapide
php artisan config:cache >/dev/null 2>&1
echo "💾 Cache configuré"

# Démarrer les services
echo "🚀 Démarrage des services..."

# Démarrer Laravel
echo "  • Laravel (port 8000)..."
php artisan serve --host=0.0.0.0 --port=8000 >/dev/null 2>&1 &
LARAVEL_PID=$!

# Attendre que Laravel soit prêt
if wait_for_service "http://localhost:8000"; then
    echo "  ✅ Laravel démarré"
else
    echo "  ❌ Laravel n'a pas démarré"
    kill $LARAVEL_PID 2>/dev/null
    exit 1
fi

# Démarrer Vite
echo "  • Vite (port 5173)..."
npm run dev >/dev/null 2>&1 &
VITE_PID=$!

# Attendre que Vite soit prêt
if wait_for_service "http://localhost:5173"; then
    echo "  ✅ Vite démarré"
else
    echo "  ❌ Vite n'a pas démarré"
    kill $LARAVEL_PID $VITE_PID 2>/dev/null
    exit 1
fi

# Démarrer Horizon (optionnel)
if command -v redis-cli &> /dev/null && redis-cli ping &> /dev/null; then
    echo "  • Horizon (Redis)..."
    php artisan horizon >/dev/null 2>&1 &
    HORIZON_PID=$!
    echo "  ✅ Horizon démarré"
else
    echo "  ⚠️  Horizon ignoré (Redis non disponible)"
    HORIZON_PID=""
fi

echo ""
echo "🎉 RestoConnect360 démarré avec succès!"
echo "========================================"
echo ""
echo "🌐 URLs disponibles:"
echo "  • Application: http://localhost:8000"
echo "  • Vite Dev: http://localhost:5173"
echo "  • Telescope: http://localhost:8000/telescope"
if [ ! -z "$HORIZON_PID" ]; then
    echo "  • Horizon: http://localhost:8000/horizon"
fi
echo ""
echo "📊 PIDs des processus:"
echo "  • Laravel: $LARAVEL_PID"
echo "  • Vite: $VITE_PID"
if [ ! -z "$HORIZON_PID" ]; then
    echo "  • Horizon: $HORIZON_PID"
fi
echo ""
echo "🛑 Pour arrêter tous les services:"
if [ ! -z "$HORIZON_PID" ]; then
    echo "  kill $LARAVEL_PID $VITE_PID $HORIZON_PID"
else
    echo "  kill $LARAVEL_PID $VITE_PID"
fi
echo ""
echo "📝 Logs en temps réel:"
echo "  • Laravel: tail -f storage/logs/laravel.log"
echo "  • Horizon: php artisan horizon:status"
echo ""

# Fonction de nettoyage
cleanup() {
    echo ""
    echo "🛑 Arrêt des services..."
    kill $LARAVEL_PID $VITE_PID 2>/dev/null
    if [ ! -z "$HORIZON_PID" ]; then
        kill $HORIZON_PID 2>/dev/null
    fi
    echo "✅ Services arrêtés"
    exit 0
}

# Capturer les signaux d'arrêt
trap cleanup INT TERM

# Attendre indéfiniment
echo "💡 Appuyez sur Ctrl+C pour arrêter tous les services"
echo ""

# Boucle d'attente avec monitoring
while true; do
    # Vérifier que les processus sont toujours actifs
    if ! kill -0 $LARAVEL_PID 2>/dev/null; then
        echo "❌ Laravel s'est arrêté inattendu"
        cleanup
    fi
    
    if ! kill -0 $VITE_PID 2>/dev/null; then
        echo "❌ Vite s'est arrêté inattendu"
        cleanup
    fi
    
    if [ ! -z "$HORIZON_PID" ] && ! kill -0 $HORIZON_PID 2>/dev/null; then
        echo "❌ Horizon s'est arrêté inattendu"
        cleanup
    fi
    
    sleep 5
done
