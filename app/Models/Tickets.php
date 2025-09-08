<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';

    protected $fillable = [
        'titulo',
        'descripcion',
        'estatus',
        'usuario_id',
        'ingeniero_asignado_id',
        'cedis_id',
        'prioridad',
        'area_id',
        'servicio_id',
        'naturaleza_id',
        'tipo_naturaleza_id',
        'categoria_id',
        'grupo_trabajo_id',
        'impacto',
        'urgencia',
        'fecha_recepcion',
        'actividad_id',
        'responsable_id',
        'tipo_via',
        'usuarios_notificar',
        'tiempo_respuesta',
        'tiempo_solucion',
        'tiempo_diagnostico',
        'tiempo_reparacion'
    ];

    protected $casts = [
        'fecha_recepcion' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'usuarios_notificar' => 'array'
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

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'servicio_id');
    }

    public function naturaleza()
    {
        return $this->belongsTo(Naturaleza::class, 'naturaleza_id');
    }

    public function tipoNaturaleza()
    {
        return $this->belongsTo(TipoNaturaleza::class, 'tipo_naturaleza_id');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function grupoTrabajo()
    {
        return $this->belongsTo(GrupoTrabajo::class, 'grupo_trabajo_id');
    }

    public function actividad()
    {
        return $this->belongsTo(Actividad::class, 'actividad_id');
    }

    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }
}
