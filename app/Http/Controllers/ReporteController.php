<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Horario;
use App\Models\Docente;
use App\Models\GestionAcademica;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AsistenciasExport;
use App\Exports\HorariosExport;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ReporteController extends Controller
{
    /**
     * Mostrar página principal de reportes
     */
    public function index()
    {
        $gestionActiva = GestionAcademica::activa();
        $docentes = Docente::with('usuario')->where('estado', 'Activo')->get();
        
        return view('reportes.index', compact('gestionActiva', 'docentes'));
    }

    /**
     * Generar reporte de asistencias por docente
     */
    public function asistenciasPorDocente(Request $request)
    {
        $request->validate([
            'docente_id' => 'required|exists:docentes,id',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'formato' => 'required|in:pdf,excel',
        ]);

        $docente = Docente::with('usuario')->findOrFail($request->docente_id);
        
        $query = Asistencia::with(['horario.grupo.materia', 'horario.aula'])
            ->whereHas('horario', function($q) use ($request) {
                $q->where('docente_id', $request->docente_id);
            });

        // Filtros de fecha
        if ($request->filled('fecha_inicio')) {
            $query->whereDate('fecha', '>=', $request->fecha_inicio);
        }
        if ($request->filled('fecha_fin')) {
            $query->whereDate('fecha', '<=', $request->fecha_fin);
        }

        $asistencias = $query->orderBy('fecha', 'desc')->get();

        if ($asistencias->isEmpty()) {
            return back()->with('error', 'No hay datos de asistencia para este docente en el rango de fechas seleccionado.');
        }

        // Estadísticas
        $estadisticas = [
            'total' => $asistencias->count(),
            'presentes' => $asistencias->where('estado', 'Presente')->count(),
            'retrasos' => $asistencias->where('estado', 'Retraso')->count(),
            'ausentes' => $asistencias->where('estado', 'Ausente')->count(),
            'porcentaje_asistencia' => $asistencias->count() > 0 
                ? round(($asistencias->where('estado', 'Presente')->count() / $asistencias->count()) * 100, 2)
                : 0,
        ];

        $datos = [
            'docente' => $docente,
            'asistencias' => $asistencias,
            'estadisticas' => $estadisticas,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
        ];

        if ($request->formato == 'pdf') {
            $pdf = Pdf::loadView('reportes.pdf.asistencias-docente', $datos);
            return $pdf->download('asistencias_' . $docente->usuario->nombre_completo . '_' . now()->format('Y-m-d') . '.pdf');
        } else {
            return Excel::download(new AsistenciasExport($asistencias, $docente), 
                'asistencias_' . $docente->usuario->nombre_completo . '_' . now()->format('Y-m-d') . '.xlsx');
        }
    }

    /**
     * Generar reporte de horarios por docente
     */
    public function horariosPorDocente(Request $request)
    {
        $request->validate([
            'docente_id' => 'required|exists:docentes,id',
            'formato' => 'required|in:pdf,excel',
        ]);

        $docente = Docente::with('usuario')->findOrFail($request->docente_id);
        $gestionActiva = GestionAcademica::activa();

        if (!$gestionActiva) {
            return back()->with('error', 'No hay una gestión académica activa.');
        }

        $horarios = Horario::with(['grupo.materia', 'aula', 'gestion'])
            ->where('docente_id', $request->docente_id)
            ->where('gestion_id', $gestionActiva->id)
            ->where('estado', 'Activo')
            ->orderBy('dia_semana')
            ->orderBy('hora_inicio')
            ->get();

        if ($horarios->isEmpty()) {
            return back()->with('error', 'Este docente no tiene horarios asignados en la gestión actual.');
        }

        $datos = [
            'docente' => $docente,
            'horarios' => $horarios,
            'gestion' => $gestionActiva,
            'horariosPorDia' => $horarios->groupBy('dia_semana'),
        ];

        if ($request->formato == 'pdf') {
            $pdf = Pdf::loadView('reportes.pdf.horarios-docente', $datos);
            return $pdf->download('horarios_' . $docente->usuario->nombre_completo . '_' . now()->format('Y-m-d') . '.pdf');
        } else {
            return Excel::download(new HorariosExport($horarios, $docente), 
                'horarios_' . $docente->usuario->nombre_completo . '_' . now()->format('Y-m-d') . '.xlsx');
        }
    }

    /**
     * Generar reporte general de asistencias
     */
    public function asistenciasGeneral(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'formato' => 'required|in:pdf,excel',
        ]);

        $query = Asistencia::with(['horario.docente.usuario', 'horario.grupo.materia', 'horario.aula']);

        if ($request->filled('fecha_inicio')) {
            $query->whereDate('fecha', '>=', $request->fecha_inicio);
        }
        if ($request->filled('fecha_fin')) {
            $query->whereDate('fecha', '<=', $request->fecha_fin);
        }

        $asistencias = $query->orderBy('fecha', 'desc')->get();

        if ($asistencias->isEmpty()) {
            return back()->with('error', 'No hay datos de asistencia en el rango de fechas seleccionado.');
        }

        $estadisticas = [
            'total' => $asistencias->count(),
            'presentes' => $asistencias->where('estado', 'Presente')->count(),
            'retrasos' => $asistencias->where('estado', 'Retraso')->count(),
            'ausentes' => $asistencias->where('estado', 'Ausente')->count(),
        ];

        $datos = [
            'asistencias' => $asistencias,
            'estadisticas' => $estadisticas,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
        ];

        if ($request->formato == 'pdf') {
            $pdf = Pdf::loadView('reportes.pdf.asistencias-general', $datos);
            return $pdf->download('asistencias_general_' . now()->format('Y-m-d') . '.pdf');
        } else {
            return Excel::download(new AsistenciasExport($asistencias), 
                'asistencias_general_' . now()->format('Y-m-d') . '.xlsx');
        }
    }

    /**
     * Generar reporte de todos los horarios
     */
    public function horariosGeneral(Request $request)
    {
        $request->validate([
            'formato' => 'required|in:pdf,excel',
        ]);

        $gestionActiva = GestionAcademica::activa();

        if (!$gestionActiva) {
            return back()->with('error', 'No hay una gestión académica activa.');
        }

        $horarios = Horario::with(['docente.usuario', 'grupo.materia', 'aula', 'gestion'])
            ->where('gestion_id', $gestionActiva->id)
            ->where('estado', 'Activo')
            ->orderBy('dia_semana')
            ->orderBy('hora_inicio')
            ->get();

        if ($horarios->isEmpty()) {
            return back()->with('error', 'No hay horarios registrados en la gestión actual.');
        }

        $datos = [
            'horarios' => $horarios,
            'gestion' => $gestionActiva,
        ];

        if ($request->formato == 'pdf') {
            $pdf = Pdf::loadView('reportes.pdf.horarios-general', $datos)
                ->setPaper('a4', 'landscape'); // Horizontal para más espacio
            return $pdf->download('horarios_general_' . now()->format('Y-m-d') . '.pdf');
        } else {
            return Excel::download(new HorariosExport($horarios), 
                'horarios_general_' . now()->format('Y-m-d') . '.xlsx');
        }
    }
}