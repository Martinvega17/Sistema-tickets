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
use Illuminate\Support\Facades\Schema;

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

        // Cargar todos los CEDIS para el filtro JavaScript
        $allCedis = Cedis::with(['region', 'ingeniero'])->orderBy('nombre')->get();

        // Cargar CEDIS con paginación para la tabla
        $cedis = Cedis::with(['region', 'ingeniero'])->orderBy('nombre')->paginate(10);

        $regiones = Region::where('estatus', 'activo')->get();

        return view('cedis.index', compact('cedis', 'allCedis', 'regiones'));
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
            $query = Cedis::with(['region', 'ingeniero']); // ← Asegúrate de incluir 'region'

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
            $cedis->update($request->all());

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

    // En CedisController.php, actualiza el método toggleStatus:

    public function toggleStatus(Request $request, $id)
    {
        $this->checkAdminSupervisorPermission();

        try {
            $cedis = Cedis::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'estatus' => 'required|in:activo,inactivo'
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            Log::info('Cambiando estatus del CEDIS', [
                'cedis_id' => $cedis->id,
                'estatus_anterior' => $cedis->estatus,
                'estatus_nuevo' => $request->estatus,
                'user_id' => Auth::id()
            ]);

            $cedis->estatus = $request->estatus;
            $cedis->save();

            Log::info('Estatus actualizado correctamente', [
                'cedis_id' => $cedis->id,
                'estatus_actual' => $cedis->estatus
            ]);

            // Redirigir de vuelta con mensaje de éxito
            return redirect()->back()->with('success', 'Estatus actualizado correctamente');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'CEDIS no encontrado');
        } catch (\Exception $e) {
            Log::error('Error al actualizar estatus:', [
                'error' => $e->getMessage(),
                'cedis_id' => $id
            ]);
            return redirect()->back()->with('error', 'Error interno del servidor');
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
