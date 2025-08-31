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

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function ingeniero()
    {
        return $this->belongsTo(User::class, 'ingeniero_id');
    }
}
