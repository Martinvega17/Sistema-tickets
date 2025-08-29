<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Verificar que el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = Auth::user()->rol_id;

        // Convertir roles de string a integers
        $allowedRoles = array_map('intval', $roles);

        if (!in_array($userRole, $allowedRoles)) {
            abort(403, 'No tienes permisos para acceder a esta sección');
        }

        return $next($request);
    }
}
