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
       Schema::create('asistencias', function (Blueprint $table) {
        $table->id();
        $table->foreignId('horario_id')->constrained('horarios')->cascadeOnUpdate()->cascadeOnDelete();
        $table->date('fecha');
        $table->string('estado', 20);                 // Presente|Ausente|Retraso
        $table->text('observacion')->nullable();
        $table->timestamps();

        $table->unique(['horario_id', 'fecha']);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
