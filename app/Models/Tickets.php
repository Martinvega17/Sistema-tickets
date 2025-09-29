<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tickets extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_number', // Agregar este campo
        'titulo',
        'descripcion',
        'estatus',
        'prioridad',
        'impacto',
        'urgencia',
        'fecha_recepcion',
        'tipo_via',
        'usuarios_notificar',
        'usuario_id',
        'ingeniero_asignado_id',
        'responsable_id',
        'cedis_id',
        'area_id',
        'region_id',
        'servicio_id',
        'naturaleza_id',
        'categoria_id',
        'grupo_trabajo_id',
        'actividad_id',
        'tiempo_respuesta',
        'tiempo_solucion',
        'tiempo_diagnostico',
        'tiempo_reparacion',
        'observaciones'
    ];

    protected $casts = [
        'usuarios_notificar' => 'array',
        'fecha_recepcion' => 'datetime'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            // Generar número de ticket automáticamente si no existe
            if (!$ticket->ticket_number) {
                $ticket->ticket_number = self::generateTicketNumber();
            }

            // Asignar automáticamente a mesa de control (rol 2)
            $mesaControl = User::where('role_id', 2)->first();
            if ($mesaControl && !$ticket->responsable_id) {
                $ticket->responsable_id = $mesaControl->id;
            }
        });
    }

    // Relaciones principales
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function ingenieroAsignado()
    {
        return $this->belongsTo(User::class, 'ingeniero_asignado_id');
    }

    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function cedis()
    {
        return $this->belongsTo(Cedis::class, 'cedis_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'servicio_id');
    }

    public function naturaleza()
    {
        return $this->belongsTo(Naturaleza::class, 'naturaleza_id');
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

    // Relación con notas - CORREGIDA
   

    // Scopes para filtros comunes
    public function scopeAbiertos($query)
    {
        return $query->where('estatus', 'Abierto');
    }

    public function scopeEnProgreso($query)
    {
        return $query->where('estatus', 'En progreso');
    }

    public function scopeResueltos($query)
    {
        return $query->where('estatus', 'Resuelto');
    }

    public function scopeCerrados($query)
    {
        return $query->where('estatus', 'Cerrado');
    }

    public function scopePrioridadAlta($query)
    {
        return $query->where('prioridad', 'Alta')->orWhere('prioridad', 'Crítica');
    }

    // Métodos de ayuda
    public function getPrioridadColorAttribute()
    {
        return match ($this->prioridad) {
            'Baja' => 'green',
            'Media' => 'blue',
            'Alta' => 'orange',
            'Crítica' => 'red',
            default => 'gray'
        };
    }

    public function getEstatusColorAttribute()
    {
        return match ($this->estatus) {
            'Abierto' => 'red',
            'En progreso' => 'blue',
            'En espera' => 'yellow',
            'Resuelto' => 'green',
            'Cerrado' => 'gray',
            default => 'gray'
        };
    }

    public static function generateTicketNumber()
    {
        $lastTicket = self::orderBy('id', 'desc')->first();
        $nextNumber = $lastTicket ? intval($lastTicket->ticket_number) + 1 : 1;

        return str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }
}
