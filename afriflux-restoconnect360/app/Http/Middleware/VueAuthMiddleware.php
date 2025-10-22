<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VueAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier si l'utilisateur est authentifié via Sanctum
        if ($request->user()) {
            return $next($request);
        }

        // Vérifier le token dans le header Authorization
        $token = $request->bearerToken();
        if ($token) {
            // Tenter de trouver l'utilisateur par token
            $user = \Laravel\Sanctum\PersonalAccessToken::findToken($token)?->tokenable;
            if ($user) {
                // Authentifier l'utilisateur dans la requête
                $request->setUserResolver(function () use ($user) {
                    return $user;
                });
                return $next($request);
            }
        }

        // Si pas d'authentification, rediriger vers la page de connexion Vue.js
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Non authentifié',
                'redirect' => '/login'
            ], 401);
        }

        // Rediriger vers la page de connexion
        return redirect('/login?redirect=' . urlencode($request->fullUrl()));
    }
}
