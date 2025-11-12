@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h3 class="mb-0">
                        <i class="bi bi-magic"></i> Asistente de Generación Automática de Horarios
                    </h3>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        <strong>Gestión Académica:</strong> {{ $gestionActiva->nombre }}
                        ({{ $gestionActiva->fecha_inicio->format('d/m/Y') }} - {{ $gestionActiva->fecha_fin->format('d/m/Y') }})
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="alert alert-light border">
                        <h5 class="mb-3"><i class="bi bi-lightbulb"></i> ¿Cómo funciona?</h5>
                        <ol class="mb-0">
                            <li>Selecciona el <strong>docente</strong> y la <strong>materia</strong></li>
                            <li>Define cuántos <strong>períodos por semana</strong> necesitas</li>
                            <li>El sistema buscará automáticamente:
                                <ul>
                                    <li>✅ Grupos disponibles de esa materia</li>
                                    <li>✅ Horarios libres (sin conflictos)</li>
                                    <li>✅ Aulas disponibles</li>
                                </ul>
                            </li>
                            <li>Revisa las opciones y <strong>aprueba</strong> las que desees</li>
                        </ol>
                    </div>

                    <form action="{{ route('horarios.asistente.buscar') }}" method="POST" class="mt-4">
                        @csrf

                        <div class="row">
                            <!-- Seleccionar Docente -->
                            <div class="col-md-6 mb-4">
                                <label for="docente_id" class="form-label fw-bold">
                                    <i class="bi bi-person-badge text-primary"></i> Docente *
                                </label>
                                <select name="docente_id" 
                                        id="docente_id" 
                                        class="form-select form-select-lg @error('docente_id') is-invalid @enderror" 
                                        required>
                                    <option value="">Seleccione un docente</option>
                                    @foreach($docentes as $docente)
                                        <option value="{{ $docente->id }}" {{ old('docente_id') == $docente->id ? 'selected' : '' }}>
                                            {{ $docente->usuario->nombre_completo ?? 'Sin nombre' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('docente_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Seleccionar Materia -->
                            <div class="col-md-6 mb-4">
                                <label for="materia_id" class="form-label fw-bold">
                                    <i class="bi bi-book text-success"></i> Materia *
                                </label>
                                <select name="materia_id" 
                                        id="materia_id" 
                                        class="form-select form-select-lg @error('materia_id') is-invalid @enderror" 
                                        required>
                                    <option value="">Seleccione una materia</option>
                                    @foreach($materias as $materia)
                                        <option value="{{ $materia->id }}" {{ old('materia_id') == $materia->id ? 'selected' : '' }}>
                                            {{ $materia->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('materia_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Períodos por semana -->
                            <div class="col-md-6 mb-4">
                                <label for="periodos_semana" class="form-label fw-bold">
                                    <i class="bi bi-calendar-week text-warning"></i> Períodos por semana *
                                </label>
                                <input type="number" 
                                       name="periodos_semana" 
                                       id="periodos_semana" 
                                       class="form-control form-control-lg @error('periodos_semana') is-invalid @enderror" 
                                       value="{{ old('periodos_semana', 2) }}"
                                       min="1" 
                                       max="10"
                                       required>
                                <small class="text-muted">¿Cuántas clases por semana? (Ej: 2, 3, 4)</small>
                                @error('periodos_semana')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Duración por período -->
                            <div class="col-md-6 mb-4">
                                <label for="duracion_periodo" class="form-label fw-bold">
                                    <i class="bi bi-clock text-info"></i> Duración por período (horas) *
                                </label>
                                <select name="duracion_periodo" 
                                        id="duracion_periodo" 
                                        class="form-select form-select-lg @error('duracion_periodo') is-invalid @enderror"
                                        required>
                                    <option value="1" {{ old('duracion_periodo') == 1 ? 'selected' : '' }}>1 hora</option>
                                    <option value="1.5" {{ old('duracion_periodo', 1.5) == 1.5 ? 'selected' : '' }}>1.5 horas (90 min)</option>
                                    <option value="2" {{ old('duracion_periodo') == 2 ? 'selected' : '' }}>2 horas</option>
                                    <option value="2.5" {{ old('duracion_periodo') == 2.5 ? 'selected' : '' }}>2.5 horas</option>
                                    <option value="3" {{ old('duracion_periodo') == 3 ? 'selected' : '' }}>3 horas</option>
                                </select>
                                <small class="text-muted">Duración de cada clase</small>
                                @error('duracion_periodo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('horarios.index') }}" class="btn btn-lg btn-secondary">
                                <i class="bi bi-arrow-left"></i> Volver a Horarios
                            </a>
                            <button type="submit" class="btn btn-lg btn-primary">
                                <i class="bi bi-search"></i> Buscar Opciones Disponibles
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Información adicional -->
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card border-primary">
                        <div class="card-body text-center">
                            <i class="bi bi-speedometer2 fs-1 text-primary"></i>
                            <h6 class="mt-2">Rápido</h6>
                            <small class="text-muted">Genera horarios en segundos</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-success">
                        <div class="card-body text-center">
                            <i class="bi bi-shield-check fs-1 text-success"></i>
                            <h6 class="mt-2">Sin conflictos</h6>
                            <small class="text-muted">Valida automáticamente</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-info">
                        <div class="card-body text-center">
                            <i class="bi bi-hand-thumbs-up fs-1 text-info"></i>
                            <h6 class="mt-2">Control total</h6>
                            <small class="text-muted">Tú decides qué aprobar</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection