@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4 text-center fw-bold">Gestión de Grupos</h2>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <div class="text-end mb-3">
        <a href="{{ route('grupos.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nuevo Grupo
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th>Materia</th>
                    <th>Nombre del Grupo</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupos as $grupo)
                    <tr>
                        <td>{{ $grupo->materia->nombre ?? '—' }}</td>
                        <td>{{ $grupo->nombre }}</td>
                        <td>
                            <span class="badge {{ $grupo->estado == 'Activo' ? 'bg-success' : 'bg-secondary' }}">
                                {{ $grupo->estado }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('grupos.edit', $grupo->id) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('grupos.destroy', $grupo->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar grupo?')">
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
        {{ $grupos->links() }}
    </div>
</div>
@endsection
