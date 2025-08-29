<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rol;
use App\Models\Region;
use App\Models\Cedis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Verificar permisos (solo admin y supervisor)
        if (!auth()->user()->rol_id == 1 && !auth()->user()->rol_id == 2) {
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

    public function updateStatus(Request $request, User $user)
    {
        if (!auth()->user()->rol_id == 1) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $user->estatus = $request->estatus;
        $user->save();

        return response()->json(['message' => 'Estatus actualizado correctamente']);
    }

    public function resetPassword(Request $request, User $user)
    {
        if (!auth()->user()->rol_id == 1 && !auth()->user()->rol_id == 2) {
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

    public function update(Request $request, User $user)
    {
        if (!auth()->user()->rol_id == 1) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'rol_id' => 'required|exists:roles,id',
            'region_id' => 'nullable|exists:regiones,id',
            'cedis_id' => 'nullable|exists:cedis,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user->update($request->all());

        return response()->json(['message' => 'Usuario actualizado correctamente']);
    }
}
