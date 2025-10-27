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
        Schema::create('gestiones_academicas', function (Blueprint $table) {
        $table->id();
        $table->string('nombre', 50)->unique();   // p.ej. "2025-I"
        $table->date('fecha_inicio');
        $table->date('fecha_fin');
        $table->string('estado', 20);             // Activa|Planificada|Cerrada
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gestion_academicas');
    }
};
