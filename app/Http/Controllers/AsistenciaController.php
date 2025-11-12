<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Horario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AsistenciaController extends Controller
{
    /**
     * Mostrar clases del día para el docente
     */
    public function index()
    {
        $usuario = Auth::user();
        
        // Obtener el docente asociado al usuario
        $docente = $usuario->docente;
        
        if (!$docente) {
            return redirect()->route('dashboard')
                ->with('error', 'No tienes un perfil de docente asociado.');
        }

        $hoy = Carbon::now();
        $dia_semana = $hoy->dayOfWeek == 0 ? 7 : $hoy->dayOfWeek; // Domingo = 7
        $fecha_hoy = $hoy->format('Y-m-d');

        // Obtener horarios del docente para hoy
        $horarios = Horario::with(['grupo.materia', 'aula', 'asistencias' => function($q) use ($fecha_hoy) {
                $q->whereDate('fecha', $fecha_hoy);
            }])
            ->where('docente_id', $docente->id)
            ->where('dia_semana', $dia_semana)
            ->where('estado', 'Activo')
            ->orderBy('hora_inicio')
            ->get();

        return view('asistencias.index', compact('horarios', 'fecha_hoy'));
    }

    /**
     * Registrar asistencia
     */
    public function store(Request $request)
    {
        $request->validate([
            'horario_id' => 'required|exists:horarios,id',
            'estado' => 'nullable|in:Presente,Ausente,Retraso',
            'observacion' => 'nullable|string|max:500',
        ]);

        $usuario = Auth::user();
        $docente = $usuario->docente;

        if (!$docente) {
            return back()->with('error', 'No tienes un perfil de docente asociado.');
        }

        $horario = Horario::findOrFail($request->horario_id);

        // Verificar que el horario pertenece al docente
        if ($horario->docente_id != $docente->id) {
            return back()->with('error', 'Este horario no te pertenece.');
        }

        $fecha_hoy = Carbon::now()->format('Y-m-d');

        // Verificar si ya registró asistencia hoy
        $asistencia_existente = Asistencia::where('horario_id', $horario->id)
            ->whereDate('fecha', $fecha_hoy)
            ->first();

        if ($asistencia_existente) {
            return back()->with('error', 'Ya registraste tu asistencia para esta clase hoy.');
        }

        // Verificar si está en el horario permitido (30 min antes hasta fin de clase)
        if (!Asistencia::puedeRegistrar($horario)) {
            return back()->with('error', 'No puedes registrar asistencia fuera del horario permitido (30 min antes del inicio hasta el fin de la clase).');
        }

        // Determinar estado automáticamente si no se especifica
        $hora_registro = Carbon::now();
        $estado = $request->estado ?? Asistencia::determinarEstado($horario, $hora_registro);

        try {
            Asistencia::create([
                'horario_id' => $horario->id,
                'fecha' => $fecha_hoy,
                'hora_registro' => $hora_registro->format('H:i:s'),
                'estado' => $estado,
                'observacion' => $request->observacion,
            ]);

            Log::info('Asistencia registrada', [
                'docente_id' => $docente->id,
                'horario_id' => $horario->id,
                'estado' => $estado,
            ]);

            return back()->with('success', 'Asistencia registrada exitosamente como: ' . $estado);

        } catch (\Exception $e) {
            Log::error('Error al registrar asistencia', [
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Error al registrar asistencia: ' . $e->getMessage());
        }
    }

    /**
     * Ver historial de asistencias del docente
     */
    public function historial()
    {
        $usuario = Auth::user();
        $docente = $usuario->docente;

        if (!$docente) {
            return redirect()->route('dashboard')
                ->with('error', 'No tienes un perfil de docente asociado.');
        }

        $asistencias = Asistencia::with(['horario.grupo.materia', 'horario.aula'])
            ->whereHas('horario', function($q) use ($docente) {
                $q->where('docente_id', $docente->id);
            })
            ->orderBy('fecha', 'desc')
            ->orderBy('hora_registro', 'desc')
            ->paginate(20);

        return view('asistencias.historial', compact('asistencias'));
    }
}