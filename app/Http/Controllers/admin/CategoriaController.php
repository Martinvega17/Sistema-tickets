<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Naturaleza;
use App\Models\Servicio;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::with(['naturaleza', 'servicio'])->orderBy('nombre')->paginate(10);
        $naturalezas = Naturaleza::where('estatus', 'activo')->orderBy('nombre')->get();
        $servicios = Servicio::where('estatus', 'activo')->orderBy('nombre')->get();

        return view('admin.categorias.index', compact('categorias', 'naturalezas', 'servicios'));
    }

    public function create()
    {
        $naturalezas = Naturaleza::where('estatus', 'activo')->orderBy('nombre')->get();
        $servicios = Servicio::where('estatus', 'activo')->orderBy('nombre')->get();
        return view('admin.categorias.create', compact('naturalezas', 'servicios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:categorias,nombre',
            'estatus' => 'required|in:activo,inactivo',
            'naturaleza_id' => 'required|exists:naturalezas,id',
            'servicio_id' => 'required|exists:servicios,id'
        ]);

        Categoria::create($request->all());

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoría creada correctamente.');
    }

    public function show(Categoria $categoria)
    {
        return view('admin.categorias.show', compact('categoria'));
    }

    public function edit(Categoria $categoria)
    {
        $naturalezas = Naturaleza::where('estatus', 'activo')->orderBy('nombre')->get();
        $servicios = Servicio::where('estatus', 'activo')->orderBy('nombre')->get();
        return view('admin.categorias.edit', compact('categoria', 'naturalezas', 'servicios'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:categorias,nombre,' . $categoria->id,
            'estatus' => 'required|in:activo,inactivo',
            'naturaleza_id' => 'required|exists:naturalezas,id',
            'servicio_id' => 'required|exists:servicios,id'
        ]);

        $categoria->update($request->all());

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroy(Categoria $categoria)
    {
        if ($categoria->tickets()->exists()) {
            return redirect()->back()
                ->with('error', 'No se puede eliminar la categoría porque tiene tickets asociados.');
        }

        $categoria->delete();

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoría eliminada correctamente.');
    }

    // Método para obtener categorías por servicio y naturaleza (para AJAX)
    public function getByServicioYNaturaleza(Request $request)
    {
        $request->validate([
            'servicio_id' => 'required|exists:servicios,id',
            'naturaleza_id' => 'required|exists:naturalezas,id'
        ]);

        $categorias = Categoria::where('servicio_id', $request->servicio_id)
            ->where('naturaleza_id', $request->naturaleza_id)
            ->where('estatus', 'activo')
            ->orderBy('nombre')
            ->get();

        return response()->json($categorias);
    }
}
