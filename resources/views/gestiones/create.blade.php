@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-plus-circle"></i> Nueva Gestión Académica
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('gestiones.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre de la Gestión *</label>
                            <input type="text" 
                                   name="nombre" 
                                   id="nombre" 
                                   class="form-control @error('nombre') is-invalid @enderror" 
                                   value="{{ old('nombre') }}"
                                   placeholder="Ej: 2025-I, 2025-II, 2025 Verano"
                                   required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Formato sugerido: AÑO-PERIODO (Ej: 2025-I)</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="fecha_inicio" class="form-label">Fecha de Inicio *</label>
                                <input type="date" 
                                       name="fecha_inicio" 
                                       id="fecha_inicio" 
                                       class="form-control @error('fecha_inicio') is-invalid @enderror" 
                                       value="{{ old('fecha_inicio') }}"
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
                                       value="{{ old('fecha_fin') }}"
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
                                <option value="">Seleccione un estado</option>
                                <option value="Planificada" {{ old('estado') == 'Planificada' ? 'selected' : '' }}>
                                    Planificada
                                </option>
                                <option value="Activa" {{ old('estado') == 'Activa' ? 'selected' : '' }}>
                                    Activa
                                </option>
                                <option value="Cerrada" {{ old('estado') == 'Cerrada' ? 'selected' : '' }}>
                                    Cerrada
                                </option>
                            </select>
                            @error('estado')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle"></i>
                            <strong>Importante:</strong> Si marca esta gestión como "Activa", 
                            todas las demás gestiones activas se cambiarán automáticamente a "Planificada".
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('gestiones.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Guardar Gestión
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection