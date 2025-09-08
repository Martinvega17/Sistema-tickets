<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    use HasFactory;

    protected $table = 'actividades'; // 👈 nombre real en tu DB

    protected $fillable = ['nombre', 'estatus'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
