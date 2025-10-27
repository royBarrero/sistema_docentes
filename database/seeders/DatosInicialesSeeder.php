<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatosInicialesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
    

         DB::table('roles')->insertOrIgnore([
            ['nombre' => 'Administrador', 'descripcion' => 'Control total del sistema'],
            ['nombre' => 'Coordinador', 'descripcion' => 'Gestiona horarios y asistencias'],
            ['nombre' => 'Docente', 'descripcion' => 'Registra asistencia y ve su carga'],
        ]);

        // ----- GESTIÓN ACADÉMICA -----
        DB::table('gestiones_academicas')->insertOrIgnore([
            [
                'nombre' => '2025-I',
                'fecha_inicio' => '2025-02-10',
                'fecha_fin' => '2025-07-05',
                'estado' => 'Activa',
            ],
        ]);

        // ----- USUARIO ADMIN -----
        DB::table('usuarios')->insertOrIgnore([
            [
                'nombre_completo' => 'Admin General',
                'email' => 'admin@ficct.edu.bo',
                'telefono' => '70000000',
                'password_hash' => Hash::make('admin123'), // Contraseña: admin123
                'estado' => 'Activo',
                'role_id' => 1, // Administrador
            ],
        ]);
    }
}
