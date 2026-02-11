<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // La Façade

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // On utilise Auth:: sans parenthèses
        if (!Auth::check() || !in_array(Auth::user()->role, $roles)) {
            abort(403, "Accès non autorisé.");
        }

        return $next($request);
    }
}
