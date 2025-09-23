<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        return redirect()->route('profile.personal');
    }

    protected function getUser(): User
    {
        // Garantiza que siempre devolvemos un modelo Eloquent
        return User::findOrFail(Auth::id());
    }

    public function updatePersonalData(Request $request)
    {
        $user = $this->getUser();

        $validationRules = [
            'telefono' => 'nullable|string|max:20',
            'genero' => 'nullable|string|in:Masculino,Femenino,Otro',
        ];

        if (in_array($user->rol_id, [1, 2])) {
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

        // Actualización de campos
        $user->telefono = $request->telefono;
        $user->genero = $request->genero;

        if (in_array($user->rol_id, [1, 2])) {
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
        $user = $this->getUser();

        if (!in_array($user->rol_id, [1, 2])) {
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

        $user->update($request->only([
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

        return response()->json(['message' => 'Información de empresa actualizada correctamente']);
    }

    public function updatePassword(Request $request)
    {
        $user = $this->getUser();

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'La contraseña actual es incorrecta'
            ], 422);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Contraseña cambiada correctamente'
        ]);
    }


    public function updateLanguage(Request $request)
    {
        $user = $this->getUser();

        $validator = Validator::make($request->all(), [
            'idioma' => 'required|in:ES,EN,PT',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user->idioma = $request->idioma;
        $user->save();

        return response()->json(['message' => 'Idioma actualizado correctamente']);
    }

    public function personal()
    {
        $user = $this->getUser();
        return view('profile.personal', compact('user'));
    }

    public function company()
    {
        $user = $this->getUser();
        return view('profile.company', compact('user'));
    }

    public function password()
    {
        $user = $this->getUser();
        return view('profile.password', compact('user'));
    }
}
