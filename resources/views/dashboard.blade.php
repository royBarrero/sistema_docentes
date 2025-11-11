@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4 text-center fw-bold">Panel Principal</h2>
        <p class="text-center text-muted mb-5">Bienvenido al sistema de gestión docente</p>

        {{-- Dashboard para Administrador --}}
        @if (auth()->user()->rol->nombre == 'Administrador')
            {{-- 📦 Paquete 1: Autenticación y Seguridad --}}
            <div class="mb-5">
                <h4 class="mb-3 text-primary">
                    <i class="bi bi-shield-lock"></i> Autenticación y Seguridad
                </h4>
                <div class="row g-4">
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="card shadow-sm h-100 border-0 hover-card">
                            <div class="card-body text-center">
                                <i class="bi bi-person-circle fs-1 text-secondary"></i>
                                <h5 class="card-title mt-3">Usuarios</h5>
                                <p class="card-text text-muted small">Administra usuarios del sistema</p>
                                <a href="{{ route('usuarios.index') }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-arrow-right-circle"></i> Acceder
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="card shadow-sm h-100 border-0 hover-card">
                            <div class="card-body text-center">
                                <i class="bi bi-people-fill fs-1 text-primary"></i>
                                <h5 class="card-title mt-3">Roles</h5>
                                <p class="card-text text-muted small">Gestiona los roles del sistema</p>
                                <a href="{{ route('roles.index') }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-arrow-right-circle"></i> Acceder
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 📦 Paquete 2: Gestión Académica --}}
            <div class="mb-5">
                <h4 class="mb-3 text-success">
                    <i class="bi bi-book"></i> Gestión Académica
                </h4>
                <div class="row g-4">
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="card shadow-sm h-100 border-0 hover-card">
                            <div class="card-body text-center">
                                <i class="bi bi-person-badge-fill fs-1 text-success"></i>
                                <h5 class="card-title mt-3">Docentes</h5>
                                <p class="card-text text-muted small">Registra y administra docentes</p>
                                <a href="{{ route('docentes.index') }}" class="btn btn-sm btn-outline-success">
                                    <i class="bi bi-arrow-right-circle"></i> Acceder
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="card shadow-sm h-100 border-0 hover-card">
                            <div class="card-body text-center">
                                <i class="bi bi-journal-bookmark-fill fs-1 text-warning"></i>
                                <h5 class="card-title mt-3">Materias</h5>
                                <p class="card-text text-muted small">Gestiona las materias de cada gestión</p>
                                <a href="{{ route('materias.index') }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-arrow-right-circle"></i> Acceder
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="card shadow-sm h-100 border-0 hover-card">
                            <div class="card-body text-center">
                                <i class="bi bi-people fs-1 text-info"></i>
                                <h5 class="card-title mt-3">Grupos</h5>
                                <p class="card-text text-muted small">Administra grupos y paralelos</p>
                                <a href="{{ route('grupos.index') }}" class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-arrow-right-circle"></i> Acceder
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="card shadow-sm h-100 border-0 hover-card">
                            <div class="card-body text-center">
                                <i class="bi bi-door-open-fill fs-1 text-danger"></i>
                                <h5 class="card-title mt-3">Aulas</h5>
                                <p class="card-text text-muted small">Gestiona las aulas de la facultad</p>
                                <a href="{{ route('aulas.index') }}" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-arrow-right-circle"></i> Acceder
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 📦 Paquete 3: Asignación Académica --}}
            <div class="mb-5">
                <h4 class="mb-3 text-dark">
                    <i class="bi bi-calendar-check"></i> Asignación Académica
                </h4>
                <div class="row g-4">
                    <!-- Tarjeta Gestiones Académicas -->
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="card shadow-sm h-100 border-0 hover-card">
                            <div class="card-body text-center">
                                <i class="bi bi-calendar3 fs-1 text-primary"></i>
                                <h5 class="card-title mt-3">Gestiones Académicas</h5>
                                <p class="card-text text-muted small">Administrar períodos académicos</p>
                                <a href="{{ route('gestiones.index') }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-arrow-right-circle"></i> Acceder
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta Horarios -->
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="card shadow-sm h-100 border-0 hover-card">
                            <div class="card-body text-center">
                                <i class="bi bi-clock fs-1 text-success"></i>
                                <h5 class="card-title mt-3">Horarios</h5>
                                <p class="card-text text-muted small">Gestionar horarios de clases</p>
                                <a href="{{ route('horarios.index') }}" class="btn btn-sm btn-outline-success">
                                    <i class="bi bi-arrow-right-circle"></i> Acceder
                                </a>
                            </div>
                        </div>
                    </div>
                

            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card shadow-sm h-100 border-0 hover-card bg-light">
                    <div class="card-body text-center">
                        <i class="bi bi-calendar3 fs-1 text-dark"></i>
                        <h5 class="card-title mt-3">Generar Horarios</h5>
                        <p class="card-text text-muted small">Crear horarios automáticamente</p>
                        <button class="btn btn-sm btn-secondary" disabled>
                            <i class="bi bi-hourglass-split"></i> Próximamente
                        </button>
                    </div>
                </div>
            </div>

       {{-- 📦 Paquete 5: Reportes --}}
