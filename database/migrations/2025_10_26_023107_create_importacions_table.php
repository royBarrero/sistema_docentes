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
       Schema::create('importaciones', function (Blueprint $table) {
        $table->id();
        $table->string('archivo_nombre', 255);
        $table->timestamp('fecha_carga')->useCurrent();
        $table->integer('cantidad_registros')->default(0);
        $table->foreignId('usuario_admin_id')->nullable()
              ->constrained('usuarios')
              ->cascadeOnUpdate();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('importacions');
    }
};
