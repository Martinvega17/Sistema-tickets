<?php

namespace App\Policies;

use App\Models\KnowledgeArticle;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class KnowledgeArticlePolicy
{
    public function update(User $user, KnowledgeArticle $article)
    {
        return $user->id === $article->user_id
            ? Response::allow()
            : Response::deny('No tienes permisos para editar este artículo');
    }

    public function delete(User $user, KnowledgeArticle $article)
    {
        return $user->id === $article->user_id
            ? Response::allow()
            : Response::deny('No tienes permisos para eliminar este artículo');
    }
}
