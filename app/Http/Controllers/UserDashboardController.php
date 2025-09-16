<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data = [
            'user' => $user,
            'userRole' => $user->rol_id
        ];

        return view('dashboard', $data);
    }

    public function configuracion()
    {
        // Esta ruta ya está protegida por middleware role:1,2
        return view('configuracion');
    }
}
