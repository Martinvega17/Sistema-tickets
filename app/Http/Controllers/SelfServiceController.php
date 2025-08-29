<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SelfServiceController extends Controller
{
    public function index()
    {
        // Datos de ejemplo para artículos destacados
        $articulosDestacados = [
            [
                'titulo' => 'Problemas con la impresora',
                'categoria' => 'Hardware'
            ],
            [
                'titulo' => 'Como levantar un ticket (EXCLUSIVO PARA C.R)',
                'categoria' => 'Procedimientos'
            ],
            [
                'titulo' => 'Iniciar Microsoft Authenticator',
                'categoria' => 'Software'
            ],
            [
                'titulo' => 'Solucionar problemas R12',
                'categoria' => 'Sistemas'
            ],
            [
                'titulo' => 'Iniciar DWH',
                'categoria' => 'Sistemas'
            ]
        ];

        return view('self-service', compact('articulosDestacados'));
    }
}
