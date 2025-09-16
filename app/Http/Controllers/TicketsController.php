<?php

namespace App\Http\Controllers;

use App\Models\Tickets;
use App\Models\Area;
use App\Models\Servicio;
use App\Models\Naturaleza;
use App\Models\TipoNaturaleza;
use App\Models\Categoria;
use App\Models\GrupoTrabajo;
use App\Models\Actividad;
use App\Models\User;
use App\Models\Cedis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;


class TicketsController extends Controller
{
    public function index(Request $request)
    {
        $query = Tickets::with(['usuario', 'ingenieroAsignado', 'cedis', 'area', 'servicio']);

        // Filtros según el rol del usuario
        if (Auth::user()->rol_id == 4) { // Soporte
            $query->where('ingeniero_asignado_id', Auth::id());
        } elseif (Auth::user()->rol_id == 5) { // Usuario
            $query->where('usuario_id', Auth::id());
        } elseif (in_array(Auth::user()->rol_id, [2, 3])) { // Supervisor y Coordinador
            // Pueden ver tickets de sus regiones/cedis
            $cedisIds = Cedis::where('region_id', Auth::user()->region_id)->pluck('id');
            $query->whereIn('cedis_id', $cedisIds);
        }

        // Búsqueda
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('titulo', 'like', "%$search%")
                    ->orWhere('descripcion', 'like', "%$search%")
                    ->orWhere('id', 'like', "%$search%");
            });
        }

        // Filtro por estatus
        if ($request->has('estatus') && $request->estatus !== '') {
            $query->where('estatus', $request->estatus);
        }

        $tickets = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        $areas = Area::where('estatus', 'activo')->get();
        $naturalezas = Naturaleza::where('estatus', 'activo')->get();
        $categorias = Categoria::where('estatus', 'activo')->get();
        $gruposTrabajo = GrupoTrabajo::where('estatus', 'activo')->get();
        $actividades = Actividad::where('estatus', 'activo')->get();
        $responsables = User::whereIn('rol_id', [2, 3, 4])->where('estatus', 1)->get();
        $cedis = Cedis::where('estatus', 'activo')->get();

        return view('tickets.create', compact(
            'areas',
            'naturalezas',
            'categorias',
            'gruposTrabajo',
            'actividades',
            'responsables',
            'cedis'
        ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'area_id' => 'required|exists:areas,id',
            'servicio_id' => 'required|exists:servicios,id',
            'naturaleza_id' => 'required|exists:naturalezas,id',
            'categoria_id' => 'required|exists:categorias,id',
            'grupo_trabajo_id' => 'required|exists:grupo_trabajos,id',
            'impacto' => 'required|in:Baja,Media,Alta',
            'prioridad' => 'required|in:Baja,Media,Alta',
            'urgencia' => 'required|in:Baja,Media,Alta',
            'fecha_recepcion' => 'required|date',
            'tipo_naturaleza_id' => 'required|exists:tipo_naturalezas,id',
            'actividad_id' => 'required|exists:actividades,id',
            'responsable_id' => 'required|exists:users,id',
            'cedis_id' => 'required|exists:cedis,id',
            'usuarios_notificar' => 'nullable|array',
            'tipo_via' => 'required|in:Correo electrónico,Teléfono,Presencial'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Calcular tiempos según prioridad
        $tiempos = $this->calcularTiempos($request->prioridad);

        $ticket = Tickets::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'estatus' => 'Abierto',
            'usuario_id' => Auth::id(),
            'area_id' => $request->area_id,
            'servicio_id' => $request->servicio_id,
            'naturaleza_id' => $request->naturaleza_id,
            'categoria_id' => $request->categoria_id,
            'grupo_trabajo_id' => $request->grupo_trabajo_id,
            'impacto' => $request->impacto,
            'prioridad' => $request->prioridad,
            'urgencia' => $request->urgencia,
            'fecha_recepcion' => $request->fecha_recepcion,
            'tipo_naturaleza_id' => $request->tipo_naturaleza_id,
            'actividad_id' => $request->actividad_id,
            'responsable_id' => $request->responsable_id,
            'cedis_id' => $request->cedis_id,
            'ingeniero_asignado_id' => $request->responsable_id,
            'usuarios_notificar' => $request->usuarios_notificar,
            'tipo_via' => $request->tipo_via,
            'tiempo_respuesta' => $tiempos['respuesta'],
            'tiempo_solucion' => $tiempos['solucion'],
            'tiempo_diagnostico' => $tiempos['diagnostico'],
            'tiempo_reparacion' => $tiempos['reparacion']
        ]);

        // Notificar a usuarios si se especificó
        if ($request->usuarios_notificar) {
            $this->notificarUsuarios($ticket, $request->usuarios_notificar);
        }

        return redirect()->route('tickets.show', $ticket->id)
            ->with('success', 'Ticket creado exitosamente.');
    }

    public function show(Tickets $ticket)
    {
        // Verificar permisos para ver el ticket
        $this->authorizeView($ticket);

        return view('tickets.show', compact('ticket'));
    }

    private function calcularTiempos($prioridad)
    {
        // Lógica para calcular tiempos según prioridad
        $tiempos = [
            'Baja' => [
                'respuesta' => '6 hrs',
                'solucion' => '48 hrs',
                'diagnostico' => '72 hrs',
                'reparacion' => '120 hrs'
            ],
            'Media' => [
                'respuesta' => '4 hrs',
                'solucion' => '24 hrs',
                'diagnostico' => '48 hrs',
                'reparacion' => '96 hrs'
            ],
            'Alta' => [
                'respuesta' => '30 min',
                'solucion' => '2 hrs',
                'diagnostico' => '24 hrs',
                'reparacion' => '48 hrs'
            ]
        ];

        return $tiempos[$prioridad];
    }

    private function authorizeView(Tickets $ticket)
    {
        $user = Auth::user();

        if ($user->rol_id == 5 && $ticket->usuario_id != $user->id) {
            abort(403, 'No tienes permisos para ver este ticket.');
        }

        if ($user->rol_id == 4 && $ticket->ingeniero_asignado_id != $user->id) {
            abort(403, 'No tienes permisos para ver este ticket.');
        }

        if (in_array($user->rol_id, [2, 3])) {
            $userCedis = Cedis::where('region_id', $user->region_id)->pluck('id');
            if (!$userCedis->contains($ticket->cedis_id)) {
                abort(403, 'No tienes permisos para ver este ticket.');
            }
        }
    }

    public function getServiciosByArea($areaId)
    {
        $servicios = Servicio::where('area_id', $areaId)
            ->where('estatus', 'activo')
            ->get();

        return response()->json($servicios);
    }


    private function notificarUsuarios($ticket, $usuariosIds)
    {
        // Implementar lógica de notificación (email, notificación interna, etc.)
        // Por ahora solo es un placeholder
        Log::info('Notificando a usuarios sobre el ticket: ' . $ticket->id);
    }
}
