<?php

namespace App\Http\Controllers;

use App\Models\Cedis;
use App\Models\Region;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CedisController extends Controller
{
    public function index(Request $request)
    {
        // Verificar permisos (solo admin y supervisor)
        if (Auth::user()->rol_id != 1 && Auth::user()->rol_id != 2) {
            abort(403, 'No tienes permisos para acceder a esta sección');
        }

        $query = Cedis::with(['region', 'ingeniero']);

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

        // Obtener ingenieros (usuarios con rol_id 4 - Soporte)
        $ingenieros = User::where('rol_id', 4) // Rol 4 = Soporte
            ->where('estatus', 1) // 1 = activo
            ->with('rol') // Cargar la relación rol
            ->orderBy('nombre')
            ->get(['id', 'numero_nomina', 'nombre', 'apellido', 'rol_id']);

        // Si es petición AJAX, devolver JSON
        if ($request->ajax()) {
            return response()->json([
                'cedis' => $cedis->items(),
                'pagination' => [
                    'current_page' => $cedis->currentPage(),
                    'last_page' => $cedis->lastPage(),
                    'per_page' => $cedis->perPage(),
                    'total' => $cedis->total(),
                ],
                'regiones' => $regiones,
                'ingenieros' => $ingenieros
            ]);
        }


        return view('cedis.index', compact('regiones'));
    }

    public function show(Request $request, $id)
    {
        try {
            $cedis = Cedis::find($id);

            if (!$cedis) {
                return response()->json(['error' => 'CEDIS no encontrado'], 404);
            }

            // Cargar relaciones manualmente
            try {
                $cedis->region = \App\Models\Region::find($cedis->region_id);
            } catch (\Exception $e) {
                $cedis->region = null;
            }

            try {
                if ($cedis->ingeniero_id) {
                    $cedis->ingeniero = \App\Models\User::find($cedis->ingeniero_id);
                } else {
                    $cedis->ingeniero = null;
                }
            } catch (\Exception $e) {
                $cedis->ingeniero = null;
            }

            return response()->json($cedis);
        } catch (\Exception $e) {
            Log::error('Error en show:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Error al cargar el CEDIS'], 500);
        }
    }

    public function getCedisData(Request $request)
    {
        try {
            $query = Cedis::query();

            if ($request->query('search') && !empty($request->query('search'))) {
                $search = $request->query('search');
                $query->where(function ($q) use ($search) {
                    $q->where('nombre', 'like', "%$search%")
                        ->orWhere('codigo', 'like', "%$search%");
                });
            }

            if ($request->query('region') && !empty($request->query('region'))) {
                $query->where('region_id', $request->query('region'));
            }

            if ($request->query('estatus') && $request->query('estatus') !== '') {
                $query->where('estatus', $request->query('estatus'));
            }

            $cedisList = $query->orderBy('nombre')->get();

            // Cargar relaciones manualmente para evitar problemas
            $cedisList->each(function ($cedis) {
                try {
                    $cedis->region = \App\Models\Region::find($cedis->region_id);
                } catch (\Exception $e) {
                    $cedis->region = null;
                    Log::error('Error cargando región:', ['cedis_id' => $cedis->id, 'error' => $e->getMessage()]);
                }

                try {
                    if ($cedis->ingeniero_id) {
                        $cedis->ingeniero = \App\Models\User::find($cedis->ingeniero_id);
                    } else {
                        $cedis->ingeniero = null;
                    }
                } catch (\Exception $e) {
                    $cedis->ingeniero = null;
                    Log::error('Error cargando ingeniero:', ['cedis_id' => $cedis->id, 'error' => $e->getMessage()]);
                }
            });

            return response()->json($cedisList);
        } catch (\Exception $e) {
            Log::error('Error en getCedisData:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Error al cargar los datos'], 500);
        }
    }

    public function updateStatus(Request $request, Cedis $cedis)
    {
        // Verificar permisos (solo admin)
        if (Auth::user()->rol_id != 1) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $validator = Validator::make($request->all(), [
            'estatus' => 'required|in:activo,inactivo'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $cedis->estatus = $request->estatus;
            $cedis->save();

            return response()->json([
                'message' => 'Estatus actualizado correctamente',
                'estatus' => $cedis->estatus
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al actualizar el estatus: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        // Verificar permisos (solo admin)
        if (Auth::user()->rol_id != 1) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        try {
            $cedis = Cedis::find($id);

            if (!$cedis) {
                return response()->json(['error' => 'CEDIS no encontrado'], 404);
            }

            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:100',
                // ELIMINADA LA VALIDACIÓN DE CÓDIGO
                'direccion' => 'nullable|string',
                'telefono' => 'nullable|string|max:20',
                'responsable' => 'nullable|string|max:100',
                'region_id' => 'required|exists:regiones,id',
                'estatus' => 'required|in:activo,inactivo',
                'ingeniero_id' => 'nullable|exists:users,id'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Actualizar manualmente campo por campo (SIN CÓDIGO)
            $cedis->nombre = $request->nombre;
            // ELIMINADA LA ASIGNACIÓN DE CÓDIGO
            $cedis->direccion = $request->direccion;
            $cedis->telefono = $request->telefono;
            $cedis->responsable = $request->responsable;
            $cedis->region_id = $request->region_id;
            $cedis->estatus = $request->estatus;
            $cedis->ingeniero_id = $request->ingeniero_id;

            $cedis->save();

            return response()->json([
                'message' => 'CEDIS actualizado correctamente',
                'cedis' => $cedis
            ]);
        } catch (\Exception $e) {
            Log::error('Error en update:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Error interno del servidor: ' . $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        // Verificar permisos (solo admin)
        if (Auth::user()->rol_id != 1) {
            abort(403, 'No tienes permisos para realizar esta acción');
        }

        $cedis = Cedis::findOrFail($id);
        $regiones = Region::where('estatus', 'activo')->get();
        $ingenieros = User::where('rol_id', 4)
            ->where('estatus', 1)
            ->orderBy('nombre')
            ->get(['id', 'numero_nomina', 'nombre', 'apellido']);

        return view('cedis.modals.edit', compact('cedis', 'regiones', 'ingenieros', 'id'));
    }

    public function create()
    {
        // Verificar permisos (solo admin)
        if (Auth::user()->rol_id != 1) {
            abort(403, 'No tienes permisos para realizar esta acción');
        }

        $regiones = Region::where('estatus', 'activo')->get();
        $ingenieros = User::where('rol_id', 4)
            ->where('estatus', 1)
            ->orderBy('nombre')
            ->get(['id', 'numero_nomina', 'nombre', 'apellido']);

        return view('cedis.modals.create', compact('regiones', 'ingenieros'));
    }

    public function store(Request $request)
    {
        // Verificar permisos (solo admin)
        if (Auth::user()->rol_id != 1) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        try {
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:100',
                'direccion' => 'nullable|string',
                'telefono' => 'nullable|string|max:20',
                'responsable' => 'nullable|string|max:100',
                'region_id' => 'required|exists:regiones,id',
                'estatus' => 'required|in:activo,inactivo',
                'ingeniero_id' => 'nullable|exists:users,id'
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $cedis = Cedis::create($request->all());

            return redirect()->route('cedis.index')
                ->with('success', 'CEDIS creado correctamente');
        } catch (\Exception $e) {
            Log::error('Error al crear CEDIS: ' . $e->getMessage());
            return back()->with('error', 'Error al crear el CEDIS: ' . $e->getMessage())->withInput();
        }
    }

    // En CedisController.php
    public function destroy($id)
    {
        // Verificar permisos (solo admin)
        if (Auth::user()->rol_id != 1) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        try {
            $cedis = Cedis::findOrFail($id);

            // Verificar si el CEDIS tiene tickets asociados
            if ($cedis->tickets()->exists()) {
                return response()->json([
                    'error' => 'No se puede eliminar el CEDIS porque tiene tickets asociados'
                ], 422);
            }

            $cedis->delete();

            return response()->json([
                'message' => 'CEDIS eliminado correctamente'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'CEDIS no encontrado'], 404);
        } catch (\Exception $e) {
            Log::error('Error al eliminar CEDIS: ' . $e->getMessage());
            return response()->json(['error' => 'Error interno del servidor'], 500);
        }
    }

    // En UserController.php
    public function getUserJson(User $user)
    {
        return response()->json($user);
    }
}
