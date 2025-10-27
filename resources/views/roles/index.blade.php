@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4 text-center fw-bold">Gestión de Roles</h2>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <div class="text-end mb-3">
        <a href="{{ route('roles.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nuevo Rol
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $rol)
                    <tr>
                        <td>{{ $rol->id }}</td>
                        <td>{{ $rol->nombre }}</td>
                        <td>{{ $rol->descripcion }}</td>
                        <td>
                            <a href="{{ route('roles.edit', $rol->id) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('roles.destroy', $rol->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar rol?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
