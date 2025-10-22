#!/bin/bash

# RestoConnect360 - Script de démarrage Windsurf
# Ce script configure automatiquement l'environnement de développement

set -e

echo "🚀 RestoConnect360 - Configuration Windsurf"
echo "=============================================="

# Couleurs pour les messages
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Fonction pour afficher les messages
print_status() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

print_success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Vérifier les prérequis
print_status "Vérification des prérequis..."

# Vérifier PHP
if ! command -v php &> /dev/null; then
    print_error "PHP n'est pas installé. Veuillez installer PHP 8.2+"
    exit 1
fi

PHP_VERSION=$(php -r "echo PHP_VERSION;")
print_success "PHP $PHP_VERSION détecté"

# Vérifier Composer
if ! command -v composer &> /dev/null; then
    print_error "Composer n'est pas installé. Veuillez installer Composer"
    exit 1
fi

print_success "Composer détecté"

# Vérifier Node.js
if ! command -v node &> /dev/null; then
    print_error "Node.js n'est pas installé. Veuillez installer Node.js 18+"
    exit 1
fi

NODE_VERSION=$(node --version)
print_success "Node.js $NODE_VERSION détecté"

# Vérifier npm
if ! command -v npm &> /dev/null; then
    print_error "npm n'est pas installé"
    exit 1
fi

print_success "npm détecté"

# Installation des dépendances PHP
print_status "Installation des dépendances PHP..."
composer install --no-interaction --prefer-dist --optimize-autoloader
print_success "Dépendances PHP installées"

# Installation des dépendances Node.js
print_status "Installation des dépendances Node.js..."
npm install --silent
print_success "Dépendances Node.js installées"

# Configuration de l'environnement
print_status "Configuration de l'environnement..."

if [ ! -f .env ]; then
    if [ -f .env.example ]; then
        cp .env.example .env
        print_success "Fichier .env créé depuis .env.example"
    else
        print_error "Fichier .env.example non trouvé"
        exit 1
    fi
else
    print_warning "Fichier .env existe déjà"
fi

# Génération de la clé d'application
print_status "Génération de la clé d'application..."
php artisan key:generate --force
print_success "Clé d'application générée"

# Configuration de la base de données
print_status "Configuration de la base de données..."

# Vérifier si MySQL est disponible
if command -v mysql &> /dev/null; then
    print_success "MySQL détecté"
else
    print_warning "MySQL non détecté. Assurez-vous que MySQL est installé et démarré"
fi

# Exécution des migrations
print_status "Exécution des migrations..."
php artisan migrate --force
print_success "Migrations exécutées"

# Exécution des seeders
print_status "Exécution des seeders..."
php artisan db:seed --force
print_success "Seeders exécutés"

# Configuration du cache
print_status "Configuration du cache..."
php artisan config:cache
php artisan route:cache
print_success "Cache configuré"

# Vérification Redis
print_status "Vérification de Redis..."
if command -v redis-cli &> /dev/null; then
    if redis-cli ping &> /dev/null; then
        print_success "Redis est disponible"
    else
        print_warning "Redis n'est pas démarré. Veuillez démarrer Redis"
    fi
else
    print_warning "Redis non détecté. Veuillez installer Redis"
fi

# Création des répertoires nécessaires
print_status "Création des répertoires nécessaires..."
mkdir -p storage/logs
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p bootstrap/cache
print_success "Répertoires créés"

# Configuration des permissions
print_status "Configuration des permissions..."
chmod -R 775 storage bootstrap/cache
print_success "Permissions configurées"

# Build des assets
print_status "Build des assets..."
npm run build
print_success "Assets construits"

# Vérification finale
print_status "Vérification finale..."

# Test de l'application
if php artisan --version &> /dev/null; then
    print_success "Laravel fonctionne correctement"
else
    print_error "Problème avec Laravel"
    exit 1
fi

# Affichage des informations de démarrage
echo ""
echo "🎉 Configuration terminée avec succès!"
echo "======================================"
echo ""
echo "📋 Informations de démarrage:"
echo "  • Laravel: http://localhost:8000"
echo "  • Vite Dev: http://localhost:5173"
echo "  • Telescope: http://localhost:8000/telescope"
echo "  • Horizon: http://localhost:8000/horizon"
echo ""
echo "🚀 Commandes de démarrage:"
echo "  • Backend: php artisan serve --host=0.0.0.0 --port=8000"
echo "  • Frontend: npm run dev"
echo "  • Horizon: php artisan horizon"
echo ""
echo "🔧 Commandes utiles:"
echo "  • Tests: php artisan test"
echo "  • Cache: php artisan optimize"
echo "  • Logs: tail -f storage/logs/laravel.log"
echo ""
echo "📚 Documentation: WINDSURF_README.md"
echo ""

# Option de démarrage automatique
read -p "Voulez-vous démarrer les serveurs maintenant? (y/N): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    print_status "Démarrage des serveurs..."
    
    # Démarrer Laravel en arrière-plan
    php artisan serve --host=0.0.0.0 --port=8000 &
    LARAVEL_PID=$!
    
    # Démarrer Vite en arrière-plan
    npm run dev &
    VITE_PID=$!
    
    print_success "Serveurs démarrés!"
    echo "  • Laravel PID: $LARAVEL_PID"
    echo "  • Vite PID: $VITE_PID"
    echo ""
    echo "Pour arrêter les serveurs:"
    echo "  kill $LARAVEL_PID $VITE_PID"
    echo ""
    echo "Ou utilisez Ctrl+C pour arrêter ce script"
    
    # Attendre l'interruption
    trap "kill $LARAVEL_PID $VITE_PID 2>/dev/null; exit" INT
    wait
else
    print_status "Configuration terminée. Utilisez les commandes ci-dessus pour démarrer."
fi
