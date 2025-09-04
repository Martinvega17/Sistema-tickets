<?php
// app/Models/KnowledgeAttachment.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KnowledgeAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id',
        'file_path',
        'file_name',
        'file_type',
        'file_size'
    ];

    public function article()
    {
        return $this->belongsTo(KnowledgeArticle::class, 'article_id');
    }
}
