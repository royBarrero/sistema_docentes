@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4 text-center fw-bold">Gestión de Docentes</h2>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <div class="text-end mb-3">
        <a href="{{ route('docentes.create') }}" class="btn btn-primary">
            <i class="bi bi-person-plus"></i> Nuevo Docente
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th>CI</th>
                    <th>Nombre Completo</th>
                    <th>Correo</th>
                    <th>Título</th>
                    <th>Especialidad</th>
                    <th>Teléfono</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($docentes as $docente)
                    <tr>
                        <td>{{ $docente->ci }}</td>
                        <td>{{ $docente->nombre }} {{ $docente->apellidos }}</td>
                        <td>{{ $docente->usuario->email ?? $docente->correo_institucional }}</td>
                        <td>{{ $docente->titulo }}</td>
                        <td>{{ $docente->especialidad }}</td>
                        <td>{{ $docente->telefono }}</td>
                        <td>
                            <span class="badge {{ $docente->estado == 'Activo' ? 'bg-success' : 'bg-secondary' }}">
                                {{ $docente->estado }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('docentes.edit', $docente->id) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('docentes.destroy', $docente->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar docente?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $docentes->links() }}
    </div>
</div>
@endsection
