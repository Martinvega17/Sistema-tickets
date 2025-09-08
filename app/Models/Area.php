<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'estatus'];

    public function servicios()
    {
        return $this->hasMany(Servicio::class);
    }

    public function tickets()
    {
        return $this->hasMany(Tickets::class);
    }
}
