<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'color', 'color_class'];

    public function articles()
    {
        return $this->hasMany(KnowledgeArticle::class);
    }

    // Accesor para obtener la clase de color
    public function getColorClassAttribute()
    {
        $colorClasses = [
            'red' => 'bg-red-100 text-red-800',
            'blue' => 'bg-blue-100 text-blue-800',
            'green' => 'bg-green-100 text-green-800',
            'purple' => 'bg-purple-100 text-purple-800',
            'yellow' => 'bg-yellow-100 text-yellow-800',
        ];

        return $colorClasses[$this->color] ?? 'bg-gray-100 text-gray-800';
    }
}
