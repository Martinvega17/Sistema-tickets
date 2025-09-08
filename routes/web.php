<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SelfServiceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CedisController;
use App\Http\Controllers\KnowledgeBaseController;
use App\Http\Controllers\TicketsController;
use App\Models\Cedis;
use App\Models\Region;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;


// Redirección principal
Route::redirect('/', '/login');

// Rutas de autenticación (solo para invitados)
Route::middleware('guest')->group(function () {
    Route::controller(LoginController::class)->group(function () {
        Route::get('login', 'showLoginForm')->name('login');
        Route::post('login', 'login');
    });

    Route::controller(RegisterController::class)->group(function () {
        Route::get('register', 'showRegistrationForm')->name('register');
        Route::post('register', 'register');
    });
});

// Rutas para datos públicos (sin autenticación)
Route::get('/get-cedis', function () {
    $cedis = Cedis::where('estatus', 'activo')
        ->orderBy('nombre')
        ->get(['id', 'nombre', 'region_id']);

    return response()->json($cedis);
});

Route::get('/cedis-por-region/{regionId}', function ($regionId) {
    $cedis = Cedis::where('region_id', $regionId)
        ->where('estatus', 'activo')
        ->orderBy('nombre')
        ->get(['id', 'nombre']);

    return response()->json($cedis);
});

Route::get('/api/regiones', function () {
    return response()->json(
        Region::where('estatus', 'activo')->get(['id', 'nombre'])
    );
});

// Ruta para Self Service (accesible sin autenticación)
Route::get('/self-service', [SelfServiceController::class, 'index'])->name('self-service');

// Rutas protegidas (requieren autenticación)
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/configuracion', [DashboardController::class, 'configuracion'])->name('configuracion');

    // Usuarios
    Route::controller(UserController::class)->group(function () {
        Route::get('/usuarios', 'index')->name('usuarios.index');
        Route::get('/usuarios/editar', 'edit')->name('usuarios.edit');
        Route::put('/usuarios/{user}', 'update')->name('usuarios.update');
        Route::get('/user-json/{user}', 'getUserJson')->name('user.json');
    });

    // Rutas de usuarios con restricción de roles
    Route::middleware('role:1,2,3')->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('/usuarios/{user}', 'show')->name('usuarios.show');
            Route::put('/usuarios/{user}/estatus', 'updateStatus')->name('usuarios.estatus');
            Route::put('/usuarios/{user}/password', 'resetPassword')->name('usuarios.password');
        });
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

    });


    // Base de Conocimiento - Todas las rutas en un resource
    Route::prefix('knowledgebase')->controller(KnowledgeBaseController::class)->group(function () {
        Route::get('/', 'index')->name('knowledgebase.index');
        Route::get('/create', 'create')->name('knowledgebase.create');
        Route::post('/', 'store')->name('knowledgebase.store');
        Route::get('/{id}', 'show')->name('knowledgebase.article');
        Route::get('/{id}/edit', 'edit')->name('knowledgebase.edit');
        Route::put('/{id}', 'update')->name('knowledgebase.update');
        Route::delete('/{id}', 'destroy')->name('knowledgebase.destroy');
        Route::get('/{id}/download', 'downloadPdf')->name('knowledgebase.download');
    });

    // Alias para compatibilidad
    Route::get('/knowledge/{id}', [KnowledgeBaseController::class, 'show'])
        ->name('knowledgebase.article.alias');
});


// Rutas para tickets
Route::resource('tickets', TicketsController::class);
Route::get('/api/servicios/{area}', [TicketsController::class, 'getServiciosByArea']);
Route::get('/api/tipos-naturaleza/{naturaleza}', [TicketsController::class, 'getTiposByNaturaleza']);



// ... otros controllers

// Grupo de rutas administrativas
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
