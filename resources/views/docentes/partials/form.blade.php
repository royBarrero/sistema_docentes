<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">CI</label>
        <input type="text" name="ci" class="form-control" value="{{ old('ci', $docente->ci ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control"
             value="{{ old('nombre', $docente->nombre ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Apellidos</label>
        <input type="text" name="apellidos" class="form-control"
         value="{{ old('apellidos', $docente->apellidos ?? '') }}" required>
    </div>
    
    <div class="col-md-6">
        <label class="form-label">Correo Institucional</label>
        <input type="email" name="correo_institucional" class="form-control" value="{{ old('correo_institucional', $docente->correo_institucional ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Título</label>
        <input type="text" name="titulo" class="form-control" value="{{ old('titulo', $docente->titulo ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Especialidad</label>
        <input type="text" name="especialidad" class="form-control" value="{{ old('especialidad', $docente->especialidad ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Teléfono</label>
        <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $docente->telefono ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Estado</label>
        <select name="estado" class="form-select">
            <option value="Activo" {{ (old('estado', $docente->estado ?? '') == 'Activo') ? 'selected' : '' }}>Activo</option>
            <option value="Inactivo" {{ (old('estado', $docente->estado ?? '') == 'Inactivo') ? 'selected' : '' }}>Inactivo</option>
        </select>
    </div>
</div>

<div class="text-center mt-4">
    <button type="submit" class="btn btn-success">
        <i class="bi bi-save"></i> {{ $modo == 'crear' ? 'Guardar' : 'Actualizar' }}
    </button>
    <a href="{{ route('docentes.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left-circle"></i> Volver
    </a>
</div>
