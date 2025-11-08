@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Control de Asistencia</h2>
            <p class="text-muted mb-0">Registro y control de asistencia docente</p>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="alert alert-warning text-center">
                <i class="bi bi-exclamation-triangle fs-3"></i>
                <p class="mb-0 mt-2"><strong>Módulo en desarrollo - Ciclo 2</strong></p>
                <small class="text-muted">Aquí podrás registrar y controlar la asistencia de los docentes.</small>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h5><i class="bi bi-calendar-check text-success"></i> Asistencias del día</h5>
                            <p class="text-muted">{{ date('d/m/Y') }}</p>
                            <h2 class="text-success">0</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h5><i class="bi bi-exclamation-triangle text-danger"></i> Faltas del día</h5>
                            <p class="text-muted">{{ date('d/m/Y') }}</p>
                            <h2 class="text-danger">0</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection