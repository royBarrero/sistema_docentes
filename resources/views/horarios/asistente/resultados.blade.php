@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <h3 class="mb-0">
                <i class="bi bi-list-check"></i> Opciones Encontradas
            </h3>
        </div>
        <div class="card-body p-4">
            <!-- Información de búsqueda -->
            <div class="alert alert-info">
                <div class="row">
                    <div class="col-md-6">
                        <strong><i class="bi bi-person-badge"></i> Docente:</strong> 
                        {{ $docente->usuario->nombre_completo ?? 'N/A' }}
                    </div>
                    <div class="col-md-6">
                        <strong><i class="bi bi-book"></i> Materia:</strong> 
                        {{ $materia->nombre }}
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <strong><i class="bi bi-calendar-week"></i> Períodos:</strong> 
                        {{ $periodos_semana }} por semana
                    </div>
                    <div class="col-md-6">
                        <strong><i class="bi bi-clock"></i> Duración:</strong> 
                        {{ $duracion_periodo }} horas
                    </div>
                </div>
            </div>

            @if(empty($opciones))
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle"></i>
                    <strong>No se encontraron opciones disponibles.</strong>
                    <p class="mb-0 mt-2">Posibles causas:</p>
                    <ul>
                        <li>No hay grupos disponibles para esta materia</li>
                        <li>El docente tiene muchos horarios ocupados</li>
                        <li>No hay suficientes aulas libres</li>
                    </ul>
                </div>
                <a href="{{ route('horarios.asistente') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-left"></i> Intentar con otros parámetros
                </a>
            @else
                <div class="alert alert-success">
                    <i class="bi bi-check-circle"></i>
                    Se encontraron <strong>{{ count($opciones) }} opciones</strong> posibles
                </div>

                <!-- Mostrar opciones -->
                @foreach($opciones as $index => $opcion)
                    <div class="card mb-4 {{ $opcion['completo'] ? 'border-success' : 'border-warning' }}">
                        <div class="card-header {{ $opcion['completo'] ? 'bg-success' : 'bg-warning' }} text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="bi bi-{{ $opcion['completo'] ? 'check-circle' : 'exclamation-triangle' }}"></i>
                                    Opción {{ $index + 1 }}: {{ $opcion['grupo']->materia->nombre }} - Grupo {{ $opcion['grupo']->nombre }}
                                </h5>
                                @if($opcion['completo'])
                                    <span class="badge bg-light text-success">Completo</span>
                                @else
                                    <span class="badge bg-light text-warning">Incompleto</span>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            @if(!$opcion['completo'])
                                <div class="alert alert-warning mb-3">
                                    <i class="bi bi-exclamation-triangle"></i>
                                    Solo se encontraron <strong>{{ count($opcion['horarios']) }}</strong> de {{ $periodos_semana }} períodos necesarios
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Día</th>
                                            <th>Horario</th>
                                            <th>Aula</th>
                                            <th>Capacidad</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($opcion['horarios'] as $horario)
                                            <tr>
                                                <td>
                                                    <span class="badge bg-primary">{{ $horario['dia_nombre'] }}</span>
                                                </td>
                                                <td>
                                                    <strong>{{ $horario['hora_inicio'] }}</strong> - {{ $horario['hora_fin'] }}
                                                </td>
                                                <td>
                                                    <i class="bi bi-door-open text-success"></i>
                                                    {{ $horario['aula']->codigo }}
                                                </td>
                                                <td>
                                                    <i class="bi bi-people"></i>
                                                    {{ $horario['aula']->capacidad }} estudiantes
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            @if($opcion['completo'])
                                <form action="{{ route('horarios.asistente.aprobar') }}" method="POST" class="mt-3">
                                    @csrf
                                    <input type="hidden" name="docente_id" value="{{ $docente->id }}">
                                    <input type="hidden" name="grupo_id" value="{{ $opcion['grupo']->id }}">
                                    <input type="hidden" name="horarios" value="{{ json_encode(array_map(function($h) {
                                        return [
                                            'dia' => $h['dia'],
                                            'hora_inicio' => $h['hora_inicio'],
                                            'hora_fin' => $h['hora_fin'],
                                            'aula_id' => $h['aula']->id,
                                        ];
                                    }, $opcion['horarios'])) }}">
                                    {{-- 👇 DEBUGGING: Ver qué datos se envían --}}
        <script>
            document.getElementById('form-{{ $index }}').addEventListener('submit', function(e) {
                console.log('=== DATOS DEL FORMULARIO {{ $index }} ===');
                console.log('Docente ID:', this.querySelector('[name="docente_id"]').value);
                console.log('Grupo ID:', this.querySelector('[name="grupo_id"]').value);
                console.log('Horarios:', this.querySelector('[name="horarios"]').value);
            });
        </script>
                                    <button type="submit" 
                                            class="btn btn-success btn-lg w-100"
                                            onclick="return confirm('¿Aprobar y crear estos horarios?')">
                                        <i class="bi bi-check-circle"></i> Aprobar esta opción
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-secondary btn-lg w-100" disabled>
                                    <i class="bi bi-x-circle"></i> Opción incompleta - No se puede aprobar
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach

                <div class="mt-4">
                    <a href="{{ route('horarios.asistente') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-left"></i> Buscar con otros parámetros
                    </a>
                    <a href="{{ route('horarios.index') }}" class="btn btn-secondary">
                        <i class="bi bi-list"></i> Ver todos los horarios
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection