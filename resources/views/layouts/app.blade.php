<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sistema de Gestión Docente</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-white" href="{{ url('/dashboard') }}">
                <i class="bi bi-mortarboard-fill"></i> Sistema Docente
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <!-- Dashboard visible para todos -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}"
                            href="{{ url('/dashboard') }}">
                            <i class="bi bi-house-door"></i> Dashboard
                        </a>
                    </li>

                    {{-- ========== MENÚ PARA ADMINISTRADOR ========== --}}
                    @if (Auth::check() && Auth::user()->rol && Auth::user()->rol->nombre == 'Administrador')
                        {{-- 📦 1. Seguridad --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->is('usuarios*') || request()->is('roles*') ? 'active' : '' }}"
                                href="#" id="authDropdown" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="bi bi-shield-lock"></i> Seguridad
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="authDropdown">
                                <li>
                                    <a class="dropdown-item {{ request()->is('usuarios*') ? 'active' : '' }}"
                                        href="{{ url('/usuarios') }}">
                                        <i class="bi bi-person-circle"></i> Usuarios
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item {{ request()->is('roles*') ? 'active' : '' }}"
                                        href="{{ url('/roles') }}">
                                        <i class="bi bi-people-fill"></i> Roles
                                    </a>
                                </li>
                            </ul>
                        </li>

                        {{-- 📦 2. Gestión Académica --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="academicDropdown" role="button"
                                data-bs-toggle="dropdown">
                                <i class="bi bi-book"></i> Gestión Académica
                            </a>
                            <ul class="dropdown-menu">
                             
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ url('/docentes') }}">
                                        <i class="bi bi-person-badge"></i> Docentes
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item {{ request()->is('materias*') ? 'active' : '' }}"
                                        href="{{ url('/materias') }}">
                                        <i class="bi bi-people"></i> Materias
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item {{ request()->is('grupos*') ? 'active' : '' }}"
                                        href="{{ url('/grupos') }}">
                                        <i class="bi bi-people"></i> Grupos
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item {{ request()->is('aulas*') ? 'active' : '' }}"
                                        href="{{ url('/aulas') }}">
                                        <i class="bi bi-door-open"></i> Aulas
                                    </a>
                                </li>
                            </ul>
                        </li>

                        {{-- 📦 3. Asignación Académica --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->is('gestiones*') || request()->is('horarios*') ? 'active' : '' }}"
                                href="#" id="assignDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-calendar-check"></i> Asignaciones
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="assignDropdown">
                                <li>
                                    <a class="dropdown-item {{ request()->is('gestiones*') ? 'active' : '' }}"
                                        href="{{ route('gestiones.index') }}">
                                        <i class="bi bi-calendar3"></i> Gestiones Académicas
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item {{ request()->is('horarios*') ? 'active' : '' }}"
                                        href="{{ route('horarios.index') }}">
                                        <i class="bi bi-clock"></i> Horarios
                                    </a>
                                </li>
                            </ul>
                        </li>
                        {{-- 📦 5. Reportes --}}
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('reportes*') ? 'active' : '' }}" href="#">
                                <i class="bi bi-file-earmark-bar-graph"></i> Reportes
                            </a>
                        </li>
                    @endif

                    {{-- ========== MENÚ PARA COORDINADOR ========== --}}
                    @if (Auth::check() && Auth::user()->rol && Auth::user()->rol->nombre == 'Coordinador')
                        {{-- 📦 Gestión Académica --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->is('coordinador/docentes*') || request()->is('coordinador/materias*') || request()->is('coordinador/grupos*') || request()->is('coordinador/aulas*') ? 'active' : '' }}"
                                href="#" id="coordAcademicDropdown" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="bi bi-book"></i> Gestión Académica
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="coordAcademicDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('coordinador.docentes') }}">
                                        <i class="bi bi-person-badge"></i> Docentes
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('coordinador.materias') }}">
                                        <i class="bi bi-journal-bookmark"></i> Materias
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('coordinador.grupos') }}">
                                        <i class="bi bi-people"></i> Grupos
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('coordinador.aulas') }}">
                                        <i class="bi bi-door-open"></i> Aulas
                                    </a>
                                </li>
                            </ul>
                        </li>
                            
                        {{-- 📦 Reportes --}}
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('coordinador/reportes*') ? 'active' : '' }}"
                                href="{{ route('coordinador.reportes') }}">
                                <i class="bi bi-file-earmark-bar-graph"></i> Reportes
                            </a>
                        </li>
                    @endif

                    {{-- ========== MENÚ PARA AUTORIDAD ========== --}}
                    @if (Auth::check() && Auth::user()->rol && Auth::user()->rol->nombre == 'Autoridad')
                        {{-- 📦 Consultas --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->is('autoridad/*') ? 'active' : '' }}"
                                href="#" id="autoridadDropdown" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="bi bi-eye"></i> Consultas
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="autoridadDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('autoridad.docentes') }}">
                                        <i class="bi bi-person-lines-fill"></i> Lista de Docentes
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('autoridad.horarios') }}">
                                        <i class="bi bi-calendar3"></i> Horarios
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('autoridad.asistencias') }}">
                                        <i class="bi bi-clipboard-check"></i> Historial Asistencias
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('autoridad.faltas') }}">
                                        <i class="bi bi-exclamation-triangle"></i> Faltas
                                    </a>
                                </li>
                            </ul>
                        </li>

                        {{-- 📦 Reportes --}}
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('autoridad/reportes*') ? 'active' : '' }}"
                                href="{{ route('autoridad.reportes') }}">
                                <i class="bi bi-file-earmark-bar-graph"></i> Reportes
                            </a>
                        </li>
                    @endif

                    {{-- ========== MENÚ PARA DOCENTE ========== --}}
                    @if (Auth::check() && Auth::user()->rol && Auth::user()->rol->nombre == 'Docente')
                        {{-- 📦 Mi Asistencia --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->is('docente/*') ? 'active' : '' }}"
                                href="#" id="docenteDropdown" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="bi bi-clipboard-check"></i> Mi Asistencia
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="docenteDropdown">
                                <li>
                                    <a class="dropdown-item {{ request()->is('docente/mi-horario*') ? 'active' : '' }}"
                                        href="{{ route('docente.horario') }}">
                                        <i class="bi bi-calendar-event"></i> Mi Horario
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item {{ request()->is('docente/asistencia*') ? 'active' : '' }}"
                                        href="{{ route('docente.asistencia') }}">
                                        <i class="bi bi-check-circle"></i> Registrar Asistencia
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item {{ request()->is('docente/historial*') ? 'active' : '' }}"
                                        href="{{ route('docente.historial') }}">
                                        <i class="bi bi-clock-history"></i> Historial
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>

                <!-- Usuario y logout -->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="userDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i>
                            {{ Auth::user()->nombre_completo ?? 'Usuario' }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bi bi-person"></i> Perfil
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <span class="dropdown-item-text small text-muted">
                                    Rol: <strong>{{ Auth::user()->rol->nombre ?? 'Sin rol' }}</strong>
                                </span>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>
</body>

</html>
