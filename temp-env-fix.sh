#\!/bin/bash
# Désactiver temporairement Redis pour tester R2
cd afriflux-restoconnect360

# Créer une copie de backup
cp .env .env.backup

# Remplacer Redis par des alternatives temporaires
sed -i '' 's/CACHE_STORE=redis/CACHE_STORE=file/' .env
sed -i '' 's/SESSION_DRIVER=redis/SESSION_DRIVER=file/' .env
sed -i '' 's/QUEUE_CONNECTION=redis/QUEUE_CONNECTION=database/' .env
sed -i '' 's/BROADCAST_CONNECTION=pusher/BROADCAST_CONNECTION=log/' .env

echo "✅ Configuration temporaire appliquée (Redis désactivé)"
echo "   Cache: file"
echo "   Session: file"
echo "   Queue: database"
echo "   Broadcast: log"
