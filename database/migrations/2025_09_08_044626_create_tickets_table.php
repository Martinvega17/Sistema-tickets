<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            // Información básica del ticket
            $table->string('titulo');
            $table->text('descripcion');
            $table->enum('estatus', ['Abierto', 'En progreso', 'En espera', 'Resuelto', 'Cerrado'])->default('Abierto');
            $table->enum('prioridad', ['Baja', 'Media', 'Alta', 'Crítica'])->default('Media');
            $table->enum('impacto', ['Baja', 'Media', 'Alta'])->default('Media');
            $table->enum('urgencia', ['Baja', 'Media', 'Alta'])->default('Media');
            $table->dateTime('fecha_recepcion');
            $table->enum('tipo_via', ['Correo electrónico', 'Teléfono', 'Presencial'])->default('Correo electrónico');
            $table->json('usuarios_notificar')->nullable();

            // Relaciones con usuarios y CEDIS
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('ingeniero_asignado_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('responsable_id')->nullable()->constrained('users');
            $table->foreignId('cedis_id')->constrained('cedis')->onDelete('cascade');

            // Relaciones con otras tablas
            $table->foreignId('area_id')->nullable()->constrained('areas');
            $table->foreignId('servicio_id')->nullable()->constrained('servicios');
            $table->foreignId('naturaleza_id')->nullable()->constrained('naturalezas');
            $table->foreignId('tipo_naturaleza_id')->nullable()->constrained('tipo_naturalezas');
            $table->foreignId('categoria_id')->nullable()->constrained('categorias');
            $table->foreignId('grupo_trabajo_id')->nullable()->constrained('grupo_trabajos');
            $table->foreignId('actividad_id')->nullable()->constrained('actividades');

            // Campos de tiempos
            $table->string('tiempo_respuesta')->nullable();
            $table->string('tiempo_solucion')->nullable();
            $table->string('tiempo_diagnostico')->nullable();
            $table->string('tiempo_reparacion')->nullable();

            $table->timestamps();

            // Índices para mejorar el rendimiento
            $table->index('estatus');
            $table->index('prioridad');
            $table->index('usuario_id');
            $table->index('ingeniero_asignado_id');
            $table->index('cedis_id');
            $table->index('fecha_recepcion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
