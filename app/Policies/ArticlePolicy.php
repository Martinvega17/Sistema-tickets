<?php

namespace App\Policies;

use App\Models\KnowledgeArticle;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class KnowledgeArticlePolicy
{
    /**
     * Determine whether the user can update the article.
     */
    public function update(User $user, KnowledgeArticle $article): bool
    {
        // Solo administradores (1), supervisores (2) y coordinadores (3) pueden editar
        return in_array($user->role_id, [1, 2, 3]);
    }

    /**
     * Determine whether the user can delete the article.
     */
    public function delete(User $user, KnowledgeArticle $article): bool
    {
        // Solo administradores (1), supervisores (2) y coordinadores (3) pueden eliminar
        return in_array($user->role_id, [1, 2, 3]);
    }

    /**
     * Determine whether the user can create articles.
     */
    public function create(User $user): bool
    {
        // Solo administradores (1), supervisores (2) y coordinadores (3) pueden crear
        return in_array($user->role_id, [1, 2, 3]);
    }
}
