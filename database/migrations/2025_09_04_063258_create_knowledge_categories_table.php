<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('knowledge_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('color'); // red, blue, green, etc.
            $table->string('color_class')->nullable(); // bg-red-100 text-red-800
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('knowledge_categories');
    }
};