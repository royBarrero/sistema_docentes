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
        Schema::table('docentes', function (Blueprint $table) {
        $table->string('nombre', 100)->nullable()->after('usuario_id');
        $table->string('apellidos', 100)->nullable()->after('nombre');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
           Schema::table('docentes', function (Blueprint $table) {
        $table->dropColumn(['nombre', 'apellidos']);
    });
    }
};
