@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-warning">
                    <h4 class="mb-0">
                        <i class="bi bi-pencil"></i> Editar Horario
                    </h4>
                </div>
                <div class="card-body">
                   @if(session('error_conflictos'))
    <div class="alert alert-danger">
        <i class="bi bi-exclamation-triangle"></i>
        <strong>¡Conflictos detectados!</strong>
        <ul class="mb-0 mt-2">
            @foreach(session('error_conflictos') as $conflicto)
                <li>{{ $conflicto }}</li>
            @endforeach
        </ul>
    </div>
@endif

                    <form action="{{ route('horarios.update', $horario->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Docente -->
                            <div class="col-md-6 mb-3">
                                <label for="docente_id" class="form-label">Docente *</label>
                                <select name="docente_id" 
                                        id="docente_id" 
                                        class="form-select @error('docente_id') is-invalid @enderror" 
                                        required>
                                    <option value="">Seleccione un docente</option>
                                    @foreach($docentes as $docente)
                                        <option value="{{ $docente->id }}" 
                                                {{ old('docente_id', $horario->docente_id) == $docente->id ? 'selected' : '' }}>
                                            {{ $docente->usuario->nombre_completo ?? 'Sin nombre' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('docente_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Grupo -->
                            <div class="col-md-6 mb-3">
                                <label for="grupo_id" class="form-label">Materia - Grupo *</label>
                                <select name="grupo_id" 
                                        id="grupo_id" 
                                        class="form-select @error('grupo_id') is-invalid @enderror" 
                                        required>
                                    <option value="">Seleccione materia y grupo</option>
                                    @foreach($grupos as $grupo)
                                        <option value="{{ $grupo->id }}" 
                                                {{ old('grupo_id', $horario->grupo_id) == $grupo->id ? 'selected' : '' }}>
                                            {{ $grupo->materia->nombre ?? 'N/A' }} - Grupo {{ $grupo->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('grupo_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Aula -->
                            <div class="col-md-6 mb-3">
                                <label for="aula_id" class="form-label">Aula *</label>
                                <select name="aula_id" 
                                        id="aula_id" 
                                        class="form-select @error('aula_id') is-invalid @enderror" 
                                        required>
                                    <option value="">Seleccione un aula</option>
                                    @foreach($aulas as $aula)
                                        <option value="{{ $aula->id }}" 
                                                {{ old('aula_id', $horario->aula_id) == $aula->id ? 'selected' : '' }}>
                                            {{ $aula->codigo }} - Cap: {{ $aula->capacidad }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('aula_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Día -->
                            <div class="col-md-6 mb-3">
                                <label for="dia_semana" class="form-label">Día *</label>
                                <select name="dia_semana" 
                                        id="dia_semana" 
                                        class="form-select @error('dia_semana') is-invalid @enderror" 
                                        required>
                                    <option value="">Seleccione un día</option>
                                    @foreach($dias as $numero => $nombre)
                                        <option value="{{ $numero }}" 
                                                {{ old('dia_semana', $horario->dia_semana) == $numero ? 'selected' : '' }}>
                                            {{ $nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('dia_semana')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Hora inicio -->
                            <div class="col-md-6 mb-3">
                                <label for="hora_inicio" class="form-label">Hora Inicio *</label>
                                <input type="time" 
                                       name="hora_inicio" 
                                       id="hora_inicio" 
                                       class="form-control @error('hora_inicio') is-invalid @enderror" 
                                       value="{{ old('hora_inicio', \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i')) }}"
                                       required>
                                @error('hora_inicio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Hora fin -->
                            <div class="col-md-6 mb-3">
                                <label for="hora_fin" class="form-label">Hora Fin *</label>
                                <input type="time" 
                                       name="hora_fin" 
                                       id="hora_fin" 
                                       class="form-control @error('hora_fin') is-invalid @enderror" 
                                       value="{{ old('hora_fin', \Carbon\Carbon::parse($horario->hora_fin)->format('H:i')) }}"
                                       required>
                                @error('hora_fin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('horarios.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-save"></i> Actualizar Horario
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection