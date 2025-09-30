<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        // Verificar si es admin y redirigir - CORREGIDO
        if (in_array(Auth::user()->rol_id, [1, 2])) {
            return redirect()->route('admin.dashboard');
        }

        $user = Auth::user();
        $data = [
            'user' => $user,
            'userRole' => $user->rol_id
        ];

        // Tu lógica actual del dashboard de usuario normal
        return view('dashboard', $data);
    }

    public function configuracion()
    {
        // Esta ruta ya está protegida por middleware role:1,2
        return view('configuracion');
    }
}
