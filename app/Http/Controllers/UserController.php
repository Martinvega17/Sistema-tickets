<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rol;
use App\Models\Region;
use App\Models\Cedis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Verificar permisos (solo admin y supervisor) - CORREGIDO
        if (\Illuminate\Support\Facades\Auth::user()->rol_id != 1 && \Illuminate\Support\Facades\Auth::user()->rol_id != 2) {
            abort(403, 'No tienes permisos para acceder a esta sección');
        }

        $query = User::with(['rol', 'region', 'cedis']);

        // Búsqueda
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%$search%")
                    ->orWhere('apellido', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('numero_nomina', 'like', "%$search%");
            });
        }

        // Filtrar por rol
        if ($request->has('rol') && !empty($request->rol)) {
            $query->where('rol_id', $request->rol);
        }

        // Filtrar por estatus
        if ($request->has('estatus') && $request->estatus !== '') {
            $query->where('estatus', $request->estatus);
        }

        $users = $query->orderBy('nombre')->paginate(15);
        $roles = Rol::all();
        $regiones = Region::where('estatus', 'activo')->get();
        $cedis = Cedis::where('estatus', 'activo')->get();

        return view('users.index', compact('users', 'roles', 'regiones', 'cedis'));
    }

    // Agregar estos métodos al UserController

    public function create()
    {
        // Verificar permisos (solo admin y supervisor)
        if (Auth::user()->rol_id != 1 && Auth::user()->rol_id != 2) {
            abort(403, 'No tienes permisos para acceder a esta sección');
        }

        $roles = Rol::all();
        $regiones = Region::where('estatus', 'activo')->get();
        $cedis = Cedis::where('estatus', 'activo')->get();

        return view('users.modals.create', compact('roles', 'regiones', 'cedis'));
    }

    public function store(Request $request)
    {
        // CORREGIDO: Solo administradores pueden crear usuarios
        if (Auth::user()->rol_id != 1) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'numero_nomina' => 'required|string|max:50|unique:users,numero_nomina',
            'telefono' => 'nullable|string|max:20',
            'rol_id' => 'required|exists:roles,id',
            'password' => 'required|min:8|confirmed',
        ], [
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Crear nuevo usuario
        $user = User::create([
            'numero_nomina' => $request->numero_nomina,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
            'rol_id' => $request->rol_id,
            'region_id' => $request->region_id,
            'cedis_id' => $request->cedis_id,
            'estatus' => 1, // Activo por defecto
        ]);

        return response()->json([
            'message' => 'Usuario creado correctamente',
            'user_id' => $user->id
        ]);
    }

    public function updateStatus(Request $request, User $user)
    {
        if (Auth::user()->rol_id != 1) {
            return response()->json(['error' => 'No autorizado'], 403);
        }


        $user->estatus = $request->estatus;
        $user->save();

        return response()->json(['message' => 'Estatus actualizado correctamente']);
    }

    public function resetPassword(Request $request, User $user)
    {
        // CORREGIDO: Verificar si es admin o supervisor (rol_id 1 o 2)
        if (Auth::user()->rol_id != 1 && Auth::user()->rol_id != 2) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message' => 'Contraseña restablecida correctamente']);
    }

    public function show(Request $request, User $user)
    {
        // Verificar permisos
        if (Auth::user()->rol_id != 1 && Auth::user()->rol_id != 2) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'No autorizado'], 403);
            }
            abort(403, 'No tienes permisos para acceder a esta sección');
        }

        // Devolver JSON para peticiones AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'id' => $user->id,
                'nombre' => $user->nombre,
                'apellido' => $user->apellido,
                'email' => $user->email,
                'numero_nomina' => $user->numero_nomina,
                'telefono' => $user->telefono,
                'rol_id' => $user->rol_id,
                'region_id' => $user->region_id,
                'cedis_id' => $user->cedis_id,
                'estatus' => $user->estatus,
                // Campos de empresa
                'empresa' => $user->empresa,
                'pais' => $user->pais,
                'ubicacion' => $user->ubicacion,
                'ciudad' => $user->ciudad,
                'estado' => $user->estado,
                'departamento' => $user->departamento,
                'piso' => $user->piso,
                'torre' => $user->torre,
                'cargo' => $user->cargo,
                'centro_costos' => $user->centro_costos
            ]);
        }

        // Para peticiones normales
        return view('users.show', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // CORREGIDO: Solo administradores pueden editar usuarios
        if (Auth::user()->rol_id != 1) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'numero_nomina' => 'required|string|max:50|unique:users,numero_nomina,' . $user->id,
            'telefono' => 'nullable|string|max:20',
            'rol_id' => 'required|exists:roles,id',
            'nueva_password' => 'nullable|min:8|confirmed',
            // Agregar validación para campos de empresa
            'empresa' => 'nullable|string|max:255',
            'pais' => 'nullable|string|max:100',
            'ubicacion' => 'nullable|string|max:255',
            'ciudad' => 'nullable|string|max:100',
            'estado' => 'nullable|string|max:100',
            'departamento' => 'nullable|string|max:100',
            'piso' => 'nullable|string|max:50',
            'torre' => 'nullable|string|max:50',
            'cargo' => 'nullable|string|max:100',
            'centro_costos' => 'nullable|string|max:100',
        ], [
            'nueva_password.confirmed' => 'La confirmación de la contraseña no coincide.',
            'nueva_password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Actualizar datos básicos incluyendo campos de empresa
        $user->update($request->only([
            'nombre',
            'apellido',
            'email',
            'numero_nomina',
            'telefono',
            'rol_id',
            'region_id',
            'cedis_id',
            'empresa',
            'pais',
            'ubicacion',
            'ciudad',
            'estado',
            'departamento',
            'piso',
            'torre',
            'cargo',
            'centro_costos'
        ]));

        // Actualizar contraseña si se proporcionó
        if ($request->filled('nueva_password')) {
            $user->password = Hash::make($request->nueva_password);
            $user->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Usuario actualizado correctamente'
        ]);
    }

    // Método para la vista de edición
    public function edit()
    {
        // CORREGIDO: Verificar permisos
        if (\Illuminate\Support\Facades\Auth::user()->rol_id != 1 && \Illuminate\Support\Facades\Auth::user()->rol_id != 2) {
            abort(403, 'No tienes permisos para acceder a esta sección');
        }

        $users = User::with('rol')->orderBy('nombre')->get();
        $roles = Rol::all();

        return view('users.edit', compact('users', 'roles'));
    }

    public function getUserJson(User $user)
    {
        // Verificar permisos
        if (Auth::user()->rol_id != 1 && Auth::user()->rol_id != 2) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        return response()->json([
            'id' => $user->id,
            'nombre' => $user->nombre,
            'apellido' => $user->apellido,
            'email' => $user->email,
            'numero_nomina' => $user->numero_nomina,
            'telefono' => $user->telefono,
            'rol_id' => $user->rol_id,
            'region_id' => $user->region_id,
            'cedis_id' => $user->cedis_id,
            'estatus' => $user->estatus
        ]);
    }
}
