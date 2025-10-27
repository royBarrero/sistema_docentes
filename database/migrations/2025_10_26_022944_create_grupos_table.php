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
         Schema::create('grupos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('materia_id')
              ->constrained('materias')
              ->cascadeOnUpdate()
              ->cascadeOnDelete();
        $table->string('nombre', 50);                 // "A", "B", "1", "2", etc.
        $table->string('estado', 20)->default('Activo');
        $table->timestamps();

        $table->unique(['materia_id', 'nombre']);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grupos');
    }
};
