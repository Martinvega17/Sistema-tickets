<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id',
        'original_name',
        'path',
        'size',
        'mime_type',
        'type' // 'pdf', 'image', 'document', etc.
    ];

    public function article()
    {
        return $this->belongsTo(KnowledgeArticle::class, 'article_id');
    }

    // Scope para PDFs
    public function scopePdfs($query)
    {
        return $query->where('type', 'pdf')
            ->orWhere('mime_type', 'application/pdf');
    }

    // Método para obtener solo el PDF principal
    public function isPdf()
    {
        return $this->type === 'pdf' || $this->mime_type === 'application/pdf';
    }
}
