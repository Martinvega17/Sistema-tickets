<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'area_id', 'estatus'];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
