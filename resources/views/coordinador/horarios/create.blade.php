@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="bi bi-plus-circle"></i> Crear Nuevo Horario
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i>
                            <strong>Gestión Académica:</strong> {{ $gestionActiva->nombre }}
                            ({{ $gestionActiva->fecha_inicio->format('d/m/Y') }} -
                            {{ $gestionActiva->fecha_fin->format('d/m/Y') }})
                        </div>

                        @if (session('error_conflictos'))
                            <div class="alert alert-danger">
                                <i class="bi bi-exclamation-triangle"></i>
                                <strong>¡Conflictos detectados!</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach (session('error_conflictos') as $conflicto)
                                        <li>{{ $conflicto }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('coordinador.horarios.store') }}" method="POST" id="formHorario">
                            @csrf

                            <div class="row">
                                <!-- Docente -->
                                <div class="col-md-6 mb-3">
                                    <label for="docente_id" class="form-label">Docente *</label>
                                    <select name="docente_id" id="docente_id"
                                        class="form-select @error('docente_id') is-invalid @enderror" required>
                                        <option value="">Seleccione un docente</option>
                                        @foreach ($docentes as $docente)
                                            <option value="{{ $docente->id }}"
                                                {{ old('docente_id') == $docente->id ? 'selected' : '' }}>
                                                {{ $docente->usuario->nombre_completo ?? 'Sin nombre' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('docente_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Grupo (Materia + Grupo) -->
                                <div class="col-md-6 mb-3">
                                    <label for="grupo_id" class="form-label">Materia - Grupo *</label>
                                    <select name="grupo_id" id="grupo_id"
                                        class="form-select @error('grupo_id') is-invalid @enderror" required>
                                        <option value="">Seleccione materia y grupo</option>
                                        @foreach ($grupos as $grupo)
                                            <option value="{{ $grupo->id }}"
                                                {{ old('grupo_id') == $grupo->id ? 'selected' : '' }}>
                                                {{ $grupo->materia->nombre ?? 'N/A' }} - Grupo {{ $grupo->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('grupo_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <!-- Aula -->
                                <div class="col-md-6 mb-3">
                                    <label for="aula_id" class="form-label">Aula *</label>
                                    <select name="aula_id" id="aula_id"
                                        class="form-select @error('aula_id') is-invalid @enderror" required>
                                        <option value="">Seleccione un aula</option>
                                        @foreach ($aulas as $aula)
                                            <option value="{{ $aula->id }}"
                                                {{ old('aula_id') == $aula->id ? 'selected' : '' }}>
                                                {{ $aula->codigo }} - Cap: {{ $aula->capacidad }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('aula_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Día de la semana -->
                                <div class="col-md-6 mb-3">
                                    <label for="dia_semana" class="form-label">Día *</label>
                                    <select name="dia_semana" id="dia_semana"
                                        class="form-select @error('dia_semana') is-invalid @enderror" required>
                                        <option value="">Seleccione un día</option>
                                        @foreach ($dias as $numero => $nombre)
                                            <option value="{{ $numero }}"
                                                {{ old('dia_semana') == $numero ? 'selected' : '' }}>
                                                {{ $nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('dia_semana')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <!-- Hora inicio -->
                                <div class="col-md-6 mb-3">
                                    <label for="hora_inicio" class="form-label">Hora Inicio *</label>
                                    <input type="time" name="hora_inicio" id="hora_inicio"
                                        class="form-control @error('hora_inicio') is-invalid @enderror"
                                        value="{{ old('hora_inicio', '07:00') }}" required>
                                    @error('hora_inicio')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Hora fin -->
                                <div class="col-md-6 mb-3">
                                    <label for="hora_fin" class="form-label">Hora Fin *</label>
                                    <input type="time" name="hora_fin" id="hora_fin"
                                        class="form-control @error('hora_fin') is-invalid @enderror"
                                        value="{{ old('hora_fin', '08:30') }}" required>
                                    @error('hora_fin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Botón de validación en tiempo real -->
                            <div class="alert alert-secondary" id="validacionResultado" style="display: none;">
                                <div class="spinner-border spinner-border-sm me-2" role="status" id="validacionSpinner">
                                    <span class="visually-hidden">Validando...</span>
                                </div>
                                <span id="validacionMensaje">Validando conflictos...</span>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('coordinador.horarios.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary" id="btnGuardar">
                                    <i class="bi bi-save"></i> Guardar Horario
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Validación en tiempo real (opcional)
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('formHorario');
            const inputs = ['docente_id', 'grupo_id', 'aula_id', 'dia_semana', 'hora_inicio', 'hora_fin'];

            inputs.forEach(id => {
                document.getElementById(id)?.addEventListener('change', validarConflictos);
            });

            function validarConflictos() {
                const data = {
                    docente_id: document.getElementById('docente_id').value,
                    grupo_id: document.getElementById('grupo_id').value,
                    aula_id: document.getElementById('aula_id').value,
                    dia_semana: document.getElementById('dia_semana').value,
                    hora_inicio: document.getElementById('hora_inicio').value,
                    hora_fin: document.getElementById('hora_fin').value,
                };

                // Verificar que todos los campos estén llenos
                if (!data.docente_id || !data.grupo_id || !data.aula_id || !data.dia_semana || !data.hora_inicio ||
                    !data.hora_fin) {
                    return;
                }

                // Mostrar spinner
                const resultado = document.getElementById('validacionResultado');
                const spinner = document.getElementById('validacionSpinner');
                const mensaje = document.getElementById('validacionMensaje');

                resultado.style.display = 'block';
                resultado.className = 'alert alert-secondary';
                spinner.style.display = 'inline-block';
                mensaje.textContent = 'Validando conflictos...';

                // Hacer petición AJAX
                fetch('{{ route('horarios.validar-conflicto') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => response.json())
                    .then(result => {
                        spinner.style.display = 'none';

                        if (result.success) {
                            resultado.className = 'alert alert-success';
                            mensaje.innerHTML =
                                '<i class="bi bi-check-circle"></i> No hay conflictos. Puede guardar el horario.';
                        } else {
                            resultado.className = 'alert alert-danger';
                            let conflictosHtml =
                                '<i class="bi bi-exclamation-triangle"></i> <strong>Conflictos detectados:</strong><ul class="mb-0 mt-2">';
                            result.conflictos.forEach(conflicto => {
                                conflictosHtml += `<li>${conflicto}</li>`;
                            });
                            conflictosHtml += '</ul>';
                            mensaje.innerHTML = conflictosHtml;
                        }
                    })
                    .catch(error => {
                        spinner.style.display = 'none';
                        resultado.className = 'alert alert-warning';
                        mensaje.textContent = 'Error al validar. Intente de nuevo.';
                    });
            }
        });
    </script>
@endsection
