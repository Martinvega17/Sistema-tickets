<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function index()
    {
        $regiones = Region::orderBy('nombre')->get();
        return view('admin.regiones.index', compact('regiones'));
    }

    public function create()
    {
        return view('admin.regiones.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:regiones,nombre',
            'estatus' => 'required|in:activo,inactivo'
        ]);

        Region::create($request->all());

        return redirect()->route('admin.regiones.index')
            ->with('success', 'Region creada correctamente.');
    }

    public function edit(Region $region)
    {
        return view('admin.regiones.edit', compact('region'));
    }

    public function update(Request $request, Region $region)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:regiones,nombre,' . $region->id,
            'estatus' => 'required|in:activo,inactivo'
        ]);

        $region->update($request->all());

        return redirect()->route('admin.regiones.index')
            ->with('success', 'Region actualizada correctamente.');
    }

    public function destroy(Region $region)
    {
        // Verificar si hay tickets asociados
        if ($region->tickets()->exists()) {
            return redirect()->back()
                ->with('error', 'No se puede eliminar la region porque tiene tickets asociados.');
        }

        $region->delete();

        return redirect()->route('admin.regiones.index')
            ->with('success', 'Region eliminada correctamente.');
    }
}
