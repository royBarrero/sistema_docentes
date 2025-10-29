<?php

namespace App\Http\Controllers\Docente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Docente;
use App\Models\Horario;
use App\Models\Asistencia;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DocenteDashboardController extends Controller
{
    /**
     * Obtener el docente autenticado
     */
    private function getDocenteActual()
    {
        if (!Auth::check()) {
            return null;
        }
        
        return Docente::where('usuario_id', Auth::id())->first();
    }

    /**
     * Mostrar el horario del docente
     */
    public function miHorario()
    {
        $docente = $this->getDocenteActual();
        
        if (!$docente) {
            return redirect()->route('dashboard')
                ->with('error', 'No se encontró información del docente.');
        }

        // Obtener horarios de la gestión activa
        $horarios = Horario::where('docente_id', $docente->id)
            ->where('estado', 'Activo')
            ->with(['grupo.materia', 'aula', 'gestion'])
            ->whereHas('gestion', function($query) {
                $query->where('estado', 'Activo');
            })
            ->orderBy('dia_semana')
            ->orderBy('hora_inicio')
            ->get();

        // Organizar por día de la semana
        $horariosPorDia = $horarios->groupBy('dia_semana');

        return view('docente.mi-horario', compact('horarios', 'horariosPorDia'));
    }

    /**
     * Mostrar formulario de registro de asistencia
     */
    public function asistencia()
    {
        $docente = $this->getDocenteActual();
        
        if (!$docente) {
            return redirect()->route('dashboard')
                ->with('error', 'No se encontró información del docente.');
        }

        $hoy = Carbon::now();
        $diaActual = $hoy->dayOfWeek == 0 ? 7 : $hoy->dayOfWeek;
        $horaActual = $hoy->format('H:i:s');

        // Obtener horarios de hoy
        $horariosHoy = Horario::where('docente_id', $docente->id)
            ->where('dia_semana', $diaActual)
            ->where('estado', 'Activo')
            ->with(['grupo.materia', 'aula'])
            ->whereHas('gestion', function($query) {
                $query->where('estado', 'Activo');
            })
            ->get();

        return view('docente.asistencia', compact('horariosHoy', 'hoy'));
    }

    /**
     * Guardar la asistencia
     */
    public function guardarAsistencia(Request $request)
    {
        $request->validate([
            'horario_id' => 'required|exists:horarios,id',
            'estado' => 'required|in:Presente,Ausente,Retraso',
            'observacion' => 'nullable|string|max:500',
        ]);

        $fecha = Carbon::now()->format('Y-m-d');

        // Verificar si ya existe asistencia
        $asistenciaExistente = Asistencia::where('horario_id', $request->horario_id)
            ->where('fecha', $fecha)
            ->first();

        if ($asistenciaExistente) {
            return back()->with('error', 'Ya registraste asistencia para esta clase hoy.');
        }

        Asistencia::create([
            'horario_id' => $request->horario_id,
            'fecha' => $fecha,
            'estado' => $request->estado,
            'observacion' => $request->observacion,
        ]);

        return back()->with('success', 'Asistencia registrada exitosamente.');
    }

    /**
     * Ver historial de asistencias
     */
    public function historialAsistencia()
    {
        $docente = $this->getDocenteActual();
        
        if (!$docente) {
            return redirect()->route('dashboard')
                ->with('error', 'No se encontró información del docente.');
        }

        // Obtener asistencias del docente
        $asistencias = Asistencia::whereHas('horario', function($query) use ($docente) {
                $query->where('docente_id', $docente->id);
            })
            ->with(['horario.grupo.materia', 'horario.aula'])
            ->orderBy('fecha', 'desc')
            ->paginate(20);

        return view('docente.historial-asistencia', compact('asistencias'));
    }
}