<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Cedis;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users/{user}', [UserController::class, 'show']);
});

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// Ruta para obtener CEDIS por región
Route::get('/cedis', function (Request $request) {
    $regionId = $request->query('region_id');

    if (!$regionId) {
        return response()->json([]);
    }

    $cedis = Cedis::where('region_id', $regionId)
        ->where('estatus', 'activo')
        ->orderBy('nombre')
        ->get(['id', 'nombre', 'region_id']);

    return response()->json($cedis);
});
