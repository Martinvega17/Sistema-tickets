<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Region;
use App\Models\Cedis;
use App\Models\Rol; // Asegúrate de importar el modelo Rol
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
        ], [
            'terms.accepted' => 'Debes aceptar los términos y condiciones.',
            'cedis_id.exists' => 'El CEDIS seleccionado no es válido.',
            'region_id.exists' => 'La región seleccionada no es válida.',
        ]);
    }

    protected function create(array $data)
    {
        // Buscar el rol de "Usuario" por nombre en lugar de usar ID fijo
        $rolUsuario = Rol::where('nombre', 'Usuario')->first();

        // Si no existe, buscar el primer rol disponible
        if (!$rolUsuario) {
            $rolUsuario = Rol::first();
        }

        // Si no hay roles en absoluto, crear uno básico
        if (!$rolUsuario) {
            $rolUsuario = Rol::create([
                'nombre' => 'Usuario',
                'descripcion' => 'Usuario regular del sistema',
                'permisos' => json_encode(['tickets.ver.propios', 'tickets.crear.propios', 'dashboard.ver'])
            ]);
        }

        return User::create([
            'numero_nomina' => $data['numero_nomina'],
            'nombre' => $data['nombre'],
            'apellido' => $data['apellido'],
            'email' => $data['email'],
            'telefono' => $data['telefono'] ?? null,
            'region_id' => $data['region_id'],
            'cedis_id' => $data['cedis_id'],
            'rol_id' => $rolUsuario->id, // Usar el ID del rol encontrado o creado
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

    // Método para obtener CEDIS (para el JavaScript)
    public function getCedis()
    {
        $cedis = Cedis::where('estatus', 'activo')
            ->orderBy('nombre')
            ->get(['id', 'nombre', 'region_id']);

        return response()->json($cedis);
    }
}
