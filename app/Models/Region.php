<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    // Especifica el nombre correcto de la tabla
    protected $table = 'regiones'; // ← ESTA LÍNEA ES CLAVE

    protected $fillable = [
        'nombre',
        'estatus'
    ];

    // Relación con Cedis
    public function cedis()
    {
        return $this->hasMany(Cedis::class, 'region_id');
    }
}
