<?php

namespace App\Providers;

use App\Models\KnowledgeArticle;
use App\Policies\KnowledgeArticlePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        KnowledgeArticle::class => KnowledgeArticlePolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
