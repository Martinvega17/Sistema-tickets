<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tickets;
use App\Models\User;
use App\Models\Cedis;
use App\Models\Area;
use App\Models\Categoria;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        // Aplicar middleware de autenticación y admin
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        // Verificar que el usuario tenga permisos de admin (redundante por el middleware, pero por seguridad)
        if (!in_array(Auth::user()->rol_id, [1, 2])) {
            return redirect()->route('dashboard')->with('error', 'No tienes permisos para acceder al panel de administración.');
        }

        $stats = [
            'total_tickets' => Tickets::count(),
            'tickets_abiertos' => Tickets::where('estatus', 'Abierto')->count(),
            'tickets_en_progreso' => Tickets::where('estatus', 'En progreso')->count(),
            'tickets_resueltos' => Tickets::where('estatus', 'Resuelto')->count(),
            'total_usuarios' => User::count(),
            'total_cedis' => Cedis::where('estatus', 'activo')->count(),
            'total_areas' => Area::where('estatus', 'activo')->count(),
            'total_categorias' => Categoria::where('estatus', 'activo')->count(),
        ];

        // Tickets por estatus
        $ticketsPorEstatus = Tickets::select('estatus', DB::raw('count(*) as total'))
            ->groupBy('estatus')
            ->get();

        // Tickets recientes
        $ticketsRecientes = Tickets::with(['usuario', 'cedis'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'ticketsPorEstatus', 'ticketsRecientes'));
    }
}
