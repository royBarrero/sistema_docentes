@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-info text-white">
                <h4 class="mb-0">
                    <i class="bi bi-calendar-week"></i> Mi Horario Semanal
                </h4>
            </div>
            <div class="card-body">
                @if ($horarios->isEmpty())
                    <div class="alert alert-warning text-center">
                        <i class="bi bi-calendar-x fs-1 d-block mb-3"></i>
                        <h5>No tienes horarios asignados</h5>
                        <p class="mb-0">Contacta al administrador para que te asigne materias y grupos.</p>
                    </div>
                @else
                    <!-- Información de la gestión -->
                    @if ($horarios->first()->gestion)
                        <div class="alert alert-info">
                            <strong><i class="bi bi-calendar3"></i> Gestión Académica:</strong>
                            {{ $horarios->first()->gestion->nombre }}
                            ({{ $horarios->first()->gestion->fecha_inicio->format('d/m/Y') }} -
                            {{ $horarios->first()->gestion->fecha_fin->format('d/m/Y') }})
                        </div>
                    @endif

                    <!-- Resumen de clases -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <i class="bi bi-book fs-1 text-primary"></i>
                                    <h3 class="mb-0 mt-2">{{ $horarios->unique('grupo.materia_id')->count() }}</h3>
                                    <small class="text-muted">Materias</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <i class="bi bi-people fs-1 text-success"></i>
                                    <h3 class="mb-0 mt-2">{{ $horarios->unique('grupo_id')->count() }}</h3>
                                    <small class="text-muted">Grupos</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <i class="bi bi-clock fs-1 text-warning"></i>
                                    <h3 class="mb-0 mt-2">{{ $horarios->count() }}</h3>
                                    <small class="text-muted">Clases por Semana</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Vista de tabla semanal -->
                    <h5 class="mb-3">
                        <i class="bi bi-table"></i> Horario Semanal
                    </h5>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th style="width: 100px;">Hora</th>
                                    <th>Lunes</th>
                                    <th>Martes</th>
                                    <th>Miércoles</th>
                                    <th>Jueves</th>
                                    <th>Viernes</th>
                                    <th>Sábado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $horaInicio = 7;
                                    $horaFin = 20;

                                    // Agrupar por día y franja horaria (con rango de 1 hora)
                                    $horariosPorDiaHora = [];
                                    foreach ($horarios as $h) {
                                        $horaInicioHorario = (int) \Carbon\Carbon::parse($h->hora_inicio)->format('H');
                                        $key = $h->dia_semana . '-' . $horaInicioHorario;

                                        if (!isset($horariosPorDiaHora[$key])) {
                                            $horariosPorDiaHora[$key] = collect();
                                        }
                                        $horariosPorDiaHora[$key]->push($h);
                                    }
                                    $horariosPorDiaHora = collect($horariosPorDiaHora);
                                @endphp

                                @for ($hora = $horaInicio; $hora <= $horaFin; $hora++)
                                    <tr>
                                        <td class="fw-bold text-center bg-light">
                                            {{ sprintf('%02d:00', $hora) }}
                                        </td>
                                        @for ($dia = 1; $dia <= 6; $dia++)
                                            @php
                                                $key = $dia . '-' . $hora;
                                                $horarios_encontrados = $horariosPorDiaHora->has($key)
                                                    ? $horariosPorDiaHora->get($key)
                                                    : collect();
                                            @endphp
                                            <td class="{{ $horarios_encontrados->isNotEmpty() ? 'table-info' : '' }}">
                                                @if ($horarios_encontrados->isNotEmpty())
                                                    @foreach ($horarios_encontrados as $horario)
                                                        <div class="mb-2">
                                                            <strong
                                                                class="d-block">{{ $horario->grupo->materia->nombre ?? 'N/A' }}</strong>
                                                            <small class="text-muted d-block">
                                                                Grupo: {{ $horario->grupo->nombre ?? 'N/A' }}
                                                            </small>
                                                            <small class="text-muted d-block">
                                                                <i class="bi bi-door-open"></i>
                                                                {{ $horario->aula->codigo ?? 'N/A' }}
                                                            </small>
                                                            <small class="text-muted">
                                                                {{ \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') }}
                                                                -
                                                                {{ \Carbon\Carbon::parse($horario->hora_fin)->format('H:i') }}
                                                            </small>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        @endfor
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>

                    <!-- Lista detallada por día -->
                    <h5 class="mt-5 mb-3">
                        <i class="bi bi-list-ul"></i> Horario Detallado
                    </h5>

                    @foreach ($horariosPorDia as $dia => $horariosDelDia)
                        @php
                            $nombresDias = [
                                1 => 'Lunes',
                                2 => 'Martes',
                                3 => 'Miércoles',
                                4 => 'Jueves',
                                5 => 'Viernes',
                                6 => 'Sábado',
                                7 => 'Domingo',
                            ];
                        @endphp
                        <div class="card mb-3">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0">
                                    <i class="bi bi-calendar-day"></i> {{ $nombresDias[$dia] ?? 'N/A' }}
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Horario</th>
                                                <th>Materia</th>
                                                <th>Grupo</th>
                                                <th>Aula</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($horariosDelDia as $horario)
                                                <tr>
                                                    <td>
                                                        <strong>
                                                            {{ \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') }}
                                                            -
                                                            {{ \Carbon\Carbon::parse($horario->hora_fin)->format('H:i') }}
                                                        </strong>
                                                    </td>
                                                    <td>{{ $horario->grupo->materia->nombre ?? 'N/A' }}</td>
                                                    <td>{{ $horario->grupo->nombre ?? 'N/A' }}</td>
                                                    <td>
                                                        <i class="bi bi-door-open text-success"></i>
                                                        {{ $horario->aula->codigo ?? 'N/A' }}
                                                        <small class="text-muted">(Cap:
                                                            {{ $horario->aula->capacidad ?? 'N/A' }})</small>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Botones de acción -->
                    <div class="text-center mt-4">
                        <a href="{{ route('docente.asistencia') }}" class="btn btn-primary">
                            <i class="bi bi-clipboard-check"></i> Registrar Asistencia
                        </a>
                        <a href="{{ route('docente.historial') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-clock-history"></i> Ver Historial
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
