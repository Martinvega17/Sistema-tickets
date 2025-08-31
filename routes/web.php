<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SelfServiceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CedisController;

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

// Ruta para Self Service (accesible sin autenticación)
Route::get('/self-service', [SelfServiceController::class, 'index'])->name('self-service');

// Rutas de usuarios
Route::middleware(['auth'])->group(function () {
    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
    Route::put('/usuarios/{user}/estatus', [UserController::class, 'updateStatus'])->name('usuarios.estatus');
    Route::put('/usuarios/{user}/password', [UserController::class, 'resetPassword'])->name('usuarios.password');
    Route::put('/usuarios/{user}', [UserController::class, 'update'])->name('usuarios.update');
    Route::get('/user-json/{user}', [UserController::class, 'getUserJson'])->name('user.json');
});

// Rutas de usuarios
Route::middleware(['auth'])->group(function () {
    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/editar', [UserController::class, 'edit'])->name('usuarios.edit');
    Route::put('/usuarios/{user}', [UserController::class, 'update'])->name('usuarios.update');
});

// En routes/web.php, dentro del grupo de autenticación
Route::middleware(['auth', 'role:1,2,3'])->group(function () {
    // Rutas existentes...
    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/editar', [UserController::class, 'edit'])->name('usuarios.edit');

    // ✅ AGREGAR ESTA RUTA (FALTANTE)
    Route::get('/usuarios/{user}', [UserController::class, 'show'])->name('usuarios.show');

    // Rutas PUT existentes...
    Route::put('/usuarios/{user}/estatus', [UserController::class, 'updateStatus'])->name('usuarios.estatus');
    Route::put('/usuarios/{user}/password', [UserController::class, 'resetPassword'])->name('usuarios.password');
    Route::put('/usuarios/{user}', [UserController::class, 'update'])->name('usuarios.update');
});

// Rutas para gestión de CEDIS
Route::middleware(['auth', 'role:1,2'])->group(function () {
    Route::get('/cedis', [CedisController::class, 'index'])->name('cedis.index');
    Route::get('/cedis/data', [CedisController::class, 'getCedisData'])->name('cedis.data');

    // Rutas solo para administradores
    Route::middleware(['role:1'])->group(function () {
        Route::get('/cedis/create', [CedisController::class, 'create'])->name('cedis.create');
        Route::post('/cedis', [CedisController::class, 'store'])->name('cedis.store');
        Route::get('/cedis/{cedis}/edit', [CedisController::class, 'edit'])->name('cedis.edit');
        Route::put('/cedis/{cedis}', [CedisController::class, 'update'])->name('cedis.update');
        Route::put('/cedis/{cedis}/estatus', [CedisController::class, 'updateStatus'])->name('cedis.estatus');
        Route::delete('/cedis/{cedis}', [CedisController::class, 'destroy'])->name('cedis.destroy'); // ← NUEVA RUTA
        
    });

    // Ruta show para todos los usuarios con rol 1,2
    Route::get('/cedis/{cedis}', [CedisController::class, 'show'])->name('cedis.show');
});

// API para regiones
Route::get('/api/regiones', function () {
    return response()->json(
        \App\Models\Region::where('estatus', 'activo')->get(['id', 'nombre'])
    );
});
