<?php

namespace App\Http\Controllers\Docente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Docente;
use App\Models\Horario;
use App\Models\Asistencia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
                $query->where('estado', 'Activa');
            })
            ->orderBy('dia_semana')
            ->orderBy('hora_inicio')
            ->get();

        // Organizar por día de la semana
        $horariosPorDia = $horarios->groupBy('dia_semana');

        return view('docente.mi-horario', compact('horarios', 'horariosPorDia'));
    }

    /**
     * Mostrar formulario de registro de asistencia (CU10)
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
        $fechaHoy = $hoy->format('Y-m-d');

        // Obtener horarios del día con asistencias
        $horariosHoy = Horario::where('docente_id', $docente->id)
            ->where('dia_semana', $diaActual)
            ->where('estado', 'Activo')
            ->with(['grupo.materia', 'aula', 'asistencias' => function($q) use ($fechaHoy) {
                $q->whereDate('fecha', $fechaHoy);
            }])
            ->whereHas('gestion', function($query) {
                $query->where('estado', 'Activa');
            })
            ->orderBy('hora_inicio')
            ->get();

        // Agregar información adicional a cada horario
        $horariosHoy->each(function($horario) use ($hoy) {
            $horario->ya_registro = $horario->asistencias->isNotEmpty();
            $horario->puede_registrar = $this->puedeRegistrarAsistencia($horario, $hoy);
            $horario->tiempo_restante = $this->tiempoRestante($horario, $hoy);
        });

        return view('docente.asistencia', compact('horariosHoy', 'hoy'));
    }

    /**
     * Guardar la asistencia (CU10)
     */
    public function guardarAsistencia(Request $request)
    {
        $request->validate([
            'horario_id' => 'required|exists:horarios,id',
            'estado' => 'nullable|in:Presente,Ausente,Retraso',
            'observacion' => 'nullable|string|max:500',
        ]);

        $docente = $this->getDocenteActual();
        
        if (!$docente) {
            return back()->with('error', 'No se encontró información del docente.');
        }

        $horario = Horario::findOrFail($request->horario_id);

        // Verificar que el horario pertenece al docente
        if ($horario->docente_id != $docente->id) {
            return back()->with('error', 'Este horario no te pertenece.');
        }

        $fecha = Carbon::now();
        $fechaHoy = $fecha->format('Y-m-d');

        // Verificar si ya existe asistencia
        $asistenciaExistente = Asistencia::where('horario_id', $request->horario_id)
            ->whereDate('fecha', $fechaHoy)
            ->first();

        if ($asistenciaExistente) {
            return back()->with('error', 'Ya registraste asistencia para esta clase hoy.');
        }

        // CU10: Validar que está en horario permitido (30 min antes hasta fin de clase)
        if (!$this->puedeRegistrarAsistencia($horario, $fecha)) {
            $hora_inicio = Carbon::parse($horario->hora_inicio)->format('H:i');
            $hora_fin = Carbon::parse($horario->hora_fin)->format('H:i');
            
            return back()->with('error', "No puedes registrar asistencia fuera del horario permitido. La clase es de {$hora_inicio} a {$hora_fin}. Puedes registrar desde 30 minutos antes hasta el fin de la clase.");
        }

        // Determinar estado automáticamente si no se especifica
        $horaRegistro = $fecha->format('H:i:s');
        $estado = $request->estado ?? $this->determinarEstadoAutomatico($horario, $fecha);

        try {
            Asistencia::create([
                'horario_id' => $request->horario_id,
                'fecha' => $fechaHoy,
                'hora_registro' => $horaRegistro,
                'estado' => $estado,
                'observacion' => $request->observacion,
            ]);

            Log::info('Asistencia registrada - CU10', [
                'docente_id' => $docente->id,
                'horario_id' => $horario->id,
                'fecha' => $fechaHoy,
                'hora_registro' => $horaRegistro,
                'estado' => $estado,
            ]);

            return back()->with('success', "Asistencia registrada exitosamente como: {$estado}");

        } catch (\Exception $e) {
            Log::error('Error al registrar asistencia - CU10', [
                'error' => $e->getMessage(),
                'docente_id' => $docente->id,
            ]);

            return back()->with('error', 'Error al registrar asistencia. Por favor, intenta de nuevo.');
        }
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
            ->orderBy('hora_registro', 'desc')
            ->paginate(20);

        // Estadísticas
        $estadisticas = [
            'total' => $asistencias->total(),
            'presentes' => Asistencia::whereHas('horario', function($q) use ($docente) {
                    $q->where('docente_id', $docente->id);
                })
                ->where('estado', 'Presente')
                ->count(),
            'ausentes' => Asistencia::whereHas('horario', function($q) use ($docente) {
                    $q->where('docente_id', $docente->id);
                })
                ->where('estado', 'Ausente')
                ->count(),
            'retrasos' => Asistencia::whereHas('horario', function($q) use ($docente) {
                    $q->where('docente_id', $docente->id);
                })
                ->where('estado', 'Retraso')
                ->count(),
        ];

        return view('docente.historial-asistencia', compact('asistencias', 'estadisticas'));
    }

    /**
     * CU10: Verificar si puede registrar asistencia
     * Permite 30 minutos antes hasta el fin de la clase
     */
    private function puedeRegistrarAsistencia($horario, $fecha)
    {
        $hora_actual = $fecha->format('H:i:s');
        $hora_inicio = Carbon::parse($horario->hora_inicio);
        $hora_fin = Carbon::parse($horario->hora_fin);
        
        // Permitir 30 minutos antes del inicio
        $hora_permitida_inicio = $hora_inicio->copy()->subMinutes(30)->format('H:i:s');
        $hora_permitida_fin = $hora_fin->format('H:i:s');
        
        return $hora_actual >= $hora_permitida_inicio && $hora_actual <= $hora_permitida_fin;
    }

    /**
     * CU10: Determinar estado automáticamente
     * Retraso si llega más de 15 minutos después del inicio
     */
    private function determinarEstadoAutomatico($horario, $fecha)
    {
        $hora_actual = $fecha->format('H:i:s');
        $hora_inicio = Carbon::parse($horario->hora_inicio);
        
        // Si llega más de 15 minutos después, es retraso
        $limite_retraso = $hora_inicio->copy()->addMinutes(15)->format('H:i:s');
        
        if ($hora_actual > $limite_retraso) {
            return 'Retraso';
        }
        
        return 'Presente';
    }

    /**
     * Calcular tiempo restante para registrar
     */
    private function tiempoRestante($horario, $fecha)
    {
        $hora_actual = $fecha;
        $hora_fin = Carbon::parse($horario->hora_fin);
        
        if ($hora_actual->greaterThan($hora_fin)) {
            return 'Expirado';
        }
        
        $diferencia = $hora_actual->diffInMinutes($hora_fin);
        
        if ($diferencia < 60) {
            return "{$diferencia} minutos";
        }
        
        $horas = floor($diferencia / 60);
        $minutos = $diferencia % 60;
        
        return "{$horas}h {$minutos}min";
    }
}