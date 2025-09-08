<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupoTrabajo extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'estatus'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
