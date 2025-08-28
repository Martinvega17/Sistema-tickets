<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Models\Cedis;
use Illuminate\Support\Facades\Route;

// Redirección principal
Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas de autenticación
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);

    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/configuracion', [DashboardController::class, 'configuracion'])->name('configuracion');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// routes/web.php
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');

// Rutas protegidas (requieren autenticación)
Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Rutas para datos de CEDIS (accesibles sin autenticación para el formulario de registro)
Route::get('/get-cedis', function () {
    $cedis = Cedis::where('estatus', 'activo')
        ->orderBy('nombre')
        ->get(['id', 'nombre', 'region_id']);

    return response()->json($cedis);
});

// Ruta alternativa para obtener CEDIS por región
Route::get('/cedis-por-region/{regionId}', function ($regionId) {
    $cedis = Cedis::where('region_id', $regionId)
        ->where('estatus', 'activo')
        ->orderBy('nombre')
        ->get(['id', 'nombre']);

    return response()->json($cedis);
});
