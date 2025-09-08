<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Servicio;
use App\Models\Area;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    public function index()
    {
        $servicios = Servicio::with('area')->orderBy('nombre')->paginate(10); // ← Cambia get() por paginate(10)
        $areas = Area::where('estatus', 'activo')->orderBy('nombre')->get();

        return view('admin.servicios.index', compact('servicios', 'areas'));
    }

    public function create()
    {
        $areas = Area::where('estatus', 'activo')->orderBy('nombre')->get();
        return view('admin.servicios.create', compact('areas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'area_id' => 'required|exists:areas,id',
            'estatus' => 'required|in:activo,inactivo'
        ]);

        Servicio::create($request->all());

        return redirect()->route('admin.servicios.index')
            ->with('success', 'Servicio creado correctamente.');
    }

    public function edit(Servicio $servicio)
    {
        $areas = Area::where('estatus', 'activo')->orderBy('nombre')->get();
        return view('admin.servicios.edit', compact('servicio', 'areas'));
    }

    public function update(Request $request, Servicio $servicio)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'area_id' => 'required|exists:areas,id',
            'estatus' => 'required|in:activo,inactivo'
        ]);

        $servicio->update($request->all());

        return redirect()->route('admin.servicios.index')
            ->with('success', 'Servicio actualizado correctamente.');
    }

    public function destroy(Servicio $servicio)
    {
        if ($servicio->tickets()->exists()) {
            return redirect()->back()
                ->with('error', 'No se puede eliminar el servicio porque tiene tickets asociados.');
        }

        $servicio->delete();

        return redirect()->route('admin.servicios.index')
            ->with('success', 'Servicio eliminado correctamente.');
    }
}
