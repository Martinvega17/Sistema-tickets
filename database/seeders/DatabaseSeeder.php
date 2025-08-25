<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
{
    $this->call([
        RegionSeeder::class,
        RolSeeder::class,
        CedisSeeder::class,
    ]);

    \App\Models\User::factory()->create([
        'numero_nomina' => 'EMP001',
        'nombre' => 'Test',
        'apellido' => 'User',
        'email' => 'test@example.com',
        'password' => bcrypt('password'),
        'region_id' => 1,   // ahora sí existe
        'cedis_id' => 1,    // ahora sí existe
        'rol_id' => 1,      // ahora sí existe
        'estatus' => 1,
    ]);
}

}
