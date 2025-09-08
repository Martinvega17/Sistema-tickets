<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Naturaleza;
use App\Models\Categoria;
use Illuminate\Http\Request;

class NaturalezaController extends Controller
{
    public function index()
    {
        $naturalezas = Naturaleza::with('categorias')->orderBy('nombre')->get();
        return view('admin.naturaleza.index', compact('naturalezas'));
    }

    public function create()
    {
        return view('admin.naturaleza.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            // Cambiar 'naturaleza' por 'naturalezas'
            'nombre' => 'required|string|max:100|unique:naturalezas,nombre',
            'estatus' => 'required|in:activo,inactivo'
        ]);

        Naturaleza::create($request->all());

        return redirect()->route('admin.naturaleza.index')
            ->with('success', 'Naturaleza creada correctamente.');
    }

    public function show(Naturaleza $naturaleza)
    {
        $categorias = $naturaleza->categorias()->orderBy('nombre')->get();
        return view('admin.naturaleza.show', compact('naturaleza', 'categorias'));
    }

    public function edit(Naturaleza $naturaleza)
    {
        return view('admin.naturaleza.edit', compact('naturaleza'));
    }

    public function update(Request $request, Naturaleza $naturaleza)
    {
        $request->validate([
            // Cambiar 'naturaleza' por 'naturalezas'
            'nombre' => 'required|string|max:100|unique:naturalezas,nombre,' . $naturaleza->id,
            'estatus' => 'required|in:activo,inactivo'
        ]);

        $naturaleza->update($request->all());

        return redirect()->route('admin.naturaleza.index')
            ->with('success', 'Naturaleza actualizada correctamente.');
    }

    public function destroy(Naturaleza $naturaleza)
    {
        if ($naturaleza->tickets()->exists()) {
            return redirect()->back()
                ->with('error', 'No se puede eliminar la naturaleza porque tiene tickets asociados.');
        }

        if ($naturaleza->categorias()->exists()) {
            return redirect()->back()
                ->with('error', 'No se puede eliminar la naturaleza porque tiene categorías asociadas.');
        }

        $naturaleza->delete();

        return redirect()->route('admin.naturaleza.index')
            ->with('success', 'Naturaleza eliminada correctamente.');
    }
}