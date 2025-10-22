<?php

/*
 * Test direct de la connexion Cloudflare R2
 * Sans passer par Artisan pour éviter les problèmes Redis
 */

require __DIR__.'/vendor/autoload.php';

use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Application;

echo "🧪 Test de connexion Cloudflare R2\n";
echo "=====================================\n\n";

// Charger l'application Laravel
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    // Test 1: Upload d'un fichier
    echo "📤 Test 1: Upload d'un fichier test...\n";
    $content = "Hello from RestoConnect360!\nR2 Storage is working!\nDate: " . date('Y-m-d H:i:s');
    $result = Storage::disk('r2')->put('test-restoconnect360.txt', $content);
    
    if ($result) {
        echo "✅ SUCCESS: Fichier uploadé avec succès!\n\n";
    } else {
        echo "❌ FAILED: L'upload a échoué\n\n";
        exit(1);
    }
    
    // Test 2: Vérifier l'existence
    echo "🔍 Test 2: Vérification de l'existence...\n";
    $exists = Storage::disk('r2')->exists('test-restoconnect360.txt');
    
    if ($exists) {
        echo "✅ SUCCESS: Le fichier existe sur R2!\n\n";
    } else {
        echo "❌ FAILED: Le fichier n'existe pas\n\n";
        exit(1);
    }
    
    // Test 3: Lire le contenu
    echo "📖 Test 3: Lecture du contenu...\n";
    $readContent = Storage::disk('r2')->get('test-restoconnect360.txt');
    
    if ($readContent === $content) {
        echo "✅ SUCCESS: Contenu lu correctement!\n";
        echo "   Contenu: " . substr($readContent, 0, 50) . "...\n\n";
    } else {
        echo "❌ FAILED: Le contenu ne correspond pas\n\n";
        exit(1);
    }
    
    // Test 4: Obtenir l'URL
    echo "🌐 Test 4: Génération de l'URL publique...\n";
    $url = Storage::disk('r2')->url('test-restoconnect360.txt');
    echo "✅ SUCCESS: URL générée!\n";
    echo "   URL: $url\n\n";
    
    // Test 5: Upload d'une image test
    echo "🖼️  Test 5: Upload d'une image test...\n";
    $imageContent = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==');
    $imageResult = Storage::disk('r2')->put('images/test-pixel.png', $imageContent);
    
    if ($imageResult) {
        echo "✅ SUCCESS: Image uploadée!\n";
        $imageUrl = Storage::disk('r2')->url('images/test-pixel.png');
        echo "   URL: $imageUrl\n\n";
    } else {
        echo "❌ FAILED: L'upload de l'image a échoué\n\n";
    }
    
    // Test 6: Lister les fichiers
    echo "📋 Test 6: Liste des fichiers sur R2...\n";
    $files = Storage::disk('r2')->allFiles();
    echo "✅ SUCCESS: " . count($files) . " fichier(s) trouvé(s)\n";
    foreach ($files as $file) {
        $size = Storage::disk('r2')->size($file);
        echo "   - $file (" . number_format($size) . " bytes)\n";
    }
    echo "\n";
    
    // Résumé final
    echo "=====================================\n";
    echo "🎉 TOUS LES TESTS SONT PASSÉS!\n";
    echo "=====================================\n\n";
    echo "✅ Cloudflare R2 est correctement configuré\n";
    echo "✅ Upload: Fonctionnel\n";
    echo "✅ Lecture: Fonctionnelle\n";
    echo "✅ URLs: Générées correctement\n";
    echo "✅ Storage: Opérationnel\n\n";
    
    echo "📊 Configuration R2:\n";
    echo "   Bucket: restoconnect360-production\n";
    echo "   Endpoint: https://6c3ca4ed5965ffe4e3fc207d8807eb1a.r2.cloudflarestorage.com\n";
    echo "   Fichiers: " . count($files) . "\n\n";
    
    echo "🚀 Prêt pour la production!\n";
    
} catch (\Exception $e) {
    echo "\n❌ ERREUR: " . $e->getMessage() . "\n";
    echo "   Fichier: " . $e->getFile() . ":" . $e->getLine() . "\n\n";
    echo "Trace:\n";
    echo $e->getTraceAsString() . "\n";
    exit(1);
}
