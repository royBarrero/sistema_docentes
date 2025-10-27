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
       Schema::create('docentes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('usuario_id')->unique()
              ->constrained('usuarios')
              ->cascadeOnUpdate()
              ->cascadeOnDelete();
        $table->string('ci', 40);
        $table->string('titulo', 120)->nullable();
        $table->string('especialidad', 120)->nullable();
        $table->string('correo_institucional', 120)->nullable();
        $table->string('telefono', 30)->nullable();
        $table->string('estado', 20)->default('Activo');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('docentes');
    }
};
