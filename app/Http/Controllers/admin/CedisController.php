<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cedis;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CedisController extends Controller
{
    public function index()
    {
        // Obtener todos los CEDIS con sus regiones
        $cedis = Cedis::with('region')->orderBy('nombre')->paginate(10);

        // Obtener regiones para el filtro
        $regiones = Region::where('estatus', 'activo')
            ->orderBy('nombre')
            ->get();

        return view('admin.cedis.index', compact('cedis', 'regiones'));
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
