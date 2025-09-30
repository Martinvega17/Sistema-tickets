<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectToCorrectDashboard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Si el usuario está autenticado y está en la raíz, redirigir al dashboard correcto
        if (Auth::check() && $request->is('/')) {
            $user = Auth::user();

            if (in_array($user->rol_id, [1, 2])) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('dashboard');
            }
        }

        return $next($request);
    }
}
