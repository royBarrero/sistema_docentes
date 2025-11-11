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

    public function horarios(Request $request)
{
    // Reutilizar la misma lógica del HorarioController
    $gestionActiva = \App\Models\GestionAcademica::activa();

    if (!$gestionActiva) {
        return redirect()->back()->with('error', 'No hay una gestión académica activa.');
    }

    // Query base
    $query = \App\Models\Horario::with(['docente.usuario', 'grupo.materia', 'aula', 'gestion'])
                    ->where('gestion_id', $gestionActiva->id);

    // Aplicar filtros
    if ($request->filled('dia')) {
        $query->where('dia_semana', $request->dia);
    }

    if ($request->filled('docente')) {
        $query->whereHas('docente.usuario', function($q) use ($request) {
            $q->where('nombre_completo', 'LIKE', '%' . $request->docente . '%');
        });
    }

    if ($request->filled('aula')) {
        $query->whereHas('aula', function($q) use ($request) {
            $q->where('codigo', 'LIKE', '%' . $request->aula . '%');
        });
    }

    // Obtener horarios paginados
    $horarios = $query->orderBy('dia_semana')
                      ->orderBy('hora_inicio')
                      ->paginate(20);

    return view('coordinador.horarios.index', compact('horarios', 'gestionActiva'));
}

public function horariosCreate()
{
    $gestionActiva = \App\Models\GestionAcademica::activa();

    if (!$gestionActiva) {
        return redirect()->route('coordinador.horarios.index')
                       ->with('error', 'No hay una gestión académica activa. Solicite al administrador crear una.');
    }

    $docentes = \App\Models\Docente::with('usuario')->where('estado', 'Activo')->get();
    $grupos = \App\Models\Grupo::with('materia')->where('estado', 'Activo')->get();
    $aulas = \App\Models\Aula::where('estado', 'Disponible')->get();

    $dias = [
        1 => 'Lunes',
        2 => 'Martes',
        3 => 'Miércoles',
        4 => 'Jueves',
        5 => 'Viernes',
        6 => 'Sábado',
    ];

    return view('coordinador.horarios.create', compact('docentes', 'grupos', 'aulas', 'dias', 'gestionActiva'));
}

public function horariosStore(Request $request)
{
    $request->validate([
        'docente_id' => 'required|exists:docentes,id',
        'grupo_id' => 'required|exists:grupos,id',
        'aula_id' => 'required|exists:aulas,id',
        'dia_semana' => 'required|integer|between:1,7',
        'hora_inicio' => 'required|date_format:H:i',
        'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
    ], [
        'hora_fin.after' => 'La hora de fin debe ser posterior a la hora de inicio.',
    ]);

    $gestionActiva = \App\Models\GestionAcademica::activa();

    if (!$gestionActiva) {
        return back()->with('error', 'No hay una gestión académica activa.');
    }

    // Validar conflictos
    $conflictos = \App\Models\Horario::tieneConflicto(
        $request->docente_id,
        $request->aula_id,
        $request->grupo_id,
        $gestionActiva->id,
        $request->dia_semana,
        $request->hora_inicio,
        $request->hora_fin
    );

    if (!empty($conflictos)) {
        return back()
            ->with('error_conflictos', $conflictos)
            ->withInput();
    }

    // Crear horario
    \App\Models\Horario::create([
        'docente_id' => $request->docente_id,
        'grupo_id' => $request->grupo_id,
        'aula_id' => $request->aula_id,
        'gestion_id' => $gestionActiva->id,
        'dia_semana' => $request->dia_semana,
        'hora_inicio' => $request->hora_inicio,
        'hora_fin' => $request->hora_fin,
        'estado' => 'Activo',
    ]);

    return redirect()->route('coordinador.horarios.index')
                   ->with('success', 'Horario creado exitosamente sin conflictos.');
}

public function horariosEdit($id)
{
    $horario = \App\Models\Horario::findOrFail($id);
    
    $docentes = \App\Models\Docente::with('usuario')->where('estado', 'Activo')->get();
    $grupos = \App\Models\Grupo::with('materia')->where('estado', 'Activo')->get();
    $aulas = \App\Models\Aula::where('estado', 'Disponible')->get();

    $dias = [
        1 => 'Lunes',
        2 => 'Martes',
        3 => 'Miércoles',
        4 => 'Jueves',
        5 => 'Viernes',
        6 => 'Sábado',
    ];

    return view('coordinador.horarios.edit', compact('horario', 'docentes', 'grupos', 'aulas', 'dias'));
}

public function horariosUpdate(Request $request, $id)
{
    $horario = \App\Models\Horario::findOrFail($id);

    $request->validate([
        'docente_id' => 'required|exists:docentes,id',
        'grupo_id' => 'required|exists:grupos,id',
        'aula_id' => 'required|exists:aulas,id',
        'dia_semana' => 'required|integer|between:1,7',
        'hora_inicio' => 'required|date_format:H:i',
        'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
    ], [
        'hora_fin.after' => 'La hora de fin debe ser posterior a la hora de inicio.',
    ]);

    // Validar conflictos (excluyendo el horario actual)
    $conflictos = \App\Models\Horario::tieneConflicto(
        $request->docente_id,
        $request->aula_id,
        $request->grupo_id,
        $horario->gestion_id,
        $request->dia_semana,
        $request->hora_inicio,
        $request->hora_fin,
        $horario->id
    );

    if (!empty($conflictos)) {
        return back()
            ->with('error_conflictos', $conflictos)
            ->withInput();
    }

    // Actualizar horario
    $horario->update([
        'docente_id' => $request->docente_id,
        'grupo_id' => $request->grupo_id,
        'aula_id' => $request->aula_id,
        'dia_semana' => $request->dia_semana,
        'hora_inicio' => $request->hora_inicio,
        'hora_fin' => $request->hora_fin,
    ]);

    return redirect()->route('coordinador.horarios.index')
                   ->with('success', 'Horario actualizado exitosamente.');
}

public function horariosDestroy($id)
{
    $horario = \App\Models\Horario::findOrFail($id);
    $horario->delete();

    return redirect()->route('coordinador.horarios.index')
                   ->with('success', 'Horario eliminado exitosamente.');
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