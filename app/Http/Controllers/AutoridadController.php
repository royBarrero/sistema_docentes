<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Docente;
use App\Models\Horario;
use App\Models\Asistencia;

class AutoridadController extends Controller
{
    // Consultas de solo lectura
    public function docentes()
    {
        $docentes = Docente::with('usuario')->get();
        return view('autoridad.docentes', compact('docentes'));
    }

    public function horarios()
    {
        $horarios = Horario::with(['docente', 'grupo.materia', 'aula'])->get();
        return view('autoridad.horarios', compact('horarios'));
    }

    public function asistencias()
    {
        $asistencias = Asistencia::with(['horario.docente', 'horario.grupo.materia'])->get();
        return view('autoridad.asistencias', compact('asistencias'));
    }

    public function faltas()
    {
        $faltas = Asistencia::where('estado', 'Ausente')
                            ->with(['horario.docente', 'horario.grupo.materia'])
                            ->get();
        return view('autoridad.faltas', compact('faltas'));
    }

    public function reportes()
    {
        return view('autoridad.reportes');
    }
}