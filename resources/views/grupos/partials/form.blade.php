<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Materia</label>
        <select name="materia_id" class="form-select" required>
            <option value="">Seleccione una materia</option>
            @foreach($materias as $id => $nombre)
                <option value="{{ $id }}" {{ old('materia_id', $grupo->materia_id ?? '') == $id ? 'selected' : '' }}>
                    {{ $nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">Nombre del Grupo</label>
        <input type="text" name="nombre" class="form-control"
               value="{{ old('nombre', $grupo->nombre ?? '') }}" required>
    </div>
        @error('nombre')
    <div class="text-danger small mt-1">{{ $message }}</div>
@enderror
    <div class="col-md-6">
        <label class="form-label">Estado</label>
        <select name="estado" class="form-select">
            <option value="Activo" {{ (old('estado', $grupo->estado ?? '') == 'Activo') ? 'selected' : '' }}>Activo</option>
            <option value="Inactivo" {{ (old('estado', $grupo->estado ?? '') == 'Inactivo') ? 'selected' : '' }}>Inactivo</option>
        </select>
    </div>
</div>

<div class="text-center mt-4">
    <button type="submit" class="btn btn-success">
        <i class="bi bi-save"></i> {{ $modo == 'crear' ? 'Guardar' : 'Actualizar' }}
    </button>
    <a href="{{ route('grupos.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left-circle"></i> Volver
    </a>
</div>
