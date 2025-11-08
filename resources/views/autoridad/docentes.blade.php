@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-eye text-primary"></i> Lista de Docentes
            </h2>
            <p class="text-muted mb-0">Consulta de información - Solo lectura</p>
        </div>
        <span class="badge bg-info text-white px-3 py-2">
            <i class="bi bi-lock"></i> Solo lectura
        </span>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i>
                <strong>Funcionalidad en desarrollo</strong> - Esta vista estará disponible en el Ciclo 2.
            </div>

            <!-- Filtros -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Buscar por nombre..." disabled>
                </div>
                <div class="col-md-3">
                    <select class="form-select" disabled>
                        <option>Filtrar por estado</option>
                        <option>Activo</option>
                        <option>Inactivo</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary" disabled>
                        <i class="bi bi-search"></i> Buscar
                    </button>
                </div>
            </div>

            <!-- Tabla -->
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>CI</th>
                            <th>Nombre Completo</th>
                            <th>Título</th>
                            <th>Especialidad</th>
                            <th>Teléfono</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No hay datos para mostrar
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection