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
        // Verificar permisos según el rol
        $this->checkTicketsPermission();

        $query = Tickets::with([
            'usuario',
            'ingenieroAsignado',
            'cedis',
            'region',
            'area',
            'servicio'
        ]);

        // Filtros
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('titulo', 'like', "%$search%")
                    ->orWhere('descripcion', 'like', "%$search%")
                    ->orWhereHas('usuario', function ($q) use ($search) {
                        $q->where('nombre', 'like', "%$search%")
                            ->orWhere('apellido', 'like', "%$search%");
                    });
            });
        }

        if ($request->has('estatus') && !empty($request->estatus)) {
            $query->where('estatus', $request->estatus);
        }

        if ($request->has('prioridad') && !empty($request->prioridad)) {
            $query->where('prioridad', $request->prioridad);
        }

        if ($request->has('cedis_id') && !empty($request->cedis_id)) {
            $query->where('cedis_id', $request->cedis_id);
        }

        if ($request->has('region_id') && !empty($request->region_id)) {
            $query->where('region_id', $request->region_id);
        }

        // Ordenamiento
        $sortField = $request->get('sort', 'fecha_recepcion');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $tickets = $query->paginate(20);

        // Datos para filtros
        $cedis = Cedis::where('estatus', 'activo')->orderBy('nombre')->get();
        $regiones = Region::where('estatus', 'activo')->orderBy('nombre')->get();
        $ingenieros = User::where('rol_id', 4)->where('estatus', 1)->orderBy('nombre')->get();

        // Pasar datos a la vista de forma explícita
        return view('tickets.index', [
            'tickets' => $tickets,
            'cedis' => $cedis,
            'regiones' => $regiones,
            'ingenieros' => $ingenieros
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->checkTicketsPermission();

        $cedis = Cedis::where('estatus', 'activo')->orderBy('nombre')->get();
        $regiones = Region::where('estatus', 'activo')->orderBy('nombre')->get();
        $areas = Area::where('estatus', 'activo')->orderBy('nombre')->get();
        $ingenieros = User::where('rol_id', 4)->where('estatus', 1)->orderBy('nombre')->get();
        $usuarios = User::where('estatus', 1)->orderBy('nombre')->get();

        return view('tickets.create', compact(
            'cedis',
            'regiones',
            'areas',
            'ingenieros',
            'usuarios'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Verificar permisos
        $this->checkTicketsPermission();

        Log::info('=== STORE TICKET METHOD CALLED ===');
        Log::info('Datos recibidos:', $request->all());

        // Validación
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'region_id' => 'required|exists:regiones,id',
            'cedis_id' => 'required|exists:cedis,id',
            'area_id' => 'required|exists:areas,id',
            'servicio_id' => 'nullable|exists:servicios,id',
            'observaciones' => 'nullable|string',
        ]);

        Log::info('Datos validados:', $validated);

        try {
            // Asignar valores automáticamente
            $ticketData = [
                'titulo' => $validated['titulo'],
                'descripcion' => $validated['descripcion'],
                'region_id' => $validated['region_id'],
                'cedis_id' => $validated['cedis_id'],
                'area_id' => $validated['area_id'],
                'servicio_id' => $validated['servicio_id'] ?? null,

                // Valores automáticos
                'estatus' => 'Abierto',
                'prioridad' => 'Media',
                'impacto' => 'Media',
                'urgencia' => 'Media',
                'fecha_recepcion' => now(),
                'tipo_via' => 'Presencial',
                'usuario_id' => Auth::id(),
            ];

            Log::info('Datos para crear ticket:', $ticketData);

            // Asignar automáticamente a Mesa de Control (Rol 2)
            $mesaControl = User::where('rol_id', 2)
                ->where('estatus', 1)
                ->first();

            if ($mesaControl) {
                $ticketData['responsable_id'] = $mesaControl->id;
                Log::info('Asignado a Mesa de Control: ' . $mesaControl->nombre);
            } else {
                Log::warning('No se encontró usuario con rol 2 (Mesa de Control)');
            }

            // Crear el ticket
            $ticket = Tickets::create($ticketData);

            Log::info('Ticket creado exitosamente. ID: ' . $ticket->id);

            return redirect()->route('tickets.index')
                ->with('success', 'Ticket creado correctamente. Será asignado a Mesa de Control para su revisión.');
        } catch (\Exception $e) {
            Log::error('Error al crear ticket: ' . $e->getMessage());
            Log::error('Trace: ' . $e->getTraceAsString());

            return back()
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
}
