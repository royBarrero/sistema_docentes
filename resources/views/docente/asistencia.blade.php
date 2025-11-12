@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-clipboard-check"></i> Registrar Asistencia
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Fecha y hora actual -->
                    <div class="alert alert-info">
                        <div class="row">
                            <div class="col-md-6">
                                <strong><i class="bi bi-calendar3"></i> Fecha:</strong> 
                                {{ $hoy->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                            </div>
                            <div class="col-md-6">
                                <strong><i class="bi bi-clock"></i> Hora actual:</strong> 
                                <span id="hora-actual">{{ $hoy->format('H:i:s') }}</span>
                            </div>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="bi bi-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Clases del día -->
                    @if($horariosHoy->isEmpty())
                        <div class="alert alert-warning text-center">
                            <i class="bi bi-calendar-x fs-1 d-block mb-3"></i>
                            <h5>No tienes clases programadas para hoy</h5>
                            <p class="mb-0">Revisa tu horario semanal o contacta al administrador.</p>
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('docente.horario') }}" class="btn btn-primary">
                                <i class="bi bi-calendar-week"></i> Ver Mi Horario Completo
                            </a>
                        </div>
                    @else
                        <h5 class="mb-3">
                            <i class="bi bi-list-check"></i> Tus clases de hoy ({{ $horariosHoy->count() }})
                        </h5>

                        <div class="row">
                            @foreach($horariosHoy as $horario)
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100 {{ $horario->ya_registro ? 'border-success' : ($horario->puede_registrar ? 'border-primary' : 'border-secondary') }}">
                                        <div class="card-header {{ $horario->ya_registro ? 'bg-success' : ($horario->puede_registrar ? 'bg-primary' : 'bg-secondary') }} text-white">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-0">
                                                        <i class="bi bi-book"></i>
                                                        {{ $horario->grupo->materia->nombre ?? 'N/A' }}
                                                    </h6>
                                                    <small>Grupo: {{ $horario->grupo->nombre ?? 'N/A' }}</small>
                                                </div>
                                                @if($horario->ya_registro)
                                                    <span class="badge bg-light text-success">
                                                        <i class="bi bi-check-circle"></i> Registrada
                                                    </span>
                                                @elseif($horario->puede_registrar)
                                                    <span class="badge bg-light text-primary">
                                                        <i class="bi bi-clock-history"></i> Disponible
                                                    </span>
                                                @else
                                                    <span class="badge bg-light text-secondary">
                                                        <i class="bi bi-lock"></i> No disponible
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <p class="mb-2">
                                                    <i class="bi bi-clock text-primary"></i>
                                                    <strong>Horario:</strong> 
                                                    {{ \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') }} - 
                                                    {{ \Carbon\Carbon::parse($horario->hora_fin)->format('H:i') }}
                                                </p>
                                                <p class="mb-2">
                                                    <i class="bi bi-door-open text-success"></i>
                                                    <strong>Aula:</strong> {{ $horario->aula->codigo ?? 'N/A' }}
                                                </p>
                                                @if(!$horario->ya_registro && $horario->puede_registrar)
                                                    <p class="mb-0">
                                                        <i class="bi bi-hourglass-split text-warning"></i>
                                                        <strong>Tiempo restante:</strong> {{ $horario->tiempo_restante }}
                                                    </p>
                                                @endif
                                            </div>

                                            @if($horario->ya_registro)
                                                <!-- Ya registró -->
                                                <div class="alert alert-success mb-0">
                                                    <i class="bi bi-check-circle"></i>
                                                    <strong>Asistencia registrada</strong><br>
                                                    <small>
                                                        Estado: {{ $horario->asistencias->first()->estado }}<br>
                                                        Hora: {{ \Carbon\Carbon::parse($horario->asistencias->first()->hora_registro)->format('H:i:s') }}
                                                    </small>
                                                </div>
                                            @elseif($horario->puede_registrar)
                                                <!-- Puede registrar -->
                                                <form action="{{ route('docente.asistencia.guardar') }}" 
                                                      method="POST"
                                                      onsubmit="return confirm('¿Confirmar registro de asistencia?')">
                                                    @csrf
                                                    <input type="hidden" name="horario_id" value="{{ $horario->id }}">
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label">Observaciones (opcional)</label>
                                                        <textarea name="observacion" 
                                                                  class="form-control" 
                                                                  rows="2" 
                                                                  placeholder="Algún comentario sobre la clase..."></textarea>
                                                    </div>

                                                    <button type="submit" class="btn btn-primary w-100">
                                                        <i class="bi bi-check-circle"></i> Registrar Mi Asistencia
                                                    </button>
                                                </form>
                                            @else
                                                <!-- No puede registrar -->
                                                <div class="alert alert-secondary mb-0">
                                                    <i class="bi bi-info-circle"></i>
                                                    <strong>Fuera de horario</strong><br>
                                                    <small>Podrás registrar desde 30 minutos antes del inicio hasta el fin de la clase.</small>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Información adicional -->
                        <div class="alert alert-light border mt-4">
                            <h6><i class="bi bi-info-circle"></i> Información importante:</h6>
                            <ul class="mb-0">
                                <li>Puedes registrar tu asistencia desde <strong>30 minutos antes</strong> del inicio de la clase</li>
                                <li>El registro está disponible hasta el <strong>fin de la clase</strong></li>
                                <li>Si llegas más de <strong>15 minutos tarde</strong>, se marcará como "Retraso" automáticamente</li>
                                <li>Solo puedes registrar <strong>una vez por clase</strong></li>
                            </ul>
                        </div>

                        <div class="text-center mt-4">
                            <a href="{{ route('docente.historial') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-clock-history"></i> Ver Historial de Asistencias
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Script para actualizar la hora en tiempo real --}}
<script>
    setInterval(function() {
        const ahora = new Date();
        const horas = String(ahora.getHours()).padStart(2, '0');
        const minutos = String(ahora.getMinutes()).padStart(2, '0');
        const segundos = String(ahora.getSeconds()).padStart(2, '0');
        document.getElementById('hora-actual').textContent = `${horas}:${minutos}:${segundos}`;
    }, 1000);
</script>
@endsection