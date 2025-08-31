<?php

namespace App\Http\Controllers;

// app/Http/Controllers/CedisController.php

use App\Models\Cedis;
use App\Models\Region;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CedisController extends Controller
{
    public function index(Request $request)
    {
        // Verificar permisos (solo admin y supervisor)
        if (Auth::user()->rol_id != 1 && Auth::user()->rol_id != 2) {
            abort(403, 'No tienes permisos para acceder a esta sección');
        }

        $query = Cedis::with('region');

        // Búsqueda
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%$search%")
                    ->orWhere('codigo', 'like', "%$search%")
                    ->orWhere('responsable', 'like', "%$search%");
            });
        }

        // Filtrar por región
        if ($request->has('region') && !empty($request->region)) {
            $query->where('region_id', $request->region);
        }

        // Filtrar por estatus
        if ($request->has('estatus') && $request->estatus !== '') {
            $query->where('estatus', $request->estatus);
        }

        $cedis = $query->orderBy('nombre')->paginate(15);
        $regiones = Region::where('estatus', 'activo')->get();

        return view('cedis.index', compact('cedis', 'regiones'));
    }

    public function create()
    {
        // Obtener usuarios con rol de ingeniero (ajusta según tu sistema de roles)
        $ingenieros = User::whereHas('roles', function ($query) {
            $query->whereIn('id', [3, 4]); // Ajusta los IDs según tus roles
        })->where('estatus', 'activo')->get();

        $regiones = Region::where('estatus', 'activo')->get();

        return view('cedis.create', compact('regiones', 'ingenieros'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->rol_id != 1) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100',
            'codigo' => 'required|string|max:50|unique:cedis',
            'direccion' => 'nullable|string',
            'telefono' => 'nullable|string|max:20',
            'responsable' => 'nullable|string|max:100',
            'region_id' => 'required|exists:regiones,id',
            'estatus' => 'required|in:activo,inactivo'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        Cedis::create($request->all());

        return response()->json(['message' => 'CEDIS creado correctamente']);
    }

    public function show(Request $request, Cedis $cedis)
    {
        if (Auth::user()->rol_id != 1 && Auth::user()->rol_id != 2) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'No autorizado'], 403);
            }
            abort(403, 'No tienes permisos para acceder a esta sección');
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($cedis);
        }

        return view('cedis.show', compact('cedis'));
    }

    public function edit(Cedis $cedis)
    {
        if (Auth::user()->rol_id != 1) {
            abort(403, 'No tienes permisos para realizar esta acción');
        }

        $regiones = Region::where('estatus', 'activo')->get();
        return view('cedis.edit', compact('cedis', 'regiones'));
    }

    public function update(Request $request, Cedis $cedis)
    {
        if (Auth::user()->rol_id != 1) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100',
            'codigo' => 'required|string|max:50|unique:cedis,codigo,' . $cedis->id,
            'direccion' => 'nullable|string',
            'telefono' => 'nullable|string|max:20',
            'responsable' => 'nullable|string|max:100',
            'region_id' => 'required|exists:regiones,id',
            'estatus' => 'required|in:activo,inactivo'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $cedis->update($request->all());

        return response()->json(['message' => 'CEDIS actualizado correctamente']);
    }

    public function updateStatus(Request $request, Cedis $cedis)
    {
        if (Auth::user()->rol_id != 1) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $validator = Validator::make($request->all(), [
            'estatus' => 'required|in:activo,inactivo'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $cedis->estatus = $request->estatus;
        $cedis->save();

        return response()->json(['message' => 'Estatus actualizado correctamente']);
    }
}
