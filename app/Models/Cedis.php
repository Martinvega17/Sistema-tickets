<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cedis extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
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
}
