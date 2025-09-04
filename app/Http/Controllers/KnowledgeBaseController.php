<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\KnowledgeArticle;
use App\Models\KnowledgeCategory;


class KnowledgeBaseController extends Controller
{
    public function show($id)
    {
        $article = KnowledgeArticle::with(['category', 'author'])->findOrFail($id);

        // Incrementar contador de visitas
        $article->increment('views');

        // Obtener artículos relacionados
        $relatedArticles = $article->relatedArticles(2);

        return view('knowledgebase.article', compact('article', 'relatedArticles'));
    }

    public function edit($id)
    {
        $article = KnowledgeArticle::findOrFail($id);
        $this->authorize('update', $article); // Usar políticas si las tienes

        return view('knowledgebase.edit', compact('article'));
    }

    public function destroy($id)
    {
        $article = KnowledgeArticle::findOrFail($id);
        $this->authorize('delete', $article); // Usar políticas si las tienes

        // Eliminar archivo PDF si existe
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
}
