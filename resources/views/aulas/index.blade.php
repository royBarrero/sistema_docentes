@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4 text-center fw-bold">Gestión de Aulas</h2>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <div class="text-end mb-3">
        <a href="{{ route('aulas.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nueva Aula
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th>Código</th>
                    <th>Capacidad</th>
                    <th>Ubicación</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                   
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($aulas as $aula)
                    <tr>
                        <td>{{ $aula->codigo }}</td>
                        <td>{{ $aula->capacidad }}</td>
                        <td>{{ $aula->ubicacion }}</td>
                        <td>{{ $aula->tipo }}</td>
                        <td>
                            <span class="badge 
                                @if($aula->estado == 'Disponible') bg-success 
                                @elseif($aula->estado == 'Mantenimiento') bg-warning 
                                @else bg-secondary @endif">
                                {{ $aula->estado }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('aulas.edit', $aula->id) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('aulas.destroy', $aula->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar aula?')">
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
        {{ $aulas->links() }}
    </div>
</div>
@endsection
