@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-calendar3"></i> Gestiones Académicas
            </h2>
            <p class="text-muted mb-0">Administra los períodos académicos</p>
        </div>
        <a href="{{ route('gestiones.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nueva Gestión
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nombre</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th>Duración</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($gestiones as $gestion)
                            <tr>
                                <td>
                                    <strong>{{ $gestion->nombre }}</strong>
                                    @if($gestion->estado == 'Activa')
                                        <span class="badge bg-success ms-2">
                                            <i class="bi bi-star-fill"></i> Activa
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $gestion->fecha_inicio->format('d/m/Y') }}</td>
                                <td>{{ $gestion->fecha_fin->format('d/m/Y') }}</td>
                                <td>
                                    {{ $gestion->fecha_inicio->diffInDays($gestion->fecha_fin) }} días
                                </td>
                                <td>
                                    @if($gestion->estado == 'Activa')
                                        <span class="badge bg-success">Activa</span>
                                    @elseif($gestion->estado == 'Planificada')
                                        <span class="badge bg-info">Planificada</span>
                                    @else
                                        <span class="badge bg-secondary">Cerrada</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        @if($gestion->estado != 'Activa')
                                            <form action="{{ route('gestiones.activar', $gestion->id) }}" 
                                                  method="POST" 
                                                  class="d-inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="btn btn-sm btn-success" 
                                                        title="Activar"
                                                        onclick="return confirm('¿Activar esta gestión académica?')">
                                                    <i class="bi bi-check-circle"></i>
                                                </button>
                                            </form>
                                        @endif

                                        <a href="{{ route('gestiones.edit', $gestion->id) }}" 
                                           class="btn btn-sm btn-warning"
                                           title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form action="{{ route('gestiones.destroy', $gestion->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('¿Eliminar esta gestión académica?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-danger"
                                                    title="Eliminar">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    No hay gestiones académicas registradas
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-3">
                {{ $gestiones->links() }}
            </div>
        </div>
    </div>

    <!-- Información adicional -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i>
                <strong>Nota:</strong> Solo puede haber una gestión académica activa a la vez. 
                Al activar una nueva gestión, la anterior se marcará como "Planificada" automáticamente.
            </div>
        </div>
    </div>
</div>
@endsection