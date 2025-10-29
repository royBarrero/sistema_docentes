@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4 text-center fw-bold">Gestión de Usuarios</h2>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <div class="text-end mb-3">
        <a href="{{ route('usuarios.create') }}" class="btn btn-primary">
            <i class="bi bi-person-plus"></i> Nuevo Usuario
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Nombre Completo</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->id }}</td>
                        <td>{{ $usuario->nombre_completo }}</td>
                        <td>{{ $usuario->email }}</td>
                        <td>{{ $usuario->telefono ?? 'N/A' }}</td>
                        <td>
                            <span class="badge bg-info">
                                {{ $usuario->rol->nombre ?? 'Sin rol' }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $usuario->estado == 'Activo' ? 'bg-success' : ($usuario->estado == 'Inactivo' ? 'bg-secondary' : 'bg-warning') }}">
                                {{ $usuario->estado }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar usuario?')">
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
        {{ $usuarios->links() }}
    </div>
</div>
@endsection