<?php

use App\Models\Cedis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/cedis/{regionId}', function ($regionId) {
    $cedis = Cedis::where('region_id', $regionId)
        ->where('estatus', 'activo')
        ->get(['id', 'nombre']);

    return response()->json($cedis);
});
