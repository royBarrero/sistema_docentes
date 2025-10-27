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
        Schema::create('horarios', function (Blueprint $table) {
        $table->id();
        $table->foreignId('docente_id')->constrained('docentes')->cascadeOnUpdate();
        $table->foreignId('grupo_id')->constrained('grupos')->cascadeOnUpdate()->cascadeOnDelete();
        $table->foreignId('aula_id')->constrained('aulas')->cascadeOnUpdate();
        $table->foreignId('gestion_id')->constrained('gestiones_academicas')->cascadeOnUpdate();
        $table->tinyInteger('dia_semana');            // 1..7
        $table->time('hora_inicio');
        $table->time('hora_fin');
        $table->string('estado', 20)->default('Activo');
        $table->timestamps();

        $table->unique(['aula_id', 'gestion_id', 'dia_semana', 'hora_inicio', 'hora_fin']);
        $table->unique(['docente_id', 'gestion_id', 'dia_semana', 'hora_inicio', 'hora_fin']);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};
