<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'estatus', 'naturaleza_id', 'servicio_id'];

    public function naturaleza()
    {
        return $this->belongsTo(Naturaleza::class);
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }

    public function tickets()
    {
        return $this->hasMany(Tickets::class);
    }
}
