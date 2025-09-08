<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoNaturaleza extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'naturaleza_id', 'estatus'];

    public function naturaleza()
    {
        return $this->belongsTo(Naturaleza::class);
    }

    public function tickets()
    {
        return $this->hasMany(Tickets::class);
    }
}
