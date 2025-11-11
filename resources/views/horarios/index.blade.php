@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">
                    <i class="bi bi-calendar3"></i> Gestión de Horarios
                </h2>
                <p class="text-muted mb-0">
                    Gestión Académica: <strong>{{ $gestionActiva->nombre }}</strong>
                </p>
            </div>
            <a href="{{ route('horarios.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nuevo Horario
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Filtros -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('horarios.index') }}" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Día</label>
                        <select name="dia" class="form-select">
                            <option value="">Todos los días</option>
                            <option value="1" {{ request('dia') == 1 ? 'selected' : '' }}>Lunes</option>
                            <option value="2" {{ request('dia') == 2 ? 'selected' : '' }}>Martes</option>
                            <option value="3" {{ request('dia') == 3 ? 'selected' : '' }}>Miércoles</option>
                            <option value="4" {{ request('dia') == 4 ? 'selected' : '' }}>Jueves</option>
                            <option value="5" {{ request('dia') == 5 ? 'selected' : '' }}>Viernes</option>
                            <option value="6" {{ request('dia') == 6 ? 'selected' : '' }}>Sábado</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Docente</label>
                        <input type="text" name="docente" class="form-control" placeholder="Buscar docente..."
                            value="{{ request('docente') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Aula</label>
                        <input type="text" name="aula" class="form-control" placeholder="Buscar aula..."
                            value="{{ request('aula') }}">
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="bi bi-search"></i> Buscar
                        </button>
                        <a href="{{ route('horarios.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Limpiar
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabla de horarios -->
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Día</th>
                                <th>Hora</th>
                                <th>Docente</th>
                                <th>Materia - Grupo</th>
                                <th>Aula</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($horarios as $horario)
                                <tr>
                                    <td>
                                        <span class="badge bg-primary">{{ $horario->dia_nombre }}</span>
                                    </td>
                                    <td>
                                        <strong>{{ \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') }}</strong>
                                        -
                                        {{ \Carbon\Carbon::parse($horario->hora_fin)->format('H:i') }}
                                    </td>
                                    <td>
                                        <i class="bi bi-person-badge text-primary"></i>
                                        {{ $horario->docente->usuario->nombre_completo ?? 'Sin docente' }}
                                    </td>
                                    <td>
                                        <strong>{{ $horario->grupo->materia->nombre ?? 'N/A' }}</strong>
                                        <br>
                                        <small class="text-muted">Grupo: {{ $horario->grupo->nombre ?? 'N/A' }}</small>
                                    </td>
                                    <td>
                                        <i class="bi bi-door-open text-success"></i>
                                        {{ $horario->aula->codigo ?? 'N/A' }}
                                        <br>
                                        <small class="text-muted">Cap: {{ $horario->aula->capacidad ?? 'N/A' }}</small>
                                    </td>
                                    <td>
                                        <span
                                            class="badge {{ $horario->estado == 'Activo' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $horario->estado }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('horarios.edit', $horario->id) }}"
                                                class="btn btn-sm btn-warning" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('horarios.destroy', $horario->id) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('¿Eliminar este horario?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-5">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        No hay horarios registrados para esta gestión académica
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $horarios->links() }}
                </div>
            </div>
        </div>

       
    </div>
@endsection
