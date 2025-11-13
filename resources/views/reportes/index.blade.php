@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <h3 class="mb-0">
                <i class="bi bi-file-earmark-bar-graph"></i> Generar Reportes
            </h3>
        </div>
        <div class="card-body p-4">
            @if($gestionActiva)
                <div class="alert alert-info">
                    <strong><i class="bi bi-calendar3"></i> Gestión Académica Activa:</strong> 
                    {{ $gestionActiva->nombre }}
                    ({{ $gestionActiva->fecha_inicio->format('d/m/Y') }} - {{ $gestionActiva->fecha_fin->format('d/m/Y') }})
                </div>
            @else
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle"></i>
                    <strong>Advertencia:</strong> No hay una gestión académica activa.
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Tipos de reportes -->
            <div class="row g-4">
                <!-- 1. Reporte de Asistencias por Docente -->
                <div class="col-md-6">
                    <div class="card h-100 border-primary">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-clipboard-check"></i> Reporte de Asistencias por Docente
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">Genera un reporte detallado de las asistencias de un docente específico.</p>
                            
                            <form action="{{ route(auth()->user()->rol->nombre == 'Administrador' ? 'reportes.asistencias.docente' : (auth()->user()->rol->nombre == 'Coordinador' ? 'coordinador.reportes.asistencias.docente' : 'autoridad.reportes.asistencias.docente')) }}" 
                                  method="POST" 
                                  target="_blank">
                                @csrf
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Docente *</label>
                                    <select name="docente_id" class="form-select" required>
                                        <option value="">Seleccione un docente</option>
                                        @foreach($docentes as $docente)
                                            <option value="{{ $docente->id }}">
                                                {{ $docente->usuario->nombre_completo ?? 'N/A' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Fecha Inicio</label>
                                        <input type="date" name="fecha_inicio" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Fecha Fin</label>
                                        <input type="date" name="fecha_fin" class="form-control">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Formato *</label>
                                    <div class="btn-group w-100" role="group">
                                        <input type="radio" class="btn-check" name="formato" id="asist_doc_pdf" value="pdf" checked>
                                        <label class="btn btn-outline-danger" for="asist_doc_pdf">
                                            <i class="bi bi-file-pdf"></i> PDF
                                        </label>
                                        
                                        <input type="radio" class="btn-check" name="formato" id="asist_doc_excel" value="excel">
                                        <label class="btn btn-outline-success" for="asist_doc_excel">
                                            <i class="bi bi-file-excel"></i> Excel
                                        </label>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-download"></i> Generar Reporte
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- 2. Reporte de Horarios por Docente -->
                <div class="col-md-6">
                    <div class="card h-100 border-success">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-calendar-week"></i> Reporte de Horarios por Docente
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">Genera el horario semanal completo de un docente.</p>
                            
                            <form action="{{ route(auth()->user()->rol->nombre == 'Administrador' ? 'reportes.horarios.docente' : (auth()->user()->rol->nombre == 'Coordinador' ? 'coordinador.reportes.horarios.docente' : 'autoridad.reportes.horarios.docente')) }}" 
                                  method="POST" 
                                  target="_blank">
                                @csrf
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Docente *</label>
                                    <select name="docente_id" class="form-select" required>
                                        <option value="">Seleccione un docente</option>
                                        @foreach($docentes as $docente)
                                            <option value="{{ $docente->id }}">
                                                {{ $docente->usuario->nombre_completo ?? 'N/A' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Formato *</label>
                                    <div class="btn-group w-100" role="group">
                                        <input type="radio" class="btn-check" name="formato" id="horar_doc_pdf" value="pdf" checked>
                                        <label class="btn btn-outline-danger" for="horar_doc_pdf">
                                            <i class="bi bi-file-pdf"></i> PDF
                                        </label>
                                        
                                        <input type="radio" class="btn-check" name="formato" id="horar_doc_excel" value="excel">
                                        <label class="btn btn-outline-success" for="horar_doc_excel">
                                            <i class="bi bi-file-excel"></i> Excel
                                        </label>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-success w-100">
                                    <i class="bi bi-download"></i> Generar Reporte
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- 3. Reporte General de Asistencias -->
                <div class="col-md-6">
                    <div class="card h-100 border-warning">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0">
                                <i class="bi bi-bar-chart"></i> Reporte General de Asistencias
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">Reporte consolidado de todas las asistencias registradas.</p>
                            
                            <form action="{{ route(auth()->user()->rol->nombre == 'Administrador' ? 'reportes.asistencias.general' : (auth()->user()->rol->nombre == 'Coordinador' ? 'coordinador.reportes.asistencias.general' : 'autoridad.reportes.asistencias.general')) }}" 
                                  method="POST" 
                                  target="_blank">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Fecha Inicio</label>
                                        <input type="date" name="fecha_inicio" class="form-control">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Fecha Fin</label>
                                        <input type="date" name="fecha_fin" class="form-control">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Formato *</label>
                                    <div class="btn-group w-100" role="group">
                                        <input type="radio" class="btn-check" name="formato" id="asist_gen_pdf" value="pdf" checked>
                                        <label class="btn btn-outline-danger" for="asist_gen_pdf">
                                            <i class="bi bi-file-pdf"></i> PDF
                                        </label>
                                        
                                        <input type="radio" class="btn-check" name="formato" id="asist_gen_excel" value="excel">
                                        <label class="btn btn-outline-success" for="asist_gen_excel">
                                            <i class="bi bi-file-excel"></i> Excel
                                        </label>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-warning w-100">
                                    <i class="bi bi-download"></i> Generar Reporte
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- 4. Reporte General de Horarios -->
                <div class="col-md-6">
                    <div class="card h-100 border-info">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-calendar3"></i> Reporte General de Horarios
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">Reporte de todos los horarios de la gestión académica activa.</p>
                            
                            <form action="{{ route(auth()->user()->rol->nombre == 'Administrador' ? 'reportes.horarios.general' : (auth()->user()->rol->nombre == 'Coordinador' ? 'coordinador.reportes.horarios.general' : 'autoridad.reportes.horarios.general')) }}" 
                                  method="POST" 
                                  target="_blank">
                                @csrf
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Formato *</label>
                                    <div class="btn-group w-100" role="group">
                                        <input type="radio" class="btn-check" name="formato" id="horar_gen_pdf" value="pdf" checked>
                                        <label class="btn btn-outline-danger" for="horar_gen_pdf">
                                            <i class="bi bi-file-pdf"></i> PDF
                                        </label>
                                        
                                        <input type="radio" class="btn-check" name="formato" id="horar_gen_excel" value="excel">
                                        <label class="btn btn-outline-success" for="horar_gen_excel">
                                            <i class="bi bi-file-excel"></i> Excel
                                        </label>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-info w-100">
                                    <i class="bi bi-download"></i> Generar Reporte
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información adicional -->
            <div class="alert alert-light border mt-4">
                <h6><i class="bi bi-info-circle"></i> Información:</h6>
                <ul class="mb-0">
                    <li><strong>PDF:</strong> Formato ideal para impresión y visualización.</li>
                    <li><strong>Excel:</strong> Formato ideal para análisis de datos y manipulación.</li>
                    <li>Los reportes se generan según la gestión académica activa.</li>
                    <li>Los filtros de fecha son opcionales (si se omiten, se incluyen todos los registros).</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection