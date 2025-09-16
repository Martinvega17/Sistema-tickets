<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('genero')->nullable()->after('telefono');
            $table->string('extension')->nullable()->after('genero');
            $table->string('zona_horaria')->nullable()->after('extension');
            $table->string('empresa')->nullable()->after('zona_horaria');
            $table->string('pais')->nullable()->after('empresa');
            $table->string('ubicacion')->nullable()->after('pais');
            $table->string('ciudad')->nullable()->after('ubicacion');
            $table->string('estado')->nullable()->after('ciudad');
            $table->string('departamento')->nullable()->after('estado');
            $table->string('piso')->nullable()->after('departamento');
            $table->string('torre')->nullable()->after('piso');
            $table->string('cargo')->nullable()->after('torre');
            $table->string('centro_costos')->nullable()->after('cargo');
            $table->string('idioma')->default('ES')->after('centro_costos');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'genero',
                'extension',
                'zona_horaria',
                'empresa',
                'pais',
                'ubicacion',
                'ciudad',
                'estado',
                'departamento',
                'piso',
                'torre',
                'cargo',
                'centro_costos',
                'idioma'
            ]);
        });
    }
};
