<?php
// database/migrations/xxxx_xx_xx_create_tickets_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            // Número de ticket único
            $table->string('ticket_number', 10)->unique()->nullable();

            // Información básica del ticket
            $table->string('titulo');
            $table->text('descripcion');

            // Estados y prioridades
            $table->enum('estatus', ['Abierto', 'En progreso', 'En espera', 'Resuelto', 'Cerrado'])->default('Abierto');
            $table->enum('status', ['Abierto', 'En progreso', 'Suspendido', 'Resuelto', 'Cerrado'])->default('Abierto');
            $table->enum('prioridad', ['Baja', 'Media', 'Alta', 'Crítica'])->default('Media');
            $table->integer('priority')->default(3);
            $table->enum('impacto', ['Baja', 'Media', 'Alta'])->default('Media');
            $table->enum('urgencia', ['Baja', 'Media', 'Alta'])->default('Media');

            // Fechas importantes
            $table->datetime('fecha_recepcion');
            $table->timestamp('fecha_suspension')->nullable();
            $table->timestamp('fecha_resolucion')->nullable();
            $table->timestamp('fecha_cierre')->nullable();

            // Información de contacto y medio
            $table->enum('medio_atencion', ['Correo electrónico', 'Teléfono', 'En sitio', 'Chat', 'Control Remoto', 'Otros'])->default('En sitio');

            // Usuarios para notificar
            $table->json('usuarios_notificar')->nullable();

            // Asignaciones
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('ingeniero_asignado_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('responsable_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');

            // Relaciones con otras tablas
            $table->foreignId('cedis_id')->constrained()->onDelete('cascade');
            $table->foreignId('area_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('region_id')
                ->nullable()
                ->constrained('regiones')
                ->nullOnDelete();
            $table->foreignId('servicio_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('naturaleza_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('categoria_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('grupo_trabajo_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('actividades_id')->nullable()->constrained()->onDelete('set null');

            // Tiempos de servicio
            $table->string('tiempo_respuesta')->nullable();
            $table->string('tiempo_solucion')->nullable();
            $table->string('tiempo_diagnostico')->nullable();
            $table->string('tiempo_reparacion')->nullable();

            // Información adicional
            $table->text('observaciones')->nullable();
            $table->enum('tipo_cierre', [
                'Cierre automatico',
                'Cierre unificado',
                'Solucion final',
                'Solucion primer contacto',
                'Solucionado por el usuario',
                'Soluciondo por el Ingenierio de mesa de servicio',
                'Soluciondo por Ingeniero fijo',
                'Soluciondo por Ingenierio flotante'
            ])->nullable();
            $table->string('ambiente')->nullable();
            $table->integer('porcentaje_avance')->default(0);
            $table->text('comentario_cierre')->nullable();

            // Timestamps
            $table->timestamps();

            // Índices para mejor performance
            $table->index('estatus');
            $table->index('prioridad');
            $table->index('fecha_recepcion');
            $table->index('ticket_number');
            $table->index(['status', 'prioridad']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
