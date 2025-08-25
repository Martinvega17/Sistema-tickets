<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // 👈 importar
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable; // 👈 usarlo aquí

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
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

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
        return $this->hasMany(Ticket::class, 'usuario_id');
    }

    public function ticketsAsignados()
    {
        return $this->hasMany(Ticket::class, 'ingeniero_asignado_id');
    }
}
