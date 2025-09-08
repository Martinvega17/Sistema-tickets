<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
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
        $stats = [
            'total_tickets' => Ticket::count(),
            'tickets_abiertos' => Ticket::where('estatus', 'Abierto')->count(),
            'tickets_en_progreso' => Ticket::where('estatus', 'En progreso')->count(),
            'tickets_resueltos' => Ticket::where('estatus', 'Resuelto')->count(),
            'total_usuarios' => User::count(),
            'total_cedis' => Cedis::where('estatus', 'activo')->count(),
            'total_areas' => Area::where('estatus', 'activo')->count(),
            'total_categorias' => Categoria::where('estatus', 'activo')->count(),
        ];

        // Tickets por estatus
        $ticketsPorEstatus = Ticket::select('estatus', DB::raw('count(*) as total'))
            ->groupBy('estatus')
            ->get();

        // Tickets recientes
        $ticketsRecientes = Ticket::with(['usuario', 'cedis'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'ticketsPorEstatus', 'ticketsRecientes'));
    }
}
