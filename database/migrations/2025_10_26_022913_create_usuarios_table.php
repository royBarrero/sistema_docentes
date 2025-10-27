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
        Schema::create('usuarios', function (Blueprint $table) {
        $table->id();
        $table->string('nombre_completo', 120);
        $table->string('email', 120)->unique();
        $table->string('telefono', 30)->nullable();
        $table->text('password_hash');
        $table->string('estado', 20)->default('Activo'); // Activo|Inactivo|Suspendido
        $table->foreignId('role_id')->constrained('roles')->cascadeOnUpdate();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
