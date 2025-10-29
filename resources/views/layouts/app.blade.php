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
                            Dashboard
                        </a>
                    </li>

                    {{-- Menú solo para Administrador --}}
                    @if(Auth::check() && Auth::user()->rol && Auth::user()->rol->nombre == 'Administrador')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('roles*') ? 'active' : '' }}" href="{{ url('/roles') }}">
                                Roles
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('usuarios*') ? 'active' : '' }}" href="{{ url('/usuarios') }}">
                                Usuarios
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('docentes*') ? 'active' : '' }}"
                                href="{{ url('/docentes') }}">
                                Gestionar Docentes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('materias*') ? 'active' : '' }}"
                                href="{{ url('/materias') }}">
                                Materias
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('grupos*') ? 'active' : '' }}"
                                href="{{ url('/grupos') }}">
                                Grupos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('aulas*') ? 'active' : '' }}"
                                href="{{ url('/aulas') }}">
                                Aulas
                            </a>
                        </li>
                    @endif

                    {{-- Menú solo para Docente --}}
                    @if(Auth::check() && Auth::user()->rol && Auth::user()->rol->nombre == 'Docente')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('docente/mi-horario*') ? 'active' : '' }}"
                                href="{{ route('docente.horario') }}">
                                Mi Horario
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('docente/asistencia*') ? 'active' : '' }}"
                                href="{{ route('docente.asistencia') }}">
                                Asistencia
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('docente/historial*') ? 'active' : '' }}"
                                href="{{ route('docente.historial') }}">
                                Historial
                            </a>
                        </li>
                    @endif
                </ul>

                <!-- Usuario y logout -->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" id="userDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i>
                            {{ Auth::user()->nombre_completo ?? 'Usuario' }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bi bi-person"></i> Perfil
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <span class="dropdown-item-text small text-muted">
                                    Rol: {{ Auth::user()->rol->nombre ?? 'Sin rol' }}
                                </span>
                            </li>
                            <li><hr class="dropdown-divider"></li>
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
