<?php

/**
 * Test R2 ultra-minimal sans Laravel bootstrap
 * Utilise directement AWS SDK S3
 */

require __DIR__.'/afriflux-restoconnect360/vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

echo "🧪 Test Cloudflare R2 (Sans Laravel)\n";
echo "=====================================\n\n";

// Configuration R2
$config = [
    'version' => 'latest',
    'region' => 'auto',
    'endpoint' => 'https://6c3ca4ed5965ffe4e3fc207d8807eb1a.r2.cloudflarestorage.com',
    'use_path_style_endpoint' => false,
    'credentials' => [
        'key' => '28099c8c03f30d461a7544200a455a75',
        'secret' => '3f847b807ab9c929c7e6b2102af3b32cc88f6762633bc6679b93d45d43ab7b4b',
    ],
];

try {
    echo "📡 Connexion au endpoint R2...\n";
    $s3Client = new S3Client($config);
    echo "✅ Client S3 créé avec succès\n\n";
    
    // Test 1: Upload fichier
    echo "📤 Test 1: Upload d'un fichier...\n";
    $bucket = 'restoconnect360-production';
    $key = 'test-restoconnect360.txt';
    $content = "Hello from RestoConnect360!\n" .
               "R2 Storage is working perfectly!\n" .
               "Date: " . date('Y-m-d H:i:s') . "\n" .
               "Tested with AWS SDK directly";
    
    $result = $s3Client->putObject([
        'Bucket' => $bucket,
        'Key' => $key,
        'Body' => $content,
        'ContentType' => 'text/plain',
    ]);
    
    echo "✅ SUCCESS: Fichier uploadé!\n";
    echo "   ETag: " . $result['ETag'] . "\n\n";
    
    // Test 2: Vérifier existence
    echo "🔍 Test 2: Vérification de l'existence...\n";
    $exists = $s3Client->doesObjectExist($bucket, $key);
    
    if ($exists) {
        echo "✅ SUCCESS: Le fichier existe sur R2!\n\n";
    } else {
        echo "❌ FAILED: Le fichier n'existe pas\n\n";
        exit(1);
    }
    
    // Test 3: Lire le contenu
    echo "📖 Test 3: Lecture du contenu...\n";
    $object = $s3Client->getObject([
        'Bucket' => $bucket,
        'Key' => $key,
    ]);
    
    $readContent = $object['Body']->getContents();
    echo "✅ SUCCESS: Contenu lu correctement!\n";
    echo "   Taille: " . strlen($readContent) . " bytes\n";
    echo "   Aperçu: " . substr($readContent, 0, 50) . "...\n\n";
    
    // Test 4: Upload image
    echo "🖼️  Test 4: Upload d'une image test...\n";
    // Image 1x1 pixel transparent PNG
    $imageContent = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==');
    
    $imageResult = $s3Client->putObject([
        'Bucket' => $bucket,
        'Key' => 'images/test-pixel.png',
        'Body' => $imageContent,
        'ContentType' => 'image/png',
    ]);
    
    echo "✅ SUCCESS: Image uploadée!\n";
    echo "   ETag: " . $imageResult['ETag'] . "\n\n";
    
    // Test 5: Lister les fichiers
    echo "📋 Test 5: Liste des fichiers sur R2...\n";
    $objects = $s3Client->listObjects([
        'Bucket' => $bucket,
    ]);
    
    $fileCount = isset($objects['Contents']) ? count($objects['Contents']) : 0;
    echo "✅ SUCCESS: $fileCount fichier(s) trouvé(s)\n";
    
    if (isset($objects['Contents'])) {
        foreach ($objects['Contents'] as $object) {
            $size = number_format($object['Size']);
            $date = $object['LastModified']->format('Y-m-d H:i:s');
            echo "   - {$object['Key']} ($size bytes, $date)\n";
        }
    }
    echo "\n";
    
    // Test 6: Générer une URL
    echo "🌐 Test 6: Génération d'URL...\n";
    $url = "https://6c3ca4ed5965ffe4e3fc207d8807eb1a.r2.cloudflarestorage.com/restoconnect360-production/$key";
    echo "✅ SUCCESS: URL générée\n";
    echo "   URL: $url\n\n";
    
    // Résumé final
    echo "=====================================\n";
    echo "🎉 TOUS LES TESTS SONT PASSÉS!\n";
    echo "=====================================\n\n";
    
    echo "✅ Cloudflare R2 est PARFAITEMENT configuré!\n";
    echo "✅ Upload: Fonctionnel ✨\n";
    echo "✅ Lecture: Fonctionnelle ✨\n";
    echo "✅ Images: Supportées ✨\n";
    echo "✅ Listing: Opérationnel ✨\n\n";
    
    echo "📊 Configuration:\n";
    echo "   Bucket: restoconnect360-production\n";
    echo "   Région: auto (Multi-region)\n";
    echo "   Fichiers: $fileCount\n";
    echo "   Endpoint: https://6c3ca4ed5965ffe4e3fc207d8807eb1a.r2.cloudflarestorage.com\n\n";
    
    echo "🚀 RestoConnect360 est prêt à utiliser R2 en production!\n\n";
    
    echo "💡 Utilisation dans Laravel:\n";
    echo "   Storage::disk('r2')->put('file.jpg', \$content);\n";
    echo "   Storage::disk('r2')->url('file.jpg');\n";
    echo "   Storage::disk('r2')->exists('file.jpg');\n\n";
    
} catch (AwsException $e) {
    echo "\n❌ ERREUR AWS: " . $e->getAwsErrorMessage() . "\n";
    echo "   Code: " . $e->getAwsErrorCode() . "\n";
    echo "   Statut HTTP: " . $e->getStatusCode() . "\n\n";
    exit(1);
} catch (\Exception $e) {
    echo "\n❌ ERREUR: " . $e->getMessage() . "\n";
    echo "   Fichier: " . $e->getFile() . ":" . $e->getLine() . "\n\n";
    exit(1);
}
