<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'numero_nomina',
        'nombre',
        'apellido',
        'email',
        'password',
        'telefono',
        'region_id',
        'cedis_id',
        'rol_id',
        'estatus',
        'genero',
        'extension',
        'zona_horaria',
        'empresa',
        'pais',
        'ubicacion',
        'ciudad',
        'estado',
        'departamento',
        'piso',
        'torre',
        'cargo',
        'centro_costos',
        'idioma'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'estatus' => 'integer',
    ];

    // Accessor para obtener el estatus como texto
    public function getEstatusTextoAttribute()
    {
        return $this->estatus == 1 ? 'activo' : 'inactivo';
    }

    // Relaciones
    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function cedis()
    {
        return $this->belongsTo(Cedis::class, 'cedis_id');
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rol_id');
    }

    public function tickets()
    {
        return $this->hasMany(Tickets::class, 'usuario_id');
    }

    public function ticketsAsignados()
    {
        return $this->hasMany(Tickets::class, 'ingeniero_asignado_id');
    }
    
}