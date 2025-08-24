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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('numero_nomina', 20);
            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->string('email', 150);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('telefono', 20)->nullable();
            $table->unsignedInteger('region_id')->nullable();
            $table->unsignedInteger('cedis_id')->nullable();
            $table->unsignedInteger('rol_id');
            $table->enum('estatus', ['activo', 'inactivo', 'suspendido'])->default('activo');
            $table->rememberToken();
            $table->timestamps();

            $table->unique('email');
            $table->unique('numero_nomina');

            $table->foreign('region_id')
                ->references('id')
                ->on('regiones')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('cedis_id')
                ->references('id')
                ->on('cedis')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('rol_id')
                ->references('id')
                ->on('roles')
                ->onDelete('restrict')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
