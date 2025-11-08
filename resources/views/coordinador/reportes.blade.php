@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Reportes Parciales</h2>
            <p class="text-muted mb-0">Generación de reportes operativos</p>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="alert alert-warning text-center">
                <i class="bi bi-exclamation-triangle fs-3"></i>
                <p class="mb-0 mt-2"><strong>Módulo en desarrollo - Ciclo 2</strong></p>
                <small class="text-muted">Aquí podrás generar reportes parciales en PDF y Excel.</small>
            </div>

            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <i class="bi bi-file-earmark-pdf fs-1 text-danger"></i>
                            <h5 class="mt-3">Reporte de Asignaciones</h5>
                            <button class="btn btn-sm btn-outline-danger mt-2" disabled>
                                <i class="bi bi-download"></i> Descargar PDF
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <i class="bi bi-file-earmark-excel fs-1 text-success"></i>
                            <h5 class="mt-3">Reporte de Asistencias</h5>
                            <button class="btn btn-sm btn-outline-success mt-2" disabled>
                                <i class="bi bi-download"></i> Descargar Excel
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <i class="bi bi-file-earmark-bar-graph fs-1 text-primary"></i>
                            <h5 class="mt-3">Reporte de Horarios</h5>
                            <button class="btn btn-sm btn-outline-primary mt-2" disabled>
                                <i class="bi bi-download"></i> Descargar PDF
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection