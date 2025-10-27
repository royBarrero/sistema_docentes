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
        Schema::create('aulas', function (Blueprint $table) {
        $table->id();
        $table->string('codigo', 50)->unique();       // "A-201"
        $table->integer('capacidad');
        $table->string('ubicacion', 120)->nullable();
        $table->string('tipo', 50)->nullable();       // Teórica|Lab|Auditorio
        $table->string('estado', 20)->default('Disponible'); // Disponible|Mantenimiento|Cerrada
        $table->string('telefono', 30)->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aulas');
    }
};
