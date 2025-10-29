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
