<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;

    protected $table = 'roles'; // Nombre de la tabla

    protected $fillable = [
        'nombre',
        'descripcion',
        'permisos',
    ];

    protected $casts = [
        'permisos' => 'array', // Si los permisos se almacenan como un JSON
    ];

    // Relaciones
    public function users()
    {
        return $this->hasMany(User::class, 'rol_id');
    }
}
