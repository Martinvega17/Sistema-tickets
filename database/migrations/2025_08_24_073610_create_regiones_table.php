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
        Schema::create('regiones', function (Blueprint $table) {
            $table->unsignedInteger('id', true);
            $table->string('nombre', 50);
            $table->string('codigo', 10);
            $table->enum('estatus', ['activo', 'inactivo'])->default('activo');
            $table->timestamps();

            $table->unique('codigo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regiones');
    }
};
