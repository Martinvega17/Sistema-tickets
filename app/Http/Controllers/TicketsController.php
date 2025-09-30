<?php

namespace App\Http\Controllers;

use App\Models\Tickets;
use App\Models\User;
use App\Models\Cedis;
use App\Models\Region;
use App\Models\Area;
use App\Models\Servicio;
use App\Models\Naturaleza;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Tickets::with(['usuario', 'ingenieroAsignado', 'area'])
            ->latest('fecha_recepcion');

        // Filtros
        if ($request->has('estatus') && $request->estatus != '') {
            $query->where('estatus', $request->estatus);
        }

        if ($request->has('prioridad') && $request->prioridad != '') {
            $query->where('prioridad', $request->prioridad);
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('titulo', 'like', "%{$search}%")
                    ->orWhere('descripcion', 'like', "%{$search}%")
                    ->orWhere('ticket_number', 'like', "%{$search}%");
            });
        }

        $tickets = $query->paginate(10);

        return view('tickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $regiones = \App\Models\Region::where('estatus', 'activo')
            ->orderBy('nombre')
            ->get();

        // Verifica que hay regiones
        if ($regiones->isEmpty()) {
            Log::warning('No se encontraron regiones activas');
        } else {
            Log::info('Regiones cargadas:', ['count' => $regiones->count()]);
        }

        $areas = \App\Models\Area::all();
        $servicios = \App\Models\Servicio::all();
        $categorias = \App\Models\Categoria::all();
        $naturalezas = \App\Models\Naturaleza::all();

        return view('tickets.create', compact(
            'regiones',
            'areas',
            'servicios',
            'categorias',
            'naturalezas'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'region_id' => 'required|exists:regiones,id',
            'cedis_id' => 'required|exists:cedis,id',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'area_id' => 'nullable|exists:areas,id',
            'servicio_id' => 'nullable|exists:servicios,id',
            'categoria_id' => 'nullable|exists:categorias,id',
            'naturaleza_id' => 'nullable|exists:naturalezas,id',
            'observaciones' => 'nullable|string',
        ]);

        try {
            // Validar que el CEDIS pertenezca a la región seleccionada
            $cedis = \App\Models\Cedis::find($validated['cedis_id']);
            if ($cedis->region_id != $validated['region_id']) {
                return redirect()->back()
                    ->with('error', 'El CEDIS seleccionado no pertenece a la región elegida.')
                    ->withInput();
            }

            // OPCIÓN 1: Usar Auth facade
            $validated['usuario_id'] = \Illuminate\Support\Facades\Auth::id();

            // OPCIÓN 2: Usar el request
            // $validated['usuario_id'] = $request->user()->id;

            // Asignar fecha de recepción actual
            $validated['fecha_recepcion'] = now();

            // Asignar valores por defecto
            $validated['estatus'] = 'Abierto';
            $validated['status'] = 'Abierto';
            $validated['prioridad'] = 'Media';
            $validated['impacto'] = 'Media';
            $validated['urgencia'] = 'Media';
            $validated['tipo_via'] = 'Correo electrónico';
            $validated['medio_atencion'] = 'Presencial';

            $ticket = Tickets::create($validated);

            return redirect()->route('tickets.show', $ticket->id)
                ->with('success', 'Ticket creado exitosamente. Será revisado por Mesa de Control.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al crear el ticket: ' . $e->getMessage())
                ->withInput();
        }
    }



    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $ticket = Tickets::with(['notes.user', 'assignedUser'])->findOrFail($id);
        $soporteUsers = \App\Models\User::where('role_id', 3)->get(); // Rol 3: Soporte

        return view('tickets.show', compact('ticket', 'soporteUsers'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tickets $ticket)
    {
        $this->checkTicketsPermission();

        $cedis = Cedis::where('estatus', 'activo')->orderBy('nombre')->get();
        $regiones = Region::where('estatus', 'activo')->orderBy('nombre')->get();
        $areas = Area::where('estatus', 'activo')->orderBy('nombre')->get();
        $ingenieros = User::where('rol_id', 4)->where('estatus', 1)->orderBy('nombre')->get();
        $usuarios = User::where('estatus', 1)->orderBy('nombre')->get();

        return view('tickets.edit', compact(
            'ticket',
            'cedis',
            'regiones',
            'areas',
            'ingenieros',
            'usuarios'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tickets $ticket)
    {
        $this->checkTicketsPermission();

        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'estatus' => 'required|in:Abierto,En progreso,En espera,Resuelto,Cerrado',
            'prioridad' => 'required|in:Baja,Media,Alta,Crítica',
            'impacto' => 'required|in:Baja,Media,Alta',
            'urgencia' => 'required|in:Baja,Media,Alta',
            'fecha_recepcion' => 'required|date',
            'tipo_via' => 'required|in:Correo electrónico,Teléfono,Presencial',
            'usuario_id' => 'required|exists:users,id',
            'cedis_id' => 'required|exists:cedis,id',
            'region_id' => 'required|exists:regiones,id',
            'area_id' => 'nullable|exists:areas,id',
            'servicio_id' => 'nullable|exists:servicios,id',
            'ingeniero_asignado_id' => 'nullable|exists:users,id',
        ]);

        $ticket->update($validated);

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tickets $ticket)
    {
        $this->checkTicketsPermission();

        $ticket->delete();

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket eliminado correctamente');
    }

    /**
     * Verificar permisos para tickets
     */
    private function checkTicketsPermission()
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'No autenticado');
        }

        // Admin y Supervisor tienen acceso completo
        if ($user->rol_id == 1 || $user->rol_id == 2) {
            return true;
        }

        // Coordinador puede ver y crear tickets
        if ($user->rol_id == 3) {
            return true;
        }

        // Soporte solo puede ver tickets asignados
        if ($user->rol_id == 4) {
            // Aquí puedes agregar lógica específica para soporte
            return true;
        }

        // Usuario regular solo puede ver sus propios tickets
        if ($user->rol_id == 5) {
            // Aquí puedes agregar lógica específica para usuarios
            return true;
        }

        abort(403, 'No tienes permisos para acceder a esta sección');
    }

    /**
     * Obtener servicios por área (para AJAX)
     */
    public function getServiciosByArea($areaId)
    {
        $servicios = Servicio::where('area_id', $areaId)
            ->where('estatus', 'activo')
            ->orderBy('nombre')
            ->get();

        return response()->json($servicios);
    }

    public function getCedisByRegion(Request $request)
    {
        $regionId = $request->query('region_id');

        Log::info('🔍 Solicitando CEDIS para región:', ['region_id' => $regionId]);

        // DEBUG: Verificar todas las regiones disponibles
        $todasRegiones = \App\Models\Region::where('estatus', 'activo')->get();
        Log::info('📍 Regiones disponibles:', $todasRegiones->pluck('nombre', 'id')->toArray());

        if (!$regionId) {
            Log::warning('❌ No se proporcionó region_id');
            return response()->json([]);
        }

        try {
            $cedis = Cedis::where('region_id', $regionId)
                ->where('estatus', 'activo')
                ->orderBy('nombre')
                ->get(['id', 'nombre', 'region_id']);

            Log::info('✅ CEDIS encontrados:', [
                'count' => $cedis->count(),
                'region_id' => $regionId,
                'cedis' => $cedis->pluck('nombre')->toArray()
            ]);

            // Si no hay CEDIS, verificar si la región existe
            if ($cedis->count() === 0) {
                $region = \App\Models\Region::find($regionId);
                Log::warning('⚠️ No hay CEDIS para la región:', [
                    'region_id' => $regionId,
                    'region_nombre' => $region ? $region->nombre : 'No encontrada'
                ]);
            }

            return response()->json($cedis);
        } catch (\Exception $e) {
            Log::error('❌ Error al cargar CEDIS:', [
                'error' => $e->getMessage(),
                'region_id' => $regionId,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json(['error' => 'Error al cargar CEDIS'], 500);
        }
    }
}
