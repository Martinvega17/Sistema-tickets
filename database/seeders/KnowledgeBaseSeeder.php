<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KnowledgeCategory;
use App\Models\KnowledgeArticle;
use App\Models\User;

class KnowledgeBaseSeeder extends Seeder
{
    public function run()
    {
        // Crear categorías
        $categories = [
            ['name' => 'Soporte Técnico', 'color' => 'blue', 'color_class' => 'bg-blue-100 text-blue-800'],
            ['name' => 'Software', 'color' => 'purple', 'color_class' => 'bg-purple-100 text-purple-800'],
            ['name' => 'Hardware', 'color' => 'green', 'color_class' => 'bg-green-100 text-green-800'],
            ['name' => 'Redes', 'color' => 'red', 'color_class' => 'bg-red-100 text-red-800'],
        ];

        foreach ($categories as $category) {
            KnowledgeCategory::create($category);
        }

        // Crear artículos de ejemplo
        $user = User::first();

        $articles = [
            [
                'title' => 'Cómo resetear la contraseña de Windows',
                'content' => 'Guía paso a paso para recuperar acceso a equipos con Windows cuando se ha olvidado la contraseña...',
                'summary' => 'Guía paso a paso para recuperar acceso a equipos con Windows',
                'category_id' => 1,
                'author_id' => $user->id,
                'views' => 245,
                'rating' => 4.45,
                'is_featured' => true
            ],
            // Agrega más artículos aquí...
        ];

        foreach ($articles as $article) {
            KnowledgeArticle::create($article);
        }
    }
}
