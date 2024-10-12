<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // Obtiene el usuario autenticado a través del token JWT
        $user = JWTAuth::parseToken()->authenticate();

        // Verifica si el usuario tiene el rol necesario
        if (!$user || !$user->hasRole($role)) {
            return response()->json(['error' => 'No tienes el rol necesario'], 403);
        }

        return $next($request);
    }
}
