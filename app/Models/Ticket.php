<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets'; // Nombre de la tabla

    protected $fillable = [
        'titulo',
        'descripcion',
        'estatus',
        'usuario_id',
        'ingeniero_asignado_id',
        'cedis_id',
        'prioridad',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relaciones
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function ingenieroAsignado()
    {
        return $this->belongsTo(User::class, 'ingeniero_asignado_id');
    }

    public function cedis()
    {
        return $this->belongsTo(Cedis::class, 'cedis_id');
    }
}
