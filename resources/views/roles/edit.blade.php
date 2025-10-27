@extends('layouts.app')

@section('content')
<div class="container col-md-6">
    <h3 class="fw-bold text-center mb-4">Editar Rol</h3>

    <form action="{{ route('roles.update', $role->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label class="form-label">Nombre del Rol</label>
            <input type="text" name="nombre" class="form-control" value="{{ $role->nombre }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control">{{ $role->descripcion }}</textarea>
        </div>
        <div class="text-center mt-4">
    <button type="submit" class="btn btn-success">
        <i class="bi bi-pencil-square"></i> Actualizar
    </button>
    <a href="{{ route('roles.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left-circle"></i> Volver
    </a>
</div>

    </form>
</div>
@endsection
