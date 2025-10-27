@extends('layouts.app')

@section('content')
<div class="container col-md-6">
    <h3 class="fw-bold text-center mb-4">Nuevo Rol</h3>

    <form action="{{ route('roles.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nombre del Rol</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control"></textarea>
        </div>
       <div class="text-center mt-4">
    <button type="submit" class="btn btn-success">
        <i class="bi bi-save"></i> Guardar
    </button>
    <a href="{{ route('roles.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left-circle"></i> Volver
    </a>
</div>

    </form>
</div>
@endsection
