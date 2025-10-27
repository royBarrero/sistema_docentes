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
        Schema::create('reportes', function (Blueprint $table) {
        $table->id();
        $table->string('tipo_reporte', 40);           // Horarios|Asistencia|Aulas|CargaHoraria
        $table->string('ruta_archivo', 400);
        $table->timestamp('fecha_generacion')->useCurrent();
        $table->foreignId('usuario_id')->constrained('usuarios')->cascadeOnUpdate();
        $table->foreignId('gestion_id')->constrained('gestiones_academicas')->cascadeOnUpdate();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportes');
    }
};
