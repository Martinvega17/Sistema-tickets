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
                'name' => 'Hardware',
                'color' => 'blue',
            ],
            [
                'name' => 'Software',
                'color' => 'green',
            ],
            [
                'name' => 'Ciberseguridad',
                'color' => 'purple',
            ],
            [
                'name' => 'Soporte',
                'color' => 'red',
            ],
        ];

        foreach ($categories as $category) {
            KnowledgeCategory::create($category);
        }
    }
}
