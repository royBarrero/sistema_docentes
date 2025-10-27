<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Código</label>
        <input type="text" name="codigo" class="form-control"
               value="{{ old('codigo', $materia->codigo ?? '') }}" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control"
               value="{{ old('nombre', $materia->nombre ?? '') }}" required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Nivel</label>
        <input type="text" name="nivel" class="form-control"
               value="{{ old('nivel', $materia->nivel ?? '') }}">
    </div>

    <div class="col-md-6">
        <label class="form-label">Carrera</label>
        <input type="text" name="carrera" class="form-control"
               value="{{ old('carrera', $materia->carrera ?? '') }}">
    </div>

    <div class="col-md-6">
        <label class="form-label">Gestión Académica</label>
        <select name="gestion_id" class="form-select" required>
            <option value="">Seleccione una gestión</option>
            @foreach($gestiones as $id => $nombre)
                <option value="{{ $id }}" {{ old('gestion_id', $materia->gestion_id ?? '') == $id ? 'selected' : '' }}>
                    {{ $nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-6">
        <label class="form-label">Estado</label>
        <select name="estado" class="form-select">
            <option value="Activa" {{ (old('estado', $materia->estado ?? '') == 'Activa') ? 'selected' : '' }}>Activa</option>
            <option value="Inactiva" {{ (old('estado', $materia->estado ?? '') == 'Inactiva') ? 'selected' : '' }}>Inactiva</option>
        </select>
    </div>
</div>

<div class="text-center mt-4">
    <button type="submit" class="btn btn-success">
        <i class="bi bi-save"></i> {{ $modo == 'crear' ? 'Guardar' : 'Actualizar' }}
    </button>
    <a href="{{ route('materias.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left-circle"></i> Volver
    </a>
</div>
