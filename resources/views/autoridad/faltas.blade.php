@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-eye text-danger"></i> Registro de Faltas
            </h2>
            <p class="text-muted mb-0">Ausencias de docentes - Solo lectura</p>
        </div>
        <span class="badge bg-info text-white px-3 py-2">
            <i class="bi bi-lock"></i> Solo lectura
        </span>
    </div>

    <!-- Estadísticas de faltas -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-danger">
                <div class="card-body">
                    <h6 class="text-danger">
                        <i class="bi bi-exclamation-triangle"></i> Faltas del Día
                    </h6>
                    <h2 class="text-danger mb-0">0</h2>
                    <small class="text-muted">{{ date('d/m/Y') }}</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-warning">
                <div class="card-body">
                    <h6 class="text-warning">
                        <i class="bi bi-calendar-x"></i> Faltas de la Semana
                    </h6>
                    <h2 class="text-warning mb-0">0</h2>
                    <small class="text-muted">Últimos 7 días</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-info">
                <div class="card-body">
                    <h6 class="text-info">
                        <i class="bi bi-calendar3"></i> Faltas del Mes
                    </h6>
                    <h2 class="text-info mb-0">0</h2>
                    <small class="text-muted">{{ date('F Y') }}</small>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle"></i>
                <strong>Funcionalidad en desarrollo</strong> - Esta vista estará disponible en el Ciclo 2.
            </div>

            <!-- Filtros -->
            <div class="row mb-3">
                <div class="col-md-3">
                    <input type="date" class="form-control" placeholder="Fecha desde" disabled>
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control" placeholder="Fecha hasta" disabled>
                </div>
                <div class="col-md-3">
                    <select class="form-select" disabled>
                        <option>Seleccionar docente</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-danger" disabled>
                        <i class="bi bi-search"></i> Buscar Faltas
                    </button>
                </div>
            </div>

            <!-- Tabla de faltas -->
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="table-danger">
                        <tr>
                            <th>Fecha</th>
                            <th>Docente</th>
                            <th>Materia</th>
                            <th>Grupo</th>
                            <th>Hora</th>
                            <th>Tipo</th>
                            <th>Justificación</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                <i class="bi bi-check-circle fs-1 d-block mb-2 text-success"></i>
                                No hay faltas registradas
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Ranking de docentes con más faltas -->
            <div class="mt-4">
                <h5 class="mb-3">
                    <i class="bi bi-bar-chart"></i> Docentes con más ausencias
                </h5>
                <div class="alert alert-secondary text-center">
                    <i class="bi bi-info-circle"></i> No hay datos suficientes para generar estadísticas
                </div>
            </div>
        </div>
    </div>
</div>
@endsection