<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Eliminar usuario existente si hay
        User::where('email', 'admin@gepp.com')->delete();

        // Crear nuevo usuario administrador
        User::create([
            'numero_nomina' => 'ADMIN001',
            'nombre' => 'Administrador',
            'apellido' => 'Sistema',
            'email' => 'admin@gepp.com',
            'password' => Hash::make('Admin123'),
            'telefono' => '1234567890',
            'region_id' => 1,
            'cedis_id' => 1,
            'rol_id' => 1,
            'estatus' => 1,
        ]);

        echo "Usuario administrador creado exitosamente\n";
    }
}
