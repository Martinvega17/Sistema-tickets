<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\KnowledgeArticle;
use App\Models\KnowledgeCategory;
use Illuminate\Support\Facades\Auth;
use App\Models\KnowledgeBase;
use Illuminate\Support\Facades\View;

class KnowledgeBaseController extends Controller
{
    // ✅ AÑADE ESTE MÉTODO QUE FALTA

    public function index(Request $request)
    {
        // Filtro de categoría
        $query = KnowledgeArticle::with('category');

        if ($request->has('category_id') && !empty($request->category_id)) {
            $query->where('category_id', $request->category_id);
        }

        // Artículos (para la tabla principal)
        $articles = $query->latest()->get();

        // Artículos destacados (últimos 3 con contenido)
        $featuredArticles = KnowledgeArticle::with('category')
            ->whereNotNull('content')
            ->where('content', '!=', '')
            ->when($request->category_id, function ($q) use ($request) {
                $q->where('category_id', $request->category_id);
            })
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Categorías activas
        $categories = KnowledgeCategory::where('is_active', true)->get();

        return view('knowledgebase.index', compact('articles', 'featuredArticles', 'categories'));
    }


    public function show($id)
    {
        $article = KnowledgeArticle::with(['category', 'author'])->findOrFail($id);
        $article->increment('views');
        $relatedArticles = $article->relatedArticles(2);

        $categories = KnowledgeCategory::where('is_active', true)->get(); // <= si tu vista/partial lo usa
        return view('knowledgebase.article', compact('article', 'relatedArticles', 'categories'));
    }


    public function edit($id)
    {
        $article = KnowledgeArticle::findOrFail($id);



        $categories = KnowledgeCategory::all(); // Añade esto si necesitas las categorías
        return view('Knowledgebase.edit', compact('article', 'categories'));
    }

    public function destroy($id)
    {
        $article = KnowledgeArticle::findOrFail($id);
        $this->authorize('delete', $article);

        if ($article->pdf_path) {
            Storage::delete($article->pdf_path);
        }

        $article->delete();

        return redirect()->route('knowledgebase.index')
            ->with('success', 'Artículo eliminado correctamente.');
    }

    public function downloadPdf($id)
    {
        $article = KnowledgeArticle::findOrFail($id);

        if (!$article->pdf_path || !Storage::exists($article->pdf_path)) {
            abort(404);
        }

        return Storage::download($article->pdf_path, $article->title . '.pdf');
    }

    public function create()
    {
        $categories = KnowledgeCategory::where('is_active', true)->get();
        return view('knowledgebase.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:knowledge_categories,id',
            'author' => 'required|string|max:255',
            'content' => 'required|string',
            'pdf_path' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        // Agregar el user_id del usuario autenticado
        $validated['user_id'] = Auth::id();

        // Procesar el archivo PDF si se subió
        if ($request->hasFile('pdf_path')) {
            $path = $request->file('pdf_path')->store('pdfs', 'public');
            $validated['pdf_path'] = $path;
        }

        KnowledgeArticle::create($validated);

        return redirect()->route('knowledgebase.index')
            ->with('success', 'Artículo creado exitosamente');
    }

    public function update(Request $request, $id)
    {
        $article = KnowledgeArticle::findOrFail($id);

        // Verificar autorización
        if (!$this->authorize('update', $article)) {
            abort(403, 'No tienes permisos para editar este artículo');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:knowledge_categories,id',
            'content' => 'required|string',
        ]);

        $article->update([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'content' => $request->content,
        ]);

        return redirect()->route('knowledgebase.index')
            ->with('success', 'Artículo actualizado exitosamente');
    }
}
