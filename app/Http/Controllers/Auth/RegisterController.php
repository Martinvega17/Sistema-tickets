<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Region;
use App\Models\Cedis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'numero_nomina' => ['required', 'string', 'max:20', 'unique:users'],
            'nombre' => ['required', 'string', 'max:100'],
            'apellido' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:150', 'unique:users'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'region_id' => ['required', 'exists:regiones,id'],
            'cedis_id' => ['required', 'exists:cedis,id'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms' => ['required', 'accepted'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'numero_nomina' => $data['numero_nomina'],
            'nombre' => $data['nombre'],
            'apellido' => $data['apellido'],
            'email' => $data['email'],
            'telefono' => $data['telefono'],
            'region_id' => $data['region_id'],
            'cedis_id' => $data['cedis_id'],
            'rol_id' => 4, // Rol de usuario por defecto
            'password' => Hash::make($data['password']),
        ]);
    }

    public function showRegistrationForm()
    {
        // Obtener regiones activas
        $regiones = Region::where('estatus', 'activo')
            ->orderBy('nombre')
            ->get();

        // Obtener todos los CEDIS activos
        $todosCedis = Cedis::where('estatus', 'activo')
            ->orderBy('nombre')
            ->get();

        return view('auth.register', compact('regiones', 'todosCedis'));
    }
}
