<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard'); // Asegúrate de que esta vista extienda de layouts.app
    }
    public function configuracion()
    {
        return view('configuracion'); // Crea esta vista si es necesario
    }
}
