<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\KnowledgeCategory;

class KnowledgeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'General',
                'color' => 'gray',
            ],
            [
                'name' => 'Tecnología',
                'color' => 'blue',
            ],
            [
                'name' => 'Recursos Humanos',
                'color' => 'green',
            ],
            [
                'name' => 'Finanzas',
                'color' => 'purple',
            ],
            [
                'name' => 'Marketing',
                'color' => 'red',
            ],
            [
                'name' => 'Operaciones',
                'color' => 'yellow',
            ],
            [
                'name' => 'Legal',
                'color' => 'purple',
            ],
            [
                'name' => 'Clientes',
                'color' => 'blue',
            ],
            [
                'name' => 'Procedimientos',
                'color' => 'green',
            ],
            [
                'name' => 'FAQ',
                'color' => 'red',
            ],
        ];

        foreach ($categories as $category) {
            KnowledgeCategory::create($category);
        }
    }
}