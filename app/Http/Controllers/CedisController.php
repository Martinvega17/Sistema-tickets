<?php

namespace App\Http\Controllers;

use App\Models\Cedis;
use App\Models\Region;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CedisController extends Controller
{
    /**
     * Middleware para verificar permisos
     */
    private function checkAdminPermission()
    {
        if (Auth::user()->rol_id != 1) {
            abort(403, 'No tienes permisos para realizar esta acción');
        }
    }

    private function checkAdminSupervisorPermission()
    {
        if (Auth::user()->rol_id != 1 && Auth::user()->rol_id != 2) {
            abort(403, 'No tienes permisos para acceder a esta sección');
        }
    }

    /**
     * Métodos para vistas
     */
    public function index(Request $request)
    {
        $this->checkAdminSupervisorPermission();

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

        // Filtros
        if ($request->has('region') && !empty($request->region)) {
            $query->where('region_id', $request->region);
        }

        if ($request->has('estatus') && $request->estatus !== '') {
            $query->where('estatus', $request->estatus);
        }

        $cedis = $query->orderBy('nombre')->paginate(15);
        $regiones = Region::where('estatus', 'activo')->get();

        // Para peticiones AJAX
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
                'ingenieros' => $this->getIngenieros()
            ]);
        }

        return view('cedis.index', compact('regiones'));
    }

    public function create()
    {
        $this->checkAdminPermission();

        return view('cedis.modals.create', [
            'regiones' => Region::where('estatus', 'activo')->get(),
            'ingenieros' => $this->getIngenieros()
        ]);
    }

    public function edit($id)
    {
        $this->checkAdminPermission();

        $cedis = Cedis::findOrFail($id);

        return view('cedis.modals.edit', [
            'cedis' => $cedis,
            'regiones' => Region::where('estatus', 'activo')->get(),
            'ingenieros' => $this->getIngenieros(),
            'id' => $id
        ]);
    }

    /**
     * Métodos para API/JSON
     */
    public function show($id)
    {
        try {
            $cedis = Cedis::with(['region', 'ingeniero'])->findOrFail($id);
            return response()->json($cedis);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'CEDIS no encontrado'], 404);
        } catch (\Exception $e) {
            Log::error('Error en show:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Error al cargar el CEDIS'], 500);
        }
    }

    public function getCedisData(Request $request)
    {
        try {
            $query = Cedis::with(['region', 'ingeniero']);

            // Filtros
            if ($request->query('search')) {
                $search = $request->query('search');
                $query->where(function ($q) use ($search) {
                    $q->where('nombre', 'like', "%$search%")
                        ->orWhere('codigo', 'like', "%$search%");
                });
            }

            if ($request->query('region')) {
                $query->where('region_id', $request->query('region'));
            }

            if ($request->query('estatus') && $request->query('estatus') !== '') {
                $query->where('estatus', $request->query('estatus'));
            }

            $cedisList = $query->orderBy('nombre')->get();
            return response()->json($cedisList);
        } catch (\Exception $e) {
            Log::error('Error en getCedisData:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'Error al cargar los datos'], 500);
        }
    }

    /**
     * Métodos CRUD
     */
    public function store(Request $request)
    {
        $this->checkAdminPermission();

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

        try {
            Cedis::create($request->all());
            return redirect()->route('cedis.index')
                ->with('success', 'CEDIS creado correctamente');
        } catch (\Exception $e) {
            Log::error('Error al crear CEDIS: ' . $e->getMessage());
            return back()->with('error', 'Error al crear el CEDIS: ' . $e->getMessage())->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $this->checkAdminPermission();

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
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $cedis = Cedis::findOrFail($id);

            $cedis->update([
                'nombre' => $request->nombre,
                'direccion' => $request->direccion,
                'telefono' => $request->telefono,
                'responsable' => $request->responsable,
                'region_id' => $request->region_id,
                'estatus' => $request->estatus,
                'ingeniero_id' => $request->ingeniero_id
            ]);

            return response()->json([
                'message' => 'CEDIS actualizado correctamente',
                'cedis' => $cedis
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'CEDIS no encontrado'], 404);
        } catch (\Exception $e) {
            Log::error('Error en update:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Error interno del servidor'], 500);
        }
    }

    public function updateStatus(Request $request, Cedis $cedis)
    {
        $this->checkAdminPermission();

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

    public function destroy($id)
    {
        $this->checkAdminPermission();

        try {
            $cedis = Cedis::findOrFail($id);

            // Verificar dependencias
            if ($cedis->tickets()->exists()) {
                return response()->json([
                    'error' => 'No se puede eliminar el CEDIS porque tiene tickets asociados'
                ], 422);
            }

            $cedis->delete();

            return response()->json([
                'message' => 'CEDIS eliminado correctamente'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'CEDIS no encontrado'], 404);
        } catch (\Exception $e) {
            Log::error('Error al eliminar CEDIS: ' . $e->getMessage());
            return response()->json(['error' => 'Error interno del servidor'], 500);
        }
    }

    /**
     * Métodos auxiliares
     */
    private function getIngenieros()
    {
        return User::where('rol_id', 4)
            ->where('estatus', 1)
            ->with('rol')
            ->orderBy('nombre')
            ->get(['id', 'numero_nomina', 'nombre', 'apellido', 'rol_id']);
    }
}
