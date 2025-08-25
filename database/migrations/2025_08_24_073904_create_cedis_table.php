<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cedis', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED
            $table->foreignId('region_id')->constrained('regiones')->onDelete('restrict');
            $table->string('nombre', 100);
            $table->text('direccion')->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('responsable', 100)->nullable();
            $table->enum('estatus', ['activo', 'inactivo'])->default('activo');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cedis');
    }
};
