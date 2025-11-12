@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">
                <i class="bi bi-clock-history"></i> Historial de Asistencias
            </h4>
        </div>
        <div class="card-body">
            <!-- Estadísticas -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-light border-0">
                        <div class="card-body text-center">
                            <i class="bi bi-list-check fs-1 text-primary"></i>
                            <h3 class="mb-0 mt-2">{{ $estadisticas['total'] }}</h3>
                            <small class="text-muted">Total Registros</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success bg-opacity-10 border-success">
                        <div class="card-body text-center">
                            <i class="bi bi-check-circle fs-1 text-success"></i>
                            <h3 class="mb-0 mt-2">{{ $estadisticas['presentes'] }}</h3>
                            <small class="text-muted">Presente</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning bg-opacity-10 border-warning">
                        <div class="card-body text-center">
                            <i class="bi bi-clock fs-1 text-warning"></i>
                            <h3 class="mb-0 mt-2">{{ $estadisticas['retrasos'] }}</h3>
                            <small class="text-muted">Retrasos</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-danger bg-opacity-10 border-danger">
                        <div class="card-body text-center">
                            <i class="bi bi-x-circle fs-1 text-danger"></i>
                            <h3 class="mb-0 mt-2">{{ $estadisticas['ausentes'] }}</h3>
                            <small class="text-muted">Ausente</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Porcentaje de asistencia -->
            @if($estadisticas['total'] > 0)
                @php
                    $porcentajePresente = round(($estadisticas['presentes'] / $estadisticas['total']) * 100, 1);
                @endphp
                <div class="alert alert-info">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong>Porcentaje de asistencia:</strong>
                        </div>
                        <div>
                            <h4 class="mb-0">{{ $porcentajePresente }}%</h4>
                        </div>
                    </div>
                    <div class="progress mt-2" style="height: 25px;">
                        <div class="progress-bar bg-success" 
                             role="progressbar" 
                             style="width: {{ $porcentajePresente }}%"
                             aria-valuenow="{{ $porcentajePresente }}" 
                             aria-valuemin="0" 
                             aria-valuemax="100">
                            {{ $porcentajePresente }}%
                        </div>
                    </div>
                </div>
            @endif

            <!-- Tabla de historial -->
            <h5 class="mt-4 mb-3">
                <i class="bi bi-table"></i> Registro Detallado
            </h5>

            @if($asistencias->isEmpty())
                <div class="alert alert-warning text-center">
                    <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                    <h5>No tienes registros de asistencia</h5>
                    <p class="mb-0">Comienza a registrar tu asistencia diaria para ver tu historial aquí.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Fecha</th>
                                <th>Día</th>
                                <th>Materia - Grupo</th>
                                <th>Horario</th>
                                <th>Aula</th>
                                <th>Hora Registro</th>
                                <th>Estado</th>
                                <th>Observación</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($asistencias as $asistencia)
                                <tr>
                                    <td>
                                        <strong>{{ \Carbon\Carbon::parse($asistencia->fecha)->format('d/m/Y') }}</strong>
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($asistencia->fecha)->locale('es')->isoFormat('dddd') }}
                                    </td>
                                    <td>
                                        <strong>{{ $asistencia->horario->grupo->materia->nombre ?? 'N/A' }}</strong>
                                        <br>
                                        <small class="text-muted">Grupo: {{ $asistencia->horario->grupo->nombre ?? 'N/A' }}</small>
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($asistencia->horario->hora_inicio)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($asistencia->horario->hora_fin)->format('H:i') }}
                                    </td>
                                    <td>
                                        <i class="bi bi-door-open text-success"></i>
                                        {{ $asistencia->horario->aula->codigo ?? 'N/A' }}
                                    </td>
                                    <td>
                                        @if($asistencia->hora_registro)
                                            {{ \Carbon\Carbon::parse($asistencia->hora_registro)->format('H:i:s') }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($asistencia->estado == 'Presente')
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle"></i> Presente
                                            </span>
                                        @elseif($asistencia->estado == 'Retraso')
                                            <span class="badge bg-warning">
                                                <i class="bi bi-clock"></i> Retraso
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="bi bi-x-circle"></i> Ausente
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($asistencia->observacion)
                                            <small>{{ Str::limit($asistencia->observacion, 50) }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $asistencias->links() }}
                </div>
            @endif

            <!-- Botones de acción -->
            <div class="text-center mt-4">
                <a href="{{ route('docente.asistencia') }}" class="btn btn-primary">
                    <i class="bi bi-clipboard-check"></i> Registrar Asistencia Hoy
                </a>
                <a href="{{ route('docente.horario') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-calendar-week"></i> Ver Mi Horario
                </a>
            </div>
        </div>
    </div>
</div>
@endsection