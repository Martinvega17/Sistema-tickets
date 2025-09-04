<?php
// app/Models/KnowledgeArticle.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\KnowledgeCategory;
use App\Models\KnowledgeAttachment;

class KnowledgeArticle extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'category_id',
        'user_id',
        'author',
        'views',
        'rating'
    ];

    public function category()
    {
        return $this->belongsTo(KnowledgeCategory::class, 'category_id');
    }

    public function attachments()
    {
        return $this->hasMany(KnowledgeAttachment::class, 'article_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
