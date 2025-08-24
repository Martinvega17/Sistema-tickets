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
        Schema::create('cedis', function (Blueprint $table) {
            $table->unsignedInteger('id', true);
            $table->unsignedInteger('region_id');
            $table->string('nombre', 100);
            $table->text('direccion')->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('responsable', 100)->nullable();
            $table->enum('estatus', ['activo', 'inactivo'])->default('activo');
            $table->timestamps();

            $table->foreign('region_id')
                ->references('id')
                ->on('regiones')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cedis');
    }
};
