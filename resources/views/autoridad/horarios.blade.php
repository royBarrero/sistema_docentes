@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-eye text-primary"></i> Horarios Académicos
            </h2>
            <p class="text-muted mb-0">Consulta de horarios - Solo lectura</p>
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
                    <select class="form-select" disabled>
                        <option>Seleccionar docente</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" disabled>
                        <option>Seleccionar día</option>
                        <option>Lunes</option>
                        <option>Martes</option>
                        <option>Miércoles</option>
                        <option>Jueves</option>
                        <option>Viernes</option>
                        <option>Sábado</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary" disabled>
                        <i class="bi bi-search"></i> Buscar
                    </button>
                </div>
            </div>

            <!-- Horario semanal -->
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead class="table-primary">
                        <tr>
                            <th style="width: 100px;">Hora</th>
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
                                <td class="fw-bold text-center">{{ sprintf('%02d:00', $i) }}</td>
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