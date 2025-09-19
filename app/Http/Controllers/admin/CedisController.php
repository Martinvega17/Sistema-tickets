<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cedis;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CedisController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $regionId = $request->input('region_id', '');

        // Obtener regiones para el filtro
        $regiones = Region::where('estatus', 'activo')
            ->orderBy('nombre')
            ->get();

        // Consulta base para CEDIS
        $cedisQuery = Cedis::with('region');

        // Aplicar filtro de búsqueda por texto
        if (!empty($search)) {
            $cedisQuery->where(function ($query) use ($search) {
                $query->where('nombre', 'like', "%{$search}%")
                    ->orWhere('direccion', 'like', "%{$search}%")
                    ->orWhere('responsable', 'like', "%{$search}%")
                    ->orWhere('telefono', 'like', "%{$search}%");
            });
        }

        // Aplicar filtro por región
        if (!empty($regionId)) {
            $cedisQuery->where('region_id', $regionId);
        }

        // Ordenar y paginar
        $cedis = $cedisQuery->orderBy('nombre')->paginate(10);

        return view('admin.cedis.index', compact('cedis', 'regiones', 'search', 'regionId'));
    }

    // ✅ AGREGA ESTE MÉTODO FILTER
    public function filter(Request $request)
    {
        $search = $request->input('search', '');   // valor por defecto
        $regionId = $request->input('region_id', ''); // valor por defecto

        $query = Cedis::query();

        if ($regionId) {
            $query->where('region_id', $regionId);
        }

        if ($request->has('estatus') && $request->estatus) {
            $query->where('estatus', $request->estatus);
        }

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('direccion', 'like', "%{$search}%")
                    ->orWhere('responsable', 'like', "%{$search}%")
                    ->orWhere('telefono', 'like', "%{$search}%");
            });
        }


        $cedis = $query->orderBy('nombre')->paginate(10, ['*'], 'page', $request->page ?? 1);


        $regiones = Region::where('estatus', 'activo')->orderBy('nombre')->get();

        if ($request->ajax()) {
            $html = view('admin.cedis.partials.cedis_rows', compact('cedis'))->render();
            $pagination_html = $cedis->links()->render();

            return response()->json([
                'html' => $html,
                'pagination_html' => $pagination_html,
                'pagination' => [
                    'count' => $cedis->count(),
                    'total' => $cedis->total()
                ]
            ]);
        }

        return view('admin.cedis.index', compact('cedis', 'regiones', 'search', 'regionId'));
    }



    public function create()
    {
        $regiones = Region::where('estatus', 'activo')
            ->orderBy('nombre')
            ->get();

        return view('admin.cedis.create', compact('regiones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'region_id' => 'required|exists:regiones,id',
            'nombre' => 'required|string|max:100|unique:cedis,nombre',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'responsable' => 'nullable|string|max:100',
            'estatus' => 'required|in:activo,inactivo'
        ]);

        Cedis::create($request->all());

        return redirect()->route('admin.cedis.index')
            ->with('success', 'CEDIS creado correctamente.');
    }

    public function edit(Cedis $cedis)
    {
        $regiones = Region::where('estatus', 'activo')
            ->orderBy('nombre')
            ->get();

        return view('admin.cedis.edit', compact('cedis', 'regiones'));
    }

    public function update(Request $request, Cedis $cedis)
    {
        $request->validate([
            'region_id' => 'required|exists:regiones,id',
            'nombre' => 'required|string|max:100|unique:cedis,nombre,' . $cedis->id,
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'responsable' => 'nullable|string|max:100',
            'estatus' => 'required|in:activo,inactivo'
        ]);

        $cedis->update($request->all());

        return redirect()->route('admin.cedis.index')
            ->with('success', 'CEDIS actualizado correctamente.');
    }

    public function destroy(Cedis $cedis)
    {
        // Verificar si hay tickets asociados
        if ($cedis->tickets()->exists()) {
            return redirect()->back()
                ->with('error', 'No se puede eliminar el CEDIS porque tiene tickets asociados.');
        }

        $cedis->delete();

        return redirect()->route('admin.cedis.index')
            ->with('success', 'CEDIS eliminado correctamente.');
    }

    public function toggleStatus(Cedis $cedis)
    {
        $cedis->estatus = $cedis->estatus == 'activo' ? 'inactivo' : 'activo';
        $cedis->save();

        return redirect()->back()
            ->with('success', 'Estado del CEDIS actualizado correctamente.');
    }
}
