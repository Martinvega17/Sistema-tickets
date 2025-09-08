<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tipo_naturalezas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->foreignId('naturaleza_id')->constrained()->onDelete('cascade');
            $table->string('estatus')->default('activo');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tipo_naturalezas');
    }
};
