<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Naturaleza extends Model
{
    use HasFactory;

    // Especificar el nombre de la tabla
    protected $table = 'naturalezas';

    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'nombre',
        'estatus'
    ];

    // Relación con categorías
    public function categorias()
    {
        return $this->hasMany(Categoria::class);
    }

    // Agregar esta relación con tickets
    public function tickets()
    {
        return $this->hasMany(Tickets::class);
    }
}
