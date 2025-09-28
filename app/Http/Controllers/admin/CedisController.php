<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

        // Cargar todos los CEDIS para el filtro JavaScript
        $allCedis = Cedis::with(['region', 'ingeniero'])->orderBy('nombre')->get();

        // Cargar CEDIS con paginación para la tabla
        $cedis = Cedis::with(['region', 'ingeniero'])->orderBy('nombre')->paginate(10);

        $regiones = Region::where('estatus', 'activo')->get();
        $ingenieros = $this->getIngenieros();

        return view('admin.cedis.index', compact('cedis', 'allCedis', 'regiones', 'ingenieros'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create()
    {
        $this->checkAdminPermission();

        $regiones = Region::where('estatus', 'activo')->get();
        $ingenieros = User::where('rol_id', 4)
            ->where('estatus', 1)
            ->orderBy('nombre')
            ->orderBy('apellido')
            ->get(['id', 'nombre', 'apellido', 'numero_nomina']);

        // Usar compact correctamente
        return view('admin.cedis.create', compact('regiones', 'ingenieros'));
    }

    public function edit($id)
    {
        $this->checkAdminPermission();

        $cedis = Cedis::findOrFail($id);
        $regiones = Region::where('estatus', 'activo')->get();
        $ingenieros = $this->getIngenieros();

        return view('admin.cedis.edit', [
            'cedis' => $cedis,
            'regiones' => $regiones,
            'ingenieros' => $ingenieros
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
    // En CedisController - métodos store y update
    public function store(Request $request)
    {
        $this->checkAdminPermission();

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100',
            'direccion' => 'nullable|string',
            'telefono' => 'nullable|string|max:20',
            'responsable' => 'nullable|string|max:100', // Mantener como texto
            'region_id' => 'required|exists:regiones,id',
            'estatus' => 'required|in:activo,inactivo',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // Debug para ver qué se está enviando
            Log::info('Datos del formulario:', $request->all());

            Cedis::create($request->all());
            return redirect()->route('admin.cedis.index')
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
            'responsable' => 'nullable|string|max:100', // Mantener como texto
            'region_id' => 'required|exists:regiones,id',
            'estatus' => 'required|in:activo,inactivo',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $cedis = Cedis::findOrFail($id);

            // Debug antes de actualizar
            Log::info('Actualizando CEDIS:', [
                'id' => $cedis->id,
                'datos_anteriores' => $cedis->toArray(),
                'datos_nuevos' => $request->all()
            ]);

            $cedis->update($request->all());

            // Debug después de actualizar
            $cedis->refresh();
            Log::info('CEDIS actualizado:', $cedis->toArray());

            return redirect()->route('admin.cedis.index')
                ->with('success', 'CEDIS actualizado correctamente');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'CEDIS no encontrado');
        } catch (\Exception $e) {
            Log::error('Error en update:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Error interno del servidor');
        }
    }

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

            if ($cedis->tickets()->exists()) {
                return response()->json([
                    'error' => 'No se puede eliminar el CEDIS porque tiene tickets asociados'
                ], 422);
            }

            $cedis->delete();

            return redirect()->route('admin.cedis.index')
                ->with('success', 'CEDIS eliminado correctamente');
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
        try {
            Log::info('=== GET INGENIEROS METHOD CALLED ===');

            $ingenieros = User::where('rol_id', 4)
                ->where('estatus', 1)
                ->orderBy('nombre')
                ->orderBy('apellido')
                ->get(['id', 'nombre', 'apellido', 'numero_nomina']);

            Log::info('Ingenieros encontrados: ' . $ingenieros->count());

            foreach ($ingenieros as $ingeniero) {
                Log::info(' - ' . $ingeniero->nombre . ' ' . $ingeniero->apellido);
            }

            return $ingenieros;
        } catch (\Exception $e) {
            Log::error('Error en getIngenieros: ' . $e->getMessage());
            return collect(); // Retorna colección vacía en caso de error
        }
    }

    public function filter(Request $request)
    {
        try {
            $this->checkAdminSupervisorPermission();

            $search = $request->input('search');
            $regionId = $request->input('region_id');
            $page = $request->input('page', 1);

            $query = Cedis::with(['region', 'ingeniero']);

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nombre', 'like', "%$search%")
                        ->orWhere('direccion', 'like', "%$search%")
                        ->orWhere('responsable', 'like', "%$search%")
                        ->orWhere('telefono', 'like', "%$search%");
                });
            }

            if ($regionId) {
                $query->where('region_id', $regionId);
            }

            $cedis = $query->orderBy('nombre')->paginate(10, ['*'], 'page', $page);

            $cedis->appends([
                'search' => $search,
                'region_id' => $regionId
            ]);

            if ($request->ajax()) {
                $html = view('admin.cedis.partials.cedis_rows', compact('cedis'))->render();
                $paginationHtml = $cedis->links()->toHtml();

                return response()->json([
                    'html' => $html,
                    'pagination_html' => $paginationHtml,
                    'pagination' => [
                        'current_page' => $cedis->currentPage(),
                        'last_page' => $cedis->lastPage(),
                        'total' => $cedis->total(),
                        'count' => $cedis->count()
                    ],
                    'filters' => [
                        'search' => $search,
                        'region_id' => $regionId
                    ]
                ]);
            }

            return view('admin.cedis.index', compact('cedis'));
        } catch (\Exception $e) {
            Log::error('Error en filter:', ['message' => $e->getMessage()]);

            if ($request->ajax()) {
                return response()->json(['error' => 'Error al filtrar los datos'], 500);
            }

            return back()->with('error', 'Error al filtrar los datos');
        }
    }
}
