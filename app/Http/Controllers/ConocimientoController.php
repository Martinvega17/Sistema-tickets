<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConocimientoController extends Controller
{
    public function index()
    {
        // Aquí puedes agregar lógica para obtener artículos de conocimiento si es necesario
        return view('conocimiento');
    }
}
