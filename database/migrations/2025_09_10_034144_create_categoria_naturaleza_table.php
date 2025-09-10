<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('categoria_naturaleza', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')->constrained()->onDelete('cascade');
            $table->foreignId('naturaleza_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['categoria_id', 'naturaleza_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('categoria_naturaleza');
    }
};
