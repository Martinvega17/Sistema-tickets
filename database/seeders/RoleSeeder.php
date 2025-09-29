<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'id' => 1,
                'nombre' => 'Administrador',
                'descripcion' => 'Acceso completo al sistema',
                'permisos' => json_encode(['*']), // Acceso total
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'nombre' => 'Mesa de control',
                'descripcion' => 'Supervisa múltiples CEDIS y regiones',
                'permisos' => json_encode([
                    'tickets.ver', 'tickets.crear', 'tickets.editar', 'tickets.asignar',
                    'usuarios.ver', 'reportes.ver', 'dashboard.ver'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'nombre' => 'Coordinador',
                'descripcion' => 'Coordina actividades en un CEDIS',
                'permisos' => json_encode([
                    'tickets.ver', 'tickets.crear', 'tickets.editar.propios', 'tickets.asignar',
                    'dashboard.ver'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'nombre' => 'Soporte',
                'descripcion' => 'Atiende tickets asignados',
                'permisos' => json_encode([
                    'tickets.ver.asignados', 'tickets.atender', 'tickets.actualizar.estado',
                    'dashboard.ver'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'nombre' => 'Usuario',
                'descripcion' => 'Usuario regular del sistema',
                'permisos' => json_encode([
                    'tickets.ver.propios', 'tickets.crear.propios', 'dashboard.ver'
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(
                ['id' => $role['id']],
                $role
            );
        }

        $this->command->info('Roles creados: Administrador, Supervisor, Coordinador, Soporte, Usuario');
    }
}