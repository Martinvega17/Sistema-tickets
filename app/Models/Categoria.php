<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    // Solo estos campos, quitamos naturaleza_id y servicio_id
    protected $fillable = ['nombre', 'estatus'];

    // Relación muchos a muchos con naturalezas
    public function naturalezas()
    {
        return $this->belongsToMany(Naturaleza::class, 'categoria_naturaleza');
    }

    // Relación muchos a muchos con servicios
    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'categoria_servicio');
    }

    public function tickets()
    {
        return $this->hasMany(Tickets::class);
    }
}
