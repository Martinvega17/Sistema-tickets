<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KnowledgeArticle extends Model
{
    use HasFactory;


    protected $fillable = [
        'title',
        'content',
        'summary',
        'category_id',
        'author_id',
        'views',
        'rating',
        'pdf_path' // Añadir este campo para el PDF
    ];

    protected $casts = [
        'rating' => 'decimal:2'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    // Método para verificar si tiene PDF
    public function hasPdf()
    {
        return !empty($this->pdf_path);
    }

    // Método para obtener artículos relacionados
    public function relatedArticles($limit = 2)
    {
        return self::where('category_id', $this->category_id)
            ->where('id', '!=', $this->id)
            ->orderBy('views', 'desc')
            ->limit($limit)
            ->get();
    }
}
