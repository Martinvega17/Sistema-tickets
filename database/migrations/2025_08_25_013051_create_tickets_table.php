<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED
            $table->string('titulo');
            $table->text('descripcion');
            $table->string('estatus'); // abierto, cerrado, etc.
            $table->foreignId('usuario_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('ingeniero_asignado_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('cedis_id')->constrained('cedis')->cascadeOnDelete();
            $table->string('prioridad')->default('normal'); // alta, normal, baja
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
