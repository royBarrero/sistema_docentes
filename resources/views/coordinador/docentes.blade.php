@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Gestión de Docentes</h2>
            <p class="text-muted mb-0">Vista del Coordinador - Solo lectura</p>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle fs-3"></i>
                <p class="mb-0 mt-2"><strong>Funcionalidad en desarrollo</strong></p>
                <small class="text-muted">Esta vista estará disponible en el Ciclo 2. Aquí podrás consultar la lista de docentes.</small>
            </div>

            <!-- Placeholder de tabla -->
            <div class="table-responsive mt-4">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>CI</th>
                            <th>Nombre Completo</th>
                            <th>Título</th>
                            <th>Especialidad</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-5">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No hay datos disponibles
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection