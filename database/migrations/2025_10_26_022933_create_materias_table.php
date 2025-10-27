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
          Schema::create('materias', function (Blueprint $table) {
        $table->id();
        $table->string('codigo', 30);
        $table->string('nombre', 120);
        $table->string('nivel', 30)->nullable();
        $table->string('carrera', 120)->nullable();
        $table->foreignId('gestion_id')
              ->constrained('gestiones_academicas')
              ->cascadeOnUpdate();
        $table->string('estado', 20)->default('Activa');
        $table->timestamps();

        $table->unique(['codigo', 'gestion_id']);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materias');
    }
};
