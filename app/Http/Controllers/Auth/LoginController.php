<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validar el número de nómina y la contraseña
        $credentials = $request->validate([
            'numero_nomina' => ['required', 'string'],
            'password' => ['required'],
        ]);

        // Intentar autenticar al usuario
        $user = \App\Models\User::where('numero_nomina', $credentials['numero_nomina'])->first();

        if ($user && Auth::attempt(['email' => $user->email, 'password' => $credentials['password']])) {
            $request->session()->regenerate();

            if ($user->estatus !== 'activo') {
                Auth::logout();
                return back()->withErrors([
                    'numero_nomina' => 'Tu cuenta está inactiva. Contacta al administrador.',
                ]);
            }

            // Redirigir según el rol
            switch ($user->rol_id) {
                case 1:
                    return redirect('/admin/dashboard');
                case 2:
                    return redirect('/soporte/dashboard');
                case 3:
                    return redirect('/coordinador/dashboard');
                default:
                    return redirect('/dashboard');
            }
        }

        return back()->withErrors([
            'numero_nomina' => 'Las credenciales proporcionadas no son válidas.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
