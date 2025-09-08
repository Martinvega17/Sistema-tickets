<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Naturaleza extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'estatus'];

    public function tipos()
    {
        return $this->hasMany(TipoNaturaleza::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
