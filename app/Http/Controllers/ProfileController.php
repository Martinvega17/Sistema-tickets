<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function updatePersonalData(Request $request)
    {
        $user = Auth::user();

        // Definir reglas de validación según el rol
        $validationRules = [
            'telefono' => 'nullable|string|max:20',
            'genero' => 'nullable|string|in:Masculino,Femenino,Otro',
        ];

        // Si es admin o supervisor, puede editar más campos
        if ($user->rol_id == 1 || $user->rol_id == 2) {
            $validationRules = array_merge($validationRules, [
                'nombre' => 'required|string|max:100',
                'apellido' => 'required|string|max:100',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'extension' => 'nullable|string|max:10',
                'zona_horaria' => 'nullable|string|max:50',
            ]);
        }

        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Actualizar datos según permisos
        $user->telefono = $request->telefono;
        $user->genero = $request->genero;

        if ($user->rol_id == 1 || $user->rol_id == 2) {
            $user->nombre = $request->nombre;
            $user->apellido = $request->apellido;
            $user->email = $request->email;
            $user->extension = $request->extension;
            $user->zona_horaria = $request->zona_horaria;
        }

        $user->save();

        return response()->json(['message' => 'Datos personales actualizados correctamente']);
    }

    public function updateCompanyData(Request $request)
    {
        $user = Auth::user();

        // Solo admin y supervisor pueden editar
        if ($user->rol_id != 1 && $user->rol_id != 2) {
            return response()->json(['error' => 'No tienes permisos para editar esta información'], 403);
        }

        $validator = Validator::make($request->all(), [
            'empresa' => 'nullable|string|max:100',
            'pais' => 'nullable|string|max:50',
            'ubicacion' => 'nullable|string|max:100',
            'ciudad' => 'nullable|string|max:50',
            'estado' => 'nullable|string|max:50',
            'departamento' => 'nullable|string|max:50',
            'piso' => 'nullable|string|max:20',
            'torre' => 'nullable|string|max:20',
            'cargo' => 'nullable|string|max:50',
            'centro_costos' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user->update($request->all());

        return response()->json(['message' => 'Información de empresa actualizada correctamente']);
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = Auth::user();

        // Verificar contraseña actual
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['errors' => ['current_password' => ['La contraseña actual no es correcta']]], 422);
        }

        // Actualizar contraseña
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Contraseña actualizada correctamente']);
    }

    public function updateLanguage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idioma' => 'required|in:ES,EN,PT',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = Auth::user();
        $user->idioma = $request->idioma;
        $user->save();

        return response()->json(['message' => 'Idioma actualizado correctamente']);
    }


    public function personal()
    {
        $user = Auth::user();
        return view('profile.personal', compact('user'));
    }

    public function company()
    {
        $user = Auth::user();
        return view('profile.company', compact('user'));
    }

    public function password()
    {
        $user = Auth::user();
        return view('profile.password', compact('user'));
    }
}
