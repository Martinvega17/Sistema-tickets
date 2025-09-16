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

        // Buscar usuario por número de nómina
        $user = \App\Models\User::where('numero_nomina', $credentials['numero_nomina'])->first();

        // Verificar si el usuario existe y las credenciales son correctas
        if ($user && \Illuminate\Support\Facades\Hash::check($credentials['password'], $user->password)) {

            // Verificar estatus (1 = activo, 0 = inactivo)
            if ($user->estatus !== 1) {
                return back()->withErrors([
                    'numero_nomina' => 'Tu cuenta está inactiva. Contacta al administrador.',
                ]);
            }

            // Iniciar sesión manualmente
            Auth::login($user, $request->has('remember'));
            $request->session()->regenerate();

            // Redirigir según el rol
            switch ($user->rol_id) {
                case 1: // Administrador
                case 2: // Supervisor
                    return redirect('/admin/dashboard');
                case 3: // Coordinador
                case 4: // Soporte  
                case 5: // Usuario
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
