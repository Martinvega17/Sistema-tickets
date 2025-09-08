<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TipoNaturaleza;
use App\Models\Naturaleza;
use Illuminate\Http\Request;

class TipoNaturalezaController extends Controller
{
    public function index()
    {
        $tipos = TipoNaturaleza::with('naturaleza')->orderBy('nombre')->get();
        return view('admin.tipo-naturalezas.index', compact('tipos'));
    }

    public function create()
    {
        $naturalezas = Naturaleza::where('estatus', 'activo')->orderBy('nombre')->get();
        return view('admin.tipo-naturalezas.create', compact('naturalezas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'naturaleza_id' => 'required|exists:naturalezas,id',
            'estatus' => 'required|in:activo,inactivo'
        ]);

        TipoNaturaleza::create($request->all());

        return redirect()->route('admin.tipo-naturalezas.index')
            ->with('success', 'Tipo de naturaleza creado correctamente.');
    }

    public function edit(TipoNaturaleza $tipoNaturaleza)
    {
        $naturalezas = Naturaleza::where('estatus', 'activo')->orderBy('nombre')->get();
        return view('admin.tipo-naturalezas.edit', compact('tipoNaturaleza', 'naturalezas'));
    }

    public function update(Request $request, TipoNaturaleza $tipoNaturaleza)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'naturaleza_id' => 'required|exists:naturalezas,id',
            'estatus' => 'required|in:activo,inactivo'
        ]);

        $tipoNaturaleza->update($request->all());

        return redirect()->route('admin.tipo-naturalezas.index')
            ->with('success', 'Tipo de naturaleza actualizado correctamente.');
    }

    public function destroy(TipoNaturaleza $tipoNaturaleza)
    {
        if ($tipoNaturaleza->tickets()->exists()) {
            return redirect()->back()
                ->with('error', 'No se puede eliminar el tipo porque tiene tickets asociados.');
        }

        $tipoNaturaleza->delete();

        return redirect()->route('admin.tipo-naturalezas.index')
            ->with('success', 'Tipo de naturaleza eliminado correctamente.');
    }
}
