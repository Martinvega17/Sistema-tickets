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
        // Cargar las relaciones muchos a muchos
        $categorias = Categoria::with(['naturalezas', 'servicios'])->orderBy('nombre')->paginate(10);
        $naturalezas = Naturaleza::where('estatus', 'activo')->orderBy('nombre')->get();
        $servicios = Servicio::where('estatus', 'activo')->orderBy('nombre')->get();

        return view('admin.categorias.index', compact('categorias', 'naturalezas', 'servicios'));
    }

    public function edit(Categoria $categoria)
    {
        $naturalezas = Naturaleza::where('estatus', 'activo')->orderBy('nombre')->get();
        $servicios = Servicio::where('estatus', 'activo')->orderBy('nombre')->get();

        // Obtener IDs de naturalezas y servicios asignados
        $naturalezasSeleccionadas = $categoria->naturalezas->pluck('id')->toArray();
        $serviciosSeleccionados = $categoria->servicios->pluck('id')->toArray();

        return view('admin.categorias.edit', compact('categoria', 'naturalezas', 'servicios', 'naturalezasSeleccionadas', 'serviciosSeleccionados'));
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
            'nombre' => 'required|string|max:100', // ← QUITAR 'unique:categorias,nombre'
            'estatus' => 'required|in:activo,inactivo',
            'naturalezas' => 'required|array|min:1',
            'naturalezas.*' => 'exists:naturalezas,id',
            'servicios' => 'required|array|min:1',
            'servicios.*' => 'exists:servicios,id'
        ]);

        // Validación personalizada: Verificar combinaciones únicas
        foreach ($request->naturalezas as $naturalezaId) {
            foreach ($request->servicios as $servicioId) {
                $existeCombinacion = Categoria::where('nombre', $request->nombre)
                    ->whereHas('naturalezas', function ($query) use ($naturalezaId) {
                        $query->where('naturalezas.id', $naturalezaId);
                    })
                    ->whereHas('servicios', function ($query) use ($servicioId) {
                        $query->where('servicios.id', $servicioId);
                    })
                    ->exists();

                if ($existeCombinacion) {
                    $naturaleza = Naturaleza::find($naturalezaId);
                    $servicio = Servicio::find($servicioId);

                    return redirect()->back()
                        ->withInput()
                        ->with('error', "La categoría '{$request->nombre}' ya existe para la combinación: Naturaleza: {$naturaleza->nombre}, Servicio: {$servicio->nombre}");
                }
            }
        }

        $categoria = Categoria::create([
            'nombre' => $request->nombre,
            'estatus' => $request->estatus
        ]);

        // Asignar naturalezas y servicios
        $categoria->naturalezas()->sync($request->naturalezas);
        $categoria->servicios()->sync($request->servicios);

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoría creada correctamente.');
    }

    public function show(Categoria $categoria)
    {
        return view('admin.categorias.show', compact('categoria'));
    }



    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'nombre' => 'required|string|max:100', // ← QUITAR 'unique:categorias,nombre'
            'estatus' => 'required|in:activo,inactivo',
            'naturalezas' => 'required|array|min:1',
            'naturalezas.*' => 'exists:naturalezas,id',
            'servicios' => 'required|array|min:1',
            'servicios.*' => 'exists:servicios,id'
        ]);

        // Validación personalizada: Verificar combinaciones únicas (excluyendo la categoría actual)
        foreach ($request->naturalezas as $naturalezaId) {
            foreach ($request->servicios as $servicioId) {
                $existeCombinacion = Categoria::where('nombre', $request->nombre)
                    ->where('id', '!=', $categoria->id) // Excluir la categoría actual
                    ->whereHas('naturalezas', function ($query) use ($naturalezaId) {
                        $query->where('naturalezas.id', $naturalezaId);
                    })
                    ->whereHas('servicios', function ($query) use ($servicioId) {
                        $query->where('servicios.id', $servicioId);
                    })
                    ->exists();

                if ($existeCombinacion) {
                    $naturaleza = Naturaleza::find($naturalezaId);
                    $servicio = Servicio::find($servicioId);

                    return redirect()->back()
                        ->withInput()
                        ->with('error', "La categoría '{$request->nombre}' ya existe para la combinación: Naturaleza: {$naturaleza->nombre}, Servicio: {$servicio->nombre}");
                }
            }
        }

        $categoria->update([
            'nombre' => $request->nombre,
            'estatus' => $request->estatus
        ]);

        // Sincronizar naturalezas y servicios
        $categoria->naturalezas()->sync($request->naturalezas);
        $categoria->servicios()->sync($request->servicios);

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
