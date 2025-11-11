<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Docente;
use App\Models\Grupo;
use App\Models\Aula;
use App\Models\GestionAcademica;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
{
    // Obtener la gestión académica activa
    $gestionActiva = GestionAcademica::activa();

    if (!$gestionActiva) {
        return redirect()->back()->with('error', 'No hay una gestión académica activa.');
    }

    // Query base
    $query = Horario::with(['docente.usuario', 'grupo.materia', 'aula', 'gestion'])
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

    return view('horarios.index', compact('horarios', 'gestionActiva'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtener gestión activa
        $gestionActiva = GestionAcademica::activa();

        if (!$gestionActiva) {
            return redirect()->route('horarios.index')
                           ->with('error', 'No hay una gestión académica activa. Cree una primero.');
        }

        // Obtener recursos disponibles
        $docentes = Docente::with('usuario')->where('estado', 'Activo')->get();
        $grupos = Grupo::with('materia')->where('estado', 'Activo')->get();
        $aulas = Aula::where('estado', 'Disponible')->get();

        $dias = [
            1 => 'Lunes',
            2 => 'Martes',
            3 => 'Miércoles',
            4 => 'Jueves',
            5 => 'Viernes',
            6 => 'Sábado',
        ];

        return view('horarios.create', compact('docentes', 'grupos', 'aulas', 'dias', 'gestionActiva'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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

        // Obtener gestión activa
        $gestionActiva = GestionAcademica::activa();

        if (!$gestionActiva) {
            return back()->with('error', 'No hay una gestión académica activa.');
        }

        // Validar conflictos
        $conflictos = Horario::tieneConflicto(
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
        Horario::create([
            'docente_id' => $request->docente_id,
            'grupo_id' => $request->grupo_id,
            'aula_id' => $request->aula_id,
            'gestion_id' => $gestionActiva->id,
            'dia_semana' => $request->dia_semana,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'estado' => 'Activo',
        ]);

        return redirect()->route('horarios.index')
                       ->with('success', 'Horario creado exitosamente sin conflictos.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Horario $horario)
    {
        $horario->load(['docente.usuario', 'grupo.materia', 'aula', 'gestion']);
        return view('horarios.show', compact('horario'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Horario $horario)
    {
        $docentes = Docente::with('usuario')->where('estado', 'Activo')->get();
        $grupos = Grupo::with('materia')->where('estado', 'Activo')->get();
        $aulas = Aula::where('estado', 'Disponible')->get();

        $dias = [
            1 => 'Lunes',
            2 => 'Martes',
            3 => 'Miércoles',
            4 => 'Jueves',
            5 => 'Viernes',
            6 => 'Sábado',
        ];

        return view('horarios.edit', compact('horario', 'docentes', 'grupos', 'aulas', 'dias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Horario $horario)
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

        // Validar conflictos (excluyendo el horario actual)
        $conflictos = Horario::tieneConflicto(
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

        return redirect()->route('horarios.index')
                       ->with('success', 'Horario actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Horario $horario)
    {
        $horario->delete();

        return redirect()->route('horarios.index')
                       ->with('success', 'Horario eliminado exitosamente.');
    }

    /**
     * Validar conflictos en tiempo real (AJAX)
     */
    public function validarConflicto(Request $request)
    {
        $gestionActiva = GestionAcademica::activa();

        if (!$gestionActiva) {
            return response()->json(['error' => 'No hay gestión activa'], 400);
        }

        $conflictos = Horario::tieneConflicto(
            $request->docente_id,
            $request->aula_id,
            $request->grupo_id,
            $gestionActiva->id,
            $request->dia_semana,
            $request->hora_inicio,
            $request->hora_fin,
            $request->horario_id ?? null
        );

        if (empty($conflictos)) {
            return response()->json(['success' => true, 'message' => 'No hay conflictos']);
        }

        return response()->json(['success' => false, 'conflictos' => $conflictos]);
    }
}