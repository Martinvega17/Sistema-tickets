<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !in_array(Auth::user()->rol_id, [1, 2])) {
            abort(403, 'No tienes permisos para acceder al panel de administración');
        }

        return $next($request);
    }
}
