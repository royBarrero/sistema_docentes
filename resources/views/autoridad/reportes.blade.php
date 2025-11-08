@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-file-earmark-bar-graph text-primary"></i> Reportes Completos
            </h2>
            <p class="text-muted mb-0">Generación de reportes institucionales</p>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i>
                <strong>Funcionalidad en desarrollo</strong> - Este módulo estará disponible en el Ciclo 2.
            </div>

            <!-- Tipos de reportes -->
            <div class="row g-4 mt-3">
                <!-- Reporte de Docentes -->
                <div class="col-md-6">
                    <div class="card border-primary">
                        <div class="card-header bg-primary text-white">
                            <i class="bi bi-person-badge"></i> Reporte de Docentes
                        </div>
                        <div class="card-body">
                            <p class="card-text">Listado completo de docentes con su información académica.</p>
                            <div class="d-grid gap-2">
                                <button class="btn btn-outline-danger" disabled>
                                    <i class="bi bi-file-earmark-pdf"></i> Descargar PDF
                                </button>
                                <button class="btn btn-outline-success" disabled>
                                    <i class="bi bi-file-earmark-excel"></i> Descargar Excel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reporte de Asistencias -->
                <div class="col-md-6">
                    <div class="card border-success">
                        <div class="card-header bg-success text-white">
                            <i class="bi bi-clipboard-check"></i> Reporte de Asistencias
                        </div>
                        <div class="card-body">
                            <p class="card-text">Registro completo de asistencias por docente y período.</p>
                            <div class="d-grid gap-2">
                                <button class="btn btn-outline-danger" disabled>
                                    <i class="bi bi-file-earmark-pdf"></i> Descargar PDF
                                </button>
                                <button class="btn btn-outline-success" disabled>
                                    <i class="bi bi-file-earmark-excel"></i> Descargar Excel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reporte de Faltas -->
                <div class="col-md-6">
                    <div class="card border-danger">
                        <div class="card-header bg-danger text-white">
                            <i class="bi bi-exclamation-triangle"></i> Reporte de Faltas
                        </div>
                        <div class="card-body">
                            <p class="card-text">Detalle de ausencias y faltas por docente.</p>
                            <div class="d-grid gap-2">
                                <button class="btn btn-outline-danger" disabled>
                                    <i class="bi bi-file-earmark-pdf"></i> Descargar PDF
                                </button>
                                <button class="btn btn-outline-success" disabled>
                                    <i class="bi bi-file-earmark-excel"></i> Descargar Excel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reporte de Horarios -->
                <div class="col-md-6">
                    <div class="card border-info">
                        <div class="card-header bg-info text-white">
                            <i class="bi bi-calendar3"></i> Reporte de Horarios
                        </div>
                        <div class="card-body">
                            <p class="card-text">Horarios académicos completos por docente, grupo o aula.</p>
                            <div class="d-grid gap-2">
                                <button class="btn btn-outline-danger" disabled>
                                    <i class="bi bi-file-earmark-pdf"></i> Descargar PDF
                                </button>
                                <button class="btn btn-outline-success" disabled>
                                    <i class="bi bi-file-earmark-excel"></i> Descargar Excel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filtros de reportes -->
            <div class="mt-5">
                <h5 class="mb-3">
                    <i class="bi bi-funnel"></i> Filtros de Reportes
                </h5>
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">Fecha desde</label>
                        <input type="date" class="form-control" disabled>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Fecha hasta</label>
                        <input type="date" class="form-control" disabled>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Docente</label>
                        <select class="form-select" disabled>
                            <option>Todos los docentes</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection