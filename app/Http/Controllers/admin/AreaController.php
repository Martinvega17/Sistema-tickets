<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index()
    {
        $areas = Area::orderBy('nombre')->get();
        return view('admin.areas.index', compact('areas'));
    }

    public function create()
    {
        return view('admin.areas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:areas,nombre',
            'estatus' => 'required|in:activo,inactivo'
        ]);

        Area::create($request->all());

        return redirect()->route('admin.areas.index')
            ->with('success', 'Área creada correctamente.');
    }

    public function edit(Area $area)
    {
        return view('admin.areas.edit', compact('area'));
    }

    public function update(Request $request, Area $area)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:areas,nombre,' . $area->id,
            'estatus' => 'required|in:activo,inactivo'
        ]);

        $area->update($request->all());

        return redirect()->route('admin.areas.index')
            ->with('success', 'Área actualizada correctamente.');
    }

    public function destroy(Area $area)
    {
        // Verificar si hay tickets asociados
        if ($area->tickets()->exists()) {
            return redirect()->back()
                ->with('error', 'No se puede eliminar el área porque tiene tickets asociados.');
        }

        $area->delete();

        return redirect()->route('admin.areas.index')
            ->with('success', 'Área eliminada correctamente.');
    }
}
