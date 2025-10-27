@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4 text-center fw-bold">Gestión de Materias</h2>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <div class="text-end mb-3">
        <a href="{{ route('materias.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nueva Materia
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Nivel</th>
                    <th>Carrera</th>
                    <th>Gestión</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($materias as $materia)
                    <tr>
                        <td>{{ $materia->codigo }}</td>
                        <td>{{ $materia->nombre }}</td>
                        <td>{{ $materia->nivel }}</td>
                        <td>{{ $materia->carrera }}</td>
                        <td>{{ $materia->gestion->nombre ?? '—' }}</td>
                        <td>
                            <span class="badge {{ $materia->estado == 'Activa' ? 'bg-success' : 'bg-secondary' }}">
                                {{ $materia->estado }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('materias.edit', $materia->id) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('materias.destroy', $materia->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar materia?')">
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
        {{ $materias->links() }}
    </div>
</div>
@endsection
