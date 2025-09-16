<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\SelfServiceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CedisController;
use App\Http\Controllers\KnowledgeBaseController;
use App\Http\Controllers\TicketsController;
use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\ServicioController;
use App\Http\Controllers\Admin\NaturalezaController;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\ProfileController;
use App\Models\Cedis;
use App\Models\Region;
use Illuminate\Support\Facades\Route;


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



    // Rutas para gestión de usuarios
    Route::middleware(['auth', 'role:1,2'])->group(function () {
        Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
        Route::get('/usuarios/create', [UserController::class, 'create'])->name('usuarios.modals.create'); // ← NUEVA RUTA
        Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store'); // ← NUEVA RUTA
        Route::get('/usuarios/{user}/edit', [UserController::class, 'edit'])->name('usuarios.edit');
        Route::put('/usuarios/{user}', [UserController::class, 'update'])->name('usuarios.update');
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
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Rutas solo para administradores
        Route::middleware(['role:1,2'])->group(function () {
            Route::get('/cedis/create', [CedisController::class, 'create'])->name('cedis.create');
            Route::post('/cedis', [CedisController::class, 'store'])->name('cedis.store');
            Route::get('/cedis/{cedis}/edit', [CedisController::class, 'edit'])->name('cedis.edit');
            Route::put('/cedis/{cedis}', [CedisController::class, 'update'])->name('cedis.update');
            Route::put('/cedis/{cedis}/estatus', [CedisController::class, 'updateStatus'])->name('cedis.estatus');
            Route::delete('/cedis/{cedis}', [CedisController::class, 'destroy'])->name('cedis.destroy'); // ← NUEVA RUTA
            // routes/web.php
            Route::put('cedis/{cedis}/toggle-status', [CedisController::class, 'toggleStatus'])
                ->name('cedis.toggle-status');
        });
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


Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('areas', AreaController::class);
    Route::resource('servicios', ServicioController::class);
    Route::resource('naturaleza', NaturalezaController::class);
    Route::resource('categorias', CategoriaController::class);
});

//Rutas para usarios 
Route::middleware(['auth', 'role:3,4,5'])->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
});

// Rutas para perfil de usuario
Route::prefix('profile')->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/personal', [ProfileController::class, 'personal'])->name('profile.personal');
    Route::get('/company', [ProfileController::class, 'company'])->name('profile.company');
    Route::get('/password', [ProfileController::class, 'password'])->name('profile.password');

    Route::post('/personal', [ProfileController::class, 'updatePersonalData'])->name('profile.updatePersonal');
    Route::post('/company', [ProfileController::class, 'updateCompanyData'])->name('profile.updateCompany');
    Route::post('/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::post('/language', [ProfileController::class, 'updateLanguage'])->name('profile.updateLanguage');
});
