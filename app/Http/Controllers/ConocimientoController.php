<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KnowledgeArticle;

class ConocimientoController extends Controller
{
    public function index()
    {
        $articles = KnowledgeArticle::with('category')->orderBy('created_at', 'desc')->get();
        return view('conocimiento', compact('articles'));
    }
}
