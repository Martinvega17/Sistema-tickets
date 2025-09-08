<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Naturaleza;
use Illuminate\Http\Request;

class NaturalezaController extends Controller
{
    public function index()
    {
        $naturalezas = Naturaleza::orderBy('nombre')->get();
        return view('admin.naturalezas.index', compact('naturalezas'));
    }

    public function create()
    {
        return view('admin.naturalezas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:naturalezas,nombre',
            'estatus' => 'required|in:activo,inactivo'
        ]);

        Naturaleza::create($request->all());

        return redirect()->route('admin.naturalezas.index')
            ->with('success', 'Naturaleza creada correctamente.');
    }

    public function edit(Naturaleza $naturaleza)
    {
        return view('admin.naturalezas.edit', compact('naturaleza'));
    }

    public function update(Request $request, Naturaleza $naturaleza)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:naturalezas,nombre,' . $naturaleza->id,
            'estatus' => 'required|in:activo,inactivo'
        ]);

        $naturaleza->update($request->all());

        return redirect()->route('admin.naturalezas.index')
            ->with('success', 'Naturaleza actualizada correctamente.');
    }

    public function destroy(Naturaleza $naturaleza)
    {
        if ($naturaleza->tickets()->exists()) {
            return redirect()->back()
                ->with('error', 'No se puede eliminar la naturaleza porque tiene tickets asociados.');
        }

        if ($naturaleza->tipos()->exists()) {
            return redirect()->back()
                ->with('error', 'No se puede eliminar la naturaleza porque tiene tipos asociados.');
        }

        $naturaleza->delete();

        return redirect()->route('admin.naturalezas.index')
            ->with('success', 'Naturaleza eliminada correctamente.');
    }
}
