@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning">
                    <h4 class="mb-0">
                        <i class="bi bi-pencil"></i> Editar Gestión Académica
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('gestiones.update', $gestione->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre de la Gestión *</label>
                            <input type="text" 
                                   name="nombre" 
                                   id="nombre" 
                                   class="form-control @error('nombre') is-invalid @enderror" 
                                   value="{{ old('nombre', $gestione->nombre) }}"
                                   required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="fecha_inicio" class="form-label">Fecha de Inicio *</label>
                                <input type="date" 
                                       name="fecha_inicio" 
                                       id="fecha_inicio" 
                                       class="form-control @error('fecha_inicio') is-invalid @enderror" 
                                       value="{{ old('fecha_inicio', $gestione->fecha_inicio->format('Y-m-d')) }}"
                                       required>
                                @error('fecha_inicio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="fecha_fin" class="form-label">Fecha de Fin *</label>
                                <input type="date" 
                                       name="fecha_fin" 
                                       id="fecha_fin" 
                                       class="form-control @error('fecha_fin') is-invalid @enderror" 
                                       value="{{ old('fecha_fin', $gestione->fecha_fin->format('Y-m-d')) }}"
                                       required>
                                @error('fecha_fin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado *</label>
                            <select name="estado" 
                                    id="estado" 
                                    class="form-select @error('estado') is-invalid @enderror" 
                                    required>
                                <option value="Planificada" {{ old('estado', $gestione->estado) == 'Planificada' ? 'selected' : '' }}>
                                    Planificada
                                </option>
                                <option value="Activa" {{ old('estado', $gestione->estado) == 'Activa' ? 'selected' : '' }}>
                                    Activa
                                </option>
                                <option value="Cerrada" {{ old('estado', $gestione->estado) == 'Cerrada' ? 'selected' : '' }}>
                                    Cerrada
                                </option>
                            </select>
                            @error('estado')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if($gestione->estado != 'Activa')
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle"></i>
                                <strong>Importante:</strong> Si marca esta gestión como "Activa", 
                                todas las demás gestiones activas se cambiarán automáticamente a "Planificada".
                            </div>
                        @endif

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('gestiones.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-save"></i> Actualizar Gestión
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection