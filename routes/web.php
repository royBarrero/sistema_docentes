<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolController;
use App\Http\Controllers\Docente\DocenteDashboardController;

Route::get('/', function () {
    return redirect('/login');
});

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    
    // Dashboard accesible para todos los usuarios autenticados
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Rutas solo para ADMINISTRADOR
    Route::middleware(['role:Administrador'])->group(function () {
        Route::resource('roles', RolController::class);
        Route::resource('usuarios', App\Http\Controllers\UsuarioController::class);
        Route::resource('docentes', App\Http\Controllers\DocenteController::class);
        Route::resource('materias', App\Http\Controllers\MateriaController::class);
        Route::resource('grupos', App\Http\Controllers\GrupoController::class);
        Route::resource('aulas', App\Http\Controllers\AulaController::class);
Route::resource('gestiones', App\Http\Controllers\GestionAcademicaController::class);
    Route::post('gestiones/{id}/activar', [App\Http\Controllers\GestionAcademicaController::class, 'activar'])->name('gestiones.activar');
    Route::resource('horarios', App\Http\Controllers\HorarioController::class);
    Route::post('horarios/validar-conflicto', [App\Http\Controllers\HorarioController::class, 'validarConflicto'])->name('horarios.validar-conflicto');
    });
// ========== RUTAS PARA COORDINADOR ==========
Route::middleware(['role:Coordinador'])->group(function () {
    // Dashboard
    Route::get('/coordinador/dashboard', [App\Http\Controllers\CoordinadorController::class, 'dashboard'])->name('coordinador.dashboard');
    
    // Gestión Académica (solo lectura para coordinador)
    Route::get('/coordinador/docentes', [App\Http\Controllers\CoordinadorController::class, 'docentes'])->name('coordinador.docentes');
    Route::get('/coordinador/materias', [App\Http\Controllers\CoordinadorController::class, 'materias'])->name('coordinador.materias');
    Route::get('/coordinador/grupos', [App\Http\Controllers\CoordinadorController::class, 'grupos'])->name('coordinador.grupos');
    Route::get('/coordinador/aulas', [App\Http\Controllers\CoordinadorController::class, 'aulas'])->name('coordinador.aulas');
    
    // Horarios (CRUD completo)
    Route::get('/coordinador/horarios', [App\Http\Controllers\CoordinadorController::class, 'horarios'])->name('coordinador.horarios.index');
    Route::get('/coordinador/horarios/create', [App\Http\Controllers\CoordinadorController::class, 'horariosCreate'])->name('coordinador.horarios.create');
    Route::post('/coordinador/horarios', [App\Http\Controllers\CoordinadorController::class, 'horariosStore'])->name('coordinador.horarios.store');
    Route::get('/coordinador/horarios/{id}/edit', [App\Http\Controllers\CoordinadorController::class, 'horariosEdit'])->name('coordinador.horarios.edit');
    Route::put('/coordinador/horarios/{id}', [App\Http\Controllers\CoordinadorController::class, 'horariosUpdate'])->name('coordinador.horarios.update');
    Route::delete('/coordinador/horarios/{id}', [App\Http\Controllers\CoordinadorController::class, 'horariosDestroy'])->name('coordinador.horarios.destroy');
    Route::post('/coordinador/horarios/validar-conflicto', [App\Http\Controllers\CoordinadorController::class, 'validarConflicto'])->name('coordinador.horarios.validar-conflicto');
    
    // Asignaciones
    Route::get('/coordinador/asignaciones', [App\Http\Controllers\CoordinadorController::class, 'asignaciones'])->name('coordinador.asignaciones');
    
    // Control de Asistencia
    Route::get('/coordinador/asistencia', [App\Http\Controllers\CoordinadorController::class, 'asistencia'])->name('coordinador.asistencia');
    
    // Reportes Parciales
    Route::get('/coordinador/reportes', [App\Http\Controllers\CoordinadorController::class, 'reportes'])->name('coordinador.reportes');
});

    // ========== RUTAS PARA AUTORIDAD (SOLO LECTURA) ==========
    Route::middleware(['role:Autoridad'])->group(function () {
        Route::get('/autoridad/docentes', [App\Http\Controllers\AutoridadController::class, 'docentes'])->name('autoridad.docentes');
        Route::get('/autoridad/horarios', [App\Http\Controllers\AutoridadController::class, 'horarios'])->name('autoridad.horarios');
        Route::get('/autoridad/asistencias', [App\Http\Controllers\AutoridadController::class, 'asistencias'])->name('autoridad.asistencias');
        Route::get('/autoridad/faltas', [App\Http\Controllers\AutoridadController::class, 'faltas'])->name('autoridad.faltas');
        Route::get('/autoridad/reportes', [App\Http\Controllers\AutoridadController::class, 'reportes'])->name('autoridad.reportes');
    });
    // Rutas para DOCENTES
    Route::middleware(['role:Docente'])->group(function () {
        Route::get('/docente/mi-horario', [DocenteDashboardController::class, 'miHorario'])->name('docente.horario');
        Route::get('/docente/asistencia', [DocenteDashboardController::class, 'asistencia'])->name('docente.asistencia');
        Route::post('/docente/asistencia', [DocenteDashboardController::class, 'guardarAsistencia'])->name('docente.asistencia.guardar');
        Route::get('/docente/historial', [DocenteDashboardController::class, 'historialAsistencia'])->name('docente.historial');
    });
});

require __DIR__.'/auth.php';
