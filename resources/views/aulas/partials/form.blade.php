<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Código</label>
        <input type="text" name="codigo" class="form-control"
               value="{{ old('codigo', $aula->codigo ?? '') }}" required>
        @error('codigo') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Capacidad</label>
        <input type="number" name="capacidad" class="form-control"
               value="{{ old('capacidad', $aula->capacidad ?? '') }}" required min="1">
        @error('capacidad') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Ubicación</label>
        <input type="text" name="ubicacion" class="form-control"
               value="{{ old('ubicacion', $aula->ubicacion ?? '') }}">
    </div>

    <div class="col-md-6">
        <label class="form-label">Tipo</label>
        <select name="tipo" class="form-select">
            <option value="">Seleccione</option>
            <option value="Teórica" {{ old('tipo', $aula->tipo ?? '') == 'Teórica' ? 'selected' : '' }}>Teórica</option>
            <option value="Laboratorio" {{ old('tipo', $aula->tipo ?? '') == 'Laboratorio' ? 'selected' : '' }}>Laboratorio</option>
            <option value="Auditorio" {{ old('tipo', $aula->tipo ?? '') == 'Auditorio' ? 'selected' : '' }}>Auditorio</option>
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">Estado</label>
        <select name="estado" class="form-select">
            <option value="Disponible" {{ old('estado', $aula->estado ?? '') == 'Disponible' ? 'selected' : '' }}>Disponible</option>
            <option value="Mantenimiento" {{ old('estado', $aula->estado ?? '') == 'Mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
            <option value="Cerrada" {{ old('estado', $aula->estado ?? '') == 'Cerrada' ? 'selected' : '' }}>Cerrada</option>
        </select>
    </div>

    
</div>

<div class="text-center mt-4">
    <button type="submit" class="btn btn-success">
        <i class="bi bi-save"></i> {{ $modo == 'crear' ? 'Guardar' : 'Actualizar' }}
    </button>
    <a href="{{ route('aulas.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left-circle"></i> Volver
    </a>
</div>
