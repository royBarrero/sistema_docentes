@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-calendar-week"></i> Consultar Horario de Docente
                    </h4>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        <strong>Instrucción:</strong> Selecciona un docente para ver su horario semanal completo.
                    </div>

                    @if($docentes->isEmpty())
                        <div class="alert alert-warning text-center">
                            <i class="bi bi-exclamation-triangle fs-1 d-block mb-3"></i>
                            <h5>No hay docentes activos</h5>
                            <p class="mb-0">Registra docentes primero para poder consultar sus horarios.</p>
                        </div>
                    @else
                      <form method="GET" id="formConsultar">
                            <div class="mb-4">
                                <label for="docente_id" class="form-label fw-bold">
                                    <i class="bi bi-person-badge text-primary"></i> Seleccionar Docente
                                </label>
                               <select name="docente_id" 
        id="docente_id" 
        class="form-select form-select-lg" 
        required
        onchange="redirigirDocente(this.value)">
                                    <option value="">-- Seleccione un docente --</option>
                                    @foreach($docentes as $docente)
                                        <option value="{{ $docente->id }}">
                                            {{ $docente->usuario->nombre_completo ?? 'Sin nombre' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </form>

                        <!-- Lista de docentes con botones -->
                        <hr class="my-4">
                        <h5 class="mb-3">O selecciona directamente:</h5>

                        <div class="row g-3">
                            @foreach($docentes as $docente)
                                <div class="col-md-6">
                                    <a href="{{ route('horarios.consultar.ver', $docente->id) }}" 
                                       class="btn btn-outline-primary w-100 text-start">
                                        <i class="bi bi-person-badge"></i>
                                        {{ $docente->usuario->nombre_completo ?? 'Sin nombre' }}
                                        <i class="bi bi-arrow-right float-end mt-1"></i>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="text-center mt-4">
                        <a href="{{ route('horarios.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Volver a Horarios
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function redirigirDocente(docenteId) {
    if (docenteId) {
        window.location.href = "{{ url('horarios/consultar/docente') }}/" + docenteId;
    }
}

// Por si acaso se envía el formulario
document.getElementById('formConsultar')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const docenteId = document.getElementById('docente_id').value;
    redirigirDocente(docenteId);
});
</script>
@endsection