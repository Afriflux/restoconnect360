<?php

namespace App\Services;

use App\Models\User;
use PragmaRX\Google2FA\Google2FA;
use PragmaRX\Google2FA\Support\QRCode;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class TwoFactorService
{
    protected $google2fa;
    
    public function __construct()
    {
        $this->google2fa = new Google2FA();
    }
    
    /**
     * Générer une clé secrète 2FA pour un utilisateur
     */
    public function generateSecretKey(User $user): string
    {
        $secretKey = $this->google2fa->generateSecretKey();
        
        // Sauvegarder temporairement la clé (pas encore confirmée)
        $user->update([
            'two_factor_secret' => encrypt($secretKey),
            'two_factor_enabled' => false,
        ]);
        
        return $secretKey;
    }
    
    /**
     * Générer le QR Code pour l'authentification 2FA
     */
    public function generateQRCode(User $user, string $secretKey): string
    {
        $companyName = config('app.name', 'RestoConnect360');
        $companyEmail = $user->email;
        
        $qrCodeUrl = $this->google2fa->getQRCodeUrl(
            $companyName,
            $companyEmail,
            $secretKey
        );
        
        return $qrCodeUrl;
    }
    
    /**
     * Vérifier le code 2FA et activer l'authentification
     */
    public function verifyAndEnable(User $user, string $code): bool
    {
        $secretKey = decrypt($user->two_factor_secret);
        
        if ($this->google2fa->verifyKey($secretKey, $code)) {
            // Générer les codes de récupération
            $recoveryCodes = $this->generateRecoveryCodes();
            
            $user->update([
                'two_factor_enabled' => true,
                'two_factor_confirmed_at' => now(),
                'two_factor_recovery_codes' => encrypt(json_encode($recoveryCodes)),
            ]);
            
            return true;
        }
        
        return false;
    }
    
    /**
     * Vérifier le code 2FA lors de la connexion
     */
    public function verifyCode(User $user, string $code): bool
    {
        if (!$user->two_factor_enabled) {
            return true;
        }
        
        $secretKey = decrypt($user->two_factor_secret);
        
        // Vérifier le code normal
        if ($this->google2fa->verifyKey($secretKey, $code)) {
            return true;
        }
        
        // Vérifier les codes de récupération
        return $this->verifyRecoveryCode($user, $code);
    }
    
    /**
     * Générer des codes de récupération
     */
    public function generateRecoveryCodes(): array
    {
        $codes = [];
        for ($i = 0; $i < 8; $i++) {
            $codes[] = strtoupper(Str::random(8));
        }
        return $codes;
    }
    
    /**
     * Vérifier un code de récupération
     */
    public function verifyRecoveryCode(User $user, string $code): bool
    {
        $recoveryCodes = json_decode(decrypt($user->two_factor_recovery_codes), true);
        
        if (in_array($code, $recoveryCodes)) {
            // Supprimer le code utilisé
            $recoveryCodes = array_diff($recoveryCodes, [$code]);
            
            $user->update([
                'two_factor_recovery_codes' => encrypt(json_encode(array_values($recoveryCodes))),
            ]);
            
            return true;
        }
        
        return false;
    }
    
    /**
     * Désactiver l'authentification 2FA
     */
    public function disable(User $user): bool
    {
        $user->update([
            'two_factor_enabled' => false,
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
        ]);
        
        return true;
    }
    
    /**
     * Régénérer les codes de récupération
     */
    public function regenerateRecoveryCodes(User $user): array
    {
        $recoveryCodes = $this->generateRecoveryCodes();
        
        $user->update([
            'two_factor_recovery_codes' => encrypt(json_encode($recoveryCodes)),
        ]);
        
        return $recoveryCodes;
    }
    
    /**
     * Vérifier si l'utilisateur doit utiliser 2FA
     */
    public function isRequired(User $user): bool
    {
        // 2FA obligatoire pour les rôles sensibles
        $sensitiveRoles = ['super_admin', 'admin', 'company_manager'];
        
        return in_array($user->role, $sensitiveRoles) || $user->two_factor_enabled;
    }
    
    /**
     * Obtenir les codes de récupération décryptés
     */
    public function getRecoveryCodes(User $user): array
    {
        if (!$user->two_factor_recovery_codes) {
            return [];
        }
        
        return json_decode(decrypt($user->two_factor_recovery_codes), true);
    }
    
    /**
     * Vérifier si l'utilisateur est verrouillé
     */
    public function isLocked(User $user): bool
    {
        if (!$user->locked_until) {
            return false;
        }
        
        return now()->isBefore($user->locked_until);
    }
    
    /**
     * Verrouiller le compte après trop de tentatives
     */
    public function lockAccount(User $user, int $minutes = 15): void
    {
        $user->update([
            'locked_until' => now()->addMinutes($minutes),
            'failed_login_attempts' => 0,
        ]);
    }
    
    /**
     * Incrémenter les tentatives de connexion échouées
     */
    public function incrementFailedAttempts(User $user): void
    {
        $attempts = $user->failed_login_attempts + 1;
        
        $user->update(['failed_login_attempts' => $attempts]);
        
        // Verrouiller après 5 tentatives
        if ($attempts >= 5) {
            $this->lockAccount($user);
        }
    }
    
    /**
     * Réinitialiser les tentatives de connexion
     */
    public function resetFailedAttempts(User $user): void
    {
        $user->update([
            'failed_login_attempts' => 0,
            'locked_until' => null,
            'last_login_at' => now(),
            'last_login_ip' => request()->ip(),
        ]);
    }
    
    /**
     * Middleware pour vérifier 2FA
     */
    public function middlewareCheck(User $user): bool
    {
        // Vérifier si le compte est verrouillé
        if ($this->isLocked($user)) {
            return false;
        }
        
        // Si 2FA est requis mais pas activé
        if ($this->isRequired($user) && !$user->two_factor_enabled) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Obtenir le temps restant avant déverrouillage
     */
    public function getLockTimeRemaining(User $user): ?int
    {
        if (!$user->locked_until) {
            return null;
        }
        
        return now()->diffInMinutes($user->locked_until);
    }
}
