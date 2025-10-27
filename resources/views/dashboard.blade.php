@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center fw-bold">Panel Principal</h2>
    <p class="text-center text-muted mb-5">Bienvenido al sistema de gestión docente</p>

    <div class="row g-4 justify-content-center">
        <!-- Tarjeta Roles -->
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-body text-center">
                    <i class="bi bi-people-fill fs-1 text-primary"></i>
                    <h5 class="card-title mt-3">Roles</h5>
                    <p class="card-text text-muted">Gestiona los roles del sistema</p>
                    <a href="{{ route('roles.index') }}" class="btn btn-outline-primary">Ver módulo</a>
                </div>
            </div>
        </div>

        <!-- Tarjeta Docentes -->
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-body text-center">
                    <i class="bi bi-person-badge-fill fs-1 text-success"></i>
                    <h5 class="card-title mt-3">Docentes</h5>
                    <p class="card-text text-muted">Registra y administra docentes</p>
                    <a href="{{ route('docentes.index') }}" class="btn btn-success">Ver módulo</a>
                </div>
            </div>
        </div>

        <!-- Tarjeta Materias -->
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-body text-center">
                    <i class="bi bi-journal-bookmark-fill fs-1 text-warning"></i>
                    <h5 class="card-title mt-3">Materias</h5>
                    <p class="card-text text-muted">Gestiona las materias de cada gestión</p>
                   <a href="{{ route('materias.index') }}" class="btn btn-warning text-dark">Ver módulo</a>
                </div>
            </div>
        </div>

        <!-- Tarjeta Grupos -->
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-body text-center">
                    <i class="bi bi-people fs-1 text-info"></i>
                    <h5 class="card-title mt-3">Grupos</h5>
                    <p class="card-text text-muted">Administra grupos y paralelos</p>
                    <a href="{{ route('grupos.index') }}" class="btn btn-warning text-dark">Ver módulo</a>
                </div>
            </div>
        </div>

        <!-- Tarjeta Aulas -->
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-body text-center">
                    <i class="bi bi-door-open-fill fs-1 text-danger"></i>
                    <h5 class="card-title mt-3">Aulas</h5>
                    <p class="card-text text-muted">Gestiona las aulas de la facultad</p>
                    <a href="{{ route('aulas.index') }}" class="btn btn-warning text-dark">Ver módulo</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
