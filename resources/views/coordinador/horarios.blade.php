@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Generar Horarios</h2>
            <p class="text-muted mb-0">Generación automática de horarios y validación de conflictos</p>
        </div>
        <button class="btn btn-success" disabled>
            <i class="bi bi-calendar-plus"></i> Generar Horario
        </button>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="alert alert-warning text-center">
                <i class="bi bi-exclamation-triangle fs-3"></i>
                <p class="mb-0 mt-2"><strong>Módulo en desarrollo - Ciclo 2</strong></p>
                <small class="text-muted">Aquí podrás generar horarios automáticamente y validar conflictos.</small>
            </div>

            <!-- Placeholder de horario semanal -->
            <div class="table-responsive mt-4">
                <table class="table table-bordered">
                    <thead class="table-primary">
                        <tr>
                            <th>Hora</th>
                            <th>Lunes</th>
                            <th>Martes</th>
                            <th>Miércoles</th>
                            <th>Jueves</th>
                            <th>Viernes</th>
                            <th>Sábado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($i = 7; $i <= 20; $i++)
                            <tr>
                                <td class="fw-bold">{{ sprintf('%02d:00', $i) }} - {{ sprintf('%02d:00', $i+1) }}</td>
                                <td class="text-center text-muted">-</td>
                                <td class="text-center text-muted">-</td>
                                <td class="text-center text-muted">-</td>
                                <td class="text-center text-muted">-</td>
                                <td class="text-center text-muted">-</td>
                                <td class="text-center text-muted">-</td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection