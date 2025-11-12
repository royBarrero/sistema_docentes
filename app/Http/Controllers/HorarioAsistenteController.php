<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Docente;
use App\Models\Materia;
use App\Models\Grupo;
use App\Models\Aula;
use App\Models\GestionAcademica;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class HorarioAsistenteController extends Controller
{
    /**
     * Mostrar el formulario del asistente
     */
    public function index()
{
    $gestionActiva = GestionAcademica::activa();

    if (!$gestionActiva) {
        return redirect()->back()->with('error', 'No hay una gestión académica activa.');
    }

    $docentes = Docente::with('usuario')->where('estado', 'Activo')->get();
    
    // 👇 CAMBIO TEMPORAL: Trae todas las materias sin filtro
   $materias = Materia::all();
    

    return view('horarios.asistente.index', compact('docentes', 'materias', 'gestionActiva'));
}
    /**
     * Buscar opciones disponibles
     */
    public function buscarOpciones(Request $request)
    {
        $request->validate([
            'docente_id' => 'required|exists:docentes,id',
            'materia_id' => 'required|exists:materias,id',
            'periodos_semana' => 'required|integer|min:1|max:10',
            'duracion_periodo' => 'required|numeric|min:1|max:4',
        ]);

        $gestionActiva = GestionAcademica::activa();

        if (!$gestionActiva) {
            return back()->with('error', 'No hay una gestión académica activa.');
        }

        $docente_id = $request->docente_id;
        $materia_id = $request->materia_id;
        $periodos_semana = $request->periodos_semana;
        $duracion_periodo = $request->duracion_periodo; // En horas (ej: 1.5)

        // 1. Buscar grupos de esa materia sin horarios asignados
        $grupos_disponibles = Grupo::with('materia')
            ->where('materia_id', $materia_id)
            ->where('estado', 'Activo')
            ->whereDoesntHave('horarios', function($q) use ($gestionActiva) {
                $q->where('gestion_id', $gestionActiva->id);
            })
            ->get();

        if ($grupos_disponibles->isEmpty()) {
            return back()->with('error', 'No hay grupos disponibles para esta materia.');
        }

        // 2. Definir franjas horarias posibles
        $franjas = $this->generarFranjas($duracion_periodo);

        // 3. Días de la semana (Lunes a Sábado)
        $dias = [1, 2, 3, 4, 5, 6];

        // 4. Buscar opciones para cada grupo
        $opciones = [];

        foreach ($grupos_disponibles as $grupo) {
            $horarios_encontrados = [];

            foreach ($dias as $dia) {
                if (count($horarios_encontrados) >= $periodos_semana) {
                    break; // Ya encontramos suficientes períodos
                }

                foreach ($franjas as $franja) {
                    if (count($horarios_encontrados) >= $periodos_semana) {
                        break;
                    }

                    // Verificar si el docente está libre
                    $docente_ocupado = Horario::where('gestion_id', $gestionActiva->id)
                        ->where('docente_id', $docente_id)
                        ->where('dia_semana', $dia)
                        ->where(function($q) use ($franja) {
                            $q->whereBetween('hora_inicio', [$franja['inicio'], $franja['fin']])
                              ->orWhereBetween('hora_fin', [$franja['inicio'], $franja['fin']])
                              ->orWhere(function($q2) use ($franja) {
                                  $q2->where('hora_inicio', '<=', $franja['inicio'])
                                     ->where('hora_fin', '>=', $franja['fin']);
                              });
                        })
                        ->exists();

                    if ($docente_ocupado) {
                        continue;
                    }

                    // Buscar aula disponible
                    $aula = Aula::where('estado', 'Disponible')
                        ->whereDoesntHave('horarios', function($q) use ($gestionActiva, $dia, $franja) {
                            $q->where('gestion_id', $gestionActiva->id)
                              ->where('dia_semana', $dia)
                              ->where(function($q2) use ($franja) {
                                  $q2->whereBetween('hora_inicio', [$franja['inicio'], $franja['fin']])
                                     ->orWhereBetween('hora_fin', [$franja['inicio'], $franja['fin']])
                                     ->orWhere(function($q3) use ($franja) {
                                         $q3->where('hora_inicio', '<=', $franja['inicio'])
                                            ->where('hora_fin', '>=', $franja['fin']);
                                     });
                              });
                        })
                        ->first();

                    if ($aula) {
                        $horarios_encontrados[] = [
                            'dia' => $dia,
                            'dia_nombre' => $this->getNombreDia($dia),
                            'hora_inicio' => $franja['inicio'],
                            'hora_fin' => $franja['fin'],
                            'aula' => $aula,
                        ];
                    }
                }
            }

            // Solo agregar si encontró todos los períodos necesarios
            if (count($horarios_encontrados) >= $periodos_semana) {
                $opciones[] = [
                    'grupo' => $grupo,
                    'horarios' => array_slice($horarios_encontrados, 0, $periodos_semana),
                    'completo' => true,
                ];
            } else {
                $opciones[] = [
                    'grupo' => $grupo,
                    'horarios' => $horarios_encontrados,
                    'completo' => false,
                ];
            }
        }

        $docente = Docente::with('usuario')->find($docente_id);
        $materia = Materia::find($materia_id);

        return view('horarios.asistente.resultados', compact(
            'opciones',
            'docente',
            'materia',
            'periodos_semana',
            'duracion_periodo',
            'gestionActiva'
        ));
    }

    /**
     * Aprobar y guardar una opción
     */
  public function aprobarOpcion(Request $request)
{
    Log::info('=== APROBAR OPCIÓN - INICIO ===');
    Log::info('Request completo:', $request->all());
    
    try {
        // Validación
        $validated = $request->validate([
            'docente_id' => 'required|exists:docentes,id',
            'grupo_id' => 'required|exists:grupos,id',
            'horarios' => 'required|string', // Cambiar de array a string
        ]);
        
        Log::info('Validación exitosa');

        $gestionActiva = GestionAcademica::activa();

        if (!$gestionActiva) {
            Log::error('No hay gestión activa');
            return redirect()->route('horarios.index')
                ->with('error', 'No hay una gestión académica activa.');
        }

        Log::info('Gestión activa:', ['id' => $gestionActiva->id]);

        // Decodificar horarios
        $horarios = json_decode($request->horarios, true);
        
        Log::info('Horarios decodificados:', ['horarios' => $horarios, 'tipo' => gettype($horarios)]);

        if (!is_array($horarios) || empty($horarios)) {
            Log::error('Formato de horarios inválido', ['horarios_raw' => $request->horarios]);
            return redirect()->route('horarios.index')
                ->with('error', 'Formato de horarios inválido.');
        }

        $creados = 0;

        foreach ($horarios as $index => $horario_data) {
            Log::info("Procesando horario {$index}:", $horario_data);
            
            // Validar que tenga todos los campos
            if (!isset($horario_data['dia'], $horario_data['hora_inicio'], $horario_data['hora_fin'], $horario_data['aula_id'])) {
                Log::error("Horario {$index} incompleto", $horario_data);
                continue;
            }
            
            try {
                $horario_creado = Horario::create([
                    'docente_id' => $request->docente_id,
                    'grupo_id' => $request->grupo_id,
                    'aula_id' => $horario_data['aula_id'],
                    'gestion_id' => $gestionActiva->id,
                    'dia_semana' => $horario_data['dia'],
                    'hora_inicio' => $horario_data['hora_inicio'],
                    'hora_fin' => $horario_data['hora_fin'],
                    'estado' => 'Activo',
                ]);
                
                Log::info("✅ Horario {$index} creado exitosamente", ['id' => $horario_creado->id]);
                $creados++;
                
            } catch (\Exception $e) {
                Log::error("❌ Error al crear horario {$index}", [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }

        Log::info("=== APROBAR OPCIÓN - FIN === Total creados: {$creados}");

        if ($creados > 0) {
            return redirect()->route('horarios.index')
                ->with('success', "{$creados} horarios generados exitosamente.");
        } else {
            return redirect()->route('horarios.index')
                ->with('error', 'No se pudo crear ningún horario. Revisa los logs.');
        }
        
    } catch (\Illuminate\Validation\ValidationException $e) {
        Log::error('Error de validación:', ['errors' => $e->errors()]);
        return redirect()->route('horarios.index')
            ->with('error', 'Error de validación: ' . json_encode($e->errors()));
            
    } catch (\Exception $e) {
        Log::error('Error general:', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ]);
        return redirect()->route('horarios.index')
            ->with('error', 'Error: ' . $e->getMessage());
    }
}

    /**
     * Generar franjas horarias según duración
     */
    private function generarFranjas($duracion)
    {
        $franjas = [];
        $hora_inicio = 7; // Inicia a las 7:00
        $hora_fin = 20;   // Termina a las 20:00

        while ($hora_inicio < $hora_fin) {
            $inicio = sprintf('%02d:00', $hora_inicio);
            
            // Calcular hora de fin
            $minutos_duracion = $duracion * 60;
            $hora_fin_periodo = Carbon::parse($inicio)->addMinutes($minutos_duracion)->format('H:i');

            $franjas[] = [
                'inicio' => $inicio,
                'fin' => $hora_fin_periodo,
            ];

            // Siguiente franja (avanzar la duración + 15 min de descanso)
            $hora_inicio += $duracion + 0.25; // 15 minutos = 0.25 horas
        }

        return $franjas;
    }

    /**
     * Obtener nombre del día
     */
    private function getNombreDia($dia)
    {
        $dias = [
            1 => 'Lunes',
            2 => 'Martes',
            3 => 'Miércoles',
            4 => 'Jueves',
            5 => 'Viernes',
            6 => 'Sábado',
        ];

        return $dias[$dia] ?? '-';
    }
}