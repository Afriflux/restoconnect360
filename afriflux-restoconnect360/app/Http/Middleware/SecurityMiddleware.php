<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use App\Services\TwoFactorService;
use Symfony\Component\HttpFoundation\Response;

class SecurityMiddleware
{
    protected $twoFactorService;
    
    public function __construct(TwoFactorService $twoFactorService)
    {
        $this->twoFactorService = $twoFactorService;
    }
    
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        
        // Vérifier si l'utilisateur est authentifié
        if (!$user) {
            return $next($request);
        }
        
        // Vérifier si le compte est verrouillé
        if ($this->twoFactorService->isLocked($user)) {
            Auth::logout();
            return response()->json([
                'message' => 'Compte temporairement verrouillé. Veuillez réessayer plus tard.',
                'lock_time_remaining' => $this->twoFactorService->getLockTimeRemaining($user)
            ], 423);
        }
        
        // Vérifier les permissions Spatie pour les endpoints critiques
        if ($this->isCriticalEndpoint($request)) {
            if (!$this->hasRequiredPermissions($user, $request)) {
                return response()->json([
                    'message' => 'Accès non autorisé à cette ressource.'
                ], 403);
            }
        }
        
        // Vérifier 2FA pour les rôles sensibles
        if ($this->twoFactorService->isRequired($user)) {
            if (!$user->two_factor_enabled) {
                return response()->json([
                    'message' => 'Authentification à deux facteurs requise.',
                    'requires_2fa_setup' => true
                ], 403);
            }
        }
        
        // Rate limiting pour les actions sensibles
        if ($this->isSensitiveAction($request)) {
            $key = 'sensitive_action:' . $user->id . ':' . $request->ip();
            
            if (RateLimiter::tooManyAttempts($key, 5)) {
                $seconds = RateLimiter::availableIn($key);
                return response()->json([
                    'message' => "Trop de tentatives. Réessayez dans {$seconds} secondes.",
                    'retry_after' => $seconds
                ], 429);
            }
            
            RateLimiter::hit($key, 300); // 5 minutes
        }
        
        // Vérifier l'IP pour les connexions suspectes
        if ($this->isSuspiciousActivity($user, $request)) {
            \Log::warning('Suspicious activity detected', [
                'user_id' => $user->id,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'route' => $request->route()->getName()
            ]);
            
            // Optionnel : envoyer une alerte ou verrouiller temporairement
        }
        
        return $next($request);
    }
    
    /**
     * Vérifier si c'est un endpoint critique
     */
    protected function isCriticalEndpoint(Request $request): bool
    {
        $criticalRoutes = [
            'admin-users',
            'admin-companies',
            'admin-payments',
            'admin-subscriptions',
            'admin-payment-aggregators',
            'admin-geolocation',
            'admin-emails'
        ];
        
        return in_array($request->route()->getName(), $criticalRoutes);
    }
    
    /**
     * Vérifier les permissions requises
     */
    protected function hasRequiredPermissions($user, Request $request): bool
    {
        $routeName = $request->route()->getName();
        
        // Permissions spécifiques par route
        $permissions = [
            'admin-users' => 'manage-users',
            'admin-companies' => 'manage-companies',
            'admin-payments' => 'manage-payments',
            'admin-subscriptions' => 'manage-subscriptions',
            'admin-payment-aggregators' => 'manage-payment-aggregators',
            'admin-geolocation' => 'manage-geolocation',
            'admin-emails' => 'manage-emails'
        ];
        
        if (isset($permissions[$routeName])) {
            return $user->can($permissions[$routeName]);
        }
        
        return true;
    }
    
    /**
     * Vérifier si c'est une action sensible
     */
    protected function isSensitiveAction(Request $request): bool
    {
        $sensitiveActions = [
            'admin-users',
            'admin-companies',
            'admin-payments',
            'admin-subscriptions',
            'admin-payment-aggregators',
            'admin-geolocation',
            'admin-emails',
            'admin-settings'
        ];
        
        return in_array($request->route()->getName(), $sensitiveActions);
    }
    
    /**
     * Détecter une activité suspecte
     */
    protected function isSuspiciousActivity($user, Request $request): bool
    {
        // Vérifier si l'IP a changé récemment
        if ($user->last_login_ip && $user->last_login_ip !== $request->ip()) {
            // Si la dernière connexion était il y a moins de 24h et IP différente
            if ($user->last_login_at && $user->last_login_at->isAfter(now()->subDay())) {
                return true;
            }
        }
        
        // Vérifier les User-Agents suspects
        $userAgent = $request->userAgent();
        $suspiciousPatterns = [
            'bot',
            'crawler',
            'spider',
            'scraper',
            'curl',
            'wget'
        ];
        
        foreach ($suspiciousPatterns as $pattern) {
            if (stripos($userAgent, $pattern) !== false) {
                return true;
            }
        }
        
        return false;
    }
}
