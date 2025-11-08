@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Asignar Docentes</h2>
            <p class="text-muted mb-0">Asignación de docentes a materias y grupos</p>
        </div>
        <button class="btn btn-primary" disabled>
            <i class="bi bi-plus-circle"></i> Nueva Asignación
        </button>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="alert alert-warning text-center">
                <i class="bi bi-exclamation-triangle fs-3"></i>
                <p class="mb-0 mt-2"><strong>Módulo en desarrollo - Ciclo 2</strong></p>
                <small class="text-muted">Aquí podrás asignar docentes a materias y grupos para cada gestión académica.</small>
            </div>

            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <i class="bi bi-person-badge fs-1 text-primary"></i>
                            <h5 class="mt-3">Seleccionar Docente</h5>
                            <p class="text-muted small">Elige el docente a asignar</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <i class="bi bi-journal-bookmark fs-1 text-warning"></i>
                            <h5 class="mt-3">Seleccionar Materia</h5>
                            <p class="text-muted small">Elige la materia</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <i class="bi bi-people fs-1 text-info"></i>
                            <h5 class="mt-3">Seleccionar Grupo</h5>
                            <p class="text-muted small">Elige el grupo</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection