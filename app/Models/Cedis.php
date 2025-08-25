<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cedis extends Model
{
    protected $table = 'cedis';
    protected $fillable = ['nombre', 'region_id', 'estatus'];

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }
}
