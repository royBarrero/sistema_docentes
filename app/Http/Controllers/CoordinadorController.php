<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Docente;
use App\Models\Materia;
use App\Models\Grupo;
use App\Models\Aula;

class CoordinadorController extends Controller
{
    // Gestión Académica
    public function docentes()
    {
        return view('coordinador.docentes');
    }

    public function materias()
    {
        return view('coordinador.materias');
    }

    public function grupos()
    {
        return view('coordinador.grupos');
    }

    public function aulas()
    {
        return view('coordinador.aulas');
    }

    // Asignación Académica
    public function asignaciones()
    {
        return view('coordinador.asignaciones');
    }

    public function horarios()
    {
        return view('coordinador.horarios');
    }

    // Control de Asistencia
    public function asistencia()
    {
        return view('coordinador.asistencia');
    }

    // Reportes
    public function reportes()
    {
        return view('coordinador.reportes');
    }
}