<div class="mb-5">
    <h4 class="mb-3 text-info">
        <i class="bi bi-file-earmark-bar-graph"></i> Reportes
    </h4>
    <div class="row g-4">
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card shadow-sm h-100 border-0 hover-card bg-light">
                <div class="card-body text-center">
                    <i class="bi bi-file-earmark-pdf fs-1 text-info"></i>
                    <h5 class="card-title mt-3">Generar Reportes</h5>
                    <p class="card-text text-muted small">Reportes en PDF y Excel</p>
                    <button class="btn btn-sm btn-secondary" disabled>
                        <i class="bi bi-hourglass-split"></i> Próximamente
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endif 

    {{-- Dashboard para Coordinador --}}
    @if (auth()->user()->rol->nombre == 'Coordinador')
        {{-- 📦 Gestión Académica --}}
        <div class="mb-5">
            <h4 class="mb-3 text-success">
                <i class="bi bi-book"></i> Gestión Académica
            </h4>
            <div class="row g-4">
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card shadow-sm h-100 border-0 hover-card">
                        <div class="card-body text-center">
                            <i class="bi bi-person-badge fs-1 text-success"></i>
                            <h5 class="card-title mt-3">Docentes</h5>
                            <p class="card-text text-muted small">Ver docentes</p>
                            <a href="{{ route('coordinador.docentes') }}" class="btn btn-sm btn-outline-success">
                                <i class="bi bi-eye"></i> Ver
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card shadow-sm h-100 border-0 hover-card">
                        <div class="card-body text-center">
                            <i class="bi bi-journal-bookmark fs-1 text-warning"></i>
                            <h5 class="card-title mt-3">Materias</h5>
                            <p class="card-text text-muted small">Ver materias</p>
                            <a href="{{ route('coordinador.materias') }}" class="btn btn-sm btn-outline-warning">
                                <i class="bi bi-eye"></i> Ver
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card shadow-sm h-100 border-0 hover-card">
                        <div class="card-body text-center">
                            <i class="bi bi-people fs-1 text-info"></i>
                            <h5 class="card-title mt-3">Grupos</h5>
                            <p class="card-text text-muted small">Ver grupos</p>
                            <a href="{{ route('coordinador.grupos') }}" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-eye"></i> Ver
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card shadow-sm h-100 border-0 hover-card">
                        <div class="card-body text-center">
                            <i class="bi bi-door-open fs-1 text-danger"></i>
                            <h5 class="card-title mt-3">Aulas</h5>
                            <p class="card-text text-muted small">Ver aulas</p>
                            <a href="{{ route('coordinador.aulas') }}" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-eye"></i> Ver
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 📦 Asignación Académica para Coordinador --}}
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="coordAssignDropdown" role="button"
                data-bs-toggle="dropdown">
                <i class="bi bi-calendar-check"></i> Asignaciones
            </a>
          
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card shadow-sm h-100 border-0 hover-card">
                <div class="card-body text-center">
                    <i class="bi bi-calendar3 fs-1 text-success"></i>
                    <h5 class="card-title mt-3">Generar Horarios</h5>
                    <p class="card-text text-muted">Validar conflictos de horario</p>
                    <a href="{{ route('coordinador.horarios.index') }}" class="btn btn-success">
                        <i class="bi bi-calendar-plus"></i> Gestionar
                    </a>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card shadow-sm h-100 border-0 hover-card">
                <div class="card-body text-center">
                    <i class="bi bi-clipboard-check fs-1 text-warning"></i>
                    <h5 class="card-title mt-3">Control Asistencia</h5>
                    <p class="card-text text-muted">Registrar y controlar asistencia</p>
                    <a href="{{ route('coordinador.asistencia') }}" class="btn btn-warning">
                        <i class="bi bi-check-circle"></i> Gestionar
                    </a>
                </div>
            </div>
        </div>

        {{-- 📦 Reportes --}}
        <div class="mb-5">
            <h4 class="mb-3 text-info">
                <i class="bi bi-file-earmark-bar-graph"></i> Reportes
            </h4>
            <div class="row g-4">
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="card shadow-sm h-100 border-0 hover-card">
                        <div class="card-body text-center">
                            <i class="bi bi-file-earmark-pdf fs-1 text-info"></i>
                            <h5 class="card-title mt-3">Reportes Parciales</h5>
                            <p class="card-text text-muted">Generar reportes operativos</p>
                            <a href="{{ route('coordinador.reportes') }}" class="btn btn-info">
                                <i class="bi bi-file-earmark-text"></i> Ver reportes
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Dashboard para Autoridad --}}
    @if (auth()->user()->rol->nombre == 'Autoridad')
        <div class="alert alert-info text-center mb-5">
            <i class="bi bi-info-circle fs-4"></i>
            <p class="mb-0 mt-2">Acceso de <strong>solo lectura</strong> a la información académica</p>
        </div>

        {{-- 📦 Consultas --}}
        <div class="mb-5">
            <h4 class="mb-3 text-primary">
                <i class="bi bi-eye"></i> Consultas
            </h4>
            <div class="row g-4">
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="card shadow-sm h-100 border-0 hover-card">
                        <div class="card-body text-center">
                            <i class="bi bi-person-lines-fill fs-1 text-success"></i>
                            <h5 class="card-title mt-3">Lista de Docentes</h5>
                            <p class="card-text text-muted">Ver información de docentes</p>
                            <a href="{{ route('autoridad.docentes') }}" class="btn btn-success">
                                <i class="bi bi-eye"></i> Ver lista
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-4">
                    <div class="card shadow-sm h-100 border-0 hover-card">
                        <div class="card-body text-center">
                            <i class="bi bi-calendar3 fs-1 text-primary"></i>
                            <h5 class="card-title mt-3">Horarios</h5>
                            <p class="card-text text-muted">Consultar horarios académicos</p>
                            <a href="{{ route('autoridad.horarios') }}" class="btn btn-primary">
                                <i class="bi bi-eye"></i> Ver horarios
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-4">
                    <div class="card shadow-sm h-100 border-0 hover-card">
                        <div class="card-body text-center">
                            <i class="bi bi-clipboard-check fs-1 text-info"></i>
                            <h5 class="card-title mt-3">Historial Asistencias</h5>
                            <p class="card-text text-muted">Ver registro de asistencias</p>
                            <a href="{{ route('autoridad.asistencias') }}" class="btn btn-info">
                                <i class="bi bi-eye"></i> Ver historial
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-4">
                    <div class="card shadow-sm h-100 border-0 hover-card">
                        <div class="card-body text-center">
                            <i class="bi bi-exclamation-triangle fs-1 text-danger"></i>
                            <h5 class="card-title mt-3">Faltas</h5>
                            <p class="card-text text-muted">Ver ausencias de docentes</p>
                            <a href="{{ route('autoridad.faltas') }}" class="btn btn-danger">
                                <i class="bi bi-eye"></i> Ver faltas
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-4">
                    <div class="card shadow-sm h-100 border-0 hover-card">
                        <div class="card-body text-center">
                            <i class="bi bi-file-earmark-bar-graph fs-1 text-warning"></i>
                            <h5 class="card-title mt-3">Reportes</h5>
                            <p class="card-text text-muted">Generar reportes completos</p>
                            <a href="{{ route('autoridad.reportes') }}" class="btn btn-warning">
                                <i class="bi bi-file-earmark-pdf"></i> Ver reportes
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Dashboard para Docente --}}
    @if (auth()->user()->rol->nombre == 'Docente')
        {{-- 📦 Paquete 4: Control de Asistencia --}}
        <div class="mb-5">
            <h4 class="mb-3 text-primary">
                <i class="bi bi-clipboard-check"></i> Control de Asistencia
            </h4>
            <div class="row g-4 justify-content-center">
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="card shadow-sm h-100 border-0 hover-card">
                        <div class="card-body text-center">
                            <i class="bi bi-calendar-check fs-1 text-success"></i>
                            <h5 class="card-title mt-3">Mi Horario</h5>
                            <p class="card-text text-muted">Consulta tu horario de clases</p>
                            <a href="{{ route('docente.horario') }}" class="btn btn-success">
                                <i class="bi bi-eye"></i> Ver horario
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-4">
                    <div class="card shadow-sm h-100 border-0 hover-card">
                        <div class="card-body text-center">
                            <i class="bi bi-clipboard-check fs-1 text-primary"></i>
                            <h5 class="card-title mt-3">Asistencia</h5>
                            <p class="card-text text-muted">Registra tu asistencia</p>
                            <a href="{{ route('docente.asistencia') }}" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Marcar asistencia
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-4">
                    <div class="card shadow-sm h-100 border-0 hover-card">
                        <div class="card-body text-center">
                            <i class="bi bi-clock-history fs-1 text-info"></i>
                            <h5 class="card-title mt-3">Historial</h5>
                            <p class="card-text text-muted">Ver asistencias anteriores</p>
                            <a href="{{ route('docente.historial') }}" class="btn btn-info">
                                <i class="bi bi-list-ul"></i> Ver historial
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    </div>

    <style>
        .hover-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15) !important;
        }
    </style>
@endsection
