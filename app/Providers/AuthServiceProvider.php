<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\KnowledgeArticle;
use App\Policies\KnowledgeArticlePolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        KnowledgeArticle::class => KnowledgeArticlePolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        // Definir gate adicional para verificar si el usuario puede ver botones de edición
        Gate::define('manage-knowledge', function (User $user) {
            return in_array($user->role_id, [1, 2, 3]);
        });
    }
}
