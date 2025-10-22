<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\TwoFactorService;
use Illuminate\Http\JsonResponse;

class TwoFactorController extends Controller
{
    protected $twoFactorService;
    
    public function __construct(TwoFactorService $twoFactorService)
    {
        $this->twoFactorService = $twoFactorService;
    }
    
    /**
     * Générer la clé secrète et le QR code
     */
    public function generate(Request $request): JsonResponse
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['message' => 'Non authentifié'], 401);
        }
        
        // Générer la clé secrète
        $secretKey = $this->twoFactorService->generateSecretKey($user);
        
        // Générer le QR code
        $qrCodeUrl = $this->twoFactorService->generateQRCode($user, $secretKey);
        
        return response()->json([
            'secret_key' => $secretKey,
            'qr_code_url' => $qrCodeUrl,
            'manual_entry_key' => $secretKey
        ]);
    }
    
    /**
     * Vérifier le code et activer 2FA
     */
    public function verify(Request $request): JsonResponse
    {
        $request->validate([
            'code' => 'required|string|size:6'
        ]);
        
        $user = Auth::user();
        
        if ($this->twoFactorService->verifyAndEnable($user, $request->code)) {
            $recoveryCodes = $this->twoFactorService->getRecoveryCodes($user);
            
            return response()->json([
                'message' => 'Authentification à deux facteurs activée avec succès',
                'recovery_codes' => $recoveryCodes,
                'enabled' => true
            ]);
        }
        
        return response()->json([
            'message' => 'Code invalide'
        ], 400);
    }
    
    /**
     * Vérifier le code lors de la connexion
     */
    public function verifyLogin(Request $request): JsonResponse
    {
        $request->validate([
            'code' => 'required|string|min:6|max:8'
        ]);
        
        $user = Auth::user();
        
        if ($this->twoFactorService->verifyCode($user, $request->code)) {
            $this->twoFactorService->resetFailedAttempts($user);
            
            return response()->json([
                'message' => 'Code vérifié avec succès',
                'verified' => true
            ]);
        }
        
        $this->twoFactorService->incrementFailedAttempts($user);
        
        return response()->json([
            'message' => 'Code invalide'
        ], 400);
    }
    
    /**
     * Désactiver 2FA
     */
    public function disable(Request $request): JsonResponse
    {
        $request->validate([
            'password' => 'required|string'
        ]);
        
        $user = Auth::user();
        
        // Vérifier le mot de passe
        if (!password_verify($request->password, $user->password)) {
            return response()->json([
                'message' => 'Mot de passe incorrect'
            ], 400);
        }
        
        $this->twoFactorService->disable($user);
        
        return response()->json([
            'message' => 'Authentification à deux facteurs désactivée',
            'enabled' => false
        ]);
    }
    
    /**
     * Régénérer les codes de récupération
     */
    public function regenerateRecoveryCodes(Request $request): JsonResponse
    {
        $user = Auth::user();
        
        if (!$user->two_factor_enabled) {
            return response()->json([
                'message' => '2FA n\'est pas activé'
            ], 400);
        }
        
        $recoveryCodes = $this->twoFactorService->regenerateRecoveryCodes($user);
        
        return response()->json([
            'message' => 'Codes de récupération régénérés',
            'recovery_codes' => $recoveryCodes
        ]);
    }
    
    /**
     * Obtenir le statut 2FA
     */
    public function status(): JsonResponse
    {
        $user = Auth::user();
        
        return response()->json([
            'enabled' => $user->two_factor_enabled,
            'required' => $this->twoFactorService->isRequired($user),
            'confirmed_at' => $user->two_factor_confirmed_at,
            'recovery_codes_count' => count($this->twoFactorService->getRecoveryCodes($user))
        ]);
    }
    
    /**
     * Obtenir les codes de récupération
     */
    public function recoveryCodes(): JsonResponse
    {
        $user = Auth::user();
        
        if (!$user->two_factor_enabled) {
            return response()->json([
                'message' => '2FA n\'est pas activé'
            ], 400);
        }
        
        $recoveryCodes = $this->twoFactorService->getRecoveryCodes($user);
        
        return response()->json([
            'recovery_codes' => $recoveryCodes
        ]);
    }
    
    /**
     * Vérifier si le compte est verrouillé
     */
    public function lockStatus(): JsonResponse
    {
        $user = Auth::user();
        
        $isLocked = $this->twoFactorService->isLocked($user);
        $timeRemaining = $this->twoFactorService->getLockTimeRemaining($user);
        
        return response()->json([
            'is_locked' => $isLocked,
            'time_remaining' => $timeRemaining,
            'failed_attempts' => $user->failed_login_attempts
        ]);
    }
}
