<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cedis extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'codigo',
        'direccion',
        'telefono',
        'responsable',
        'region_id',
        'estatus',
        'ingeniero_id'
    ];

    // Relación con Region
    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    // Relación con User (ingeniero)
    public function ingeniero()
    {
        return $this->belongsTo(User::class, 'ingeniero_id');
    }

    public function tickets()
    {
        return $this->hasMany(Tickets::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Scope para búsqueda
    public function scopeSearch($query, $search)
    {
        if (!$search) return $query;

        return $query->where('nombre', 'LIKE', "%{$search}%")
            ->orWhere('responsable', 'LIKE', "%{$search}%")
            ->orWhere('direccion', 'LIKE', "%{$search}%");
    }

    // Scope para filtrar por región
    public function scopeByRegion($query, $regionId)
    {
        if ($regionId) {
            return $query->where('region_id', $regionId);
        }
        return $query;
    }
}
