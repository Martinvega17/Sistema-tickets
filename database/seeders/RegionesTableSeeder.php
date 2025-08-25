<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionesTableSeeder extends Seeder
{
    public function run()
    {
        $regiones = [
            ['nombre' => 'Centro', 'estatus' => 'activo'],
            ['nombre' => 'Metro', 'estatus' => 'activo'],
            ['nombre' => 'Norte', 'estatus' => 'activo'],
            ['nombre' => 'Occidente', 'estatus' => 'activo'],
            ['nombre' => 'Pacifico', 'estatus' => 'activo'],
            ['nombre' => 'Sur', 'estatus' => 'activo'],
            ['nombre' => 'Corporativo', 'estatus' => 'activo'],
            ['nombre' => 'CAT', 'estatus' => 'activo'],
            ['nombre' => 'Bajio', 'estatus' => 'activo'],
        ];

        foreach ($regiones as $region) {
            DB::table('regiones')->insert([
                'nombre' => $region['nombre'],
                'estatus' => $region['estatus'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
